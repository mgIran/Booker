<?
/* @var $this SiteController */
?>
<div class="container main-page">
    <div class="col-lg-6 col-md-8 col-sm-8 col-xs-12 col-lg-offset-3 col-md-offset-2 col-sm-offset-2 search-box">
        <div class="logo">
            <div class="icon"></div>
            <h1>بوکر</h1>
            <h2>رزرو آنلاین هتل های خارجی</h2>
        </div>
        <div class="box">
            <h3>جستجوی هتل</h3>
            <?php echo CHtml::beginForm('', 'post', array('id'=>'search-form'));?>
                <div class="input-field">
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
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="input-field">
                            <?php $this->widget('application.extensions.PDatePicker.PDatePicker', array(
                                'id'=>'enter-date',
                                'options'=>array(
                                    'format'=>'DD MMMM YYYY',
                                    'minDate'=>(time()-(60*60*24))*1000,
                                    'onShow'=>"js:function(){
                                        $('.datepicker-plot-area').width($('#enter-date').parents('.row').width()).
                                            css({
                                                top:(($(window).height()/2)-($('.datepicker-plot-area').height()/2)),
                                                left:$('#enter-date').parents('.row').offset().left
                                            });
                                        $('.datepicker-overlay').removeClass('hidden');
                                        $('.btn-submit-date').css({
                                            top:$('.datepicker-plot-area:eq(0)').offset().top+$('.datepicker-plot-area:eq(0)').height()-46,
                                            left:$('.datepicker-plot-area:eq(0)').offset().left+15
                                        }).removeClass('hidden');
                                    }",
                                    'onHide'=>"js:function(){
                                        $('.datepicker-overlay').addClass('hidden');
                                        $('.btn-submit-date').addClass('hidden');
                                        var stayTime=Math.floor(($('#out-date_altField').val()-$('#enter-date_altField').val())/(60*60*24));
                                        if(stayTime < 0)
                                            stayTime=0;
                                        $('.stay-time').text(stayTime);
                                    }"
                                ),
                                'htmlOptions'=>array(
                                    'readonly'=>'1'
                                )
                            ));?>
                            <?php echo CHtml::label('تاریخ ورود', 'enter-date');?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="input-field">
                            <?php $this->widget('application.extensions.PDatePicker.PDatePicker', array(
                                'id'=>'out-date',
                                'options'=>array(
                                    'format'=>'DD MMMM YYYY',
                                    'minDate'=>(time()-(60*60*24))*1000,
                                    'onShow'=>"js:function(){
                                        $('.datepicker-plot-area').width($('#out-date').parents('.row').width()).
                                            css({
                                                top:(($(window).height()/2)-($('.datepicker-plot-area').height()/2)),
                                                left:$('#enter-date').parents('.row').offset().left
                                            });
                                        $('.datepicker-overlay').removeClass('hidden');
                                        $('.btn-submit-date').css({
                                            top:$('.datepicker-plot-area:eq(1)').offset().top+$('.datepicker-plot-area:eq(1)').height()-46,
                                            left:$('.datepicker-plot-area:eq(1)').offset().left+15
                                        }).removeClass('hidden');
                                    }",
                                    'onHide'=>"js:function(){
                                        $('.datepicker-overlay').addClass('hidden');
                                        $('.btn-submit-date').addClass('hidden');
                                        var stayTime=Math.floor(($('#out-date_altField').val()-$('#enter-date_altField').val())/(60*60*24));
                                        if(stayTime < 0)
                                            stayTime=0;
                                        $('.stay-time').text(stayTime);
                                    }"
                                ),
                                'htmlOptions'=>array(
                                    'readonly'=>'1'
                                )
                            ));?>
                            <?php echo CHtml::label('تاریخ خروج', 'out-date');?>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <small><b>مدت اقامت: </b><span class="stay-time">0</span> شب</small>
                    </div>
                </div>
                <div class="input-field">
                    <select id="rooms-count" name="rooms-count" data-template="normal">
                        <option value="" disabled selected>تعداد اتاق را انتخاب کنید</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>
                <div class="room-info row"></div>
                <div class="buttons-block">
                    <?php echo CHtml::tag('button', array('class'=>'btn waves-effect waves-light green lighten-1 col-md-12', 'id'=>'search', 'type'=>'submit'), 'جستجو');?>
                </div>
                <p class="text-center input-field message"></p>
            <?php echo CHtml::endForm();?>
        </div>
        <ul class="nav nav-justified">
            <li role="presentation"><a href="<?php echo $this->createUrl('/reservation/hotels/cancellation');?>">درخواست انصراف</a></li>
            <li role="presentation"><a href="<?php echo $this->createUrl('/terms');?>">قوانین و مقررات</a></li>
            <li role="presentation"><a href="<?php echo $this->createUrl('/help');?>">راهنما</a></li>
            <li role="presentation"><a href="<?php echo $this->createUrl('/about');?>">درباره ما</a></li>
            <li role="presentation"><a href="<?php echo $this->createUrl('/contactUs');?>">تماس با ما</a></li>
        </ul>
        <div class="licences hidden-lg hidden-md">
            <img id='nbpegwmdgwmddrftlbrh' style='cursor:pointer' onclick='window.open("https://trustseal.enamad.ir/Verify.aspx?id=29917&p=wkynjzpgjzpgnbpdqgwl", "Popup","toolbar=no, location=no, statusbar=no, menubar=no, scrollbars=1, resizable=0, width=580, height=600, top=30")' alt='' src='https://trustseal.enamad.ir/logo.aspx?id=29917&p=qesgzpfvzpfvlznbpeuk'/>
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