<?php

/**
 * @property integer $id
 * @property string $title
 * @property string $created
 *
 * @property Exist[] $exists
 */
class Pharmacy extends CActiveRecord
{
	/**
	 * @return string
	 */
	public function tableName()
	{
		return 'pharmacy';
	}

	/**
	 * @return array
	 */
	public function rules()
	{
		return array(
			array('title, created', 'required'),
			array('title', 'length', 'max'=>256),
			array('id, title, created', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array
	 */
	public function relations()
	{
		return array(
			'exists' => array(self::HAS_MANY, 'Exist', 'pharmacy_id'),
		);
	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('model', 'id'),
			'title' => Yii::t('model', 'pharmacy.title'),
			'created' => Yii::t('model', 'created'),
		);
	}

	/**
	 * @return CActiveDataProvider
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @param string
	 * @return Pharmacy the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    protected function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->created = date('Y-m-d H:i:s');
        }

        return parent::beforeValidate();
    }

    /**
     * @param array $attributes
     * @return Pharmacy
     */
	public static function create($attributes)
    {
	    $model = self::model()->findByAttributes($attributes);
        if (!$model) {
            $model = new self;
            $model->setAttributes($attributes);
            $model->save();
        }

        return $model;
    }

    /**
     * @return CArrayDataProvider
     */
    public function getExistsProvider()
    {
        $rows = Yii::app()->db->createCommand("
            SELECT
              distributor.title AS 'id',
              product.title     AS 'product',
              sum(exist.count)  AS 'count'
            FROM exist
              INNER JOIN distributor ON distributor.id = exist.distributor_id
              INNER JOIN product ON product.id = exist.product_id
            WHERE exist.pharmacy_id = :pharmacyId
            GROUP BY exist.distributor_id, exist.product_id 
        ")->queryAll(true, [
            'pharmacyId' => $this->id
        ]);

        return new CArrayDataProvider($rows, array(
            'id' => 'pharmacyExist',
            'sort' => array(
                'attributes' => array(
                    'id',
                    'product',
                    'count',
                ),
            ),
            'pagination' => array(
                'pageSize' => 1000,
            ),
        ));
    }

    /**
     * @param CArrayDataProvider $dataProvider
     * @return array
     */
    public static function getTotals(CArrayDataProvider $dataProvider)
    {
        $data = $dataProvider->getData();

        $result = [
            'total' => 0,
            'distributors' => [],
            'products' => [],
        ];

        foreach ($data as $row) {
            list($distributor, $product, $count) = array_values($row);

            // Calculate total by distributor
            if (!isset($result['distributors'][$distributor])) {
                $result['distributors'][$distributor] = 0;
            }
            $result['distributors'][$distributor] += $count;

            // Calculate total by product
            if (!isset($result['products'][$product])) {
                $result['products'][$product] = 0;
            }
            $result['products'][$product] += $count;

            // Calculate total
            $result['total'] += $count;
        }

        return $result;
    }
}
