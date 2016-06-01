<?php

class DefaultController extends Controller
{
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'views' actions
				'actions' => array('autoComplete'),
				'users' => array('*'),
			),
			array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	protected function getData($method, $data)
	{
		$key = 'R204F3J6IMKU82';
		$url = 'http://travia.global/v1/hotel/' . $method;
		$headers = array(
			'Content-Type:application/json',
			'Authorization: Basic ' . base64_encode(":" . $key)
		);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		return CJSON::decode($response);
	}

	public function actionAutoComplete($query)
    {
        $countries = Countries::model()->findAll();
        $countries = CHtml::listData($countries, 'lowercaseIso', 'nicename');
        $data = '{"autoCompleteRq":{"query":"' . $query . '","domestic":false}}';
        $result = $this->getData('getautocomplete', $data);
        $cities = array();
        foreach ($result['autoCompleteRs']['Cities'] as $city)
            array_push($cities, array(
                'name' => $city['name'] . ' , ' . $countries[$city['country']],
                'key' => $city['key']
            ));
        echo CJSON::encode($cities);
    }
}