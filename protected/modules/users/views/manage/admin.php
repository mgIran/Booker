<?php
/* @var $this UsersManageController */
/* @var $model Users */

$this->breadcrumbs=array(
    'کاربران'=>array('manage'),
    'مدیریت',
);

$this->menu=array(
    array('label'=>'افزودن', 'url'=>array('create')),
);
?>
<? $this->renderPartial('//layouts/_flashMessage'); ?>
<h1>مدیریت کاربران</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'admins-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'email',
        array(
            'header' => 'نام کامل',
            'value' => '$data->userDetails->name',
            'filter' => CHtml::activeTextField($model,'name')
        ),
        array(
            'header' => 'وضعیت',
            'value' => '$data->statusLabels[$data->status]',
            'filter' => CHtml::activeDropDownList($model,'statusFilter',$model->statusLabels,array('prompt' => 'همه'))
        ),
        array(
            'class'=>'CButtonColumn',
            'template' => '{view}{update}{delete}'
        ),
    ),
)); ?>
