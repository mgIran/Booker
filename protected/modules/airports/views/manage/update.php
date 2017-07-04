<?php
/* @var $this ManageController */
/* @var $model DomesticAirports */

$this->breadcrumbs=array(
	'فرودگاه ها'=>array('admin'),
	$model->title=>array('update','id'=>$model->id),
	'ویرایش',
);

$this->menu=array(
	array('label'=>'افزودن فرودگاه جدید', 'url'=>array('create')),
	array('label'=>'مدیریت فرودگاه ها', 'url'=>array('admin')),
);
?>

<h1>ویرایش فرودگاه <?php echo $model->title; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>