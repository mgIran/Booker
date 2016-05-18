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
        $this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
        Yii::app()->theme = 'market';
        $this->layout = '//layouts/error';
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
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