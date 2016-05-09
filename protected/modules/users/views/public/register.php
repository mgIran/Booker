<?php
/* @var $model Users */
/* @var $form CActiveForm */
?>
<div class="container">
    <div class="content signup-box col-lg-8 col-md-8 col-sm-8 col-xs-10 col-lg-offset-2 col-md-offset-2 col-sm-offset-2 col-xs-offset-1">
        <h2 class="yekan-text">ثبت نام</h2>
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-offset-1">
            <?php if(Yii::app()->user->hasFlash('success')):?>
                <div class="alert alert-success fade in">
                    <?php echo Yii::app()->user->getFlash('success');?>
                </div>
            <?php elseif(Yii::app()->user->hasFlash('failed')):?>
                <div class="alert alert-danger fade in">
                    <?php echo Yii::app()->user->getFlash('failed');?>
                </div>
            <?php endif;?>
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'register-form',
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
                ),
            )); ?>
                <div class="input-field">
                    <?php echo $form->textField($model,'email'); ?>
                    <?php echo $form->labelEx($model,'email');?>
                    <?php echo $form->error($model,'email'); ?>
                </div>
                <div class="input-field">
                    <?php echo $form->passwordField($model,'password'); ?>
                    <?php echo $form->labelEx($model,'password');?>
                    <?php echo $form->error($model,'password'); ?>
                </div>
                <div class="input-field buttons-block">
                    <button class="btn waves-effect waves-light col-md-12 red lighten-1" type="submit">ثبت نام</button>
                </div>
                <div class="input-field link-container">
                    <a href="<?php echo $this->createUrl('/login');?>">قبلا ثبت نام کرده ام.</a>
                </div>
            <?php $this->endWidget(); ?>
        </div>
        <div class="loading-container">
            <div class="overly"></div>
            <div class="spinner">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
    </div>
</div>