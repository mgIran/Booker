<?php

class HotelsController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + getMinMaxPrice, verify'
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
                'actions' => array('autoComplete', 'search', 'view', 'getMinMaxPrice', 'getHotelInfo', 'imagesCarousel', 'getCancelRule', 'checkout', 'bill', 'pay', 'verify'),
                'users' => array('*'),
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionAutoComplete($title)
    {
        Yii::app()->getModule('cityNames');
        $criteria = new CDbCriteria();
        $criteria->compare('city_name', $title, true);
        $query = CityNames::model()->findAll($criteria);
        $cities = array();
        if (empty($query)) {
            $countries = Countries::model()->findAll();
            $countries = CHtml::listData($countries, 'lowercaseIso', 'nicename');
            $postman = new Postman();
            $result = $postman->autoComplete($title);
            foreach ($result['Cities'] as $city)
                array_push($cities, array(
                    'name' => $city['name'] . ' , ' . $countries[$city['country']],
                    'key' => $city['key']
                ));
        } else {
            /* @var $city CityNames */
            foreach ($query as $city)
                array_push($cities, array(
                    'name' => $city->city_name . ' , ' . $city->country_name,
                    'key' => $city->city_key
                ));
        }
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

            if($result==-1)
                throw new CHttpException('مدت زمان مجاز برای انجام عملیات به اتمام رسیده؛ لطفا مجددا تلاش کنید.');

            $hotels = array();
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
                    'price' => $this->getFixedPrice($price),
                ));
            }
            $this->render('search', array(
                'hotelsDataProvider' => new CArrayDataProvider($hotels, array('pagination' => false)),
                'country' => $result['country'],
                'searchID' => $result['searchId'],
                //'city' => $result['city'],
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

    public function actionView($country, $hotel, $hotelID, $searchID)
    {
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/inner';
        $this->pageName = 'details-view';
        if (isset(Yii::app()->session['rooms']))
            $this->render('view', array(
                'id' => $hotelID,
                'searchID' => $searchID,
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
        $hotel = $postman->details(Yii::app()->getRequest()->getQuery('hotel_id'), Yii::app()->getRequest()->getQuery('search_id'));

        if($hotel==-1)
            throw new CHttpException('مدت زمان مجاز برای انجام عملیات به اتمام رسیده؛ لطفا مجددا تلاش کنید.');

        $requestedRooms = $this->getRoomsInfo(Yii::app()->session['rooms']);
        $rooms = $postman->search($hotel['id'], false, date('Y-m-d', Yii::app()->session['inDate']), date('Y-m-d', Yii::app()->session['outDate']), CJSON::encode($requestedRooms));

        if($rooms==-1)
            throw new CHttpException('مدت زمان مجاز برای انجام عملیات به اتمام رسیده؛ لطفا مجددا تلاش کنید.');

        $hotel['facilities'] = $this->translateFacilities($hotel['facilities']);
        $this->renderPartial('_view', array(
            'hotel' => $hotel,
            'rooms' => $rooms['results'][0]['services'],
            'searchID' => Yii::app()->getRequest()->getQuery('search_id'),
        ));
    }

    public function actionCheckout()
    {
        $traviaID = Yii::app()->getRequest()->getQuery('tid');
        $searchID = Yii::app()->getRequest()->getQuery('sid');
        if ($traviaID) {
            Yii::app()->getModule('pages');
            /* @var $buyTerms Pages */
            $buyTerms = Pages::model()->findByPk(4);
            $purifier = new CHtmlPurifier();
            $buyTerms = $purifier->purify($buyTerms->summary);
            $orderModel = new Order();
            $passengersModel = new Passengers();

            $this->performAjaxValidation($orderModel);

            $postman = new Postman();
            Yii::app()->theme = 'frontend';
            $this->layout = '//layouts/inner';
            $this->pageName = 'checkout';

            $details = $postman->priceDetails($traviaID, $searchID);
            if($details==-1)
                throw new CHttpException('مدت زمان مجاز برای انجام عملیات به اتمام رسیده؛ لطفا مجددا تلاش کنید.');

            $hotelDetails = $postman->details($traviaID, $searchID);
            if($hotelDetails==-1)
                throw new CHttpException('مدت زمان مجاز برای انجام عملیات به اتمام رسیده؛ لطفا مجددا تلاش کنید.');

            if (isset($_POST['Order'])) {
                $orderModel->attributes = $_POST['Order'];
                $orderModel->date = time();
                $orderModel->travia_id = $traviaID;
                $orderModel->price = $details['price'];
                $hasError = false;
                if ($orderModel->save()) {
                    $roomNum=0;
                    foreach ($_POST['Passengers'] as $room) {
                        foreach ($room as $passenger) {
                            $model = new Passengers();
                            $model->attributes=$passenger;
                            $model->room_num = $roomNum;
                            $model->order_id = $orderModel->id;
                            if (!$model->save()) {
                                $hasError = true;
                                Yii::app()->user->setFlash('errors', $this->implodeErrors($model));
                                $orderModel->delete();
                                break;
                            }
                        }
                        $roomNum++;
                        if ($hasError)
                            break;
                    }
                    if (!$hasError) {
                        Yii::app()->session['orderID'] = $orderModel->id;
                        $this->redirect('bill');
                    }
                }
            }

            $this->render('checkout', array(
                'buyTerms' => $buyTerms,
                'orderModel' => $orderModel,
                'passengersModel' => $passengersModel,
                'details' => $details,
                'hotelDetails' => array(
                    'name' => $hotelDetails['name'],
                    'star' => $hotelDetails['star'],
                    'city' => $hotelDetails['city'],
                    'image' => $hotelDetails['images'][0],
                ),
            ));
        } else
            $this->redirect(['/']);
    }

    public function actionBill()
    {
        if (isset(Yii::app()->session['orderID'])) {
            Yii::app()->theme = 'frontend';
            $this->layout = '//layouts/inner';
            $this->pageName = 'bill';

            /* @var $order Order */
            $order = Order::model()->findByPk(Yii::app()->session['orderID']);
            $postman = new Postman();

            $roomPassengers = array();
            foreach ($order->passengers as $passenger) {
                if ($passenger->type == 'child')
                    $roomPassengers[$passenger->room_num] = array(
                        'name' => $passenger->name,
                        'family' => $passenger->family,
                        'gender' => $passenger->gender,
                        'passportNo' => $passenger->passport_num,
                        'type' => 'child',
                        'age' => $passenger->age,
                    );
                elseif ($passenger->type == 'adult')
                    $roomPassengers[$passenger->room_num] = array(
                        'name' => $passenger->name,
                        'family' => $passenger->family,
                        'gender' => $passenger->gender,
                        'passportNo' => $passenger->passport_num,
                        'type' => 'adult',
                    );
            }

            $postman=new Postman();
            $book=$postman->book($order->travia_id, $roomPassengers);
            if($book['status']=='succeeded'){
                Order::model()->updateByPk($order->id, array('order_id' => $book['orderId']));
                $booking=new Bookings();
                $book['cancelRules']=CJSON::encode($book['cancelRules']);
                $book['services']=CJSON::encode($book['services']);
                $booking->attributes=$book;
                $booking->save();
            }
            var_dump($book);exit;

            $details = $postman->priceDetails($order->travia_id);
            $hotelDetails = $postman->details($order->travia_id);

            $this->render('bill', array(
                'order' => $order,
                'details'=>$details,
                'hotelDetails' => array(
                    'name' => $hotelDetails['name'],
                    'star' => $hotelDetails['star'],
                    'city' => $hotelDetails['city'],
                    'image' => $hotelDetails['images'][0],
                ),
            ));
        } else
            $this->redirect(array('/site'));
    }

    public function actionPay($id)
    {
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/empty';
        $order = Order::model()->findByPk($id);
        /* @var $order Order */
        $wsdl = "https://ikc.shaparak.ir/XToken/Tokens.xml";
        $client = new nusoap_client($wsdl, true);
        $client->soap_defencoding = 'UTF-8';
        $params['amount'] = $this->getFixedPrice($order->price); // قیمت
        $params['merchantId'] = "B0E2"; // مرچند کد
        $params['invoiceNo'] = $order->id; // شناسه فاکتور
        $params['paymentId'] = $order->id; // شناسه خرید
        $params['revertURL'] = "http://www.booker24.net/reservation/hotels/verify"; // آدرس بازگشت
        $result = $client->call("MakeToken", array($params));

        $this->render('pay', array(
            'bankResponse' => $result,
        ));
    }

    public function actionVerify()
    {
        $token = trim($_POST['token']); // همان توکنی که در مرحله رزرو ساخته شد
        $resultCode = trim($_POST['resultCode']); // کد برگشت که برای تراکنش موفق عدد 100 میباشد
        $paymentId = trim($_POST['paymentId']); // همان شناسه خرید که در مرحله ساخت توکن استفاده کردیم
        $referenceId = trim($_POST['referenceId']); // شناسه مرجع که بانک میسازه و قابل پیگیری هست

        if ($resultCode == '100') {
            $wsdl = "https://ikc.shaparak.ir/XVerify/Verify.xml";
            $client = new nusoap_client($wsdl, true);
            $client->soap_defencoding = 'UTF-8';
            $params['token'] = $token;
            $params['merchantId'] = 'B0E2'; // مرچند کد
            $params['referenceNumber'] = $referenceId;
            $params['sha1Key'] = '22338240992352910814917221751200141041845518824222260'; //sha1Key که از بانک باید گرفته شود
            $result = $client->call("KicccPaymentsVerification", array($params));
            $order = Order::model()->findByPk($paymentId);
            /* @var $order Order */
            if ($result['KicccPaymentsVerificationResult'] == $order->price) {
                Yii::app()->user->setFlash('success', 'پرداخت با موفقیت انجام شد.');
                Order::model()->updateByPk($paymentId, array('payment_tracking_code' => $referenceId));
                $transaction=new Transactions();
                $transaction->tracking_code=$referenceId;
                $transaction->amount=$order->price;
                $transaction->order_id=$paymentId;
                $transaction->date=time();
                $transaction->save();

                $roomPassengers = array();
                foreach ($order->passengers as $passenger) {
                    if ($passenger->type == 'child')
                        $roomPassengers[$passenger->room_num] = array(
                            'name' => $passenger->name,
                            'family' => $passenger->family,
                            'gender' => $passenger->gender,
                            'passportNo' => $passenger->passport_num,
                            'type' => 'child',
                            'age' => $passenger->age,
                        );
                    elseif ($passenger->type == 'adult')
                        $roomPassengers[$passenger->room_num] = array(
                            'name' => $passenger->name,
                            'family' => $passenger->family,
                            'gender' => $passenger->gender,
                            'passportNo' => $passenger->passport_num,
                            'type' => 'adult',
                        );
                }

                $postman=new Postman();
                $book=$postman->book($order->travia_id, $roomPassengers);
                var_dump($book);exit;

            } else {
                Yii::app()->user->setFlash('failed', 'عملیات پرداخت ناموفق بود.');
                $this->redirect('hotels/bill');
            }
        } else {
            Yii::app()->user->setFlash('failed', 'عملیات پرداخت ناموفق بود.');
            $this->redirect('hotels/bill');
        }


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
        $searchID = Yii::app()->request->getQuery('search_id');
        $postman = new Postman();
        $details = $postman->priceDetails($traviaId, $searchID);
        if ($details == -1) {
            echo CJSON::encode(array(
                'status' => 'failed',
                'error' => 'مدت زمان مجاز برای انجام عملیات به اتمام رسیده.'
            ));
            exit;
        }

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
        foreach ($cancelRules as $key => $cancelRule) {
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
                $str .= $prevDate . ' تا تاریخ ' . $date . ' هزینه کنسل کردن ';
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
            'Wedding Services' => 'خدمات جشن عروسي',
            'Water Sports' => 'ورزشهاي آبي',
            'Turkish Bath' => 'حمام تركي',
            'Tour Desk' => 'قسمت ارائه تورها',
            'Tennis' => 'زمين تنيس',
            'Television in lobby' => 'تلويزيون در لابي',
            'Television' => 'تلويزيون',
            'Swimming Pool Nearby' => 'استخر داخلي',
            'Swimming Pool' => 'استخر',
            'Steam Bath' => 'سوناي بخار',
            'Souvenirs / Gift Shop' => 'فروشگاه هدايا',
            'Snack Bar' => 'بوفه خوراكي',
            'Shop Arcade' => 'قسمت بازي هاي آنلاين',
            'Self Laundry' => 'خدمات لباس شويي',
            'Room Service' => 'خدمات پذيرايي به اتاق',
            'Poolside Bar' => 'نوشيدني كنار استخر',
            'Parasols' => 'چتر استخر',
            'Outdoor Swimming Pool' => 'استخر محوطه',
            'Meeting Rooms' => 'اتاق جلسات',
            'Market' => 'فروشگاه',
            'Library' => 'كتابخانه',
            'Internet Corner' => 'اينرنت',
            'Indoor Pool' => 'استخر سرپوشيده',
            'High-Speed Internet' => 'اينترنت پرسرعت',
            'Health Club' => 'باشگاه تندرستي و سلامتي',
            'Gym' => 'كنسول بازي',
            'Fitness Center' => 'باشگاه بدنسازي',
            'Executive / Club Floor' => 'باشگاه همكف',
            'Dry cleaning / laundry service' => 'خشكشويي و خدمات لباسشويي',
            'Concierge Desk' => 'دربان',
            'Child Care Service' => 'خدمات نگهداي كودك',
            'Breakfast available (Surcharg)' => 'صبحانه قابل درخواست ( باهزينه )',
            'Blackout drapes/curtains' => 'پرده',
            'Bicycle Rentals' => 'كرايه دوچرخه',
            'Beauty Salon' => 'سالن آرايش و زيبايي',
            'Bar / Lounge' => 'سالن نوشيدني',
            '24 Hour business center' => 'خدمات تجاري 24 ساعته',
            '24 Hour Check-In' => 'پذيرش 24 ساعته'
        );

        $output = array();
        foreach ($facilities as $facility) {
            $addedToOutput = false;
            foreach ($translates as $key => $translate) {
                if (strtolower($facility) == strtolower($key)) {
                    $output[] = $translate;
                    $addedToOutput = true;
                }
            }
            if (!$addedToOutput)
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

    /**
     * Performs the AJAX validation.
     * @param Order $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'order-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}