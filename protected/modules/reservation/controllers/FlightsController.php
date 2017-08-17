<?php

class FlightsController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + verify, loadMore',
            'ajaxOnly + mail, loadMore, booking'
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
            array('allow',
                'actions' => array('masoud','autoComplete', 'search', 'checkout', 'bill', 'pay', 'verify', 'mail', 'loadMore', 'ticket', 'cancellation', 'domesticAirports', 'booking'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('viewCancellationRequest', 'viewBooking', 'cancel', 'refuseCancel'),
                'roles' => array('admin'),
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionAutoComplete($title)
    {
        $airports = array();
        $countries = Countries::model()->findAll();
        $countries = CHtml::listData($countries, 'iso', 'nicename');
        $postman = new FlightPostman();
        $results = $postman->autoComplete($title);
        foreach ($results as $result)
            array_push($airports, array(
                'name' => $result['city'] . ', ' . $result['airport'] . ' (' . $result['IATA'] . ') ' . $countries[$result['country_code']],
                'iata' => $result['IATA'],
                'isCity' => $result['is_city'],
            ));

        echo CJSON::encode($airports);
    }

    public function actionSearch()
    {
        Yii::app()->getModule('airports');
        if (isset($_GET['ajax'])) {
            $rDate = Yii::app()->session['dirType'] == 'two-way' ? date('Y-m-d', Yii::app()->session['rDate']) : null;
            $postman = new FlightPostman();
            $result = $postman->search(
                Yii::app()->session['domestic'] ? 'true' : 'false',
                Yii::app()->session['origin'],
                Yii::app()->session['destination'],
                date('Y-m-d', Yii::app()->session['date']),
                $rDate,
                Yii::app()->session['adult'],
                Yii::app()->session['child'],
                Yii::app()->session['infant'],
                Yii::app()->session['class'],
                Yii::app()->session['fromIsCity'],
                Yii::app()->session['toIsCity']
            );

            $nextPage = null;
            if (isset($result['nextPage']))
                $nextPage = $result['nextPage'];

            $flights = array();
            if (isset($result['flights']))
                $flights = $result['flights'];

            $this->render('search', array(
                'flightsDataProvider' => new CArrayDataProvider($flights, array('keyField' => false, 'pagination' => false)),
                'searchID' => isset($result['searchId'])?$result['searchId']:null,
                'nextPage' => $nextPage,
            ));

            Yii::app()->end();
        }

        if (isset($_POST['dom-flight-departure'])) {
            Yii::app()->session->clear();
            Yii::app()->session['domestic'] = $_POST['flight-domestic-dropdown'] == 1 ? true : false;
            Yii::app()->session['dirType'] = $_POST['flight-dir-type-dropdown'];
            if ($_POST['flight-domestic-dropdown'] == 1) {
                Yii::app()->session['origin'] = $_POST['dom_flight_departure_iata'];
                Yii::app()->session['destination'] = $_POST['dom_flight_arrival_iata'];
                Yii::app()->session['fromIsCity'] = 0;
                Yii::app()->session['toIsCity'] = 0;
                Yii::app()->session['originName'] = $_POST['dom-flight-departure'];
                Yii::app()->session['destinationName'] = $_POST['dom-flight-arrival'];
            } else {
                Yii::app()->session['origin'] = $_POST['non_dom_flight_departure_iata'];
                Yii::app()->session['destination'] = $_POST['non_dom_flight_arrival_iata'];
                Yii::app()->session['fromIsCity'] = $_POST['non_dom_flight_from_is_city'];
                Yii::app()->session['toIsCity'] = $_POST['non_dom_flight_arrival_iata'];
                Yii::app()->session['originName'] = $_POST['non-dom-flight-departure'];
                Yii::app()->session['destinationName'] = $_POST['non-dom-flight-arrival'];
            }
            Yii::app()->session['date'] = $_POST['departure-date_altField'];
            if ($_POST['flight-dir-type-dropdown'] == 'two-way')
                Yii::app()->session['rDate'] = $_POST['return-date_altField'];
            Yii::app()->session['adult'] = $_POST['flight_adult_count'];
            Yii::app()->session['child'] = $_POST['flight_child_count'];
            Yii::app()->session['infant'] = $_POST['flight_infant_count'];
            Yii::app()->session['class'] = '0';
        } elseif (isset($_POST['search_id']))
            $this->redirect('checkout?sid=' . $_POST['search_id'] . '&oid=' . $_POST['one_way_id'] . '&rid=' . ($_POST['travel_type'] == 'two-way' ? $_POST['return_id'] : '-1'));

        if (isset(Yii::app()->session['origin'])) {
            Yii::app()->theme = 'frontend';
            $this->layout = '//layouts/inner';
            $this->pageName = 'search';
//            if (Yii::app()->session['domestic']) {
//                $this->render('domestic-search', array(
//                    'oneWayDataProvider' => new CArrayDataProvider(array()),
//                    'returnDataProvider' => new CArrayDataProvider(array()),
//                    'searchID' => null
//                ));
//            } else {
//                $this->render('non-domestic-search', array(
//                    'flightsDataProvider' => new CArrayDataProvider(array()),
//                    'searchID' => null
//                ));
//            }
            $this->render('search', array(
                'flightsDataProvider' => new CArrayDataProvider(array()),
                'searchID' => null
            ));
        } else
            $this->redirect('/');
    }

    public function actionCheckout()
    {
        $oneWayID = Yii::app()->getRequest()->getQuery('oid');
        $returnID = Yii::app()->getRequest()->getQuery('rid');
        $searchID = Yii::app()->getRequest()->getQuery('sid');

        if ($oneWayID and $returnID and $searchID) {
            Yii::app()->getModule('pages');
            /* @var $buyTerms Pages */
            $buyTerms = Pages::model()->findByPk(5);
            $purifier = new CHtmlPurifier();
            $buyTerms = $purifier->purify($buyTerms->summary);
            $orderModel = new OrderFlight();
            $passengersModel = new PassengersFlight();

            $this->performAjaxValidation($orderModel);

            $postman = new FlightPostman();
            Yii::app()->theme = 'frontend';
            $this->layout = '//layouts/inner';
            $this->pageName = 'checkout';

            $details = $postman->priceDetails($oneWayID, $returnID == -1 ? null : $returnID, $searchID);

            // Calculate price
            $oneWayPrice = 0;
            $returnPrice = 0;
            foreach ($details['flights']['oneWay']['fares'] as $fare)
                $oneWayPrice += doubleval($fare['count'] * $fare['basePrice']);
            if (isset($details['flights']['return'])) {
                foreach ($details['flights']['return']['fares'] as $fare)
                    $returnPrice += doubleval($fare['count'] * $fare['basePrice']);
            }

            if (isset($_POST['OrderFlight'])) {
                $totalPrice = $totalCommission = 0;
                $totalPrice += $this->getFixedPrice($oneWayPrice/10, true, $details['flights']['oneWay']['type'])['price'];
                $totalCommission += $this->getFixedPrice($oneWayPrice/10, true, $details['flights']['oneWay']['type'])['commission'];
                if(isset($details['flights']['return']) and !$details['isTotalPrice']) {
                    $totalPrice += $this->getFixedPrice($returnPrice / 10, true, $details['flights']['return']['type'])['price'];
                    $totalCommission += $this->getFixedPrice($returnPrice/10, true, $details['flights']['return']['type'])['commission'];
                }

                $orderModel->attributes = $_POST['OrderFlight'];
                $orderModel->date = time();
                $orderModel->one_way_travia_id = $oneWayID;
                $orderModel->return_travia_id = $returnID == -1 ? null : $returnID;
                $orderModel->search_id = $searchID;
                $orderModel->price = $totalPrice;
                $orderModel->commission = $totalCommission;
                $adultHasError = $childHasError = $infantHasError = false;
                if ($orderModel->save()) {
                    // Save adult passengers
                    foreach ($_POST['Passengers']['adult'] as $person) {
                        $model = new PassengersFlight();
                        $model->attributes = $person;
                        $model->order_id = $orderModel->id;
                        $model->birth_date = isset($person['birth_day'])?$person['birth_day']:null;
                        $model->type = 'ADT';
                        if (!$model->save()) {
                            $adultHasError = true;
                            Yii::app()->user->setFlash('errors', $this->implodeErrors($model));
                            $orderModel->delete();
                            break;
                        }
                    }

                    if (!$adultHasError and isset($_POST['Passengers']['child'])) {
                        // Save child passengers
                        foreach ($_POST['Passengers']['child'] as $person) {
                            $model = new PassengersFlight();
                            $model->attributes = $person;
                            $model->order_id = $orderModel->id;
                            $model->birth_date = $person['birth_day'];
                            $model->type = 'CNN';
                            if (!$model->save()) {
                                $childHasError = true;
                                Yii::app()->user->setFlash('errors', $this->implodeErrors($model));
                                $orderModel->delete();
                                break;
                            }
                        }
                    }

                    if (!$childHasError and isset($_POST['Passengers']['infant'])) {
                        // Save infant passengers
                        foreach ($_POST['Passengers']['infant'] as $person) {
                            $model = new PassengersFlight();
                            $model->attributes = $person;
                            $model->order_id = $orderModel->id;
                            $model->birth_date = $person['birth_day'];
                            $model->type = 'INF';
                            if (!$model->save()) {
                                $infantHasError = true;
                                Yii::app()->user->setFlash('errors', $this->implodeErrors($model));
                                $orderModel->delete();
                                break;
                            }
                        }
                    }

                    if (!$adultHasError and !$childHasError and !$infantHasError) {
                        Yii::app()->session['orderID'] = $orderModel->id;
                        $this->redirect('bill');
                    }
                }
            }

            Yii::app()->getModule('airports');

            $this->render('checkout', array(
                'buyTerms' => $buyTerms,
                'orderModel' => $orderModel,
                'passengersModel' => $passengersModel,
                'details' => $details,
                'oneWayPrice' => $oneWayPrice,
                'returnPrice' => $returnPrice,
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

            /* @var $order OrderFlight */
            $order = OrderFlight::model()->findByPk(Yii::app()->session['orderID']);
            $postman = new FlightPostman();

            $details = $postman->priceDetails($order->one_way_travia_id, $order->return_travia_id, $order->search_id);

            // Calculate price
            $oneWayPrice = 0;
            $returnPrice = 0;
            foreach ($details['flights']['oneWay']['fares'] as $fare)
                $oneWayPrice += doubleval($fare['count'] * $fare['basePrice']);
            if (isset($details['flights']['return'])) {
                foreach ($details['flights']['return']['fares'] as $fare)
                    $returnPrice += doubleval($fare['count'] * $fare['basePrice']);
            }

            $totalPrice = 0;
            $totalPrice += $this->getFixedPrice($oneWayPrice/10, true, $details['flights']['oneWay']['type'])['price'];
            if(isset($details['flights']['return']) and !$details['isTotalPrice'])
                $totalPrice += $this->getFixedPrice($returnPrice / 10, true, $details['flights']['return']['type'])['price'];
            if ($order->price != $totalPrice)
                OrderFlight::model()->updateByPk(Yii::app()->session['orderID'], array('price' => $totalPrice));

            Yii::app()->getModule('airports');

            $this->render('bill', array(
                'order' => $order,
                'details' => $details,
                'oneWayPrice' => $oneWayPrice,
                'returnPrice' => $returnPrice,
            ));
        } else
            $this->redirect(array('/site'));
    }

    public function actionPay($id)
    {
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/empty';
        $order = OrderFlight::model()->findByPk($id);
        /* @var $order OrderFlight */
        $postman = new FlightPostman();
        $details = $postman->priceDetails($order->one_way_travia_id, $order->return_travia_id, $order->search_id);

        // Calculate price
        $oneWayPrice = 0;
        $returnPrice = 0;
        foreach ($details['flights']['oneWay']['fares'] as $fare)
            $oneWayPrice += doubleval($fare['count'] * $fare['basePrice']);
        if (isset($details['flights']['return'])) {
            foreach ($details['flights']['return']['fares'] as $fare)
                $returnPrice += doubleval($fare['count'] * $fare['basePrice']);
        }

        $totalPrice = 0;
        $totalPrice += $this->getFixedPrice($oneWayPrice/10, true, $details['flights']['oneWay']['type'])['price'];
        if(isset($details['flights']['return']) and !$details['isTotalPrice'])
            $totalPrice += $this->getFixedPrice($returnPrice / 10, true, $details['flights']['return']['type'])['price'];

        if ($order->price != $totalPrice)
            OrderFlight::model()->updateByPk($id, array('price' => $totalPrice));

        $Amount = doubleval($totalPrice*10);
//        $Amount = 1000;
        $CallbackURL = Yii::app()->getBaseUrl(true) . '/reservation/flights/verify';
        $result = Yii::app()->mellat->PayRequest($Amount, $order->id, $CallbackURL);
        //$result = Yii::app()->mellat->PayRequest(1000, $order->id, $CallbackURL);
        if (!$result['error']) {
            $ref_id = $result['responseCode'];
            $this->render('ext.MellatPayment.views._redirect', array('ReferenceId' => $result['responseCode']));
        } else {
            Yii::app()->user->setFlash('failed', Yii::app()->mellat->getResponseText($result['responseCode']));
            $this->redirect(array('/reservation/flights/bill'));
        }

        $this->render('pay', array(
            'bankResponse' => $result,
        ));
    }

    public function actionVerify()
    {
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/inner';
        $this->pageName = 'bill';
        $bookingID = null;

        $order = OrderFlight::model()->findByPk($_POST['SaleOrderId']);
        /* @var $order OrderFlight */

        $result = null;
        if ($_POST['ResCode'] == 0)
            $result = Yii::app()->mellat->VerifyRequest($order->id, $_POST['SaleOrderId'], $_POST['SaleReferenceId']);

        if ($result != null) {
            $RecourceCode = (!is_array($result) ? $result : $result['responseCode']);
            if ($RecourceCode == 0) {
                // Settle Payment
                $settle = Yii::app()->mellat->SettleRequest($order->id, $_POST['SaleOrderId'], $_POST['SaleReferenceId']);
                if ($settle) {
                    Yii::app()->user->setFlash('success', 'پرداخت با موفقیت انجام شد.');
                    OrderFlight::model()->updateByPk($order->id, array(
                        'payment_tracking_code' => $_POST['SaleReferenceId'],
                        'status' => OrderFlight::STATUS_PAID,
                    ));

                    $transaction = new Transactions();
                    $transaction->tracking_code = $_POST['SaleReferenceId'];
                    $transaction->amount = $order->price;
                    $transaction->order_model = 'OrderFlight';
                    $transaction->order_id = $order->id;
                    $transaction->date = time();
                    $transaction->description = 'رزرو بلیط هواپیما';
                    $transaction->save();

                    $message =
                        '<p style="text-align: right;">با سلام<br>کاربر گرامی، تراکنش شما با موفقیت انجام شد. جزئیات تراکنش به شرح ذیل می باشد:</p>
                        <div style="width: 100%;height: 1px;background: #ccc;margin-bottom: 15px;"></div>
                        <table style="font-size: 9pt;text-align: right;">
                            <tr>
                                <td style="font-weight: bold;width: 120px;">زمان</td>
                                <td>' . JalaliDate::date('d F Y - H:i', $transaction->date) . '</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;width: 120px;">مبلغ</td>
                                <td>' . Controller::parseNumbers(number_format($transaction->amount * 10, 0)) . ' ریال</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;width: 120px;">شناسه خرید</td>
                                <td>' . $transaction->order_id . '</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;width: 120px;">کد رهگیری</td>
                                <td>' . $transaction->tracking_code . '</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;width: 120px;">توضیحات</td>
                                <td>' . $transaction->description . '</td>
                            </tr>
                        </table>';
                    Mailer::mail($order->buyer_email, 'رسید پرداخت اینترنتی', $message, Yii::app()->params['noReplyEmail'], Yii::app()->params['SMTP']);

                    $this->render('verify', array(
                        'order' => $order,
                        'transaction' => $transaction,
                    ));
                } else {
                    Yii::app()->user->setFlash('failed', 'عملیات پرداخت ناموفق بود.');
                    $this->redirect(array('/reservation/flights/bill'));
                }
            } else {
                Yii::app()->user->setFlash('failed', 'عملیات پرداخت ناموفق بود.');
                $this->redirect(array('/reservation/flights/bill'));
            }
        } else {
            Yii::app()->user->setFlash('failed', 'عملیات پرداخت ناموفق بود.');
            $this->redirect(array('/reservation/flights/bill'));
        }
    }

//    public function actionVerify2()
//    {
//        Yii::app()->theme = 'frontend';
//        $this->layout = '//layouts/inner';
//        $this->pageName = 'bill';
//
//        $order = OrderFlight::model()->findByPk(21);
//        /* @var $order OrderFlight */
//
//        if (true) {
//            if (true) {
//                // Settle Payment
//                if (true) {
//                    Yii::app()->user->setFlash('success', 'پرداخت با موفقیت انجام شد.');
//                    OrderFlight::model()->updateByPk($order->id, array(
//                        'payment_tracking_code' => 123456,
//                        'status' => OrderFlight::STATUS_PAID,
//                    ));
//
//                    $transaction = new Transactions();
//                    $transaction->tracking_code = 123456;
//                    $transaction->amount = $order->price;
//                    $transaction->order_model = OrderFlight::class;
//                    $transaction->order_id = $order->id;
//                    $transaction->date = time();
//                    $transaction->description = 'رزرو بلیط هواپیما';
//                    $transaction->save();
//
//                    $message =
//                        '<p style="text-align: right;">با سلام<br>کاربر گرامی، تراکنش شما با موفقیت انجام شد. جزئیات تراکنش به شرح ذیل می باشد:</p>
//                        <div style="width: 100%;height: 1px;background: #ccc;margin-bottom: 15px;"></div>
//                        <table style="font-size: 9pt;text-align: right;">
//                            <tr>
//                                <td style="font-weight: bold;width: 120px;">زمان</td>
//                                <td>' . JalaliDate::date('d F Y - H:i', $transaction->date) . '</td>
//                            </tr>
//                            <tr>
//                                <td style="font-weight: bold;width: 120px;">مبلغ</td>
//                                <td>' . Controller::parseNumbers(number_format($transaction->amount * 10, 0)) . ' ریال</td>
//                            </tr>
//                            <tr>
//                                <td style="font-weight: bold;width: 120px;">شناسه خرید</td>
//                                <td>' . $transaction->order_id . '</td>
//                            </tr>
//                            <tr>
//                                <td style="font-weight: bold;width: 120px;">کد رهگیری</td>
//                                <td>' . $transaction->tracking_code . '</td>
//                            </tr>
//                            <tr>
//                                <td style="font-weight: bold;width: 120px;">توضیحات</td>
//                                <td>' . $transaction->description . '</td>
//                            </tr>
//                        </table>';
//                    Mailer::mail($order->buyer_email, 'رسید پرداخت اینترنتی', $message, Yii::app()->params['noReplyEmail'], Yii::app()->params['SMTP']);
//
//                    $this->render('verify', array(
//                        'order' => $order,
//                        'transaction' => $transaction,
//                    ));
//                } else {
//                    Yii::app()->user->setFlash('failed', 'عملیات پرداخت ناموفق بود.');
//                    $this->redirect(array('/reservation/hotels/bill'));
//                }
//            } else {
//                Yii::app()->user->setFlash('failed', 'عملیات پرداخت ناموفق بود.');
//                $this->redirect(array('/reservation/hotels/bill'));
//            }
//        } else {
//            Yii::app()->user->setFlash('failed', 'عملیات پرداخت ناموفق بود.');
//            $this->redirect(array('/reservation/hotels/bill'));
//        }
//    }

    public function actionBooking()
    {
        if (isset($_POST['order_id']) and isset($_POST['transaction_id'])) {
            /* @var OrderFlight $order */
            /* @var Transactions $transaction */
            $order = OrderFlight::model()->find('id = :id AND status = :status', [
                ':id' => $_POST['order_id'],
                ':status' => OrderFlight::STATUS_PAID
            ]);
            $transaction = Transactions::model()->findByPk($_POST['transaction_id']);

            if ($order and $transaction) {
                //Create passengers array for book method
                $passengers = [];
                foreach ($order->passengers as $passenger)
                    $passengers[] = [
                        "type" => $passenger->type,
                        "gender" => $passenger->gender,
                        "nameEn" => $passenger->name_en,
                        "familyEn" => $passenger->family_en,
                        "passportNo" => $passenger->passport_num,
                        "passportExpire" => "",
                        "nameFa" => $passenger->name_fa,
                        "familyFa" => $passenger->family_fa,
                        "birthDate" => date('Y-m-d', $passenger->birth_date),
                        "nationality" => "IR",
                        "nationalId" => $passenger->national_id
                    ];

                // Create contact info array for book method
                $contactInfo = [
                    "mobile" => $order->buyer_mobile,
                    "email" => $order->buyer_email

                ];

                // Booking
                $postman = new FlightPostman();
                $book = $postman->book($order->search_id, $order->one_way_travia_id, $order->return_travia_id, $passengers, $contactInfo);

                if (!isset($book['error'])) {
                    $book = $book['bookRs'];
                    OrderFlight::model()->updateByPk($order->id, array('status' => OrderFlight::STATUS_CLOSE));
                    $booking = new BookingsFlight();
                    $book['passengers'] = CJSON::encode($book['passengers']);
                    $book['flights'] = CJSON::encode($book['flights']);
                    $booking->attributes = $book;
                    $booking->order_id = $order->id;
                    $booking->save();

                    echo CJSON::encode([
                        'status' => 'success',
                        'bookingID' => $booking->id,
                    ]);
                } else {
                    if (!file_exists('errors'))
                        mkdir('errors');
                    $fp = fopen('errors/flight-result-' . date('Y-m-d-H-i', time()) . '.json', 'w');
                    fwrite($fp, json_encode($book));
                    fclose($fp);

                    echo CJSON::encode([
                        'status' => 'failed',
                        'message' => 'متاسفانه عملیات رزرو انجام نشد. لطفا با بخش پشتیبانی تماس حاصل فرمایید. می توانید از طریق <a href="' . Yii::app()->createUrl('contactUs') . '" target="_blank">این صفحه</a> با بخش پشتیبانی در تماس باشید.'
                    ]);
                }
            } else {
                echo CJSON::encode([
                    'status' => 'failed',
                    'message' => 'درخواست شما معتبر نیست!'
                ]);
            }
        } else
            echo CJSON::encode([
                'status' => 'failed',
                'message' => 'درخواست شما معتبر نیست!'
            ]);
    }

    public function actionMail()
    {
        /* @var HTML2PDF $html2pdf */
        /* @var OrderFlight $order */
        /* @var BookingsFlight $booking */
        Yii::app()->getModule('airports');
        if(isset($_POST['order_id']) and isset($_POST['booking_id'])){
            $orderID = $_POST['order_id'];
            $bookingID = $_POST['booking_id'];
        }else{
            $orderID = $_GET['order_id'];
            $bookingID = $_GET['booking_id'];
        }
        $order = OrderFlight::model()->findByPk($orderID);
        $booking = BookingsFlight::model()->findByPk($bookingID);

        // Render PDF file
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
        $lg = Array();
        $lg['a_meta_charset'] = 'UTF-8';
//        $lg['a_meta_dir'] = 'rtl';
        $lg['a_meta_language'] = 'fa';
        $lg['w_page'] = 'page';
        $html2pdf->pdf->setLanguageArray($lg);
        $html2pdf->pdf->SetMargins(5, 5, 5);
        $pdfFileName = 'fa_pdf';
        if(Yii::app()->session['domestic'])
            $pdfFileName = 'en_pdf';
        foreach (CJSON::decode($booking->passengers) as $key => $passenger) {
            $html2pdf->pdf->AddPage();
            $html2pdf->pdf->SetFont('zarbold', '', 11);
            $html2pdf->pdf->SetTextColor(0, 0, 0);
            $html2pdf->pdf->WriteHTML($this->renderPartial($pdfFileName, array(
                'booking' => $booking,
                'html2pdf' => $html2pdf,
                'passenger' => $passenger,
                'key' => $key
            ), true), true, 0, true, 0);
            $html2pdf->pdf->SetFont('zarbold', '', 8);
            $html2pdf->pdf->SetTextColor(153, 153, 153);
            $html2pdf->pdf->Line(5, 280, 205, 280, ['width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(153, 153, 153)]);
            $html2pdf->pdf->Text(5, 287, 'Site: Booker24.net');
            $html2pdf->pdf->Text(71, 287, 'Email: info@booker24.net');
            $html2pdf->pdf->Text(137, 287, 'Phone: +984533243543');
        }
        $pdfContent = $html2pdf->Output('', EYiiPdf::OUTPUT_TO_STRING);

        // Send mail
        $message = '<p style="text-align: right;">کاربر گرامی<br>بلیط در فایل ضمیمه همین نامه خدمتتان ارسال گردیده است. لطفا آن را چاپ کرده و هنگام مراجعه به فرودگاه ،آن را به متصدیان ارائه دهید.</p>';
        $message .= '<p style="text-align: right;"><b>کد رهگیری : </b>B24F-' . $booking->orderId . '</p>';
        $message .= '<p style="text-align: right;color: #ef5350;">لطفا این کد را جهت سایر عملیات ها نزد خود نگهداری کنید.</p>';
        $message .= '<p style="text-align: right;font-size:12px;margin-top: 30px;">با تشکر از خرید شما</p>';
        $message .= '<p style="text-align: right;font-size:12px">بوکر 24</p>';

        if (Mailer::mail($order->buyer_email, 'بلیط هواپیما - بوکر 24', $message, Yii::app()->params['noReplyEmail'], Yii::app()->params['SMTP'],
            array(
                'method' => 'string',
                'string' => $pdfContent,
                'filename' => 'FlightTicket.pdf',
                'type' => 'application/pdf'
            )
        )
        )
            echo CJSON::encode([
                'status' => 'success',
                'html' => '
                    <div class="overflow-fix" style="padding: 15px;">
                        <a href="' . $this->createUrl('/site') . '" class="btn waves-effect waves-light green lighten-1 col-md-2 pull-left">صفحه اصلی</a>
                        <a href="' . $this->createUrl('/reservation/flights/ticket', array('booking_id' => $booking->id)) . '" style="margin-left: 10px;" target="_blank" class="btn waves-effect waves-light amber darken-2 pull-left">دانلود بلیط</a>
                    </div>
                '
            ]);
        else
            echo CJSON::encode([
                'status' => 'failed',
                'mailError' => true,
                'message' => 'با عرض پوزش در ارسال ایمیل خطایی رخ داده است.'
            ]);
    }

    public function actionTicket()
    {
        /* @var HTML2PDF $html2pdf */
        /* @var BookingsFlight $booking */
        Yii::app()->getModule('airports');
        $bookingID = Yii::app()->request->getQuery('booking_id');
        $booking = BookingsFlight::model()->findByPk($bookingID);
        // Render PDF file
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
        $lg = Array();
        $lg['a_meta_charset'] = 'UTF-8';
//        $lg['a_meta_dir'] = 'rtl';
        $lg['a_meta_language'] = 'fa';
        $lg['w_page'] = 'page';
        $html2pdf->pdf->setLanguageArray($lg);
        $html2pdf->pdf->SetMargins(5, 5, 5);
        $pdfFileName = 'fa_pdf';
        if(Yii::app()->session['domestic'])
            $pdfFileName = 'en_pdf';
        foreach (CJSON::decode($booking->passengers) as $key => $passenger) {
            $html2pdf->pdf->AddPage();
            $html2pdf->pdf->SetFont('zarbold', '', 11);
            $html2pdf->pdf->SetTextColor(0, 0, 0);
            $html2pdf->pdf->WriteHTML($this->renderPartial($pdfFileName, array(
                'booking' => $booking,
                'html2pdf' => $html2pdf,
                'passenger' => $passenger,
                'key' => $key
            ), true), true, 0, true, 0);
            $html2pdf->pdf->SetFont('zarbold', '', 8);
            $html2pdf->pdf->SetTextColor(153, 153, 153);
            $html2pdf->pdf->Line(5, 280, 205, 280, ['width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(153, 153, 153)]);
            $html2pdf->pdf->Text(5, 287, 'Site: Booker24.net');
            $html2pdf->pdf->Text(71, 287, 'Email: info@booker24.net');
            $html2pdf->pdf->Text(137, 287, 'Phone: +984533243543');
        }
        $html2pdf->Output();
    }

    public function actionCancellation()
    {
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/inner';
        $this->pageName = 'signup';

        $model = new CancellationRequests();

        $this->performAjaxValidation($model);

        if (isset($_POST['CancellationRequests'])) {
            $model->orderId = $_POST['CancellationRequests']['orderId'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'درخواست شما با موفقیت ثبت شد. بعد از تایید توسط تیم پشتیبانی، رزرو شما کنسل خواهد شد.');
                $this->refresh();
            } else
                Yii::app()->user->setFlash('failed', 'متاسفانه در انجام عملیات خطایی رخ داده است!');
        }

        $this->render('cancellation', array(
            'model' => $model,
        ));
    }

    public function actionViewCancellationRequest($id)
    {
        Yii::app()->theme = 'abound';
        $this->layout = '//layouts/column2';

        $model = CancellationRequests::model()->findByPk($id);
        $transaction = Transactions::model()->findAll('order_model = :model AND order_id = :id', [
            ':model'=>'OrderFlight',
            ':id'=>$model->booking->order_id
        ]);

        $this->render('view-cancellation-request', array(
            'model' => $model,
            'transaction' => $transaction,
            'id' => $id,
        ));
    }

    public function actionViewBooking($id)
    {
        Yii::app()->theme = 'abound';
        $this->layout = '//layouts/column2';

        $model = BookingsFlight::model()->findByPk($id);
        $transaction = Transactions::model()->findAll('order_model = :model AND order_id = :id', [
            ':model'=>'OrderFlight',
            ':id'=>$model->order_id
        ]);

        $this->render('view-booking', array(
            'model' => $model,
            'transaction' => $transaction,
            'id' => $id,
        ));
    }

    public function actionCancel($id)
    {
        /* @var $cancelRequest CancellationRequests */
        $cancelRequest = CancellationRequests::model()->findByPk($id);

        $postman = new FlightPostman();
        $result = $postman->cancel($cancelRequest->booking->orderId, $cancelRequest->booking->order->travia_id);

        if ($result) {
            // Change status of request
            $cancelRequest->setScenario('change-status');
            $cancelRequest->status = 'canceled';
            if ($cancelRequest->save()) {
                // Change status of booking
                $cancelRequest->booking->status = 'canceled';
                if ($cancelRequest->booking->save()) {
                    // Send mail to user
                    $message = '<p style="text-align: right;">با سلام<br>کاربر گرامی، درخواست انصراف شما توسط تیم مدیریت مورد تایید قرار گرفت و سفارش شما با کد رهگیری B24F-' . $cancelRequest->orderId . ' کنسل گردید.</p>';
                    Mailer::mail($cancelRequest->booking->order->buyer_email, 'درخواست انصراف', $message, Yii::app()->params['noReplyEmail'], Yii::app()->params['SMTP']);
                    Yii::app()->user->setFlash('success', 'درخواست مورد نظر کنسل گردید. مبلغ کسر شده از حساب ' . $result['chargeAmount'] . ' تومان می باشد.');
                } else
                    Yii::app()->user->setFlash('failed', 'در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید.');
            } else
                Yii::app()->user->setFlash('failed', 'در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید.');
        }

        $this->redirect(array('/reservation/flights/viewCancellationRequest/' . $cancelRequest->id));
    }

    public function actionRefuseCancel($id)
    {
        /* @var $cancelRequest CancellationRequests */
        $cancelRequest = CancellationRequests::model()->findByPk($id);

        // Change status of request
        $cancelRequest->setScenario('change-status');
        $cancelRequest->status = 'refused';
        if ($cancelRequest->save()) {
            // Send mail to user
            $message = '<p style="text-align: right;">با سلام<br>کاربر گرامی، با عرض پوزش درخواست شما جهت انصراف از سفارش با کد رهگیری B24F-' . $cancelRequest->orderId . ' مورد تایید تیم مدیریت قرار نگرفت.</p>';
            Mailer::mail($cancelRequest->booking->order->buyer_email, 'درخواست انصراف', $message, Yii::app()->params['noReplyEmail'], Yii::app()->params['SMTP']);
            Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ثبت شد. درخواست مورد نظر رد شد.');
        } else
            Yii::app()->user->setFlash('failed', 'در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید.');

        $this->redirect(array('/reservation/flights/viewCancellationRequest/' . $cancelRequest->id));
    }

    public function actionDomesticAirports()
    {
        Yii::app()->getModule('airports');
        $airports = Airports::model()->findAll('country_code = :code AND airport != :airport', [':code' => 'IR', ':airport' => 'All Airports']);
        $array = [];
        foreach ($airports as $airport)
            $array[] = [
                'iata' => $airport->IATA,
                'title' => $airport->city_fa . ' - ' . $airport->airport_fa
            ];
        header('Content-Type: application/json');
        echo json_encode($array);
    }

    /**
     * Performs the AJAX validation.
     * @param OrderFlight $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax'])) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}