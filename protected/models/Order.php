<?php

/**
 * This is the model class for table "ym_order".
 *
 * The followings are the available columns in table 'ym_order':
 * @property string $id
 * @property string $buyer_name
 * @property string $buyer_family
 * @property string $buyer_mobile
 * @property string $buyer_email
 * @property string $date
 * @property string $order_id
 *
 * The followings are the available model relations:
 * @property Passengers[] $passengers
 */
class Order extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ym_order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('buyer_name, buyer_family', 'length', 'max'=>50),
			array('buyer_mobile', 'length', 'max'=>11),
			array('buyer_email', 'length', 'max'=>255),
			array('date, order_id', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, buyer_name, buyer_family, buyer_mobile, buyer_email, date, order_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'passengers' => array(self::HAS_MANY, 'Passengers', 'order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'شناسه',
			'buyer_name' => 'نام',
			'buyer_family' => 'نام خانوادگی',
			'buyer_mobile' => 'تلفن همراه',
			'buyer_email' => 'پست الکترونیکی',
			'date' => 'تاریخ رزرو',
			'order_id' => 'شماره سفارش',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('buyer_name',$this->buyer_name,true);
		$criteria->compare('buyer_family',$this->buyer_family,true);
		$criteria->compare('buyer_mobile',$this->buyer_mobile,true);
		$criteria->compare('buyer_email',$this->buyer_email,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('order_id',$this->order_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Order the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
