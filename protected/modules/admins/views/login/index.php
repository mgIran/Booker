<div class="login-form">
    <h1>
        ورود به مدیریت
    </h1>

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
        <?php echo $form->textField($model,'username',array('class'=>'transition focus-left','placeholder'=>'نام کاربری')); ?>
        <?php echo $form->error($model,'username'); ?>
        <span class="transition icon-envelope"></span>
    </div>
    <div class="row">
        <?php echo $form->passwordField($model,'password',array('class'=>'transition','placeholder'=>'کلمه عبور')); ?>
        <?php echo $form->error($model,'password'); ?>
        <span class="transition icon-key"></span>
    </div>
    <div class="row">
        <input class="transition" type="submit" value="ورود">
    </div>
    <?php $this->endWidget(); ?>
    <p>
        <a href="#" class="forget-link">
            کلمه عبور خود را فراموش کرده اید؟
        </a>
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