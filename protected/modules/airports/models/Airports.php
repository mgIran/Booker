<?php

/**
 * This is the model class for table "ym_airports".
 *
 * The followings are the available columns in table 'ym_airports':
 * @property integer $id
 * @property integer $country_id
 * @property string $country_code
 * @property string $city_code
 * @property string $city
 * @property string $IATA
 * @property string $airport
 * @property integer $is_city
 * @property string $unic_air
 * @property string $airport_fa
 * @property string $city_fa
 * @property string $country_fa
 * @property string $latitude
 * @property string $longitude
 */
class Airports extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ym_airports';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('country_id, country_code, city_code, city, IATA, airport, is_city, unic_air', 'required'),
			array('country_id, is_city', 'numerical', 'integerOnly'=>true),
			array('country_code, city_code, IATA', 'length', 'max'=>5),
			array('city, airport, airport_fa, city_fa, country_fa', 'length', 'max'=>50),
			array('unic_air', 'length', 'max'=>6),
			array('latitude, longitude', 'length', 'max'=>16),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, country_id, country_code, city_code, city, IATA, airport, is_city, unic_air, airport_fa, city_fa, country_fa, latitude, longitude', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'country_id' => 'Country',
			'country_code' => 'Country Code',
			'city_code' => 'City Code',
			'city' => 'City',
			'IATA' => 'Iata',
			'airport' => 'Airport',
			'is_city' => 'Is City',
			'unic_air' => 'Unic Air',
			'airport_fa' => 'Airport Fa',
			'city_fa' => 'City Fa',
			'country_fa' => 'Country Fa',
			'latitude' => 'Latitude',
			'longitude' => 'Longitude',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('country_code',$this->country_code,true);
		$criteria->compare('city_code',$this->city_code,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('IATA',$this->IATA,true);
		$criteria->compare('airport',$this->airport,true);
		$criteria->compare('is_city',$this->is_city);
		$criteria->compare('unic_air',$this->unic_air,true);
		$criteria->compare('airport_fa',$this->airport_fa,true);
		$criteria->compare('city_fa',$this->city_fa,true);
		$criteria->compare('country_fa',$this->country_fa,true);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('longitude',$this->longitude,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Airports the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getFieldByIATA($iata, $field)
	{
        $record = self::model()->find('IATA = :iata', [':iata' => $iata]);

        if ($record and $record->$field)
			return $record->$field;
		return '';
	}
}
