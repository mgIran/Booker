<?php
/* @var $content string */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="keywords" content="<?= $this->keywords ?>">
    <meta name="description" content="<?= $this->description?> ">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?= $this->siteName.(!empty($this->pageTitle)?' - '.$this->pageTitle:'') ?></title>
    <link rel="shortcut icon" href="<?= Yii::app()->createAbsoluteUrl('themes/market/images/favicon.ico'); ?>">
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/css/fontiran.css">
    <?php
    $baseUrl = Yii::app()->theme->baseUrl;
    $cs = Yii::app()->getClientScript();
    Yii::app()->clientScript->registerCoreScript('jquery');

    $cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
    $cs->registerCssFile($baseUrl.'/css/bootstrap-rtl.min.css');
    $cs->registerCssFile($baseUrl.'/css/materialize.min.css');
    $cs->registerCssFile($baseUrl.'/css/panel.css');

    $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js');
    $cs->registerScriptFile($baseUrl.'/js/materialize.min.js');
    $cs->registerScriptFile($baseUrl.'/js/jquery.script.js');
    ?>
</head>
<body class="inner-page panel-page">
    <?php $this->renderPartial('//layouts/_panel_header');?>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 hidden-xs right-side">test</div>
        <div class="col-lg-9 col-md-9 col-sm-9 hidden-xs"><?php echo $content;?></div>
    </div>
    <?php $this->renderPartial('//layouts/_footer');?>
</body>
</html>