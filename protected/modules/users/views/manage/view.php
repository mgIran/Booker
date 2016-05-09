<?php
/* @var $this UsersManageController */
/* @var $model Users */

Yii::app()->clientScript->registerCss('imgSize','
.national-card-image
{
	max-width:500px;
	max-height:500px;
}
');

$this->breadcrumbs=array(
	'کاربران'=>array('index'),
	$model->userDetails->name && !empty($model->userDetails->name)?$model->userDetails->name:$model->email,
);

$this->menu=array(
	array('label'=>'مدیرت کاربران', 'url'=>array('admin')),
//	array('label'=>'تایید اطلاعات کاربر', 'url'=>array('confirmDeveloper', 'id'=>$model->id)),
//	array('label'=>'رد اطلاعات کاربر', 'url'=>array('refuseDeveloper', 'id'=>$model->id)),
	array('label'=>'حذف کاربر', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'آیا از حذف کاربر اطمینان دارید؟')),
);
?>

<h1>نمایش اطلاعات <?php echo $model->userDetails->name && !empty($model->userDetails->name)?$model->userDetails->name:$model->email; ?></h1>


<?php
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'نام',
			'value'=>$model->userDetails->name,
		),
		array(
			'name'=>'شماره تماس',
			'value'=>$model->userDetails->phone,
		),
		array(
			'name'=>'کد ملی',
			'value'=>$model->userDetails->national_code,
		),
		array(
			'name'=>'آدرس',
			'value'=>$model->userDetails->address,
		),
		array(
			'name'=>'نوع کاربری',
			'value'=>$model->role->name,
		),
		array(
			'name'=>'وضعیت',
			'value'=>$model->statusLabels[$model->status],
		),
	),
)); ?>

