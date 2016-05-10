<div class="login-form">
    <?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'login-form',
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
            'beforeValidate' => "js:function(form) {
                $('.loading-container').fadeIn();
                return true;
            }",
            'afterValidate' => "js:function(form) {
                $('.loading-container').stop().hide();
                return true;
            }",
            'afterValidateAttribute' => 'js:function(form, attribute, data, hasError) {
                $(".loading-container").fadeOut();
            }',
        ),
    )); ?>
    <div class="row">
        <?php echo $form->textField($model,'username',array('class'=>'form-control','placeholder'=>'نام کاربری')); ?>
        <?php echo $form->error($model,'username'); ?>
    </div>
    <div class="row">
        <?php echo $form->passwordField($model,'password',array('class'=>'form-control','placeholder'=>'کلمه عبور')); ?>
        <?php echo $form->error($model,'password'); ?>
    </div>
    <div class="row">
        <input class="btn btn-success form-control" type="submit" value="ورود">
    </div>
    <?php $this->endWidget(); ?>
    <p>
        <a href="<?php echo $this->createAbsoluteUrl('//');?>" class="forget-link">صفحه اصلی سایت</a>
    </p>

    <div class="loading-container">
        <div class="overly"></div>
        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
</div>