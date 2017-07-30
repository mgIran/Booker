<?
/* @var $this SiteController */
?>
<div class="container main-page">
    <div class="search-box">
        <div class="logo">
            <div class="icon"></div>
            <h1><small>رزرو آنلاین خدمات مسافرتی و جهانگردی</small></h1>
        </div>
        <div class="box">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#domestic-flight-tab">پرواز داخلی</a></li>
                <li><a data-toggle="tab" href="#non-domestic-flight-tab">پرواز خارجی</a></li>
                <li><a data-toggle="tab" href="#hotel-tab">هتل خارجی</a></li>
            </ul>

            <div class="tab-content">
                <div id="domestic-flight-tab" class="tab-pane fade in active">
                    <?php echo CHtml::beginForm('', 'post', array('id'=>'flight-search-form'));?>
                        <?php echo CHtml::hiddenField('method', 'flight');?>
                        <?php echo CHtml::hiddenField('flight-is-domestic', '1', array('id'=>'dom-flight-is-domestic'));?>
                        <?php echo CHtml::hiddenField('dom-flight-dir-type', 'one-way');?>
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 input-field">
                                <?php echo CHtml::textField('dom-flight-departure', '', array('id'=>'dom-flight-departure', 'class'=>'dom-flight-departure'));?>
                                <?php echo CHtml::hiddenField('dom_flight_departure_iata', '', array('id'=>'dom-flight-departure-iata'));?>
                                <?php echo CHtml::label('از شهر یا فرودگاه', 'dom-flight-departure');?>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 input-field">
                                <?php echo CHtml::textField('dom-flight-arrival', '', array('id'=>'dom-flight-arrival', 'class'=>'dom-flight-arrival'));?>
                                <?php echo CHtml::hiddenField('dom_flight_arrival_iata', '', array('id'=>'dom-flight-arrival-iata'));?>
                                <?php echo CHtml::label('به شهر یا فرودگاه', 'dom-flight-arrival');?>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 input-field">
                                <?php Yii::app()->clientScript->registerScript('variables', 'var dom_departure_date, dom_return_date;', CClientScript::POS_HEAD);?>
                                <?php $this->widget('application.extensions.PDatePicker.PDatePicker', array(
                                    'id'=>'dom-departure-date',
                                    'variableName'=>'dom_departure_date',
                                    'options'=>array(
                                        'autoClose'=>true,
                                        'alignByRightSide'=>true,
                                        'autoOpenPartner'=>true,
                                        'minDate'=>(time()-(60*60*24))*1000,
                                        'title'=>'تاریخ رفت',
                                        'format'=>'DD MMMM YYYY',
                                        'partnerInput'=>'#dom-return-date',
                                        'partnerRoot'=>'#domReturnDateDatePicker',
                                        'highlightPartner'=>'#dom-return-date_altField',
                                        'highlightType'=>'start',
                                        'today'=>'js:new Date('.date('Y').', '.date('m').' - 1, '.date('d').').valueOf()',
                                        'onShow'=>"js:function(){}",
                                        'dayPicker'=>array(
                                            'onSelect'=>'js:function(){$("#domDepartureDateDatePicker").removeClass("picker--opened"),$("#dom-departure-date").blur()}',
                                            'scrollEnabled'=>false
                                        ),
                                        'monthPicker'=>false,
                                        'yearPicker'=>false,
                                        'targetId'=>'domDepartureDateDatePicker',
                                        'returnInput'=>'js:dom_return_date',
                                    ),
                                    'htmlOptions'=>array(
                                        'readonly'=>'1'
                                    )
                                ));?>
                                <?php echo CHtml::label('تاریخ رفت', 'dom-departure-date');?>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 input-field disable">
                                <?php $this->widget('application.extensions.PDatePicker.PDatePicker', array(
                                    'id'=>'dom-return-date',
                                    'variableName'=>'dom_return_date',
                                    'scriptPosition'=>CClientScript::POS_HEAD,
                                    'options'=>array(
                                        'autoClose'=>true,
                                        'minDate'=>(time()-(60*60*24))*1000,
                                        'format'=>'DD MMMM YYYY',
                                        'highlightPartner'=>'#dom-departure-date_altField',
                                        'highlightType'=>'end',
                                        'today'=>'js:new Date('.date('Y').', '.date('m').' - 1, '.date('d').').valueOf()',
                                        'title'=>'تاریخ خروج',
                                        'partnerRoot'=>'#domDepartureDateDatePicker',
                                        'onShow'=>"js:function(){}",
                                        'dayPicker'=>array(
                                            'onSelect'=>'js:function(){$("#domReturnDateDatePicker").removeClass("picker--opened"),$("#dom-return-date").blur()}',
                                            'scrollEnabled'=>false
                                        ),
                                        'targetId'=>'domReturnDateDatePicker'
                                    ),
                                    'htmlOptions'=>array(
                                        'readonly'=>'1',
                                        'disabled'=>true
                                    )
                                ));?>
                                <?php echo CHtml::label('تاریخ برگشت', 'dom-return-date');?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 input-field">
                                <?php echo CHtml::dropDownList('flight_adult_count', '1', array('1'=>'1 بزرگسال', '2'=>'2 بزرگسال', '3'=>'3 بزرگسال', '4'=>'4 بزرگسال'), array('data-template'=>'normal'));?>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 input-field">
                                <?php echo CHtml::dropDownList('flight_child_count', '0', array('0'=>'بدون کودک','1'=>'1 کودک', '2'=>'2 کودک', '3'=>'3 کودک', '4'=>'4 کودک'), array('data-template'=>'normal'));?>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 input-field">
                                <?php echo CHtml::dropDownList('flight_infant_count', '0', array('0'=>'بدون نوزاد','1'=>'1 نوزاد', '2'=>'2 نوزاد', '3'=>'3 نوزاد', '4'=>'4 نوزاد'), array('data-template'=>'normal'));?>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 input-field">
                                <?php echo CHtml::dropDownList('dom-flight-dir-type-dropdown', 'one-way', array('two-way'=>'رفت و برگشت', 'one-way'=>'یکطرفه'), array('class'=>'pull-right','data-template'=>'normal','prompt'=>'نوع سفر'));?>
                            </div>
                        </div>
                        <div class="buttons-block">
                            <?php echo CHtml::tag('button', array('class'=>'btn waves-effect waves-light green lighten-1 pull-left col-lg-2 col-md-3 col-sm-4 col-xs-12', 'id'=>'dom-flight-search-btn', 'type'=>'submit'), 'جستجو');?>
                            <p class="pull-left input-field message" id="dom-flight-message" style="margin: 0 0 0 15px;line-height: 36px;"></p>
                        </div>
                    <?php echo CHtml::endForm();?>
                </div>
                <div id="non-domestic-flight-tab" class="tab-pane fade">
                    <?php echo CHtml::beginForm('', 'post', array('id'=>'flight-search-form'));?>
                        <?php echo CHtml::hiddenField('method', 'flight');?>
                        <?php echo CHtml::hiddenField('flight-is-domestic', '0', array('id'=>'non-dom-flight-is-domestic'));?>
                        <?php echo CHtml::hiddenField('non-dom-flight-dir-type', 'one-way');?>
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 input-field">
                                <?php echo CHtml::textField('non-dom-flight-departure', '', array('id'=>'non-dom-flight-departure', 'class'=>'non-dom-flight-departure'));?>
                                <?php echo CHtml::hiddenField('non_dom_flight_departure_iata', '', array('id'=>'non-dom-flight-departure-iata'));?>
                                <?php echo CHtml::hiddenField('non_dom_flight_from_is_city', '', array('id'=>'non-dom-flight-from-is-city'));?>
                                <div class="loading-container auto-complete-loading">
                                    <div class="spinner">
                                        <div class="bounce1"></div>
                                        <div class="bounce2"></div>
                                        <div class="bounce3"></div>
                                    </div>
                                </div>
                                <?php echo CHtml::label('از شهر یا فرودگاه', 'non-dom-flight-departure');?>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 input-field">
                                <?php echo CHtml::textField('non-dom-flight-arrival', '', array('id'=>'non-dom-flight-arrival', 'class'=>'non-dom-flight-arrival'));?>
                                <?php echo CHtml::hiddenField('non_dom_flight_arrival_iata', '', array('id'=>'non-dom-flight-arrival-iata'));?>
                                <?php echo CHtml::hiddenField('non_dom_flight_to_is_city', '', array('id'=>'non-dom-flight-to-is-city'));?>
                                <div class="loading-container auto-complete-loading">
                                    <div class="spinner">
                                        <div class="bounce1"></div>
                                        <div class="bounce2"></div>
                                        <div class="bounce3"></div>
                                    </div>
                                </div>
                                <?php echo CHtml::label('به شهر یا فرودگاه', 'non-dom-flight-arrival');?>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 input-field">
                                <?php Yii::app()->clientScript->registerScript('variables', 'var non_dom_departure_date, non_dom_return_date;', CClientScript::POS_HEAD);?>
                                <?php $this->widget('application.extensions.PDatePicker.PDatePicker', array(
                                    'id'=>'non-dom-departure-date',
                                    'variableName'=>'non_dom_departure_date',
                                    'options'=>array(
                                        'autoClose'=>true,
                                        'alignByRightSide'=>true,
                                        'autoOpenPartner'=>true,
                                        'minDate'=>(time()-(60*60*24))*1000,
                                        'title'=>'تاریخ رفت',
                                        'format'=>'DD MMMM YYYY',
                                        'partnerInput'=>'#non-dom-return-date',
                                        'partnerRoot'=>'#nonDomReturnDateDatePicker',
                                        'highlightPartner'=>'#non-dom-return-date_altField',
                                        'highlightType'=>'start',
                                        'today'=>'js:new Date('.date('Y').', '.date('m').' - 1, '.date('d').').valueOf()',
                                        'onShow'=>"js:function(){}",
                                        'dayPicker'=>array(
                                            'onSelect'=>'js:function(){$("#nonDomDepartureDateDatePicker").removeClass("picker--opened"),$("#non-dom-departure-date").blur()}',
                                            'scrollEnabled'=>false
                                        ),
                                        'monthPicker'=>false,
                                        'yearPicker'=>false,
                                        'targetId'=>'nonDomDepartureDateDatePicker',
                                        'returnInput'=>'js:non_dom_return_date',
                                    ),
                                    'htmlOptions'=>array(
                                        'readonly'=>'1'
                                    )
                                ));?>
                                <?php echo CHtml::label('تاریخ رفت', 'non-dom-departure-date');?>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 input-field disable">
                                <?php $this->widget('application.extensions.PDatePicker.PDatePicker', array(
                                    'id'=>'non-dom-return-date',
                                    'variableName'=>'non_dom_return_date',
                                    'scriptPosition'=>CClientScript::POS_HEAD,
                                    'options'=>array(
                                        'autoClose'=>true,
                                        'minDate'=>(time()-(60*60*24))*1000,
                                        'format'=>'DD MMMM YYYY',
                                        'highlightPartner'=>'#non-dom-departure-date_altField',
                                        'highlightType'=>'end',
                                        'today'=>'js:new Date('.date('Y').', '.date('m').' - 1, '.date('d').').valueOf()',
                                        'title'=>'تاریخ خروج',
                                        'partnerRoot'=>'#nonDomDepartureDateDatePicker',
                                        'onShow'=>"js:function(){}",
                                        'dayPicker'=>array(
                                            'onSelect'=>'js:function(){$("#nonDomReturnDateDatePicker").removeClass("picker--opened"),$("#non-dom-return-date").blur()}',
                                            'scrollEnabled'=>false
                                        ),
                                        'targetId'=>'nonDomReturnDateDatePicker'
                                    ),
                                    'htmlOptions'=>array(
                                        'readonly'=>'1',
                                        'disabled'=>true
                                    )
                                ));?>
                                <?php echo CHtml::label('تاریخ برگشت', 'non-dom-return-date');?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 input-field">
                                <?php echo CHtml::dropDownList('flight_adult_count', '1', array('1'=>'1 بزرگسال', '2'=>'2 بزرگسال', '3'=>'3 بزرگسال', '4'=>'4 بزرگسال'), array('data-template'=>'normal'));?>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 input-field">
                                <?php echo CHtml::dropDownList('flight_child_count', '0', array('0'=>'بدون کودک','1'=>'1 کودک', '2'=>'2 کودک', '3'=>'3 کودک', '4'=>'4 کودک'), array('data-template'=>'normal'));?>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 input-field">
                                <?php echo CHtml::dropDownList('flight_infant_count', '0', array('0'=>'بدون نوزاد','1'=>'1 نوزاد', '2'=>'2 نوزاد', '3'=>'3 نوزاد', '4'=>'4 نوزاد'), array('data-template'=>'normal'));?>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 input-field">
                                <?php echo CHtml::dropDownList('non-dom-flight-dir-type-dropdown', 'one-way', array('two-way'=>'رفت و برگشت', 'one-way'=>'یکطرفه'), array('class'=>'pull-right','data-template'=>'normal','prompt'=>'نوع سفر'));?>
                            </div>
                        </div>
                        <div class="buttons-block">
                            <?php echo CHtml::tag('button', array('class'=>'btn waves-effect waves-light green lighten-1 pull-left col-lg-2 col-md-3 col-sm-4 col-xs-12', 'id'=>'non-dom-flight-search-btn', 'type'=>'submit'), 'جستجو');?>
                            <p class="pull-left input-field message" id="non-dom-flight-message" style="margin: 0 0 0 15px;line-height: 36px;"></p>
                        </div>
                    <?php echo CHtml::endForm();?>
                </div>
                <div id="hotel-tab" class="tab-pane fade">
                    <?php echo CHtml::beginForm('', 'post', array('id'=>'search-form'));?>
                    <?php echo CHtml::hiddenField('method', 'hotel');?>
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
                        <?php echo CHtml::tag('button', array('class'=>'btn waves-effect waves-light green lighten-1 pull-left col-lg-2 col-md-3 col-sm-4 col-xs-12', 'id'=>'hotel-search-btn', 'type'=>'submit'), 'جستجو');?>
                        <p class="pull-right input-field message" id="hotel-message" style="margin: 0;line-height: 36px;"></p>
                    </div>
                    <?php echo CHtml::endForm();?>
                </div>
            </div>
        </div>
        <div class="search-box-footer">
            <ul class="nav navbar-nav nav-footer">
                <li role="presentation"><a href="<?php echo $this->createUrl('/cancellation');?>">درخواست انصراف</a></li>
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
    <div class="slider">
        <ul class="cb-slideshow">
            <li><span class="slide-item" style="background: url('uploads/s1.jpg') no-repeat center / cover;"></span></li>
            <li><span class="slide-item" style="background: url('uploads/s2.jpg') no-repeat center / cover;"></span></li>
            <li><span class="slide-item" style="background: url('uploads/s3.jpg') no-repeat center / cover;"></span></li>
            <li><span class="slide-item" style="background: url('uploads/s4.jpg') no-repeat center / cover;"></span></li>
        </ul>
    </div>
    <div class="socials">
        <a href="https://telegram.me/joinchat/Awz6Sz_LeZAxMYufY1ZmIQ" target="_blank" class="telegram"></a>
    </div>
    <div class="licences">
        <img id='nbpegwmdgwmddrftlbrh' style='cursor:pointer' onclick='window.open("https://trustseal.enamad.ir/Verify.aspx?id=29917&p=wkynjzpgjzpgnbpdqgwl", "Popup","toolbar=no, location=no, statusbar=no, menubar=no, scrollbars=1, resizable=0, width=580, height=600, top=30")' alt='' src='https://trustseal.enamad.ir/logo.aspx?id=29917&p=qesgzpfvzpfvlznbpeuk'/>
    </div>
</div>
<div class="datepicker-overlay hidden"></div>
<button class="btn-submit-date hidden">انتخاب</button>
<?php Yii::app()->clientScript->registerScript('general-variables', "
    var hotelAutoCompleteUrl = '".Yii::app()->request->hostInfo.Yii::app()->request->baseUrl."/reservation/hotels/autoComplete/%QUERY';
    var flightAutoCompleteUrl= '".Yii::app()->request->hostInfo.Yii::app()->request->baseUrl."/reservation/flights/autoComplete/%QUERY';
    var domesticAirportsUrl = '".Yii::app()->request->hostInfo.Yii::app()->request->baseUrl."/reservation/flights/domesticAirports?v=8.1';
", CClientScript::POS_HEAD);?>
<?php Yii::app()->clientScript->registerScript('inline-script', "
    $('#hotel-search-btn').click(function(){
        if($('#destination').val()==''){
            $('#hotel-message').text('مقصد خود را مشخص کنید.');
            $('#destination').focus();
            return false;
        }else if($('#city-key').val()==''){
            $('#hotel-message').text('امکان رزرو در شهر مورد نظر وجود ندارد');
            return false;
        }else if($('#out-date_altField').val()==$('#enter-date_altField').val()){
            $('#hotel-message').text('تاریخ ورود و خروج نمی تواند یکسان باشد.');
            return false;
        }else if($('#rooms-count').val()==null){
            $('#hotel-message').text('تعداد اتاق را انتخاب کنید.');
            return false;
        }else if($('select.adults-count').val()==null){
            $('#hotel-message').text('تعداد بزرگسال را انتخاب کنید.');
            return false;
        }else if($('select.kids-count-select').val()==null){
            $('#hotel-message').text('تعداد کودک را انتخاب کنید.');
            return false;
        }else if($('select.kids-age').length!=0 && $('select.kids-age').val()==null){
            $('#hotel-message').text('سن کودک را انتخاب کنید.');
            return false;
        }
    });

    $('#dom-flight-search-btn').click(function(){
        if($('#dom-flight-departure').val()==''){
            $('#dom-flight-message').text('مبدا خود را مشخص کنید.');
            $('#dom-flight-departure').focus();
            return false;
        }else if($('#dom-flight-arrival').val()==''){
            $('#dom-flight-message').text('مقصد خود را مشخص کنید.');
            $('#dom-flight-arrival').focus();
            return false;
        }else if($('#dom-departure-date_altField').val()==''){
            $('#dom-flight-message').text('تاریخ رفت را مشخص کنید.');
            return false;
        }else if($('#dom-return-date_altField').val()=='' && $('#dom-flight-dir-type').val()=='two-way'){
            $('#dom-flight-message').text('تاریخ برگشت را مشخص کنید.');
            return false;
        }else if($('#dom-departure-date_altField').val()==$('#dom-return-date_altField').val()){
            $('#dom-flight-message').text('تاریخ رفت و برگشت نمی تواند یکسان باشد.');
            return false;
        }else if($('select#dom-flight-class').val()==''){
            $('#dom-flight-message').text('کلاس پرواز را انتخاب کنید.');
            return false;
        }
    });

    $('#dom-flight-dir-type-dropdown').on('change', function(){
        if($(this).val()=='one-way'){
            $('#dom-flight-dir-type').val('one-way');
            $('#domReturnDateDatePicker').addClass('picker--hidden');
            $('#dom-return-date').parent().addClass('disable');
            $('#dom-return-date').prop('disabled', true);
        }else{
            $('#dom-flight-dir-type').val('two-way');
            $('#domReturnDateDatePicker').removeClass('picker--hidden');
            if($('#dom-departure-date_altField').val() != undefined && $('#dom-departure-date_altField').val() != '')
                $('#domReturnDateDatePicker').addClass('picker--opened');
            $('#dom-return-date').parent().removeClass('disable');
            $('#dom-return-date').prop('disabled', false);
        }
    });

    $('#non-dom-flight-search-btn').click(function(){
        if($('#non-dom-flight-departure').val()==''){
            $('#non-dom-flight-message').text('مبدا خود را مشخص کنید.');
            $('#non-dom-flight-departure').focus();
            return false;
        }else if($('#non-dom-flight-arrival').val()==''){
            $('#non-dom-flight-message').text('مقصد خود را مشخص کنید.');
            $('#non-dom-flight-arrival').focus();
            return false;
        }else if($('#non-dom-departure-date_altField').val()==''){
            $('#non-dom-flight-message').text('تاریخ رفت را مشخص کنید.');
            return false;
        }else if($('#non-dom-return-date_altField').val()=='' && $('#non-dom-flight-dir-type').val()=='two-way'){
            $('#non-dom-flight-message').text('تاریخ برگشت را مشخص کنید.');
            return false;
        }else if($('#non-dom-departure-date_altField').val()==$('#non-dom-return-date_altField').val()){
            $('#non-dom-flight-message').text('تاریخ رفت و برگشت نمی تواند یکسان باشد.');
            return false;
        }
    });

    $('#non-dom-flight-dir-type-dropdown').on('change', function(){
        if($(this).val()=='one-way'){
            $('#non-dom-flight-dir-type').val('one-way');
            $('#nonDomReturnDateDatePicker').addClass('picker--hidden');
            $('#non-dom-return-date').parent().addClass('disable');
            $('#non-dom-return-date').prop('disabled', true);
        }else{
            $('#non-dom-flight-dir-type').val('two-way');
            $('#nonDomReturnDateDatePicker').removeClass('picker--hidden');
            if($('#non-dom-departure-date_altField').val() != undefined && $('#non-dom-departure-date_altField').val() != '')
                $('#nonDomReturnDateDatePicker').addClass('picker--opened');
            $('#non-dom-return-date').parent().removeClass('disable');
            $('#non-dom-return-date').prop('disabled', false);
        }
    });
");?>
<?php Yii::app()->clientScript->registerScript('hidden-picker',"
    $('#domReturnDateDatePicker').addClass('picker--hidden');
    $('#nonDomReturnDateDatePicker').addClass('picker--hidden');
", CClientScript::POS_LOAD);?>
