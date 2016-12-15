<?php
/* @var $this HotelsController */
/* @var $model CancellationRequests */
?>
<div class="container">
    <div class="content page-box text-page">
        <h2 class="yekan-text">انصراف از رزرو</h2>
        <div class="container-fluid">
            <p>جهت انصراف از رزرو انجام شده درخواست شما در سیستم ثبت شده و پس از بررسی های لازم توسط تیم پشتیبانی عملیات مورد نظر انجام خواهد شد.</p>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 col-lg-offset-2 col-md-offset-2 col-sm-offset-2 page-break"></div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 col-lg-offset-2 col-md-offset-2 col-sm-offset-2">

                <?php $this->renderPartial('//layouts/_flashMessage');?>

                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'cancellation-form',
                    'enableAjaxValidation'=>true,
                    'enableClientValidation'=>true,
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                    ),
                )); ?>

                <?php $this->renderPartial('//layouts/_flashMessage');?>

                <p class="note">جهت انصراف از رزرو فرم زیر را پر کنید.</p>

                <div class="input-field">
                    <?php echo $form->textField($model, 'orderId', array('maxlength'=>20)); ?>
                    <?php echo $form->labelEx($model, 'orderId'); ?>
                    <?php echo $form->error($model, 'orderId'); ?>
                </div>

                <div class="input-field buttons">
                    <button class="btn waves-effect waves-light green lighten-1 pull-left" type="submit">ثبت</button>
                </div>

                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>