<?php

class HotelsController extends Controller
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
				'actions' => array('autoComplete', 'search'),
				'users' => array('*'),
			),
			array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	public function actionAutoComplete($title)
    {
        $countries = Countries::model()->findAll();
        $countries = CHtml::listData($countries, 'lowercaseIso', 'nicename');
        $postman=new Postman();
        $result = $postman->autoComplete($title);
        $cities = array();
        foreach ($result['Cities'] as $city)
            array_push($cities, array(
                'name' => $city['name'] . ' , ' . $countries[$city['country']],
                'key' => $city['key']
            ));
        echo CJSON::encode($cities);
    }

	public function actionSearch()
	{
        if(isset(Yii::app()->session['cityName'])) {
            Yii::app()->theme = 'frontend';
            $this->layout = '//layouts/inner';
            $this->pageName='search';
            $this->render('search');
            /*$rooms = array();
            foreach (Yii::app()->session['rooms'] as $room) {
                if ($room['kids'] != 0)
                    $rooms[] = array(
                        'adult' => $room['adults'],
                        'child' => $room['kids'],
                        'childAge' => array_values($room['kids_age'])
                    );
                else
                    $rooms[] = array(
                        'adult' => $room['adults'],
                    );
            }
            $postman = new Postman();
            $result = $postman->search(Yii::app()->session['cityKey'], date('Y-m-d', Yii::app()->session['inDate']), date('Y-m-d', Yii::app()->session['outDate']), CJSON::encode($rooms));
            var_dump($result);*/
        }
        else
            $this->redirect('/');
	}
}