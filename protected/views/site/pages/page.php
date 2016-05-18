<?php
/* @var $this SiteController */
/* @var $error array */
/* @var $mapLat string */
/* @var $mapLng string */
/* @var $mapZoom string */
/* @var $contactModel ContactForm */
/* @var $form CActiveForm */

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
        <?php if($this->pageName=='contact'):?>
            <div class="container-fluid">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 col-lg-offset-2 col-md-offset-2 col-sm-offset-2 page-break"></div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 col-lg-offset-2 col-md-offset-2 col-sm-offset-2">

                    <?php $this->renderPartial('//layouts/_flashMessage');?>

                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'contact-form',
                        'enableClientValidation'=>true,
                        'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                        ),
                    )); ?>

                    <p class="note">جهت ارتباط با ما و یا ثبت شکایت فرم زیر را پر کنید.</p>

                    <div class="input-field">
                        <?php echo $form->textField($contactModel,'name'); ?>
                        <?php echo $form->labelEx($contactModel,'name'); ?>
                        <?php echo $form->error($contactModel,'name'); ?>
                    </div>

                    <div class="input-field">
                        <?php echo $form->textField($contactModel,'email'); ?>
                        <?php echo $form->labelEx($contactModel,'email'); ?>
                        <?php echo $form->error($contactModel,'email'); ?>
                    </div>

                    <div class="input-field">
                        <?php echo $form->textField($contactModel,'subject',array('size'=>60,'maxlength'=>128)); ?>
                        <?php echo $form->labelEx($contactModel,'subject'); ?>
                        <?php echo $form->error($contactModel,'subject'); ?>
                    </div>

                    <div class="input-field">
                        <?php echo $form->textArea($contactModel,'body',array('class'=>'materialize-textarea')); ?>
                        <?php echo $form->labelEx($contactModel,'body'); ?>
                        <?php echo $form->error($contactModel,'body'); ?>
                    </div>

                    <?php if(CCaptcha::checkRequirements()): ?>
                        <div class="input-field">
                            <?php echo $form->textField($contactModel,'verifyCode'); ?>
                            <?php echo $form->labelEx($contactModel,'verifyCode'); ?>
                            <div class="captcha">
                                <?php $this->widget('CCaptcha'); ?>
                            </div>
                            <?php echo $form->error($contactModel,'verifyCode'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="input-field buttons">
                        <button class="btn waves-effect waves-light green lighten-1 pull-left" type="submit">ارسال</button>
                    </div>

                    <?php $this->endWidget(); ?>
                </div>
            </div>
        <?php endif;?>
    </div>
</div>

<?php
if($this->pageName=='contact') {
    Yii::app()->clientScript->registerScriptFile('http://maps.googleapis.com/maps/api/js');
    Yii::app()->clientScript->registerScript('google-map', "
        var map;
        var marker;
        var myCenter=new google.maps.LatLng(" . $mapLat . "," . $mapLng . ");
        function initialize()
        {
            var mapProp = {
                center:myCenter,
                zoom:" . $mapZoom . ",
                scrollwheel: false
            };
            map = new google.maps.Map(document.getElementById('contact'),mapProp);
            placeMarker(myCenter ,map);
        }

        function placeMarker(location ,map) {

            if(marker != undefined)
                marker.setMap(null);
            marker = new google.maps.Marker({
                position: location,
                map: map,
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    ");
}?>