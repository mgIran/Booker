<?php

/**
 * This is the model class for table "ym_order_flight".
 *
 * The followings are the available columns in table 'ym_order_flight':
 * @property string $id
 * @property string $buyer_name
 * @property string $buyer_family
 * @property string $buyer_mobile
 * @property string $buyer_email
 * @property string $date
 * @property string $price
 * @property string $commission
 * @property string $payment_tracking_code
 * @property string $search_id
 * @property string $one_way_travia_id
 * @property string $return_travia_id
 * @property string $status
 *
 * The followings are the available model relations:
 * @property BookingsFlight $booking
 * @property PassengersFlight[] $passengers
 */
class OrderFlight extends CActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_PAID = 1;
    const STATUS_CLOSE = 2;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'ym_order_flight';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('buyer_name, buyer_family, buyer_mobile, buyer_email', 'required'),
            array('buyer_name, buyer_family', 'length', 'max' => 50),
            array('buyer_mobile', 'length', 'max' => 11),
            array('buyer_email, payment_tracking_code, search_id', 'length', 'max' => 255),
            array('date, price, commission, one_way_travia_id, return_travia_id', 'length', 'max' => 20),
            array('status', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, buyer_name, buyer_family, buyer_mobile, buyer_email, date, price, commission, payment_tracking_code, search_id, one_way_travia_id, return_travia_id', 'safe', 'on' => 'search'),
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
            'booking' => array(self::HAS_ONE, 'BookingsFlight', 'order_id'),
            'passengers' => array(self::HAS_MANY, 'PassengersFlight', 'order_id'),
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
            'price' => 'مبلغ',
            'commission' => 'کمیسیون سایت',
            'payment_tracking_code' => 'کد رهگیری پرداخت',
            'search_id' => 'شناسه جستجو',
            'one_way_travia_id' => 'شناسه تراویا (رفت)',
            'return_travia_id' => 'شناسه تراویا (برگشت)',
            'status' => 'وضعیت',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('buyer_name', $this->buyer_name, true);
        $criteria->compare('buyer_family', $this->buyer_family, true);
        $criteria->compare('buyer_mobile', $this->buyer_mobile, true);
        $criteria->compare('buyer_email', $this->buyer_email, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('commission', $this->commission, true);
        $criteria->compare('payment_tracking_code', $this->payment_tracking_code, true);
        $criteria->compare('search_id', $this->search_id, true);
        $criteria->compare('one_way_travia_id', $this->one_way_travia_id, true);
        $criteria->compare('return_travia_id', $this->return_travia_id, true);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return OrderFlight the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getFullName()
    {
        return $this->buyer_name . ' ' . $this->buyer_family;
    }
}