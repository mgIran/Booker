<?php
/* @var $this HotelsController */
/* @var $hotelsDataProvider CArrayDataProvider */
/* @var $country string */
/* @var $searchID string */
/* @var $nextPage string */
if(!isset($nextPage))
    $nextPage=null;
?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/bootstrap-nav-wizard.css');?>
<div class="container" id="scroll-destination">
    <div class="content page-box">
        <div class="steps hotel-steps">
            <ul class="nav nav-wizard">
                <li class="done"><a>جستجوی هتل</a></li>
                <li class="active"><a>انتخاب هتل</a></li>
                <li><a>ورود اطلاعات</a></li>
                <li><a>پرداخت</a></li>
                <li><a>دریافت واچر</a></li>
            </ul>
        </div>
        <ul class="collapsible" data-collapsible="accordion">
            <li>
                <div class="collapsible-header search-info">
                    <b class="red-text">شهر مقصد: </b><small><?php echo CHtml::encode(Yii::app()->session['cityName']);?></small>
                    <b class="red-text">مدت اقامت: </b><small><?php echo Yii::app()->session['stayTime'].' شب | از '.JalaliDate::date('d F', Yii::app()->session['inDate']).' تا '.JalaliDate::date('d F', Yii::app()->session['outDate']);?></small>
                    <b class="red-text">تعداد اتاق: </b><small><?php echo Yii::app()->session['roomsCount'].' اتاق';?></small>
                    <button class="btn btn-sm waves-effect waves-light red lighten-1 pull-left">تغییر جستجو</button>
                </div>
                <div class="search-form-container collapsible-body">
                    <div class="search-tools">
                        <?php echo CHtml::beginForm('', 'post', array('id'=>'search-form'));?>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 input-field">
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
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 input-field">
                            <?php Yii::app()->clientScript->registerScript('variables', 'var enter_date, out_date;window.serverToday = "'.date('Y-m-d').'";', CClientScript::POS_HEAD);?>
                            <?php $this->widget('application.extensions.PDatePicker.PDatePicker', array(
                                'id'=>'enter-date',
                                'variableName'=>'enter_date',
                                'options'=>array(
                                    'default'=>Yii::app()->session['inDate'],
                                    'initalHighlight'=>true,
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
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 input-field">
                            <?php $this->widget('application.extensions.PDatePicker.PDatePicker', array(
                                'id'=>'out-date',
                                'variableName'=>'out_date',
                                'scriptPosition'=>CClientScript::POS_HEAD,
                                'options'=>array(
                                    'default'=>Yii::app()->session['outDate'],
                                    'initalHighlight'=>true,
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
                        </div>
                        <?php echo CHtml::hiddenField('stay_time', Yii::app()->session['stayTime'], array('id'=>'stay-time'));?>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 input-field">
                            <?php echo CHtml::label('تعداد اتاق', 'rooms-count', array('class'=>'active'));?>
                            <?php echo CHtml::dropDownList('rooms-count', Yii::app()->session['roomsCount'], array('1'=>'1','2'=>'2','3'=>'3','4'=>'4'), array('id'=>'rooms-count', 'data-template'=>'pretty'));?>
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
            </li>
        </ul>
        <div class="search-loading-container card-panel">
            <p class="text-center">سایت در حال جستجوی هتل ها می باشد<br>لطفا شکیبا باشید...</p>
            <div class="overflow-fix">
                <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12 col-lg-offset-2 col-md-offset-2 col-sm-offset-3 col-xs-offset-0">
                    <div class="progress">
                        <div class="indeterminate"></div>
                    </div>
                </div>
            </div>
            <div class="wait-animate doing hidden-xs">
                <div class="wa-circle"></div>
                <div class="wa-v-line"></div>
                <div class="wa-feature-item f1 right">
                    <div class="wa-disc"></div>
                    <div class="wa-h-line"></div>
                    <div class="wa-content"><div><i class="material-icons pull-right medium">hotel</i>جستجو در بین بیش از 250 هزار هتل</div></div>
                </div>
                <div class="wa-feature-item f2 left">
                    <div class="wa-disc"></div>
                    <div class="wa-h-line"></div>
                    <div class="wa-content"><div><i class="material-icons pull-right medium">payment</i>پرداخت ریالی از درگاه بانک‌های معتبر</div></div>
                </div>
                <div class="wa-feature-item f3 right">
                    <div class="wa-disc"></div>
                    <div class="wa-h-line"></div>
                    <div class="wa-content"><div><i class="material-icons pull-right medium">check</i>دریافت واچر هتل در لحظه</div></div>
                </div>
                <div class="wa-feature-item f4 left">
                    <div class="wa-disc"></div>
                    <div class="wa-h-line"></div>
                    <div class="wa-content"><div><i class="material-icons pull-right medium">schedule</i>پشتیبانی ۲۴ ساعته</div></div>
                </div>
                <div class="wa-finish-disc"></div>
            </div>
        </div>
        <div id="hotels-container" class="hotels-container hidden">
            <div class="card-panel filter-hotel fixable">
                <div class="hidden-lg hidden-md hidden-sm pull-left chevron-down">
                    <i class="material-icons red-text">keyboard_arrow_down</i>
                </div>
                <div class="row">
                    <div class="title red-text yekan-text container-fluid">هتل مورد نظر خود را بیابید...</div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <select id="stars-count" name="stars-count" data-template="normal">
                            <option value="" disabled selected>ستاره</option>
                            <option value="-1">همه</option>
                            <option value="0">رتبه بندی نشده</option>
                            <option value="1">یک ستاره</option>
                            <option value="2">دو ستاره</option>
                            <option value="3">سه ستاره</option>
                            <option value="4">چهار ستاره</option>
                            <option value="5">پنج ستاره</option>
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="input-field">
                            <?php echo CHtml::textField('hotel_name', '', array('id'=>'filter-hotel-name'));?>
                            <?php echo CHtml::label('نام هتل', 'filter-hotel-name');?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <label>قیمت</label>
                        <div id="price-range"></div>
                        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/nouislider.js');?>
                        <?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/nouislider.css');?>
                    </div>
                </div>
            </div>
            <h5 class="yekan-text red-text text-accent-2">لیست هتل ها</h5>
            <?php $this->widget('zii.widgets.CListView', array(
                'id'=>'hotels-list',
                'dataProvider'=>$hotelsDataProvider,
                'itemView'=>'_hotel_item',
                'itemsCssClass'=>'items overflow-fix container-fluid',
                'template'=>'{items}',
                'viewData'=>array(
                    'duration'=>Yii::app()->session['stayTime'],
                    'country'=>(isset($country))?$country:null,
                    'searchID'=>(isset($searchID))?$searchID:null,
                    //'city'=>(isset($city))?$city:null,
                ),
                'beforeAjaxUpdate'=>"function(){
                    $('html, body').animate({ scrollTop: $('#scroll-destination').offset().top }, 500, function(){
                        waitAnimate();
                    });
                }",
                'afterAjaxUpdate'=>'function(id, data){
                    if(data=="در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید!")
                        window.location.href="'.Yii::app()->createUrl('/error?code=212').'";
                    if($(data).find("#load-more-container").find("#load-more").length != 0)
                        $("#load-more-container").html($(data).find("#load-more-container").html());
                
                    var prices=null;
                    $.ajax({
                        url: "'.Yii::app()->createUrl('/reservation/hotels/getMinMaxPrice').'",
                        type: "POST",
                        dataType: "JSON",
                        success: function(data){
                            prices=data.prices;
                            $(".search-loading-container").addClass("hidden");
                            $(".hotels-container").removeClass("hidden");
                            var slider = document.getElementById("price-range");
                            noUiSlider.create(slider, {
                                start: [prices["minPrice"], prices["maxPrice"]],
                                connect: true,
                                step: 1,
                                range: {
                                    "min": prices["minPrice"],
                                    "max": prices["maxPrice"]
                                },
                                format:wNumb({
                                    thousand: ",",
                                    encoder: function(value){
                                        return Math.round(value);
                                    },
                                    decoder: function(value){
                                        return Math.round(value);
                                    }
                                })
                            });
                            slider.noUiSlider.on("change", function(values, handle) {
                                $(".hotel-item").each(function(){
                                    price=$(this).data("price");
                                    minPrice=values[0].replace(new RegExp(",", "g"), "");
                                    maxPrice=values[1].replace(new RegExp(",", "g"), "");
                                    minPrice=parseInt(minPrice)*1000;
                                    maxPrice=(parseInt(maxPrice)+1)*1000;
                                    if(price < minPrice)
                                        $(this).addClass("hidden");
                                    else if(price > maxPrice)
                                        $(this).addClass("hidden");
                                    else
                                        $(this).removeClass("hidden");
                                });
                            });
                        }
                    });
                }'
            ));?>
            <div id="load-more-container">
                <?php if(!is_null($nextPage)):?>
                    <div id="load-more" data-key="<?php echo CHtml::encode($nextPage);?>">هتل های بیشتر...</div>
                <?php endif;?>
            </div>
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
    $.fn.yiiListView.update('hotels-list', {error:function(){window.location.href='".Yii::app()->createUrl('/error?code=212')."';return false;}});
", CClientScript::POS_LOAD);?>
<?php Yii::app()->clientScript->registerScript('load-more-hotels',"
    $('body').on('click', '#load-more', function(){
        if(!$(this).hasClass('doing')){
            $(this).text('در حال بارگذاری...').addClass('doing');
            $.ajax({
                url: '".$this->createUrl('/reservation/hotels/loadMore')."',
                type: 'POST',
                dataType: 'JSON',
                data: {key: $(this).data('key')},
                success:function(data){
                    $('#hotels-list .items').append($(data.hotels).find('.items').html());
                    if(data.loadMore != null)
                        $('#load-more').text('هتل های بیشتر...').removeClass('doing').data('key', data.loadMore);
                    else
                        $('#load-more').remove();
                },
                error:function(){
                    window.location.href='".Yii::app()->createUrl('/error?code=212')."';
                }
            })
        }
    });
", CClientScript::POS_END);?>
<?php Yii::app()->clientScript->registerScript('filter-hotels',"
    $('select#stars-count').on('change', function(){
        stars=$(this).val();
        $('.hotel-item').each(function(){
            if(stars==-1)
                $(this).removeClass('hidden');
            else{
                if($(this).data('stars')!=stars)
                    $(this).addClass('hidden');
                else
                    $(this).removeClass('hidden');
            }
        });
    });
    var timeout;
    $('#filter-hotel-name').on('keyup', function(){
        var input=$(this);
        clearTimeout(timeout);
        timeout=setTimeout(function(){
            $('.hotel-item').each(function(){
                val=input.val();
                if(val=='')
                    $(this).removeClass('hidden');
                else{
                    name=$(this).data('name');
                    var re = new RegExp(val, 'i');
                    if(re.test(name))
                        $(this).removeClass('hidden');
                    else
                        $(this).addClass('hidden');
                }
            });
        }, 1000);
    });

    $('.filter-hotel .title').click(function(){
        if($(window).width() < 768){
            if($('.filter-hotel.fixed').css('height')=='50px'){
                $('.filter-hotel.fixed').css('height','auto');
                $('.filter-hotel.fixed').css('overflow','visible');
                $('.filter-hotel .chevron-down i').text('keyboard_arrow_up');
            }else{
                $('.filter-hotel.fixed').css('height',50);
                $('.filter-hotel.fixed').css('overflow','hidden');
                $('.filter-hotel .chevron-down i').text('keyboard_arrow_down');
            }
        }
    });
", CClientScript::POS_LOAD);?>
<?php Yii::app()->clientScript->registerScript('show-cancel-rule',"
    $(document).on('click', '.cancel-rule', function(){
        $('#cancel-rules-modal').find('.modal-content p').html('در حال بارگذاری اطلاعات...');
        $.ajax({
            url:$(this).data('url'),
            type:'POST',
            dataType:'JSON',
            success:function(data){
                if(data.status=='success')
                    $('#cancel-rules-modal').find('.modal-content p').html(data.rules);
                else
                    $('#cancel-rules-modal').find('.modal-content p').html('در انجام عملیات خطایی رخ داده است. لطفا مجددا تلاش کنید!');
            },
            error:function(){
                $('#cancel-rules-modal').find('.modal-content p').html('در انجام عملیات خطایی رخ داده است. لطفا مجددا تلاش کنید!');
            }
        });
    });
");?>
<div id="cancel-rules-modal" class="modal">
    <div class="modal-content">
        <h5 class="yekan-text">شرایط کنسلی</h5>
        <p></p>
    </div>
    <div class="modal-footer">
        <a href="#" data-dismiss="modal" class="waves-effect waves-red btn-flat">انصراف</a>
    </div>
</div>