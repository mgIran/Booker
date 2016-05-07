<?php
/* @var $this PagesManageController */
/* @var $model Pages */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	'افزودن',
);
if($this->categorySlug == 'guide')
{

    $this->menu=array(
        array('label'=>'مدیریت', 'url'=>array('manage/admin/?slug=guide')),
    );
    $pageType = 'راهنما';
}
if($this->categorySlug == 'free')
{
    $this->menu=array(
        array('label'=>'مدیریت', 'url'=>array('admin')),
    );
    $pageType = 'صحفه';
}

?>

<h1>افزودن <?= $pageType ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>