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
        <ul class="collapsible" data-collapsible="accordion">
            <li>
                <div class="collapsible-header search-info">
                    <b class="red-text">شهر مقصد: </b><small><?php echo CHtml::encode(Yii::app()->session['cityName']);?></small>
                    <b class="red-text">مدت اقامت: </b><small><?php echo $this->getStayingTime(Yii::app()->session['inDate'], Yii::app()->session['outDate']).' شب | از '.JalaliDate::date('d F', Yii::app()->session['inDate']).' تا '.JalaliDate::date('d F', Yii::app()->session['outDate']);?></small>
                    <b class="red-text">تعداد اتاق: </b><small><?php echo Yii::app()->session['roomsCount'].' اتاق';?></small>
                    <button class="btn btn-sm waves-effect waves-light red lighten-1 pull-left">تغییر جستجو</button>
                </div>
                <div class="search-form-container collapsible-body">
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
                    'duration'=>floor(((Yii::app()->session['outDate']-Yii::app()->session['inDate'])/(3600*24))),
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
    $.fn.yiiListView.update('hotels-list');
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