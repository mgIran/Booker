<?php
/* @var $this MapsManageController */
/* @var $model GoogleMaps */

$this->breadcrumbs=array(
	'تعیین مکان روی نقشه'
);
?>

<h1>تعیین مکان روی نقشه</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>