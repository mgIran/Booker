<?php
/* @var $this ManageController */
/* @var $model CityNames */

$this->breadcrumbs=array(
	'شهرها'=>array('admin'),
	'مدیریت',
);

$this->menu=array(
	array('label'=>'افزودن شهر جدید', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#city-names-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>مدیریت شهرها</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'city-names-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'city_name',
		'country_name',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{delete}'
		),
	),
)); ?>
