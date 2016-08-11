<?php
/* @var $this ManageController */
/* @var $model CityNames */
/* @var $form CActiveForm */
?>

<div class="form" style="overflow:visible;">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'city-names-form',
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
		<?php echo $form->labelEx($model,'city_name'); ?>
		<?php echo $form->textField($model,'city_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'city_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'country_name'); ?>
		<?php echo $form->textField($model,'country_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'country_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city_key'); ?>
		<?php echo CHtml::textField('city_key', '', array('size'=>50,'id'=>'city_key')) ?>
		<?php echo $form->hiddenField($model,'city_key'); ?>
		<?php echo $form->error($model,'city_key'); ?>
		<span class="auto-complete-loading hidden">در حال جستجو...</span>
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
			url: '".Yii::app()->request->hostInfo.Yii::app()->request->baseUrl."/reservation/hotels/autoComplete/%QUERY',
			wildcard: '%QUERY'
		}
	});
	$('#city_key').typeahead({
		minLength: 3,
		limit: 20,
		hint: false
	}, {
		name: 'city_key',
		display: 'name',
		source: destinationSource
	}).on('typeahead:asyncrequest', function () {
		$(this).parents('.row').find('.auto-complete-loading').removeClass('hidden');
	}).on('typeahead:asyncreceive', function (a, b, c) {
		$(this).parents('.row').find('.auto-complete-loading').addClass('hidden');
	}).on('typeahead:selected', function (e, datum) {
		$('#CityNames_city_key').val(datum.key);
	});
");?>