<?php
/* @var $this FlightsController */
/* @var $form CActiveForm */
/* @var $orderModel OrderFlight */
/* @var $passengersModel PassengersFlight */
/* @var $details array */
/* @var $buyTerms string */
/* @var $oneWayPrice double */
/* @var $returnPrice double */
$totalPrice = 0;
$totalPrice += $this->getFixedPrice($oneWayPrice/10, true, $details['flights']['oneWay']['type'])['price'];
if(isset($details['flights']['return']))
    $totalPrice += $this->getFixedPrice($returnPrice/10, true, $details['flights']['return']['type'])['price'];
?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/bootstrap-nav-wizard.css');?>
<div class="container">
    <div class="content page-box hotel-details">
        <div class="steps flight-steps container-fluid">
            <ul class="nav nav-wizard">
                <li class="done"><a>جستجوی پروازها</a></li>
                <li class="done"><a>انتخاب پرواز</a></li>
                <li class="active"><a>ورود اطلاعات</a></li>
                <li><a>پرداخت</a></li>
                <li><a>دریافت بلیط</a></li>
            </ul>
        </div>
        <div id="checkout">
            <div class="card-panel">
                <h5 class="red-text">اطلاعات پرواز</h5>
                <div class="reserve-information flight-information">
                    <table class="table">
                        <thead>
                        <tr>
                            <th></th>
                            <th>تاریخ و ساعت</th>
                            <th>مبدا</th>
                            <th>مقصد</th>
                            <th>ایرلاین</th>
                            <th>قیمت</th>
                            <?php if(!Yii::app()->session['domestic']):?>
                                <th></th>
                            <?php endif;?>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="title-td" rowspan="2">پرواز رفت</td>
                            <td><?php echo JalaliDate::date('Y/m/d - H:i', strtotime($details['flights']['oneWay']['legs'][0]['departureTime']));?></td>
                            <td><?php echo Airports::getFieldByIATA($details['flights']['oneWay']['legs'][0]['origin'], 'city_fa').' - '.Airports::getFieldByIATA($details['flights']['oneWay']['legs'][0]['origin'], 'airport_fa');?></td>
                            <td><?php echo Airports::getFieldByIATA($details['flights']['oneWay']['legs'][0]['destination'], 'city_fa').' - '.Airports::getFieldByIATA($details['flights']['oneWay']['legs'][0]['destination'], 'airport_fa');?></td>
                            <td><img src="<?php echo Yii::app()->baseUrl.'/uploads/airlines-logo/dom/'.$details['flights']['oneWay']['legs'][0]['carrier'].'.png';?>"><?php echo $details['flights']['oneWay']['legs'][0]['carrierName'];?></td>
                            <td><?php echo number_format($this->getFixedPrice($oneWayPrice/10, true, $details['flights']['oneWay']['type'])['price']);?> تومان</td>
                            <?php if(!Yii::app()->session['domestic']):?>
                                <td><a href="#">جزئیات...</a></td>
                            <?php endif;?>
                        </tr>
                        <tr>
                            <td colspan="5">
                            <?php foreach($details['flights']['oneWay']['fares'] as $fare):?>
                                <?php $type = '';if($fare['type']=='ADT')
                                    $type = 'بزرگسال';
                                elseif($fare['type']=='CHD')
                                    $type = 'کودک';
                                elseif($fare['type']=='INF')
                                    $type = 'نوزاد';
                                    ?>
                                <?php if($fare['count']!=0):?>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><b>قیمت <?php echo $type;?>: </b><?php echo number_format($this->getFixedPrice($fare['basePrice']/10, true, $details['flights']['oneWay']['type'])['price']).' <small>('.$fare['count'].' نفر)</small>';?></div>
                                <?php endif;?>
                            <?php endforeach;?>
                            </td>
                        </tr>
                        <?php if(isset($details['flights']['return'])):?>
                            <tr>
                                <td class="title-td" rowspan="2">پرواز برگشت</td>
                                <td><?php echo JalaliDate::date('Y/m/d - H:i', strtotime($details['flights']['return']['legs'][0]['departureTime']));?></td>
                                <td><?php echo Airports::getFieldByIATA($details['flights']['return']['legs'][0]['origin'], 'city_fa').' - '.Airports::getFieldByIATA($details['flights']['return']['legs'][0]['origin'], 'airport_fa');?></td>
                                <td><?php echo Airports::getFieldByIATA($details['flights']['return']['legs'][0]['destination'], 'city_fa').' - '.Airports::getFieldByIATA($details['flights']['return']['legs'][0]['destination'], 'airport_fa');?></td>
                                <td><img src="<?php echo Yii::app()->baseUrl.'/uploads/airlines-logo/dom/'.$details['flights']['return']['legs'][0]['carrier'].'.png';?>"><?php echo $details['flights']['return']['legs'][0]['carrierName'];?></td>
                                <td><?php echo number_format($this->getFixedPrice($returnPrice/10, true, $details['flights']['return']['type'])['price']);?> تومان</td>
                                <?php if(!Yii::app()->session['domestic']):?>
                                    <td><a href="#">جزئیات...</a></td>
                                <?php endif;?>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <?php foreach($details['flights']['return']['fares'] as $fare):?>
                                        <?php $type = '';if($fare['type']=='ADT')
                                            $type = 'بزرگسال';
                                        elseif($fare['type']=='CHD')
                                            $type = 'کودک';
                                        elseif($fare['type']=='INF')
                                            $type = 'نوزاد';
                                        ?>
                                        <?php if($fare['count']!=0):?>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><b>قیمت <?php echo $type;?>: </b><?php echo number_format($this->getFixedPrice($fare['basePrice']/10, true, $details['flights']['return']['type'])['price']).' <small>('.$fare['count'].' نفر)</small>';?></div>
                                        <?php endif;?>
                                    <?php endforeach;?>
                                </td>
                            </tr>
                        <?php endif;?>
                        <tr class="total-tr">
                            <td colspan="5" class="text-left">قابل پرداخت</td>
                            <td colspan="2"><?php echo number_format($totalPrice);?> تومان</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>
                    </div>
                </div>
            </div>
            <div class="card-panel passengers-info">
                <h5 class="red-text">اطلاعات خریدار</h5>

                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'order-form',
                    'enableAjaxValidation'=>true,
                    'htmlOptions'=>array(
                        'class'=>'overflow-fix',
                    )
                )); ?>

                <?php if($orderModel->hasErrors()):?><div class="alert alert-danger"><?php echo $form->errorSummary($orderModel); ?></div><?php endif;?>

                <ul>
                    <li>این اطلاعات مربوط به شماست که فرآیند خرید را انجام می دهید.</li>
                    <li>تیم پشتیبانی بوکر 24 در صورت نیاز از طریق اطلاعات وارد شده در این قسمت با شما تماس خواهد گرفت.</li>
                    <li class="red-text">لطفا پست الکترونیکی را با دقت وارد کنید زیرا صورت حساب و بلیط به این آدرس ارسال خواهد شد.</li>
                    <li class="red-text">پر کردن همه فیلد ها الزامی است.</li>
                </ul>

                <div class="buyer-info overflow-fix">

                    <div class="overflow-fix">
                        <div class="input-field col-md-6">
                            <?php echo $form->textField($orderModel,'buyer_name'); ?>
                            <?php echo $form->labelEx($orderModel,'buyer_name'); ?>
                            <?php echo $form->error($orderModel,'buyer_name'); ?>
                        </div>

                        <div class="input-field col-md-6">
                            <?php echo $form->textField($orderModel,'buyer_family'); ?>
                            <?php echo $form->labelEx($orderModel,'buyer_family'); ?>
                            <?php echo $form->error($orderModel,'buyer_family'); ?>
                        </div>
                    </div>

                    <div class="overflow-fix">
                        <div class="input-field col-md-6">
                            <?php echo $form->textField($orderModel,'buyer_mobile'); ?>
                            <?php echo $form->labelEx($orderModel,'buyer_mobile'); ?>
                            <?php echo $form->error($orderModel,'buyer_mobile'); ?>
                        </div>

                        <div class="input-field col-md-6">
                            <?php echo $form->textField($orderModel,'buyer_email'); ?>
                            <?php echo $form->labelEx($orderModel,'buyer_email'); ?>
                            <?php echo $form->error($orderModel,'buyer_email'); ?>
                        </div>
                    </div>

                </div>

                <div class="room-passengers">

                    <h5 class="red-text">اطلاعات مسافران</h5>

                    <?php if(Yii::app()->user->hasFlash('errors')):?>
                        <div class="alert alert-danger">
                            <div class="errorSummary">
                                <p>لطفا خطاهای ورودی زیر را تصحیح کنید :</p>
                                <ul>
                                    <?php echo Yii::app()->user->getFlash('errors');?>
                                </ul>
                            </div>
                        </div>
                    <?php endif;?>

                    <ul>
                        <li>این اطلاعات مربوط به مسافران است؛ افرادی که بلیط به نام آنها صادر می شود.</li>
                        <li>اطلاعات را به انگلیسی و فارسی مطابق با گذرنامه پر کنید.</li>
                        <li class="red-text">مسئوليت كنترل گذرنامه از نظر اعتبار ( 6 ماه قبل از تاريخ انقضاء ) و ممنوعيت خروج از كشور بر عهده مسافر است .</li>
                    </ul>
                    <?php $j=0;?>
                    <?php for($i=1;$i<=Yii::app()->session['adult'];$i++):?>
                        <div class="room-item overflow-fix">
                            <div class="container-fluid">
                                <h6 class="col-md-1 room-label">بزرگسال <b><?php echo $this->parseNumbers(($i));?></b></h6>
                                <div class="col-md-11 room-type">بالای 12 سال</div>
                            </div>
                            <div class="container-fluid passenger-item">
                                <div class="input-field col-md-3">
                                    <?php echo CHtml::textField('Passengers[adult]['.$j.'][name_fa]', '', array('id'=>'Passengers_adult_'.$j.'_name_fa','maxlength'=>50)); ?>
                                    <?php echo CHtml::label('نام فارسی','Passengers_adult_'.$j.'_name_fa'); ?>
                                </div>
                                <div class="input-field col-md-3">
                                    <?php echo CHtml::textField('Passengers[adult]['.$j.'][family_fa]', '', array('id'=>'Passengers_adult_'.$j.'_family_fa','maxlength'=>50)); ?>
                                    <?php echo CHtml::label('نام خانوادگی فارسی','Passengers_adult_'.$j.'_family_fa'); ?>
                                </div>
                                <div class="input-field col-md-3">
                                    <?php echo CHtml::textField('Passengers[adult]['.$j.'][name_en]', '', array('id'=>'Passengers_adult_'.$j.'_name_en','maxlength'=>50)); ?>
                                    <?php echo CHtml::label('نام انگلیسی','Passengers_adult_'.$j.'_name_en'); ?>
                                </div>
                                <div class="input-field col-md-3">
                                    <?php echo CHtml::textField('Passengers[adult]['.$j.'][family_en]', '', array('id'=>'Passengers_adult_'.$j.'_family_en','maxlength'=>50)); ?>
                                    <?php echo CHtml::label('نام خانوادگی انگلیسی','Passengers_adult_'.$j.'_family_en'); ?>
                                </div>
                                <?php if(!Yii::app()->session['domestic']):?>
                                    <div class="input-field col-md-3">
                                        <?php echo CHtml::textField('Passengers[adult]['.$j.'][passport_num]', '', array('id'=>'Passengers_adult_'.$j.'_passport_num','maxlength'=>50)); ?>
                                        <?php echo CHtml::label('شماره گذرنامه','Passengers_adult_'.$j.'_passport_num'); ?>
                                    </div>
                                <?php endif;?>
                                <div class="input-field col-md-3">
                                    <?php echo CHtml::textField('Passengers[adult]['.$j.'][national_id]', '', array('id'=>'Passengers_adult_'.$j.'_national_id','maxlength'=>50)); ?>
                                    <?php echo CHtml::label('کد ملی','Passengers_adult_'.$j.'_national_id'); ?>
                                </div>
<!--                                <div class="input-field col-md-3">-->
<!--                                    --><?php //$this->widget('application.extensions.PDatePicker.PDatePicker', array(
//                                        'id'=>'Passengers_adult_'.$j.'_birth_date',
//                                        'type'=>'source',
//                                        'options'=>array(
//                                            'altFieldName'=>'Passengers[adult]['.$j.'][birth_day]',
//                                            'autoClose'=>true,
//                                            'format'=>'DD MMMM YYYY',
//                                            'today'=>'js:new Date('.date('Y').', '.date('m').' - 1, '.date('d').').valueOf()',
//                                        ),
//                                        'htmlOptions'=>array(
//                                            'readonly'=>'1'
//                                        )
//                                    ));?>
<!--                                    --><?php //echo CHtml::label('تاریخ تولد', 'Passengers_adult_'.$j.'_birth_date');?>
<!--                                </div>-->
                                <div class="col-md-3">
                                    <?php echo CHtml::label('جنسیت','',array('class'=>'gender-label')); ?>

                                    <?php echo CHtml::radioButton('Passengers[adult]['.$j.'][gender]', false, array('id'=>'Passengers_adult_'.$j.'_male','value'=>'male','class'=>'with-gap')); ?>
                                    <?php echo CHtml::label('مرد','Passengers_adult_'.$j.'_male'); ?>

                                    <?php echo CHtml::radioButton('Passengers[adult]['.$j.'][gender]', false, array('id'=>'Passengers_adult_'.$j.'_female','value'=>'female','class'=>'with-gap')); ?>
                                    <?php echo CHtml::label('زن','Passengers_adult_'.$j.'_female'); ?>
                                </div>
                            </div>
                            <?php $j++;?>
                        </div>
                    <?php endfor;?>
                    <?php if(Yii::app()->session['child'] != 0):?>
                        <?php for($i=1;$i<=Yii::app()->session['child'];$i++):?>
                            <div class="room-item overflow-fix">
                                <div class="container-fluid">
                                    <h6 class="col-md-1 room-label">کودک  <b><?php echo $this->parseNumbers(($i));?></b></h6>
                                    <div class="col-md-11 room-type">2 تا 12 سال</div>
                                </div>
                                <div class="container-fluid passenger-item">
                                    <div class="input-field col-md-3">
                                        <?php echo CHtml::textField('Passengers[child]['.$j.'][name_fa]', '', array('id'=>'Passengers_child_'.$j.'_name_fa','maxlength'=>50)); ?>
                                        <?php echo CHtml::label('نام فارسی','Passengers_child_'.$j.'_name_fa'); ?>
                                    </div>
                                    <div class="input-field col-md-3">
                                        <?php echo CHtml::textField('Passengers[child]['.$j.'][family_fa]', '', array('id'=>'Passengers_child_'.$j.'_family_fa','maxlength'=>50)); ?>
                                        <?php echo CHtml::label('نام خانوادگی فارسی','Passengers_child_'.$j.'_family_fa'); ?>
                                    </div>
                                    <div class="input-field col-md-3">
                                        <?php echo CHtml::textField('Passengers[child]['.$j.'][name_en]', '', array('id'=>'Passengers_child_'.$j.'_name_en','maxlength'=>50)); ?>
                                        <?php echo CHtml::label('نام انگلیسی','Passengers_child_'.$j.'_name_en'); ?>
                                    </div>
                                    <div class="input-field col-md-3">
                                        <?php echo CHtml::textField('Passengers[child]['.$j.'][family_en]', '', array('id'=>'Passengers_child_'.$j.'_family_en','maxlength'=>50)); ?>
                                        <?php echo CHtml::label('نام خانوادگی انگلیسی','Passengers_child_'.$j.'_family_en'); ?>
                                    </div>
                                    <?php if(!Yii::app()->session['domestic']):?>
                                        <div class="input-field col-md-3">
                                            <?php echo CHtml::textField('Passengers[child]['.$j.'][passport_num]', '', array('id'=>'Passengers_child_'.$j.'_passport_num','maxlength'=>50)); ?>
                                            <?php echo CHtml::label('شماره گذرنامه','Passengers_child_'.$j.'_passport_num'); ?>
                                        </div>
                                    <?php endif;?>
                                    <div class="input-field col-md-3">
                                        <?php echo CHtml::textField('Passengers[child]['.$j.'][national_id]', '', array('id'=>'Passengers_child_'.$j.'_national_id','maxlength'=>50)); ?>
                                        <?php echo CHtml::label('کد ملی','Passengers_child_'.$j.'_national_id'); ?>
                                    </div>
<!--                                    <div class="input-field col-md-3">-->
<!--                                        --><?php //$this->widget('application.extensions.PDatePicker.PDatePicker', array(
//                                            'id'=>'Passengers_child_'.$j.'_birth_date',
//                                            'type'=>'source',
//                                            'options'=>array(
//                                                'altFieldName'=>'Passengers[child]['.$j.'][birth_day]',
//                                                'autoClose'=>true,
//                                                'format'=>'DD MMMM YYYY',
//                                                'today'=>'js:new Date('.date('Y').', '.date('m').' - 1, '.date('d').').valueOf()',
//                                            ),
//                                            'htmlOptions'=>array(
//                                                'readonly'=>'1'
//                                            )
//                                        ));?>
<!--                                        --><?php //echo CHtml::label('تاریخ تولد', 'Passengers_child_'.$j.'_birth_date');?>
<!--                                    </div>-->
                                    <div class="col-md-3">
                                        <?php echo CHtml::label('جنسیت','',array('class'=>'gender-label')); ?>

                                        <?php echo CHtml::radioButton('Passengers[child]['.$j.'][gender]', false, array('id'=>'Passengers_child_'.$j.'_male','value'=>'male','class'=>'with-gap')); ?>
                                        <?php echo CHtml::label('مرد','Passengers_child_'.$j.'_male'); ?>

                                        <?php echo CHtml::radioButton('Passengers[child]['.$j.'][gender]', false, array('id'=>'Passengers_child_'.$j.'_female','value'=>'female','class'=>'with-gap')); ?>
                                        <?php echo CHtml::label('زن','Passengers_child_'.$j.'_female'); ?>
                                    </div>
                                </div>
                                <?php $j++;?>
                            </div>
                        <?php endfor;?>
                    <?php endif;?>
                    <?php if(Yii::app()->session['infant'] != 0):?>
                        <?php for($i=1;$i<=Yii::app()->session['infant'];$i++):?>
                            <div class="room-item overflow-fix">
                                <div class="container-fluid">
                                    <h6 class="col-md-1 room-label">نوزاد  <b><?php echo $this->parseNumbers(($i));?></b></h6>
                                    <div class="col-md-11 room-type">زیر 2 سال</div>
                                </div>
                                <div class="container-fluid passenger-item">
                                    <div class="input-field col-md-3">
                                        <?php echo CHtml::textField('Passengers[infant]['.$j.'][name_fa]', '', array('id'=>'Passengers_infant_'.$j.'_name_fa','maxlength'=>50)); ?>
                                        <?php echo CHtml::label('نام فارسی','Passengers_infant_'.$j.'_name_fa'); ?>
                                    </div>
                                    <div class="input-field col-md-3">
                                        <?php echo CHtml::textField('Passengers[infant]['.$j.'][family_fa]', '', array('id'=>'Passengers_infant_'.$j.'_family_fa','maxlength'=>50)); ?>
                                        <?php echo CHtml::label('نام خانوادگی فارسی','Passengers_infant_'.$j.'_family_fa'); ?>
                                    </div>
                                    <div class="input-field col-md-3">
                                        <?php echo CHtml::textField('Passengers[infant]['.$j.'][name_en]', '', array('id'=>'Passengers_infant_'.$j.'_name_en','maxlength'=>50)); ?>
                                        <?php echo CHtml::label('نام انگلیسی','Passengers_infant_'.$j.'_name_en'); ?>
                                    </div>
                                    <div class="input-field col-md-3">
                                        <?php echo CHtml::textField('Passengers[infant]['.$j.'][family_en]', '', array('id'=>'Passengers_infant_'.$j.'_family_en','maxlength'=>50)); ?>
                                        <?php echo CHtml::label('نام خانوادگی انگلیسی','Passengers_infant_'.$j.'_family_en'); ?>
                                    </div>
                                    <?php if(!Yii::app()->session['domestic']):?>
                                        <div class="input-field col-md-3">
                                            <?php echo CHtml::textField('Passengers[infant]['.$j.'][passport_num]', '', array('id'=>'Passengers_infant_'.$j.'_passport_num','maxlength'=>50)); ?>
                                            <?php echo CHtml::label('شماره گذرنامه','Passengers_infant_'.$j.'_passport_num'); ?>
                                        </div>
                                    <?php endif;?>
                                    <div class="input-field col-md-3">
                                        <?php echo CHtml::textField('Passengers[infant]['.$j.'][national_id]', '', array('id'=>'Passengers_infant_'.$j.'_national_id','maxlength'=>50)); ?>
                                        <?php echo CHtml::label('کد ملی','Passengers_infant_'.$j.'_national_id'); ?>
                                    </div>
<!--                                    <div class="input-field col-md-3">-->
<!--                                        --><?php //$this->widget('application.extensions.PDatePicker.PDatePicker', array(
//                                            'id'=>'Passengers_infant_'.$j.'_birth_date',
//                                            'type'=>'source',
//                                            'options'=>array(
//                                                'altFieldName'=>'Passengers[infant]['.$j.'][birth_day]',
//                                                'autoClose'=>true,
//                                                'format'=>'DD MMMM YYYY',
//                                                'today'=>'js:new Date('.date('Y').', '.date('m').' - 1, '.date('d').').valueOf()',
//                                            ),
//                                            'htmlOptions'=>array(
//                                                'readonly'=>'1'
//                                            )
//                                        ));?>
<!--                                        --><?php //echo CHtml::label('تاریخ تولد', 'Passengers_infant_'.$j.'_birth_date');?>
<!--                                    </div>-->
                                    <div class="col-md-3">
                                        <?php echo CHtml::label('جنسیت','',array('class'=>'gender-label')); ?>

                                        <?php echo CHtml::radioButton('Passengers[infant]['.$j.'][gender]', false, array('id'=>'Passengers_infant_'.$j.'_male','value'=>'male','class'=>'with-gap')); ?>
                                        <?php echo CHtml::label('مرد','Passengers_infant_'.$j.'_male'); ?>

                                        <?php echo CHtml::radioButton('Passengers[infant]['.$j.'][gender]', false, array('id'=>'Passengers_infant_'.$j.'_female','value'=>'female','class'=>'with-gap')); ?>
                                        <?php echo CHtml::label('زن','Passengers_infant_'.$j.'_female'); ?>
                                    </div>
                                </div>
                                <?php $j++;?>
                            </div>
                        <?php endfor;?>
                    <?php endif;?>
                </div>

                <div class="pull-right terms-check container-fluid">
                    <input type="checkbox" class="filled-in" id="terms-checkbox" />
                    <label for="terms-checkbox"><a class="modal-trigger" href="#terms-modal">شرایط خرید</a> را خوانده ام و با آنها موافقم.</label>
                </div>

                <div class="input-field buttons col-md-3 pull-left">
                    <?php echo CHtml::tag('button', array('disabled'=>true,'class'=>'btn waves-effect waves-light green lighten-1 col-md-12', 'id'=>'submit-form', 'type'=>'submit'), 'ادامه');?>
                </div>

                <?php $this->endWidget(); ?>
            </div>
        </div>
        <?php Yii::app()->clientScript->registerScript('inline', "
            $('#terms-checkbox').on('change', function(){
                if($(this).is(':checked'))
                    $('#submit-form').prop('disabled', false);
                else
                    $('#submit-form').prop('disabled', true);
            });

            $('#submit-form').on('click', function(){
                hasError=false;
                $('.room-passengers input').each(function(){
                    if($(this).attr('type')=='text'){
                        if($(this).val()=='')
                            hasError=true;
                    }else if($(this).attr('type')=='radio'){
                        if($('.room-passengers input[name=\"'+$(this).attr('name')+'\"]:checked').length==0)
                            hasError=true;
                    }
                });
                if(hasError){
                    Materialize.toast('اطلاعات مسافرین ناقص است.', 5000);
                    return false;
                }
            });
        ");?>
    </div>
</div>
<div id="terms-modal" class="modal">
    <div class="modal-content">
        <h4>شرایط خرید</h4>
        <p><?php echo $buyTerms;?></p>
    </div>
    <div class="modal-footer">
        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">می پذیرم</a>
    </div>
</div>