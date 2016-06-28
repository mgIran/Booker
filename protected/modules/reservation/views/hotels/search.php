<?php
/* @var $this HotelsController */
/* @var $hotelsDataProvider CArrayDataProvider */
/* @var $country string */
/* @var $city string */
?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/bootstrap-nav-wizard.css');?>
<div class="container">
    <div class="content page-box">
        <div class="steps">
            <ul class="nav nav-wizard">
                <li class="done col-lg-2"><a>جستجوی هتل</a></li>
                <li class="active col-lg-2"><a>انتخاب هتل</a></li>
                <li class="col-lg-2"><a>انتخاب اتاق</a></li>
                <li class="col-lg-2"><a>ورود اطلاعات</a></li>
                <li class="col-lg-2"><a>پرداخت</a></li>
                <li class="col-lg-2"><a>دریافت واچر</a></li>
            </ul>
        </div>
        <div class="search-form-container card-panel">
            <div class="search-tools">
                <?php echo CHtml::beginForm('', 'post', array('id'=>'search-form'));?>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="input-field">
                        <?php echo CHtml::textField('destination', CHtml::encode(Yii::app()->session['cityName']), array('id'=>'destination', 'class'=>'hotel-destination'));?>
                        <?php echo CHtml::hiddenField('city_key', Yii::app()->session['cityKey'], array('id'=>'city-key'));?>
                        <div class="loading-container auto-complete-loading">
                            <div class="spinner">
                                <div class="bounce1"></div>
                                <div class="bounce2"></div>
                                <div class="bounce3"></div>
                            </div>
                        </div>
                        <?php echo CHtml::label('شهر مقصد *', 'destination', array('class'=>'active'));?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="input-field">
                        <?php $this->widget('application.extensions.PDatePicker.PDatePicker', array(
                            'id'=>'enter-date',
                            'options'=>array(
                                'format'=>'DD MMMM YYYY',
                                'minDate'=>(time()-(60*60*24))*1000,
                                'default'=>Yii::app()->session['inDate'],
                                'onShow'=>"js:function(){
                                        $('.datepicker-plot-area').width(400).
                                            css({
                                                top:(($(window).height()/2)-($('.datepicker-plot-area').height()/2)),
                                                left:(($(window).width()/2)-($('.datepicker-plot-area').width()/2))
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
                            )
                        ));?>
                        <?php echo CHtml::label('تاریخ ورود', 'enter-date');?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="input-field">
                        <?php $this->widget('application.extensions.PDatePicker.PDatePicker', array(
                            'id'=>'out-date',
                            'options'=>array(
                                'format'=>'DD MMMM YYYY',
                                'minDate'=>(time()-(60*60*24))*1000,
                                'default'=>Yii::app()->session['outDate'],
                                'onShow'=>"js:function(){
                                        $('.datepicker-plot-area').width(400).
                                            css({
                                                top:(($(window).height()/2)-($('.datepicker-plot-area').height()/2)),
                                                left:(($(window).width()/2)-($('.datepicker-plot-area').width()/2))
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
                            )
                        ));?>
                        <?php echo CHtml::label('تاریخ خروج', 'out-date');?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="input-field">
                        <?php echo CHtml::label('تعداد اتاق', 'rooms-count', array('class'=>'active'));?>
                        <?php echo CHtml::dropDownList('rooms-count', Yii::app()->session['roomsCount'], array('1'=>'1','2'=>'2','3'=>'3','4'=>'4'), array('id'=>'rooms-count', 'data-template'=>'pretty'));?>
                    </div>
                </div>
                <div class="room-info clearfix">
                    <?php for($i=0;$i<Yii::app()->session['roomsCount'];$i++):?>
                        <div class="room-item clearfix container-fluid">
                            <h6 class="col-md-1 room-label">اتاق <b><?php echo $this->parseNumbers(($i+1));?></b></h6>
                            <div class="col-md-8 rooms-info-container">
                                <div class="col-md-3">
                                    <div class="input-field">
                                        <?php echo CHtml::dropDownList('rooms['.($i+1).'][adults]', Yii::app()->session['rooms'][$i+1]['adults'], array('1'=>'1 نفر','2'=>'2 نفر','3'=>'3 نفر','4'=>'4 نفر'), array('class'=>'adults-count', 'prompt'=>'بزرگسال'));?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-field">
                                        <?php echo CHtml::dropDownList('rooms['.($i+1).'][kids]', Yii::app()->session['rooms'][$i+1]['kids'], array('0'=>'0 نفر','1'=>'1 نفر','2'=>'2 نفر','3'=>'3 نفر'), array('class'=>'kids-count-select', 'prompt'=>'کودک'));?>
                                    </div>
                                </div>
                                <div class="col-md-6 kids-age-container">
                                    <?php if(isset(Yii::app()->session['rooms'][$i+1]['kids_age'])):?>
                                        <?php foreach(Yii::app()->session['rooms'][$i+1]['kids_age'] as $key=>$kidsAge):?>
                                            <div class="col-md-4">
                                                <div class="input-field">
                                                    <?php echo CHtml::dropDownList('rooms['.($i+1).'][kids_age]['.$key.']', $kidsAge, array('2'=>'0 تا 2','7'=>'2 تا 7','12'=>'7 تا 12'), array('class'=>'kids-age', 'prompt'=>'سن'));?>
                                                </div>
                                            </div>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                </div>
                            </div>
                            <input type="hidden" id="room-num" value="<?php echo ($i+1);?>">
                        </div>
                    <?php endfor;?>
                </div>
                <div class="container-fluid">
                    <?php echo CHtml::tag('button', array('class'=>'btn waves-effect waves-light green lighten-1 col-md-2 pull-left', 'id'=>'search', 'type'=>'submit'), 'جستجو');?>
                    <p class="message error pull-right"></p>
                </div>
                <?php echo CHtml::endForm();?>
            </div>
        </div>
        <div class="search-loading-container card-panel">
            <p class="text-center">سایت در حال جستجوی هتل ها می باشد<br>لطفا شکیبا باشید...</p>
            <div class="overflow-fix">
                <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12 col-lg-offset-2 col-md-offset-2 col-sm-offset-3 col-xs-offset-0">
                    <div class="progress">
                        <div class="indeterminate"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hotels-container">
            <h5 class="yekan-text red-text text-accent-2">لیست هتل ها</h5>
            <?php $this->widget('zii.widgets.CListView', array(
                'id'=>'hotels-list',
                'dataProvider'=>$hotelsDataProvider,
                'itemView'=>'_hotel_item',
                'itemsCssClass'=>'items overflow-fix container-fluid',
                'template'=>'{items}',
                'viewData'=>array(
                    'duration'=>floor(((Yii::app()->session['outDate']-Yii::app()->session['inDate'])/(3600*24))),
                    'country'=>(isset($country))?$country:null,
                    'city'=>(isset($city))?$city:null,
                ),
            ));?>
        </div>
    </div>
</div>
<div class="datepicker-overlay hidden"></div>
<button class="btn-submit-date hidden">انتخاب</button>
<?php Yii::app()->clientScript->registerScript('general-variables', "var hotelAutoCompleteUrl='".Yii::app()->request->hostInfo.Yii::app()->request->baseUrl."/reservation/hotels/autoComplete/%QUERY';", CClientScript::POS_HEAD);?>
<?php Yii::app()->clientScript->registerScript('submit-form', "
    $('button#search').click(function(){
        if($('#destination').val()==''){
            $('.message').text('مقصد خود را مشخص کنید.');
            $('#destination').focus();
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
<?php Yii::app()->clientScript->registerScript('search-hotels',"
    $.fn.yiiListView.update('hotels-list');
", CClientScript::POS_LOAD);?>
