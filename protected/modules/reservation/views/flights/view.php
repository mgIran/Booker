<?php
/* @var $this HotelsController */
/* @var $id string */
/* @var $searchID string */
?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/bootstrap-nav-wizard.css');?>
<div class="container">
    <div class="content page-box hotel-details">
        <div class="steps">
            <ul class="nav nav-wizard">
                <li class="done col-lg-2"><a>جستجوی هتل</a></li>
                <li class="done col-lg-2"><a>انتخاب هتل</a></li>
                <li class="active col-lg-2"><a>انتخاب اتاق</a></li>
                <li class="col-lg-2"><a>ورود اطلاعات</a></li>
                <li class="col-lg-2"><a>پرداخت</a></li>
                <li class="col-lg-2"><a>دریافت واچر</a></li>
            </ul>
        </div>
        <div id="hotel-view">
            <div class="search-loading-container card-panel">
                <p class="text-center">در حال بارگذاری اطلاعات هتل...</p>
                <div class="overflow-fix">
                    <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12 col-lg-offset-2 col-md-offset-2 col-sm-offset-3 col-xs-offset-0">
                        <div class="progress">
                            <div class="indeterminate"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="cancel-rules-modal" class="modal">
    <div class="modal-content">
        <h5>شرایط کنسلی</h5>
        <p></p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">بستن</a>
    </div>
</div>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/owl.carousel.min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/owl.carousel.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/owl.theme.default.min.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery.magnific-popup.min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/magnific-popup.css');
Yii::app()->clientScript->registerScriptFile('http://maps.googleapis.com/maps/api/js?key=AIzaSyBRyQvsBFWct4YvtN547f3ljpovifqgGYQ');
Yii::app()->clientScript->registerScript('inline-scripts-ready',"
    $(document).on('click', '.feature-item a.more#facilities-more', function(){
        if($(this).attr('aria-expanded')=='false')
            $(this).text('همه ی امکانات');
        else
            $(this).text('بستن');
    });

    $(document).on('click', '.feature-item a.more#rooms-more', function(){
        if($(this).attr('aria-expanded')=='false')
            $(this).text('همه ی اتاق ها');
        else
            $(this).text('بستن');
    });

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
            }
        });
    });
");
Yii::app()->clientScript->registerScript('inline-scripts-load',"
    $.ajax({
        url: '".$this->createUrl('/reservation/hotels/getHotelInfo', array('hotel_id'=>$id,'search_id'=>$searchID))."',
        type: 'POST',
        success: function(data){
            if(data=='در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید!')
                window.location.href='".Yii::app()->createUrl('/error?code=212')."';
            $('#hotel-view').replaceWith(data);

            $('[data-toggle=\"popover\"]').popover();

            if($('.images-carousel .image-item').length > 1){
                $('.images-carousel').owlCarousel({
                    margin:8,
                    rtl:true,
                    items:3,
                    dots:false,
                    nav:true,
                    navText:['<span class=\"arrow\"></span>','<span class=\"arrow\"></span>'],
                    responsive: {
                        0 : {
                            items:1,
                            margin :0
                        },
                        500 :{
                            items:2,
                            margin :8
                        },
                        768 :{
                            items:2,
                            margin :8
                        },
                        1025 :{
                            items:3,
                            margin :8
                        }
                    }
                });
            }

            $('.images-carousel').magnificPopup({
                delegate: 'a',
                type: 'image',
                tLoading: 'Loading image #%curr%...',
                mainClass: 'mfp-img-mobile',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0,1] // Will preload 0 - before current, and 1 after the current image
                },
                image: {
                    tError: '<a href=\" % url % \">The image #%curr%</a> could not be loaded.',
                    titleSrc: function(item) {
                        return '';
                    }
                }
            });

            var map;
            var marker;
            var myCenter=new google.maps.LatLng($('#map-point').data('lat'), $('#map-point').data('lng'));
            function initialize()
            {
                var mapProp = {
                    center:myCenter,
                    zoom:17,
                    scrollwheel: false
                };
                map = new google.maps.Map(document.getElementById('map-point'),mapProp);
                placeMarker(myCenter ,map);
            }

            function placeMarker(location ,map) {

                if(marker != undefined)
                    marker.setMap(null);
                marker = new google.maps.Marker({
                    position: location,
                    map: map,
                });
            }
            initialize();
            $('.modal-trigger').leanModal();
        },
        error: function(){
            window.location.href='".Yii::app()->createUrl('/error?code=212')."';
        }
    });
", CClientScript::POS_END);?>
