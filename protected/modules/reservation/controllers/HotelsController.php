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
                'actions' => array('autoComplete', 'search', 'view'),
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
        $postman = new Postman();
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
        if (isset($_GET['ajax']) and $_GET['ajax'] == 'hotels-list') {
            $rooms = $this->getRoomsInfo(Yii::app()->session['rooms']);
            $postman = new Postman();
            $result = $postman->search(Yii::app()->session['cityKey'], true, date('Y-m-d', Yii::app()->session['inDate']), date('Y-m-d', Yii::app()->session['outDate']), CJSON::encode($rooms));
            $hotels = array();
            Yii::app()->getModule('setting');
            $commission = SiteSetting::model()->findByAttributes(array('name' => 'commission'));
            foreach ($result['results'] as $hotel) {
                $price = null;
                $traviaID='';
                foreach ($hotel['services'] as $service) {
                    if (is_null($price)) {
                        $price = $service['price'];
                        $traviaID = $service['traviaId'];
                    } elseif ($service['price'] < $price)
                        $price = $service['price'];
                }
                array_push($hotels, array(
                    'name' => $hotel['name'],
                    'star' => $hotel['star'],
                    'id' => $hotel['id'],
                    'traviaID' => $traviaID,
                    'image' => array(
                        'tag' => $hotel['images'][0]['tag'],
                        'src' => $hotel['images'][0]['original'],
                    ),
                    'price' => ($price * 4000) + $commission->value,
                ));
            }
            $this->render('search', array(
                'hotelsDataProvider' => new CArrayDataProvider($hotels, array('pagination' => false)),
                'country' => $result['country'],
                'city' => $result['city'],
            ));
            Yii::app()->end();
        }

        if (isset($_POST['destination'])) {
            Yii::app()->session->clear();
            Yii::app()->session['cityName'] = $_POST['destination'];
            Yii::app()->session['cityKey'] = $_POST['city_key'];
            Yii::app()->session['inDate'] = $_POST['enter-date_altField'];
            Yii::app()->session['outDate'] = $_POST['out-date_altField'];
            Yii::app()->session['roomsCount'] = $_POST['rooms-count'];
            Yii::app()->session['rooms'] = $_POST['rooms'];
        }

        if (isset(Yii::app()->session['cityName'])) {
            Yii::app()->theme = 'frontend';
            $this->layout = '//layouts/inner';
            $this->pageName = 'search';
            $this->render('search', array(
                'hotelsDataProvider' => new CArrayDataProvider(array()),
            ));
        } else
            $this->redirect('/');
    }

    public function actionView($country,$city,$hotel,$hotelID)
    {
        if (isset(Yii::app()->session['rooms'])) {
            Yii::app()->theme='frontend';
            $this->layout = '//layouts/inner';
            $this->pageName = 'details-view';
            $postman = new Postman();
            $result=$postman->details($hotelID);
            $this->render('view', array(
                'hotel'=>$result,
            ));
        } else
            $this->redirect(['/']);
    }

    protected function getRoomsInfo($roomsArray)
    {
        $rooms = array();
        foreach ($roomsArray as $room) {
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
        return $rooms;
    }
}