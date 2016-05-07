<?php
/* @var $this PagesManageController */
/* @var $model Pages */

$this->breadcrumbs=array(
	'مدیریت',
);
$template = '{update}{delete}';
if($this->categorySlug == 'guide')
    $this->menu=array(
	    array('label'=>'افزودن راهنمای جدید', 'url'=>array('manage/create/?slug=guide')),
    );
if($this->categorySlug == 'base')
{
    $template = '{update}';
}
if($this->categorySlug == 'free')
    $this->menu=array(
	    array('label'=>'افزودن صحفه جدید', 'url'=>array('create')),
    );

?>

<h1>مدیریت</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'pages-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'title',
		array(
            'name' => 'summary',
            'value' => 'substr($data->summary,0,300)'
        ),
		array(
			'class'=>'CButtonColumn',
            'template' => $template
		),
	),
)); ?>
