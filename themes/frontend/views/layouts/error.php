<?php
/* @var $this Controller */
/* @var $content string */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="keywords" content="<?= $this->keywords ?>">
    <meta name="description" content="<?= $this->description?>">
    <title><?= $this->siteName.(!empty($this->pageTitle)?' - '.$this->pageTitle:'') ?></title>

    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/css/fontiran.css">
    <?php
    $baseUrl = Yii::app()->theme->baseUrl;
    $cs = Yii::app()->getClientScript();
    Yii::app()->clientScript->registerCoreScript('jquery');

    $cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
    $cs->registerCssFile($baseUrl.'/css/bootstrap-rtl.min.css');
    $cs->registerCssFile($baseUrl.'/css/materialize.min.css');
    $cs->registerCssFile($baseUrl.'/css/bootstrap-theme.css?v=0.1');
    $cs->registerCssFile($baseUrl.'/css/responsive-theme.css?v=0.1');
    $cs->registerCssFile('https://fonts.googleapis.com/icon?family=Material+Icons');

    $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js');
    $cs->registerScriptFile($baseUrl.'/js/materialize.js');
    $cs->registerScriptFile($baseUrl.'/js/typeahead.bundle.min.js');
    $cs->registerScriptFile($baseUrl.'/js/jquery.script.js');
    ?>
</head>
<body class="error-page">

<?php echo $content;?>

</body>
</html>