<?php
/* @var $this ManageController */
/* @var $model Airports */

$this->breadcrumbs=array(
	'فرودگاه ها'=>array('admin'),
	'مدیریت',
);

$this->menu=array(
	array('label'=>'افزودن فرودگاه جدید', 'url'=>array('create')),
);
?>

<h1>مدیریت فرودگاه ها</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'airports-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'title',
		'city',
		'iata',
		array(
			'name'=>'is_domestic',
			'value'=>'$data->is_domestic?"داخلی":"خارجی"',
			'filter'=>false
		),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{delete}'
		),
	),
)); ?>
