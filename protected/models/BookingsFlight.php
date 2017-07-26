<?php

/**
 * This is the model class for table "ym_bookings_flight".
 *
 * The followings are the available columns in table 'ym_bookings_flight':
 * @property string $id
 * @property string $searchId
 * @property string $identity
 * @property string $currency
 * @property string $agencyCommission
 * @property string $taxes
 * @property string $basePrice
 * @property string $totalPrice
 * @property string $passengers
 * @property string $createdAt
 * @property string $flights
 * @property string $orderId
 * @property string $order_id
 *
 * The followings are the available model relations:
 * @property OrderFlight $order
 */
class BookingsFlight extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ym_bookings_flight';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('searchId, identity, currency, agencyCommission, taxes, basePrice, totalPrice, createdAt, orderId', 'length', 'max'=>50),
			array('order_id', 'length', 'max'=>10),
			array('passengers, flights', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, searchId, identity, currency, agencyCommission, taxes, basePrice, totalPrice, passengers, createdAt, flights, orderId, order_id', 'safe', 'on'=>'search'),
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
			'searchId' => 'Search',
			'identity' => 'Identity',
			'currency' => 'Currency',
			'agencyCommission' => 'Agency Commission',
			'taxes' => 'Taxes',
			'basePrice' => 'Base Price',
			'totalPrice' => 'Total Price',
			'passengers' => 'Passengers',
			'createdAt' => 'Created At',
			'flights' => 'Flights',
			'orderId' => 'Order',
			'order_id' => 'Order',
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
		$criteria->compare('searchId',$this->searchId,true);
		$criteria->compare('identity',$this->identity,true);
		$criteria->compare('currency',$this->currency,true);
		$criteria->compare('agencyCommission',$this->agencyCommission,true);
		$criteria->compare('taxes',$this->taxes,true);
		$criteria->compare('basePrice',$this->basePrice,true);
		$criteria->compare('totalPrice',$this->totalPrice,true);
		$criteria->compare('passengers',$this->passengers,true);
		$criteria->compare('createdAt',$this->createdAt,true);
		$criteria->compare('flights',$this->flights,true);
		$criteria->compare('orderId',$this->orderId,true);
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->order = 'id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BookingsFlight the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
