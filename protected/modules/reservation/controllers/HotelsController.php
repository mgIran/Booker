<?php

class HotelsController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + getMinMaxPrice'
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
                'actions' => array('autoComplete', 'search', 'view', 'getMinMaxPrice', 'getHotelInfo', 'imagesCarousel', 'getCancelRule', 'checkout'),
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
        Yii::app()->session['minPrice'] = null;
        Yii::app()->session['maxPrice'] = null;
        if (isset($_GET['ajax']) and $_GET['ajax'] == 'hotels-list') {
            $rooms = $this->getRoomsInfo(Yii::app()->session['rooms']);
            $postman = new Postman();
            $result = $postman->search(Yii::app()->session['cityKey'], true, date('Y-m-d', Yii::app()->session['inDate']), date('Y-m-d', Yii::app()->session['outDate']), CJSON::encode($rooms));
            var_dump($result);
            $hotels = array();
            Yii::app()->getModule('setting');
            $commission = SiteSetting::model()->findByAttributes(array('name' => 'commission'));
            foreach ($result['results'] as $hotel) {
                $price = null;
                $traviaID = '';
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

    public function actionView($country, $city, $hotel, $hotelID)
    {
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/inner';
        $this->pageName = 'details-view';
        if (isset(Yii::app()->session['rooms']))
            $this->render('view', array(
                'id' => $hotelID
            ));
        else
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

    public function actionGetHotelInfo()
    {
        $postman = new Postman();
        $hotel = $postman->details(Yii::app()->getRequest()->getQuery('hotel_id'));
        $requestedRooms = $this->getRoomsInfo(Yii::app()->session['rooms']);
        $rooms = $postman->search($hotel['id'], false, date('Y-m-d', Yii::app()->session['inDate']), date('Y-m-d', Yii::app()->session['outDate']), CJSON::encode($requestedRooms));
        $hotel['facilities']=$this->translateFacilities($hotel['facilities']);
        $this->renderPartial('_view', array(
            'hotel' => $hotel,
            'rooms' => $rooms['results'][0]['services'],
        ));
    }

    public function actionCheckout()
    {
        $traviaID = Yii::app()->getRequest()->getQuery('tid');
        if ($traviaID) {
            $postman = new Postman();
            $availability=$postman->checkAvailability($traviaID);
            Yii::app()->theme = 'frontend';
            $this->layout = '//layouts/inner';
            $this->pageName = 'checkout';
            if(isset($availability['price'])) {
                $details = $postman->priceDetails($traviaID);
                $hotelDetails = $postman->details($traviaID);

                $model=new Order();

                $this->render('checkout', array(
                    'model'=>$model,
                    'availability' => true,
                    'details' => $details,
                    'hotelDetails' => array(
                        'name' => $hotelDetails['name'],
                        'star' => $hotelDetails['star'],
                        'city' => $hotelDetails['city'],
                        'image' => $hotelDetails['images'][0],
                    ),
                ));
            }else
                $this->render('checkout', array(
                    'availability' => false,
                ));
        } else
            $this->redirect(['/']);
    }

    public function getStayingTime($in, $out)
    {
        $diff = $out - $in;
        return floor($diff / (60 * 60 * 24));
    }

    public function actionGetMinMaxPrice()
    {
        echo CJSON::encode(array(
            'prices' => array(
                'minPrice' => Yii::app()->session['minPrice'],
                'maxPrice' => Yii::app()->session['maxPrice'],
            )
        ));
    }

    public function actionGetCancelRule()
    {
        $traviaId = Yii::app()->request->getQuery('tid');
        $price = Yii::app()->request->getQuery('price');
        $postman = new Postman();
        $details = $postman->priceDetails($traviaId);
        $str = '';
        foreach ($details['cancelRules'] as $cancelRule) {
            $str .= 'از امروز تا تاریخ ';
            $date = strtotime($details['checkIn']);
            $date = $date - ($cancelRule['remainDays'] * 60 * 60 * 24);
            $date = JalaliDate::date('d F Y', $date);
            $str .= $date . ' هزینه کنسل کردن ';
            $ratio = floatval($cancelRule['ratio']);
            $price = $price * $ratio;
            $str .= number_format($price, 0) . ' تومان می باشد.<br>';
        }
        echo CJSON::encode(array(
            'status' => 'success',
            'rules' => $str
        ));
    }

    public function getCancelRuleString($cancelRules, $checkIn, $price)
    {
            $str = '<ul>';
        foreach ($cancelRules as $key=>$cancelRule) {
            if ($str == '<ul>') {
                $str .= '<li>از امروز تا تاریخ ';
                $date = strtotime($checkIn);
                $date = $date - ($cancelRule['remainDays'] * 60 * 60 * 24);
                $date = JalaliDate::date('d F Y', $date);
                $str .= $date . ' هزینه کنسل کردن ';
                $ratio = floatval($cancelRule['ratio']);
                $price = $price * $ratio;
                $str .= number_format($price, 0) . ' تومان می باشد.</li>';
            } else {
                $str .= '<li>از تاریخ ';
                $date = strtotime($checkIn);
                $date = $date - ($cancelRule['remainDays'] * 60 * 60 * 24);
                $prevDate = $date - ($cancelRules[$key - 1]['remainDays'] * 60 * 60 * 24);
                $date = JalaliDate::date('d F Y', $date);
                $prevDate = JalaliDate::date('d F Y', $prevDate);
                $str .= $prevDate.' تا تاریخ '.$date . ' هزینه کنسل کردن ';
                $ratio = floatval($cancelRule['ratio']);
                $price = $price * $ratio;
                $str .= number_format($price, 0) . ' تومان می باشد.</li>';
            }
        }
        return $str;
    }

    public function translateFacilities($facilities)
    {
        $translates = array(
            'Business Centre' => 'اتاق جلسات تجاري',
            'Elevator / Lift' => 'آسانسور',
            'Car Rental' => 'اجاره ماشين',
            'Express Check In / Check Out' => 'پذيرش و خروج سريع مسافر',
            'Lounge' => 'سالن اجتماعات',
            'Shop(s)' => 'فروشگاه ها',
            'Bar' => 'خدمات نوشيدني',
            'Wireless Internet Access' => 'دسترسي به اينترنت بيسيم',
            'Laundry Service' => 'خدمات خشكشويي',
            '24 Hour Front Desk' => 'خدمات 24 ساعته پذيرش',
            '24 Hour Room Service' => 'خدمات 24 ساعته به اتاق',
            'Disco / Night Clubs' => 'كلوپ',
            'Hairdresser' => 'آريشگاه',
            'Pay Parking' => 'پاركينگ',
            'Private beach (chargeable)' => 'ساحل اختصاصي ( شارژ)',
            'Cable / Satellite Television' => 'گيرنده تلوزيون',
            'Free Wireless Internet access' => 'اينترنت بيسيم رايگان',
            'Sauna' => 'سونا',
            'Internet Access' => 'دسترسي اينترنت',
            'Safety Deposit Box' => 'صندوق امانات',
            'Restaurant' => 'رستوران',
            'Air Conditioned' => 'سيستم سرمايشي و گرمايشي اتاق',
            'Private balcony / terrace' => 'بالكن و تراس خصوصي',
            'Massage' => 'ماساژ',
            'Solarium' => 'حمام آفتاب',
            'Pool' => 'استخر',
            'Spa' => 'آب درماني',
            'Tv' => 'تلويزون',
            'Outdoor pool' => 'استخر عمومي',
            'Airport shuttle' => 'سرويس فرودگاه',
            'Family rooms' => 'اتاق خانوادگي',
            'Fitness centre' => 'سالن بدنسازي',
            'Non-smoking rooms' => 'اتاق غير سيگاري ها',
            'Daily maid service' => 'خدمات روزانه  خدمتكاري',
            'Golf course' => 'زمين گلف',
            'Tennis court' => 'زمين تنيس',
            'Spa and wellness centre' => 'مركز آبگرم و آب درماني',
            'Facilities for disabled guests' => 'امكانات براي مهمانان معلول',
            'Garden' => 'باغ',
            "Children's playground" => 'زمين بازي كودكان',
            'Pets are not allowed' => 'عدم پذيرش حيوان خانگي',
            'Languages spoken' => 'زبان مكالمه اي',
            'Pets allowed' => 'پذيرش حيوان خانگي',
            'Ironing service' => 'خدمات اتو',
            'Wake-up service' => 'خدمات بيدار كردن',
            'Exchange' => 'صرافي',
        );

        $output=array();
        foreach($facilities as $facility) {
            $addedToOutput=false;
            foreach ($translates as $key => $translate) {
                if (strtolower($facility) == strtolower($key)) {
                    $output[] = $translate;
                    $addedToOutput=true;
                }
            }
            if(!$addedToOutput)
                $output[] = $facility;
        }
        rsort($output);
        return $output;
    }

    public function getChildsCount($rooms)
    {
        $childs = 0;
        foreach ($rooms as $room)
            if ($room['child'] !== 0)
                $childs += count(explode(',', $room['child']));
        return $childs;
    }

    public function getAdultsCount($rooms)
    {
        $adults = 0;
        foreach ($rooms as $room)
            $adults += $room['adult'];
        return $adults;
    }
}