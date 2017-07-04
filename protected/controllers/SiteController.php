<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xECF0F1,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&views=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
    {
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/empty';

        if (isset($_POST['method'])) {
            if ($_POST['method'] == 'hotel') {
                Yii::app()->session->clear();
                Yii::app()->session['cityName'] = $_POST['destination'];
                Yii::app()->session['cityKey'] = $_POST['city_key'];
                Yii::app()->session['inDate'] = $_POST['enter-date_altField'];
                Yii::app()->session['outDate'] = $_POST['out-date_altField'];
                Yii::app()->session['stayTime'] = $_POST['stay_time'];
                Yii::app()->session['roomsCount'] = $_POST['rooms-count'];
                Yii::app()->session['rooms'] = $_POST['rooms'];

                $this->redirect('reservation/hotels/search');
            } elseif ($_POST['method'] == 'flight') {
                Yii::app()->session->clear();
                Yii::app()->session['domestic'] = $_POST['flight-is-domestic'] == 1 ? true : false;
                if ($_POST['flight-is-domestic'] == 1) {
                    Yii::app()->session['dirType'] = $_POST['dom-flight-dir-type'];
                    Yii::app()->session['origin'] = $_POST['dom_flight_departure_iata'];
                    Yii::app()->session['destination'] = $_POST['dom_flight_arrival_iata'];
                    Yii::app()->session['fromIsCity'] = 0;
                    Yii::app()->session['toIsCity'] = 0;
                    Yii::app()->session['date'] = $_POST['dom-departure-date_altField'];
                    if ($_POST['dom-flight-dir-type'] == 'two-way')
                        Yii::app()->session['rDate'] = $_POST['dom-return-date_altField'];
                } else {
                    Yii::app()->session['dirType'] = $_POST['non-dom-flight-dir-type'];
                    Yii::app()->session['origin'] = $_POST['non_dom_flight_departure_iata'];
                    Yii::app()->session['destination'] = $_POST['non_dom_flight_arrival_iata'];
                    Yii::app()->session['fromIsCity'] = $_POST['non_dom_flight_from_is_city'];
                    Yii::app()->session['toIsCity'] = $_POST['non_dom_flight_to_is_city'];
                    Yii::app()->session['date'] = $_POST['non-dom-departure-date_altField'];
                    if ($_POST['non-dom-flight-dir-type'] == 'two-way')
                        Yii::app()->session['rDate'] = $_POST['non-dom-return-date_altField'];
                }
                Yii::app()->session['adult'] = $_POST['flight_adult_count'];
                Yii::app()->session['child'] = $_POST['flight_child_count'];
                Yii::app()->session['infant'] = $_POST['flight_infant_count'];
                Yii::app()->session['class'] = $_POST['flight_class'];

                $this->redirect('reservation/flights/search');
            }
        }

        $this->render('index');
    }

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
    {
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/error';
        $code = Yii::app()->request->getQuery('code');
        if (!is_null($code) and $code == 212)
            $this->render('webservice-error');
        else {
            if ($error = Yii::app()->errorHandler->error) {
                if (Yii::app()->request->isAjaxRequest)
                    echo $error['message'];
                else {
                    if($error['code']==212)
                        $this->render('webservice-error');
                    else
                        $this->render('error', $error);
                }
            }
        }
    }

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

    public function actionAbout(){
        Yii::import('pages.models.*');
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/inner';
		$this->pageName='about';
        $model = Pages::model()->findByPk(1);
        $this->render('//site/pages/page',array('model' => $model));
    }

    public function actionContactUs(){
        Yii::import('pages.models.*');
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/inner';
		$this->pageName='contact';
        $model = Pages::model()->findByPk(2);
		Yii::import('map.models.GoogleMaps');
		$map_model = GoogleMaps::model()->findByPk(1);
		$mapLat = $map_model->map_lat;
		$mapLng = $map_model->map_lng;
		$mapZoom = 15;

		$contactModel=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$contactModel->attributes=$_POST['ContactForm'];
			if($contactModel->validate())
			{
				$contactTable=new Contact();
				$contactTable->attributes=$_POST['ContactForm'];
				$contactTable->date=time();
				if($contactTable->save()) {
					Yii::app()->user->setFlash('success', 'پیام شما با موفقیت ثبت شد.');
					$this->refresh();
				}
				else
					Yii::app()->user->setFlash('success', 'در ثبت اطلاعات خطایی رخ داده است لطفا مجددا تلاش کنید.');
			}
		}

        $this->render('//site/pages/page',array(
			'model' => $model,
			'contactModel' => $contactModel,
			'mapLat'=>$mapLat,
			'mapLng'=>$mapLng,
			'mapZoom'=>$mapZoom,
		));
    }

    public function actionHelp(){
        Yii::import('pages.models.*');
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/inner';
		$this->pageName='help';
        $model = Pages::model()->findByPk(3);
        $this->render('//site/pages/page',array('model' => $model));
    }

    public function actionTerms(){
		Yii::import('pages.models.*');
		Yii::app()->theme = 'frontend';
		$this->layout = '//layouts/inner';
		$this->pageName = 'terms';
		$model = Pages::model()->findByPk(4);
		$this->render('//site/pages/page', array('model' => $model));
	}


    public function actionPrivacy()
    {
        Yii::import('pages.models.*');
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/inner';
        $model = Pages::model()->findByPk(5);
        $this->render('//site/pages/page',array('model' => $model));
    }
}