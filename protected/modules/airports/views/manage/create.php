<?php
/* @var $this ManageController */
/* @var $model Airports */

$this->breadcrumbs=array(
	'فرودگاه ها'=>array('admin'),
	'افزودن',
);

$this->menu=array(
	array('label'=>'مدیریت فرودگاه ها', 'url'=>array('admin')),
);
?>

<h1>افزودن فرودگاه جدید</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>