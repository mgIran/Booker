<?php
/* @var $this ManageController */
/* @var $model CityNames */

$this->breadcrumbs=array(
	'شهرها'=>array('admin'),
	$model->city_name=>array('update','id'=>$model->id),
	'ویرایش',
);

$this->menu=array(
	array('label'=>'افزودن شهر جدید', 'url'=>array('create')),
	array('label'=>'مدیریت شهرها', 'url'=>array('admin')),
);
?>

<h1>ویرایش شهر <?php echo $model->city_name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>