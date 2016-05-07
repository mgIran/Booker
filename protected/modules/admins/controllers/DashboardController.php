<?php

class DashboardController extends Controller
{

    /**
     * @return array action filters
     */
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
                'actions'=>array('index'),
                'roles' => array('admin'),
            ),
            array('deny',  // deny all users
                'actions'=>array('index'),
                'users'=>array('*'),
            ),
        );
    }

	public function actionIndex()
    {
        Yii::app()->getModule('users');
        $criteria=new CDbCriteria();
        $criteria->addCondition('confirm=:confirm');
        $criteria->addCondition('deleted=:deleted');
        $criteria->params=array(':confirm'=>'pending',':deleted'=>'0');
        $newestPrograms=new CActiveDataProvider('Apps', array(
            'criteria'=>$criteria,
        ));
        $criteria=new CDbCriteria();
        $criteria->with='user';
        $criteria->addCondition('user.role_id=2');
        $criteria->addCondition('user.status=:userStatus');
        $criteria->addCondition('details_status=:status');
        $criteria->params=array(':status'=>'pending',':userStatus'=>'active');
        $newestDevelopers=new CActiveDataProvider('UserDetails', array(
            'criteria'=>$criteria,
        ));

        $criteria=new CDbCriteria();
        $criteria->with='user';
        $criteria->addCondition('user.status=:userStatus');
        $criteria->params=array(':userStatus'=>'active');
        $newestDevIdRequests=new CActiveDataProvider('UserDevIdRequests', array(
            'criteria'=>$criteria,
        ));
		$this->render('index', array(
            'devIDRequests'=>$newestDevIdRequests,
            'newestPrograms'=>$newestPrograms,
            'newestDevelopers'=>$newestDevelopers,
        ));
	}

}