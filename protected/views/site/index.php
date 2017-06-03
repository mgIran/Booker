<?
/* @var $this SiteController */
?>
<div class="container main-page">
    <div class="search-box">
        <div class="logo">
            <div class="icon"></div>
            <h1>بوکر<small>رزرو آنلاین هتل های خارجی</small></h1>
        </div>
        <div class="box">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#hotel">هتل خارجی</a></li>
                <li><a data-toggle="tab" href="#flight">پرواز داخلی و خارجی</a></li>
            </ul>

            <div class="tab-content">
                <div id="hotel" class="tab-pane fade in active">
                    <?php echo CHtml::beginForm('', 'post', array('id'=>'search-form'));?>
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 input-field">
                                <?php echo CHtml::textField('destination', '', array('id'=>'destination', 'class'=>'hotel-destination'));?>
                                <?php echo CHtml::hiddenField('city_key', '', array('id'=>'city-key'));?>
                                <div class="loading-container auto-complete-loading">
                                    <div class="spinner">
                                        <div class="bounce1"></div>
                                        <div class="bounce2"></div>
                                        <div class="bounce3"></div>
                                    </div>
                                </div>
                                <?php echo CHtml::label('شهر مقصد *', 'destination');?>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 input-field">
                                <?php Yii::app()->clientScript->registerScript('variables', 'var enter_date, out_date;', CClientScript::POS_HEAD);?>
                                <?php $this->widget('application.extensions.PDatePicker.PDatePicker', array(
                                    'id'=>'enter-date',
                                    'variableName'=>'enter_date',
                                    'options'=>array(
                                        'autoClose'=>true,
                                        'alignByRightSide'=>true,
                                        'autoOpenPartner'=>true,
                                        'minDate'=>(time()-(60*60*24))*1000,
                                        'title'=>'تاریخ ورود',
                                        'format'=>'DD MMMM YYYY',
                                        'partnerInput'=>'#out-date',
                                        'partnerRoot'=>'#outDateDatePicker',
                                        'highlightPartner'=>'#out-date_altField',
                                        'highlightType'=>'start',
                                        'today'=>'js:new Date('.date('Y').', '.date('m').' - 1, '.date('d').').valueOf()',
                                        'onShow'=>"js:function(){}",
                                        'dayPicker'=>array(
                                            'onSelect'=>'js:function(){$("#startDateDatePicker").removeClass("picker--opened"),$("#start-date").blur()}',
                                            'scrollEnabled'=>false
                                        ),
                                        'monthPicker'=>false,
                                        'yearPicker'=>false,
                                        'targetId'=>'startDateDatePicker',
                                        'returnInput'=>'js:out_date',
                                    ),
                                    'htmlOptions'=>array(
                                        'readonly'=>'1'
                                    )
                                ));?>
                                <?php echo CHtml::label('تاریخ ورود', 'enter-date');?>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 input-field">
                                <?php $this->widget('application.extensions.PDatePicker.PDatePicker', array(
                                    'id'=>'out-date',
                                    'variableName'=>'out_date',
                                    'scriptPosition'=>CClientScript::POS_HEAD,
                                    'options'=>array(
                                        'autoClose'=>true,
                                        'minDate'=>(time()-(60*60*24))*1000,
                                        'format'=>'DD MMMM YYYY',
                                        'highlightPartner'=>'#enter-date_altField',
                                        'highlightType'=>'end',
                                        'today'=>'js:new Date('.date('Y').', '.date('m').' - 1, '.date('d').').valueOf()',
                                        'title'=>'تاریخ خروج',
                                        'partnerRoot'=>'#startDateDatePicker',
                                        'onShow'=>"js:function(){}",
                                        'dayPicker'=>array(
                                            'onSelect'=>'js:function(){$("#outDateDatePicker").removeClass("picker--opened"),$("#out-date").blur()}',
                                            'scrollEnabled'=>false
                                        ),
                                        'targetId'=>'outDateDatePicker',
                                        'onHide'=>"js:function(){
                                            var checkInDate=persianDate.unix($('#enter-date_altField').val()),
                                                checkOutDate=persianDate.unix($('#out-date_altField').val());
                                            var stayTime=checkOutDate.diff(checkInDate, 'days');
                                            if(stayTime < 0)
                                                stayTime=0;
                                            $('#stay-time-container').removeClass('hidden');
                                            $('.stay-time').text(stayTime);
                                            $('#stay-time').val(stayTime);
                                        }"
                                    ),
                                    'htmlOptions'=>array(
                                        'readonly'=>'1'
                                    )
                                ));?>
                                <?php echo CHtml::label('تاریخ خروج', 'out-date');?>
                                <small id="stay-time-container" class="hidden"><b>مدت اقامت: </b><span class="stay-time">0</span> شب</small>
                                <?php echo CHtml::hiddenField('stay_time', '0', array('id'=>'stay-time'));?>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 input-field rooms-count-container">
                                <?php echo CHtml::dropDownList('rooms-count', '', array('1'=>1, '2'=>2, '3'=>3, '4'=>4), array('prompt'=>'تعداد اتاق را انتخاب کنید', 'data-template'=>'normal'));?>
                            </div>
                        </div>
                        <div class="room-info row"></div>
                        <div class="buttons-block">
                            <?php echo CHtml::tag('button', array('class'=>'btn waves-effect waves-light green lighten-1 pull-left col-lg-2 col-md-3 col-sm-4 col-xs-12', 'id'=>'search', 'type'=>'submit'), 'جستجو');?>
                            <p class="pull-right input-field message" style="margin: 0;line-height: 36px;"></p>
                        </div>
                    <?php echo CHtml::endForm();?>
                </div>
                <div id="flight" class="tab-pane fade">
                    <h3>Menu 1</h3>
                    <p>Some content in menu 1.</p>
                </div>
            </div>
        </div>
        <div class="search-box-footer">
            <ul class="nav navbar-nav nav-footer">
                <li role="presentation"><a href="<?php echo $this->createUrl('/reservation/hotels/cancellation');?>">درخواست انصراف</a></li>
                <li role="presentation"><a href="<?php echo $this->createUrl('/terms');?>">قوانین و مقررات</a></li>
                <li role="presentation"><a href="<?php echo $this->createUrl('/help');?>">راهنما</a></li>
                <li role="presentation"><a href="<?php echo $this->createUrl('/about');?>">درباره ما</a></li>
                <li role="presentation"><a href="<?php echo $this->createUrl('/contactUs');?>">تماس با ما</a></li>
            </ul>
            <div class="rahbod pull-left">
                <a href="https://t.me/rahbod" target="_blank" title="Rahbod"><img src="<?php echo Yii::app()->theme->baseUrl."/svg/rahbod.svg";?>"></a>
            </div>
        </div>
    </div>
<!--    <div class="slider">-->
<!--        <ul class="cb-slideshow">-->
<!--            <li><span class="slide-item" style="background: url('uploads/s1.jpg') no-repeat center / cover;"></span></li>-->
<!--            <li><span class="slide-item" style="background: url('uploads/s2.jpg') no-repeat center / cover;"></span></li>-->
<!--            <li><span class="slide-item" style="background: url('uploads/s3.jpg') no-repeat center / cover;"></span></li>-->
<!--            <li><span class="slide-item" style="background: url('uploads/s4.jpg') no-repeat center / cover;"></span></li>-->
<!--        </ul>-->
<!--    </div>-->
    <div class="socials">
        <a href="https://telegram.me/joinchat/Awz6Sz_LeZAxMYufY1ZmIQ" target="_blank" class="telegram"></a>
    </div>
    <div class="licences">
        <img id='nbpegwmdgwmddrftlbrh' style='cursor:pointer' onclick='window.open("https://trustseal.enamad.ir/Verify.aspx?id=29917&p=wkynjzpgjzpgnbpdqgwl", "Popup","toolbar=no, location=no, statusbar=no, menubar=no, scrollbars=1, resizable=0, width=580, height=600, top=30")' alt='' src='https://trustseal.enamad.ir/logo.aspx?id=29917&p=qesgzpfvzpfvlznbpeuk'/>
    </div>
</div>
<div class="datepicker-overlay hidden"></div>
<button class="btn-submit-date hidden">انتخاب</button>
<?php Yii::app()->clientScript->registerScript('general-variables', "var hotelAutoCompleteUrl='".Yii::app()->request->hostInfo.Yii::app()->request->baseUrl."/reservation/hotels/autoComplete/%QUERY';", CClientScript::POS_HEAD);?>
<?php Yii::app()->clientScript->registerScript('inline-script', "
    $('#search').click(function(){
        if($('#destination').val()==''){
            $('.message').text('مقصد خود را مشخص کنید.');
            $('#destination').focus();
            return false;
        }else if($('#city-key').val()==''){
            $('.message').text('امکان رزرو در شهر مورد نظر وجود ندارد');
            return false;
        }else if($('#out-date_altField').val()==$('#enter-date_altField').val()){
            $('.message').text('تاریخ ورود و خروج نمی تواند یکسان باشد.');
            return false;
        }else if($('#rooms-count').val()==null){
            $('.message').text('تعداد اتاق را انتخاب کنید.');
            return false;
        }else if($('select.adults-count').val()==null){
            $('.message').text('تعداد بزرگسال را انتخاب کنید.');
            return false;
        }else if($('select.kids-count-select').val()==null){
            $('.message').text('تعداد کودک را انتخاب کنید.');
            return false;
        }else if($('select.kids-age').length!=0 && $('select.kids-age').val()==null){
            $('.message').text('سن کودک را انتخاب کنید.');
            return false;
        }
    });
");?>