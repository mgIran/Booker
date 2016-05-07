<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle= Yii::app()->name . ' - '.$model->title;
$this->breadcrumbs=array(
    $model->title=>array(''),
);
?>

<div class="container">
    <div class="content page-box">
        <h2 class="yekan-text"><?= $model->title; ?></h2>
        <div class="container-fluid">
            <?= $model->summary; ?>
        </div>
    </div>
</div>
