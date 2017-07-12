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
                'actions' => array('index'),
                'roles' => array('admin'),
            ),
            array('deny',  // deny all users
                'actions' => array('index'),
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $bookings = Bookings::model()->search();

        $criteria = new CDbCriteria();
        $criteria->addCondition('status = :status');
        $criteria->params = array(':status' => 'pending');
        $criteria->order='id DESC';
        $cancellationRequests = new CActiveDataProvider('CancellationRequests', array(
            'criteria' => $criteria
        ));

        $criteria = new CDbCriteria();
        $criteria->select='SUM(amount) AS amount';
        $sumTransactions=Transactions::model()->find($criteria);

        Yii::app()->getModule('setting');
        $commissionPercent=SiteSetting::model()->find('name = :name', array(':name'=>'commission'))->value;

        $this->render('index', array(
            'cancellationRequests' => $cancellationRequests,
            'bookings' => $bookings,
            'sumTransactions' => $sumTransactions,
            'commissionPercent' => $commissionPercent,
        ));
    }
}