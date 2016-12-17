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
        $criteria = new CDbCriteria();
        $criteria->addCondition('status = :status');
        $criteria->params = array(':status' => 'pending');
        $cancellationRequests = new CActiveDataProvider('CancellationRequests', array(
            'criteria' => $criteria
        ));

        $this->render('index', array(
            'cancellationRequests' => $cancellationRequests,
        ));
    }
}