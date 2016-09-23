<?php

/**
 * @property integer $id
 * @property string $title
 * @property string $created
 *
 * @property Exist[] $exists
 */
class Product extends CActiveRecord
{
	/**
	 * @return string
	 */
	public function tableName()
	{
		return 'product';
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
			'exists' => array(self::HAS_MANY, 'Exist', 'product_id'),
		);
	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'created' => 'Created',
		);
	}

	/**
	 * @return CActiveDataProvider
	 */
	public function search()
	{
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
	 * @return Product
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
     * @return Product
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
}
