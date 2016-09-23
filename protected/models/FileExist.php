<?php

/**
 * @property integer $id
 * @property integer $file_id
 * @property string $pharmacy
 * @property string $product
 * @property string $count
 * @property string $created
 *
 * @property File $file
 */
class FileExist extends CActiveRecord
{
    const FIELD_PHARMACY = 'pharmacy';
    const FIELD_PRODUCT = 'product';
    const FIELD_COUNT = 'count';

	/**
	 * @return string
	 */
	public function tableName()
	{
		return 'file_exist';
	}

	/**
	 * @return array
	 */
	public function rules()
	{
		return array(
			array('file_id, product, pharmacy, count, created', 'required'),
			array('file_id', 'numerical', 'integerOnly'=>true),
			array('product, pharmacy', 'length', 'max'=>256),
			array('count', 'length', 'max'=>10),
			array('id, file_id, distributor, pharmacy, count, created', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array
	 */
	public function relations()
	{
		return array(
			'file' => array(self::BELONGS_TO, 'File', 'file_id'),
		);
	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('model', 'id'),
			'file_id' => Yii::t('model', 'file_exist.file'),
			'product' => Yii::t('model', 'file_exist.product'),
			'pharmacy' => Yii::t('model', 'file_exist.pharmacy'),
			'count' => Yii::t('model', 'count'),
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
		$criteria->compare('file_id',$this->file_id);
		$criteria->compare('product',$this->product,true);
		$criteria->compare('pharmacy',$this->pharmacy,true);
		$criteria->compare('count',$this->count,true);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @param string
	 * @return FileExist the static model class
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
}
