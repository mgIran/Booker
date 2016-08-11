<?php
/* @var $this ManageController */
/* @var $model CityNames */

$this->breadcrumbs=array(
	'شهرها'=>array('admin'),
	'افزودن',
);

$this->menu=array(
	array('label'=>'مدیریت شهرها', 'url'=>array('admin')),
);
?>

<h1>افزودن شهر جدید</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>