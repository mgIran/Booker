<?php
/* @var $this FlightsController */
/* @var $oneWayDataProvider CArrayDataProvider */
/* @var $returnDataProvider CArrayDataProvider */
/* @var $country string */
/* @var $searchID string */
/* @var $nextPage string */
if(!isset($nextPage))
    $nextPage=null;
?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/bootstrap-nav-wizard.css');?>
<div class="container" id="scroll-destination">
    <div class="content page-box">
        <div class="steps flight-steps container-fluid">
            <ul class="nav nav-wizard">
                <li class="done"><a>جستجوی پروازها</a></li>
                <li class="active"><a>انتخاب پرواز</a></li>
                <li><a>ورود اطلاعات</a></li>
                <li><a>پرداخت</a></li>
                <li><a>دریافت بلیط</a></li>
            </ul>
        </div>
        <div class="container-fluid">
            <ul class="collapsible" data-collapsible="accordion">
                <li>
                    <div class="collapsible-header search-info">
                        <span><?php echo Airports::getFieldByIATA(Yii::app()->session['origin'], 'city_fa');?> به <?php echo Airports::getFieldByIATA(Yii::app()->session['destination'], 'city_fa');?></span> |
                        <span><?php echo Yii::app()->session['dirType']=='one-way'?'یکطرفه':'رفت و برگشت';?></span> |
                        <span><?php echo JalaliDate::date('d F y', Yii::app()->session['date']).(Yii::app()->session['dirType']=='two-way'?' تا '.JalaliDate::date('d F y', Yii::app()->session['rDate']):'');?></span> |
                        <span><?php echo Yii::app()->session['adult']+Yii::app()->session['child']+Yii::app()->session['infant'];?> نفر</span>
                        <button class="btn btn-sm waves-effect waves-light red lighten-1 pull-left">تغییر جستجو</button>
                    </div>
                    <div class="search-form-container collapsible-body">
                        <div class="search-tools">
                            <?php echo CHtml::beginForm('', 'post', array('id'=>'flight-search-form'));?>
                                <div class="row">
                                    <div id="domestic-flights">
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
                                    </div>
                                    <div id="non-domestic-flights" class="hidden">
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
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 input-field">
                                        <?php Yii::app()->clientScript->registerScript('variables', 'var departure_date, return_date;', CClientScript::POS_HEAD);?>
                                        <?php $this->widget('application.extensions.PDatePicker.PDatePicker', array(
                                            'id'=>'departure-date',
                                            'variableName'=>'departure_date',
                                            'options'=>array(
                                                'autoClose'=>true,
                                                'alignByRightSide'=>true,
                                                'autoOpenPartner'=>true,
                                                'minDate'=>(time()-(60*60*24))*1000,
                                                'title'=>'تاریخ رفت',
                                                'format'=>'DD MMMM YYYY',
                                                'partnerInput'=>'#return-date',
                                                'partnerRoot'=>'#returnDateDatePicker',
                                                'highlightPartner'=>'#return-date_altField',
                                                'highlightType'=>'start',
                                                'today'=>'js:new Date('.date('Y').', '.date('m').' - 1, '.date('d').').valueOf()',
                                                'onShow'=>"js:function(){}",
                                                'dayPicker'=>array(
                                                    'onSelect'=>'js:function(){$("#departureDateDatePicker").removeClass("picker--opened"),$("#departure-date").blur()}',
                                                    'scrollEnabled'=>false
                                                ),
                                                'monthPicker'=>false,
                                                'yearPicker'=>false,
                                                'targetId'=>'departureDateDatePicker',
                                                'returnInput'=>'js:return_date',
                                            ),
                                            'htmlOptions'=>array(
                                                'readonly'=>'1'
                                            )
                                        ));?>
                                        <?php echo CHtml::label('تاریخ رفت', 'departure-date');?>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 input-field disable">
                                        <?php $this->widget('application.extensions.PDatePicker.PDatePicker', array(
                                            'id'=>'return-date',
                                            'variableName'=>'return_date',
                                            'scriptPosition'=>CClientScript::POS_HEAD,
                                            'options'=>array(
                                                'autoClose'=>true,
                                                'minDate'=>(time()-(60*60*24))*1000,
                                                'format'=>'DD MMMM YYYY',
                                                'highlightPartner'=>'#departure-date_altField',
                                                'highlightType'=>'end',
                                                'today'=>'js:new Date('.date('Y').', '.date('m').' - 1, '.date('d').').valueOf()',
                                                'title'=>'تاریخ خروج',
                                                'partnerRoot'=>'#departureDateDatePicker',
                                                'onShow'=>"js:function(){}",
                                                'dayPicker'=>array(
                                                    'onSelect'=>'js:function(){$("#returnDateDatePicker").removeClass("picker--opened"),$("#return-date").blur()}',
                                                    'scrollEnabled'=>false
                                                ),
                                                'targetId'=>'returnDateDatePicker'
                                            ),
                                            'htmlOptions'=>array(
                                                'readonly'=>'1',
                                                'disabled'=>true
                                            )
                                        ));?>
                                        <?php echo CHtml::label('تاریخ برگشت', 'return-date');?>
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
                                        <?php echo CHtml::dropDownList('flight-dir-type-dropdown', 'one-way', array('two-way'=>'رفت و برگشت', 'one-way'=>'یکطرفه'), array('class'=>'pull-right', 'prompt'=>'نوع سفر', 'data-template'=>'normal'));?>
                                    </div>
                                </div>
                                <div class="buttons-block">
                                    <div class="pull-right">
                                        <small class="red-text pull-right" style="line-height: 36px;margin-left: 10px;">نوع پرواز: </small><?php echo CHtml::dropDownList('flight-domestic-dropdown', 'داخلی', array(1=>'داخلی', 0=>'خارجی'), array('class'=>'pull-right x-small','data-template'=>'normal'))?>
                                    </div>
                                    <?php echo CHtml::tag('button', array('class'=>'btn waves-effect waves-light green lighten-1 col-md-2 pull-left', 'id'=>'flight-search-btn', 'type'=>'submit'), 'جستجو');?>
                                    <p class="message error pull-left" style="margin-left: 15px;line-height: 36px;"></p>
                                </div>
                            <?php echo CHtml::endForm();?>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="container-fluid">
            <div class="search-loading-container card-panel">
                <p class="text-center">سایت در حال جمع آوری اطلاعات پرواز ها می باشد<br>لطفا شکیبا باشید...</p>
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
                        <div class="wa-content"><div><i class="material-icons pull-right medium">flight</i>جستجو در بین بیش از 180 ایرلاین</div></div>
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
        </div>
        <div id="flights-container" class="flights-container hidden">
            <div class="container-fluid filter-hotel fixable">
                <div class="card-panel">
                    <div class="hidden-lg hidden-md hidden-sm pull-left chevron-down">
                        <i class="material-icons red-text">keyboard_arrow_down</i>
                    </div>
                    <div class="row">
                        <div class="title red-text yekan-text container-fluid">جستجو در بین پرواز ها</div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <?php echo CHtml::dropDownList('flight-type', '', array('-1'=>'همه','charter'=>'چارتری', 'system'=>'سیستمی'), array('prompt'=>'نوع پرواز', 'data-template'=>'normal'));?>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <?php echo CHtml::dropDownList('airlines', '', array('-1'=>'همه'), array('prompt'=>'ایرلاین', 'data-template'=>'normal'));?>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>زمان حرکت</label>
                            <div id="time-range"></div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>قیمت</label>
                            <div id="price-range"></div>
                            <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/nouislider.js');?>
                            <?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/nouislider.css');?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="flights-list-views">
                <div class="overflow-fix title-row">
                    <?php if(Yii::app()->session['dirType'] == 'two-way'):?>
                        <h5 class="yekan-text red-text text-accent-2">لیست پرواز های رفت</h5>
                    <?php else:?>
                        <h5 class="yekan-text red-text text-accent-2">لیست پرواز ها</h5>
                    <?php endif;?>
                    <?php if($oneWayDataProvider->totalItemCount != 0):?>
                        <?php echo CHtml::button(Yii::app()->session['dirType'] == 'two-way'?'تغییر پرواز رفت':'تغییر پرواز', array(
                            'class'=>'btn waves-effect waves-light blue lighten-1 pull-left hidden',
                            'id'=>'show-all-one-way'
                        ));?>
                    <?php endif;?>
                </div>
                <?php echo CHtml::hiddenField('fake_search_id', $searchID, array('id'=>'fake-search-id'));?>
                <?php $this->widget('zii.widgets.CListView', array(
                    'id'=>'one-way-list',
                    'dataProvider'=>$oneWayDataProvider,
                    'itemView'=>'_domestic_flight_item',
                    'itemsCssClass'=>'items overflow-fix container-fluid',
                    'template'=>'{items}',
                    'viewData'=>array(
                        'searchID'=>(isset($searchID))?$searchID:null,
                        'dirType'=>'one-way',
                    ),
                    'ajaxUpdate'=>'flights-list-views',
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

                        var airlines = [];
                        $(".flight-item").each(function(i, item){
                            if($(this).data("airlinename") != "" && airlines.indexOf($(this).data("airline")) == -1){
                                $("#airlines").append("<option value=\'"+$(this).data("airline")+"\'>"+$(this).data("airlinename")+"</option>");
                                airlines[airlines.length]=$(this).data("airline");
                            }
                        });
                        $("#airlines").material_select();

                        var minPrice=null, maxPrice=null;
                        $(".flight-item").each(function(){
                            if(minPrice == null){
                                minPrice = parseInt($(this).data("price"))/1000;
                                maxPrice = parseInt($(this).data("price"))/1000;
                            }else{
                                if(parseInt($(this).data("price"))/1000 < minPrice)
                                    minPrice = parseInt($(this).data("price"))/1000;

                                if(parseInt($(this).data("price"))/1000 > maxPrice)
                                    maxPrice = parseInt($(this).data("price"))/1000;
                            }
                        });

                        $(".search-loading-container").addClass("hidden");
                        $(".flights-container").removeClass("hidden");
                        var slider = document.getElementById("price-range");

                        noUiSlider.create(slider, {
                            start: [parseInt(minPrice), parseInt(maxPrice)],
                            connect: true,
                            step: 1,
                            range: {
                                "min": parseInt(minPrice),
                                "max": parseInt(maxPrice)
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
                            $(".flight-item").each(function(){
                                price=$(this).data("price");
                                minPrice=values[0].replace(new RegExp(",", "g"), "");
                                maxPrice=values[1].replace(new RegExp(",", "g"), "");
                                minPrice=parseInt(minPrice)*1000;
                                maxPrice=(parseInt(maxPrice)+1)*1000;
                                if(price < minPrice)
                                    $(this).addClass("hidden-filter");
                                else if(price > maxPrice)
                                    $(this).addClass("hidden-filter");
                                else
                                    $(this).removeClass("hidden-filter");
                            });
                        });

                        var timeSlider = document.getElementById("time-range");

                        noUiSlider.create(timeSlider, {
                            start: [1, 24],
                            connect: true,
                            step: 1,
                            range: {
                                "min": 1,
                                "max": 24
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
                        timeSlider.noUiSlider.on("change", function(values, handle) {
                            $(".flight-item").each(function(){
                                time=$(this).data("depart");
                                from=values[0].replace(new RegExp(",", "g"), "");
                                to=values[1].replace(new RegExp(",", "g"), "");
                                if(time < from)
                                    $(this).addClass("hidden-filter");
                                else if(time > to)
                                    $(this).addClass("hidden-filter");
                                else
                                    $(this).removeClass("hidden-filter");
                            });
                        });
                    }'
                ));?>
                <?php if(Yii::app()->session['dirType'] == 'two-way'):?>
                    <div id="return-flights" class="hidden">
                        <div class="title-row overflow-fix">
                            <h5 class="yekan-text red-text text-accent-2">لیست پرواز های برگشت</h5>
                            <?php if($oneWayDataProvider->totalItemCount != 0):?>
                                <?php echo CHtml::button('تغییر پرواز برگشت', array(
                                    'class'=>'btn waves-effect waves-light blue lighten-1 pull-left hidden',
                                    'id'=>'show-all-return'
                                ));?>
                            <?php endif;?>
                        </div>
                        <?php $this->widget('zii.widgets.CListView', array(
                            'id'=>'return-list',
                            'dataProvider'=>$returnDataProvider,
                            'itemView'=>'_domestic_flight_item',
                            'itemsCssClass'=>'items overflow-fix container-fluid',
                            'template'=>'{items}',
                            'viewData'=>array(
                                'searchID'=>(isset($searchID))?$searchID:null,
                                'dirType'=>'return',
                            ),
                        ));?>
                    </div>
                <?php endif;?>
            </div>
            <div id="load-more-container">
                <?php if(!is_null($nextPage)):?>
                    <div id="load-more" data-key="<?php echo CHtml::encode($nextPage);?>">هتل های بیشتر...</div>
                <?php endif;?>
            </div>
        </div>
        <div class="container-fluid hidden" id="confirm-form-container">
            <?php echo CHtml::beginForm('', 'post', array('id'=>'confirm-form'));?>
                <span class="message red-text" style="line-height: 36px;"></span>
                <?php echo CHtml::hiddenField('travel_type', Yii::app()->session['dirType']);?>
                <?php echo CHtml::hiddenField('search_id', $searchID);?>
                <?php echo CHtml::hiddenField('one_way_id', '', array('id'=>'one-way-id'));?>
                <?php echo CHtml::hiddenField('return_id', '', array('id'=>'return-id'));?>
                <?php echo CHtml::submitButton('مرحله بعد', array('class'=>'btn green lighten-1 pull-left'));?>
            <?php echo CHtml::endForm();?>
        </div>
    </div>
</div>
<?php echo CHtml::hiddenField('dir-type', Yii::app()->session['dirType']);?>

<?php Yii::app()->clientScript->registerScript('general-variables', "var hotelAutoCompleteUrl='".Yii::app()->request->hostInfo.Yii::app()->request->baseUrl."/reservation/flights/autoComplete/%QUERY';", CClientScript::POS_HEAD);?>
<?php Yii::app()->clientScript->registerScript('select-flight', "
    var selectedReturnFlight = false;
    $('body').on('click', '#one-way-list .select-flight', function(){
        if($('input#dir-type').val() == 'two-way'){
            var traviaID = $(this).attr('id');
            $('#one-way-list .flight-item').each(function(index, item){
                if($(item).attr('data-traviaID') != traviaID)
                    $(item).addClass('hidden');
            });

            $('#one-way-id').val(traviaID);
            $('#show-all-one-way').removeClass('hidden');
            $('#return-flights').removeClass('hidden');
            $('html, body').animate({scrollTop: $('#flights-container').offset().top}, 'fast');
            if(selectedReturnFlight)
                $('#confirm-form-container').removeClass('hidden');
        }else{
            var traviaID = $(this).attr('id');
            $('#one-way-list .flight-item').each(function(index, item){
                if($(item).attr('data-traviaID') != traviaID)
                    $(item).addClass('hidden');
            });

            $('#show-all-one-way').removeClass('hidden');
            $('#one-way-id').val(traviaID);
            $('#confirm-form-container').removeClass('hidden');
            $('html, body').animate({scrollTop: $(document).height()}, 'slow');
        }
        $(this).addClass('hidden');
        $(this).parents('.flight-item').addClass('selected');
        $('#search_id').val($('#fake-search-id').val());
    });

    $('body').on('click', '#return-list .select-flight', function(){
        var traviaID = $(this).attr('id');
        $('#return-list .flight-item').each(function(index, item){
            if($(item).attr('data-traviaID') != traviaID)
                $(item).addClass('hidden');
        });

        selectedReturnFlight = true;
        $('#show-all-return').removeClass('hidden');
        $('#return-id').val(traviaID);
        $('#confirm-form-container').removeClass('hidden');
        $('html, body').animate({scrollTop: $(document).height()}, 'slow');
        $(this).addClass('hidden');
        $(this).parents('.flight-item').addClass('selected');
    });

    $('body').on('click', '#show-all-one-way', function(){
        $('#one-way-list .flight-item').each(function(index, item){
            $(item).removeClass('hidden').removeClass('selected');
            $(item).find('.select-flight').removeClass('hidden');
        });
        $('#return-flights').addClass('hidden');
        $(this).addClass('hidden');
        $('#confirm-form-container').addClass('hidden');
    });

    $('body').on('click', '#show-all-return', function(){
        $('#return-list .flight-item').each(function(index, item){
            $(item).removeClass('hidden').removeClass('selected');
            $(item).find('.select-flight').removeClass('hidden');
        });
        $(this).addClass('hidden');
        $('#confirm-form-container').addClass('hidden');
    });
");?>
<?php Yii::app()->clientScript->registerScript('submit-form', "
    $('#flight-search-btn').click(function(){
        if($('#dom-flight-departure').val()=='' && $('#flight-domestic-dropdown').val()==1){
            $('.message').text('مبدا خود را مشخص کنید.');
            $('#dom-flight-departure').focus();
            return false;
        }else if($('#non-dom-flight-departure').val()=='' && $('#flight-domestic-dropdown').val()!=1){
            $('.message').text('مبدا خود را مشخص کنید.');
            $('#non-dom-flight-departure').focus();
            return false;
        }else if($('#dom-flight-arrival').val()=='' && $('#flight-domestic-dropdown').val()==1){
            $('.message').text('مقصد خود را مشخص کنید.');
            $('#dom-flight-arrival').focus();
            return false;
        }else if($('#non-dom-flight-arrival').val()=='' && $('#flight-domestic-dropdown').val()!=1){
            $('.message').text('مقصد خود را مشخص کنید.');
            $('#non-dom-flight-arrival').focus();
            return false;
        }else if($('#departure-date_altField').val()==''){
            $('.message').text('تاریخ رفت را مشخص کنید.');
            return false;
        }else if($('#return-date_altField').val()=='' && $('#flight-dir-type-dropdown').val()=='two-way'){
            $('.message').text('تاریخ برگشت را مشخص کنید.');
            return false;
        }else if($('#departure-date_altField').val()==$('#return-date_altField').val()){
            $('.message').text('تاریخ رفت و برگشت نمی تواند یکسان باشد.');
            return false;
        }
    });

    $('#flight-domestic-dropdown').on('change', function(){
        if($(this).val()=='0'){
            $('#non-domestic-flights').removeClass('hidden');
            $('#domestic-flights').addClass('hidden');
        }else{
            $('#non-domestic-flights').addClass('hidden');
            $('#domestic-flights').removeClass('hidden');
        }
    });

    $('#flight-dir-type-dropdown').on('change', function(){
        if($(this).val()=='one-way'){
            $('#returnDateDatePicker').addClass('picker--hidden');
            $('#return-date').parent().addClass('disable');
            $('#return-date').prop('disabled', true);
        }else{
            $('#returnDateDatePicker').removeClass('picker--hidden');
            if($('#departure-date_altField').val() != undefined && $('#departure-date_altField').val() != '')
                $('#returnDateDatePicker').addClass('picker--opened');
            $('#return-date').parent().removeClass('disable');
            $('#return-date').prop('disabled', false);
        }
    });

    $('#confirm-form input[type=\"submit\"]').on('click', function(){
        if($('#one-way-id').val()==''){
            $('#confirm-form .message').text('لطفا پرواز رفت را انتخاب کنید.');
            return false;
        }else if($('#return-id').val()=='' && $('#travel_type').val() == 'two-way'){
            $('#confirm-form .message').text('لطفا پرواز برگشت را انتخاب کنید.');
            return false;
        }else
            $('#confirm-form .message').text('');
    });
");?>
<?php Yii::app()->clientScript->registerScript('search-flights',"
    $.fn.yiiListView.update('one-way-list', {error:function(){window.location.href='".Yii::app()->createUrl('/error?code=212')."';return false;}});
", CClientScript::POS_LOAD);?>
<?php Yii::app()->clientScript->registerScript('load-more-flights',"
    $('body').on('click', '#load-more', function(){
        if(!$(this).hasClass('doing')){
            $(this).text('در حال بارگذاری...').addClass('doing');
            $.ajax({
                url: '".$this->createUrl('/reservation/flights/loadMore')."',
                type: 'POST',
                dataType: 'JSON',
                data: {key: $(this).data('key')},
                success:function(data){
                    $('#one-way-list .items').append($(data.flights).find('.items').html());
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
<?php Yii::app()->clientScript->registerScript('filter-flights',"
    $('select#flight-type').on('change', function(){
        type=$(this).val();
        $('.flight-item').each(function(){
            if(type==-1)
                $(this).removeClass('hidden-filter');
            else{
                if(type=='charter'){
                    if($(this).data('type')!='charter' && !$(this).hasClass('selected'))
                        $(this).addClass('hidden-filter');
                    else
                        $(this).removeClass('hidden-filter');
                }else{
                    if($(this).data('type')=='charter' && !$(this).hasClass('selected'))
                        $(this).addClass('hidden-filter');
                    else
                        $(this).removeClass('hidden-filter');
                }
            }
        });
    });

    $('select#airlines').on('change', function(){
        airline=$(this).val();
        $('.flight-item').each(function(){
            if(airline==-1)
                $(this).removeClass('hidden-filter');
            else{
                if($(this).data('airline')!=airline && !$(this).hasClass('selected'))
                    $(this).addClass('hidden-filter');
                else
                    $(this).removeClass('hidden-filter');
            }
        });
    });
", CClientScript::POS_LOAD);?>
<?php Yii::app()->clientScript->registerScript('general-variables', "
    var flightAutoCompleteUrl= '".Yii::app()->request->hostInfo.Yii::app()->request->baseUrl."/reservation/flights/autoComplete/%QUERY';
    var domesticAirportsUrl = '".Yii::app()->request->hostInfo.Yii::app()->request->baseUrl."/reservation/flights/domesticAirports?v=7';
", CClientScript::POS_HEAD);?>
<?php Yii::app()->clientScript->registerScript('hidden-picker',"$('#returnDateDatePicker').addClass('picker--hidden');", CClientScript::POS_LOAD);?>