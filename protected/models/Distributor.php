<?php

/**
 * @property integer $id
 * @property string $title
 * @property string $converter
 * @property string $created
 *
 * @property Exist[] $exists
 */
class Distributor extends CActiveRecord
{
    public $existCount;
    public $pharmacyTitle;

    /**
     * @return string
     */
    public function tableName()
    {
        return 'distributor';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('title, created', 'required'),
            array('title', 'length', 'max' => 256),
            array('id, title, converter, created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array
     */
    public function relations()
    {
        return array(
            'exists' => array(self::HAS_MANY, 'Exist', 'distributor_id'),
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('model', 'id'),
            'title' => Yii::t('model', 'distributor.title'),
            'created' => Yii::t('model', 'created'),
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @param string $className
     * @return Distributor
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @param $path
     * @return FileConverterInterface
     */
    public function getConverter($path)
    {
        $converterClass = $this->converter;
        return new $converterClass($path);
    }

    /**
     * @return CArrayDataProvider
     */
    public function getExistsProvider()
    {
        $rows = Yii::app()->db->createCommand("
            SELECT
              pharmacy.id      AS 'id',
              pharmacy.title   AS 'pharmacy',
              sum(exist.count) AS 'count'
            FROM exist
              INNER JOIN pharmacy ON pharmacy.id = exist.pharmacy_id
              WHERE exist.distributor_id = :distributorId
            GROUP BY pharmacy.id
        ")->queryAll(true, [
            'distributorId' => $this->id
        ]);

        return new CArrayDataProvider($rows, array(
            'id' => 'distributorExist',
            'sort' => array(
                'attributes' => array(
                    'id',
                    'pharmacy',
                    'count',
                ),
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }
}
