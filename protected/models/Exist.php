<?php

/**
 * @property integer $id
 * @property integer $distributor_id
 * @property integer $pharmacy_id
 * @property string $count
 * @property string $created
 * @property integer $product_id
 *
 * @property Distributor $distributor
 * @property Pharmacy $pharmacy
 * @property Product $product
 */
class Exist extends CActiveRecord
{
	/**
	 * @return string
	 */
	public function tableName()
	{
		return 'exist';
	}

	/**
	 * @return array
	 */
	public function rules()
	{
		return array(
			array('distributor_id, pharmacy_id, count, created, product_id', 'required'),
			array('distributor_id, pharmacy_id, product_id', 'numerical', 'integerOnly'=>true),
			array('count', 'length', 'max'=>10),
			array('id, distributor_id, pharmacy_id, count, created, product_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array
	 */
	public function relations()
	{
		return array(
			'distributor' => array(self::BELONGS_TO, 'Distributor', 'distributor_id'),
			'pharmacy' => array(self::BELONGS_TO, 'Pharmacy', 'pharmacy_id'),
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
		);
	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'distributor_id' => 'Distributor',
			'pharmacy_id' => 'Pharmacy',
			'count' => 'Count',
			'created' => 'Created',
			'product_id' => 'Product',
		);
	}

	/**
	 * @return CActiveDataProvider
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('distributor_id',$this->distributor_id);
		$criteria->compare('pharmacy_id',$this->pharmacy_id);
		$criteria->compare('count',$this->count,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('product_id',$this->product_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @param string $className active record class name.
	 * @return Exist the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
