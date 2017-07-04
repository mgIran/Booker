<?php

/**
 * This is the model class for table "ym_passengers_flight".
 *
 * The followings are the available columns in table 'ym_passengers_flight':
 * @property string $id
 * @property string $name_en
 * @property string $family_en
 * @property string $name_fa
 * @property string $family_fa
 * @property string $gender
 * @property string $passport_num
 * @property string $type
 * @property string $birth_date
 * @property string $national_id
 * @property string $order_id
 *
 * The followings are the available model relations:
 * @property OrderFlight $order
 */
class PassengersFlight extends CActiveRecord
{
	public static $typeLabels = [
		'ADT'=>'بزرگسال',
		'CNN'=>'کودک',
		'INF'=>'نوزاد',
	];

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ym_passengers_flight';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name_en, family_en, name_fa, family_fa, passport_num', 'length', 'max'=>50),
			array('gender', 'length', 'max'=>6),
			array('type, national_id, order_id', 'length', 'max'=>10),
			array('birth_date', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name_en, family_en, name_fa, family_fa, gender, passport_num, type, birth_date, national_id, order_id', 'safe', 'on'=>'search'),
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
			'order' => array(self::BELONGS_TO, 'OrderFlight', 'order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'شناسه',
			'name_en' => 'نام انگلیسی',
			'family_en' => 'نام خانوادگی انگلیسی',
			'name_fa' => 'نام فارسی',
			'family_fa' => 'نام خانوادگی فارسی',
			'gender' => 'جنسیت',
			'passport_num' => 'شماره گذرنامه',
			'type' => 'نوع مسافر',
			'birth_date' => 'تاریخ تولد',
			'national_id' => 'کد ملی',
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
		$criteria->compare('name_en',$this->name_en,true);
		$criteria->compare('family_en',$this->family_en,true);
		$criteria->compare('name_fa',$this->name_fa,true);
		$criteria->compare('family_fa',$this->family_fa,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('passport_num',$this->passport_num,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('birth_date',$this->birth_date,true);
		$criteria->compare('national_id',$this->national_id,true);
		$criteria->compare('order_id',$this->order_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PassengersFlight the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
