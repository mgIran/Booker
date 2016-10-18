<?php

/**
 * This is the model class for table "ym_bookings".
 *
 * The followings are the available columns in table 'ym_bookings':
 * @property string $id
 * @property string $order_id
 * @property string $hotel
 * @property string $star
 * @property string $country
 * @property string $city
 * @property string $passenger
 * @property string $code
 * @property string $traviaId
 * @property string $createdAt
 * @property string $checkIn
 * @property string $checkOut
 * @property string $nationality
 * @property string $currency
 * @property string $hotelId
 * @property string $meal
 * @property string $price
 * @property string $status
 * @property string $nonrefundable
 * @property string $cancelRules
 * @property string $services
 * @property string $orderId
 *
 * The followings are the available model relations:
 * @property Order $order
 */
class Bookings extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ym_bookings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, passenger', 'length', 'max'=>10),
			array('hotel, country, city, code, traviaId, createdAt, checkIn, checkOut, nationality, currency, hotelId, meal, price, status, nonrefundable, orderId', 'length', 'max'=>255),
			array('star', 'length', 'max'=>2),
			array('cancelRules, services', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, order_id, hotel, star, country, city, passenger, code, traviaId, createdAt, checkIn, checkOut, nationality, currency, hotelId, meal, price, status, nonrefundable, cancelRules, services, orderId', 'safe', 'on'=>'search'),
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
			'order_id' => 'سفارش',
			'hotel' => 'هتل',
			'star' => 'تعداد ستاره های هتل',
			'country' => 'کشور',
			'city' => 'شهر',
			'passenger' => 'تعداد مسافرین',
			'code' => 'کد',
			'traviaId' => 'شناسه تراویا',
			'createdAt' => 'تاریخ ثبت',
			'checkIn' => 'تاریخ ورود',
			'checkOut' => 'تاریخ خروج',
			'nationality' => 'ملیت',
			'currency' => 'واحد ارز',
			'hotelId' => 'شناسه هتل',
			'meal' => 'پذیرایی',
			'price' => 'قیمت',
			'status' => 'وضعیت',
			'nonrefundable' => 'قابلیت استرداد',
			'cancelRules' => 'شرایط کنسلی',
			'services' => 'سرویس',
			'orderId' => 'شناسه سفارش',
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
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('hotel',$this->hotel,true);
		$criteria->compare('star',$this->star,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('passenger',$this->passenger,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('traviaId',$this->traviaId,true);
		$criteria->compare('createdAt',$this->createdAt,true);
		$criteria->compare('checkIn',$this->checkIn,true);
		$criteria->compare('checkOut',$this->checkOut,true);
		$criteria->compare('nationality',$this->nationality,true);
		$criteria->compare('currency',$this->currency,true);
		$criteria->compare('hotelId',$this->hotelId,true);
		$criteria->compare('meal',$this->meal,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('nonrefundable',$this->nonrefundable,true);
		$criteria->compare('cancelRules',$this->cancelRules,true);
		$criteria->compare('services',$this->services,true);
		$criteria->compare('orderId',$this->orderId,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Bookings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
