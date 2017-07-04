<?php
/* @var $this ManageController */
/* @var $model Airports */
/* @var $form CActiveForm */
?>

<div class="form" style="overflow:visible;">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'airports-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

	<?php if(Yii::app()->user->hasFlash('success')):?>
		<div class="alert alert-success fade in">
			<button class="close close-sm" type="button" data-dismiss="alert"><i class="icon-remove"></i></button>
			<?php echo Yii::app()->user->getFlash('success');?>
		</div>
	<?php elseif(Yii::app()->user->hasFlash('failed')):?>
		<div class="alert alert-danger fade in">
			<button class="close close-sm" type="button" data-dismiss="alert"><i class="icon-remove"></i></button>
			<?php echo Yii::app()->user->getFlash('failed');?>
		</div>
	<?php endif;?>

	<p class="note">همه فیلدهای <span class="required">*</span>دار اجباری هستند.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city'); ?>
		<?php echo $form->textField($model,'city',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'iata'); ?>
		<?php echo CHtml::textField('iata', $model->isNewRecord?'':$model->iata, array('size'=>50,'id'=>'iata')) ?>
		<?php echo $form->hiddenField($model,'iata'); ?>
		<?php echo $form->error($model,'iata'); ?>
		<span class="auto-complete-loading hidden">در حال جستجو...</span>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_domestic'); ?>
		<?php echo $form->dropDownList($model,'is_domestic',array(1=>'داخلی', 0=>'خارجی')); ?>
		<?php echo $form->error($model,'is_domestic'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره',array('class'=>'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/typeahead.bundle.min.js');?>
<?php Yii::app()->clientScript->registerScript('inline-script', "
	var destinationSource = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		remote: {
			url: '".Yii::app()->request->hostInfo.Yii::app()->request->baseUrl."/reservation/flights/autoComplete/%QUERY',
			wildcard: '%QUERY'
		}
	});
	$('#iata').typeahead({
		minLength: 3,
		limit: 20,
		hint: false
	}, {
		name: 'iata',
		display: 'name',
		source: destinationSource
	}).on('typeahead:asyncrequest', function () {
		$(this).parents('.row').find('.auto-complete-loading').removeClass('hidden');
	}).on('typeahead:asyncreceive', function (a, b, c) {
		$(this).parents('.row').find('.auto-complete-loading').addClass('hidden');
	}).on('typeahead:selected', function (e, datum) {
		$('#Airports_iata').val(datum.iata);
	});
");?>