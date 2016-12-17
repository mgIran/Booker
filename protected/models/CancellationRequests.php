<?php

/**
 * This is the model class for table "ym_cancellation_requests".
 *
 * The followings are the available columns in table 'ym_cancellation_requests':
 * @property string $id
 * @property string $orderId
 * @property string $created_date
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Bookings $booking
 */
class CancellationRequests extends CActiveRecord
{
    public $statusLabels=array(
        'pending'=>'در انتظار',
        'canceled'=>'کنسل شده',
        'refused'=>'رد شده',
    );

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'ym_cancellation_requests';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('orderId', 'required'),
            array('orderId', 'checkOrderID'),
            array('created_date', 'default', 'value' => time()),
            array('orderId, created_date', 'length', 'max' => 20),
            array('status', 'length', 'max'=>8),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, orderId, created_date, status', 'safe', 'on' => 'search'),
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
            'booking' => array(self::BELONGS_TO, 'Bookings', 'orderId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'شناسه',
            'orderId' => 'کد رهگیری رزرو',
            'created_date' => 'تاریخ ثبت درخواست',
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
        $criteria->compare('orderId', $this->orderId, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('status',$this->status,true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CancellationRequests the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function checkOrderID($attribute, $params)
    {
        if (!preg_match('/(^B24-)(\d*)/', $this->$attribute))
            $this->addError($attribute, 'کد رهگیری وارد شده اشتباه است.');
        else {
            preg_match('/(^B24-)(\d*)/', $this->$attribute, $matches);
            $orderID = $matches[2];
            $booking = Bookings::model()->find('orderId = :order_id', array(':order_id' => $orderID));
            if (is_null($booking))
                $this->addError($attribute, 'کد رهگیری وارد شده در سیستم موجود نیست.');
        }
    }

    public function beforeSave()
    {
        if (parent::beforeSave()) {
            preg_match('/(^B24-)(\d*)/', $this->orderId, $matches);
            $this->orderId = $matches[2];
            return true;
        }
        return false;
    }
}