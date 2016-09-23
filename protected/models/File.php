<?php

/**
 * @property integer $id
 * @property integer $distributor_id
 * @property string $path
 * @property string $status
 * @property string $created
 *
 * @property Distributor $distributor
 * @property FileExist[] $fileExists
 */
class File extends CActiveRecord
{
    const STATUS_PROCESS = 'process';
    const STATUS_COMPLETE = 'complete';

    public $document;

    /**
     * @return string
     */
    public function tableName()
    {
        return 'file';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('distributor_id, path, created', 'required'),
            array('distributor_id', 'numerical', 'integerOnly' => true),
            array('path', 'length', 'max' => 256),
            array('status', 'length', 'max' => 8),
            array('document', 'file', 'types' => 'txt', 'on' => 'insert'),
            array('id, distributor_id, path, status, created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array
     */
    public function relations()
    {
        return array(
            'distributor' => array(self::BELONGS_TO, 'Distributor', 'distributor_id'),
            'fileExists' => array(self::HAS_MANY, 'FileExist', 'file_id'),
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('model', 'id'),
            'created' => Yii::t('model', 'created'),
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('distributor_id', $this->distributor_id);
        $criteria->compare('path', $this->path, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @return bool
     */
    public function convert()
    {
        try {
            $fileConverter = $this->distributor->getConverter($this->path);
            $rowsAttributes = $fileConverter->getData();

            foreach ($rowsAttributes as $attributes) {
                $model = new FileExist;
                $model->setAttributes($attributes);
                $model->file_id = $this->id;

                if (!$model->save()) {
                    return false;
                }
            }

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param string
     * @return File the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return bool
     */
    protected function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->created = date('Y-m-d H:i:s');
        }

        return parent::beforeValidate();
    }

    public function complete()
    {
        $pharmacies = [];
        $products = [];

        $result = [];
        foreach ($this->fileExists as $exist) {
            // Create new pharmacy if need
            if (!isset($pharmacies[$exist->pharmacy])) {
                $pharmacy = Pharmacy::create(['title' => $exist->pharmacy]);
                $pharmacies[$exist->pharmacy] = $pharmacy;
            } else {
                $pharmacy = $pharmacies[$exist->pharmacy];
            }

            // Create new product if need
            if (!isset($products[$exist->pharmacy])) {
                $product = Product::create(['title' => $exist->product]);
                $products[$exist->product] = $product;
            } else {
                $product = $products[$exist->product];
            }

            // Fill array with exists
            if (!isset($result[$pharmacy->id][$product->id])) {
                $result[$pharmacy->id][$product->id] = 0;
            }
            $result[$pharmacy->id][$product->id] += floatval($exist->count);
        }

        // Fill exists in database
        /** @var CDbTransaction $transaction */
        $transaction = Yii::app()->db->beginTransaction();
        try {
            foreach ($result as $pharmacyId => $products) {
                foreach ($products as $productId => $count) {
                    $model = new Exist;
                    $model->setAttributes([
                        'distributor_id' => $this->distributor_id,
                        'pharmacy_id' => $pharmacyId,
                        'product_id' => $productId,
                        'count' => $count,
                        'created' => date('Y-m-d H:i:s'),
                    ]);
                    $model->save();
                }
            }

            $this->status = self::STATUS_COMPLETE;
            $this->save();

            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollback();
            return false;
        }
    }

    /**
     * @return array
     */
    public function getCurrentTitles($name)
    {
        $criteria = new CDbCriteria;
        $criteria->group = sprintf('t.%s', $name);

        $models = FileExist::model()->findAll($criteria);
        return CHtml::listData($models, $name, $name);
    }

    /**
     * @return array
     */
    public function getAvailableTitles($name)
    {
        /** @var CActiveRecord $class */
        $class = ucfirst($name);

        $criteria = new CDbCriteria;
        $criteria->group = 't.title';

        $models = $class::model()->findAll($criteria);
        return CHtml::listData($models, 'title', 'title');
    }

    /**
     * @param array $compareData
     * @param string $name
     * @return bool
     */
    public static function comparePharmacies($compareData, $name)
    {
        $transaction = Yii::app()->db->beginTransaction();
        try {
            foreach ($compareData as $from => $to) {
                FileExist::model()->updateAll([
                    $name => $to
                ], sprintf('%s = :parameter', $name), [
                    'parameter' => $from
                ]);
            }

            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollback();
            return false;
        }
    }
}
