<?php

/**
 * This is the model class for table "ym_passengers".
 *
 * The followings are the available columns in table 'ym_passengers':
 * @property string $id
 * @property string $name
 * @property string $family
 * @property string $gender
 * @property string $passport_num
 * @property string $type
 * @property string $age
 * @property integer $room_num
 * @property string $order_id
 *
 * The followings are the available model relations:
 * @property Order $order
 */
class Passengers extends CActiveRecord
{
	public $genderLabels=array(
		'male'=>'مرد',
		'female'=>'زن',
	);

	public $typeLabels=array(
		'adult'=>'بزرگسال',
		'child'=>'کودک',
	);

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ym_passengers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, family, gender, passport_num', 'required'),
			array('room_num', 'numerical', 'integerOnly'=>true),
			array('name, family', 'length', 'max'=>50),
			array('gender', 'length', 'max'=>6),
			array('passport_num', 'length', 'max'=>255),
			array('type, order_id', 'length', 'max'=>10),
			array('age', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, family, gender, passport_num, type, age, room_num, order_id', 'safe', 'on'=>'search'),
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
			'order' => array(self::BELONGS_TO, 'Order', 'order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'شناسه',
			'name' => 'نام',
			'family' => 'نام خانوادگی',
			'gender' => 'جنسیت',
			'passport_num' => 'شماره گذرنامه',
			'type' => 'نوع',
			'age' => 'سن',
			'room_num' => 'شماره اتاق',
			'order_id' => 'سفارش',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('family',$this->family,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('passport_num',$this->passport_num,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('age',$this->age,true);
		$criteria->compare('room_num',$this->room_num);
		$criteria->compare('order_id',$this->order_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Passengers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
