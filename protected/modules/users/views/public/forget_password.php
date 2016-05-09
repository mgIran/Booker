<?php
/* @var $model Users */
/* @var $form CActiveForm */
?>
<div class="container">
    <div class="content signup-box col-lg-8 col-md-8 col-sm-8 col-xs-10 col-lg-offset-2 col-md-offset-2 col-sm-offset-2 col-xs-offset-1">
        <h2 class="yekan-text">بازیابی کلمه عبور</h2>
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-offset-1">
            <?php echo CHtml::beginForm(Yii::app()->createUrl('/users/public/forgetPassword'), 'post', array(
                'id'=>'forget-password-form',
            ));?>

            <div class="alert alert-success hidden" id="message"></div>

            <div class="input-field">
                <?php echo CHtml::textField('email', ''); ?>
                <?php echo CHtml::label('پست الکترونیکی','email'); ?>
            </div>
            <div class="input-field buttons-block">
                <?php echo CHtml::ajaxSubmitButton('ارسال', Yii::app()->createUrl('/users/public/forgetPassword'), array(
                    'type'=>'POST',
                    'dataType'=>'JSON',
                    'data'=>"js:$('#forget-password-form').serialize()",
                    'beforeSend'=>"js:function(){
                        $('#message').addClass('hidden');
                        $('.loading-container').fadeIn();
                    }",
                    'success'=>"js:function(data){
                        if(data.hasError)
                            $('#message').removeClass('alert-success').addClass('alert-danger').text(data.message).removeClass('hidden');
                        else
                            $('#message').removeClass('alert-danger').addClass('alert-success').text(data.message).removeClass('hidden');
                        $('.loading-container').fadeOut();
                    }"
                ), array('class'=>'btn col-md-12 red lighten-1'));?>
            </div>
            <div class="input-field link-container">
                <p><a href="<?php echo $this->createUrl('/login');?>">میخواهم وارد سیستم بشوم.</a></p>
            </div>
            <?php CHtml::endForm(); ?>
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