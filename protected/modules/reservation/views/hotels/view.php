<?php
/* @var $this HotelsController */
/* @var $id string */
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
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/owl.carousel.min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/owl.carousel.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/owl.theme.default.min.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery.magnific-popup.min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/magnific-popup.css');
Yii::app()->clientScript->registerScriptFile('http://maps.googleapis.com/maps/api/js?key=AIzaSyBRyQvsBFWct4YvtN547f3ljpovifqgGYQ');
Yii::app()->clientScript->registerScript('inline-scripts-ready',"
    $(document).on('click', '.feature-item a.more', function(){
        if($(this).attr('aria-expanded')=='false')
            $(this).text('همه ی امکانات');
        else
            $(this).text('بستن');
    });
");
Yii::app()->clientScript->registerScript('inline-scripts-load',"
    $.ajax({
        url: '".$this->createUrl('/reservation/hotels/getHotelInfo', array('hotel_id'=>$id))."',
        type: 'POST',
        success: function(data){
            $('#hotel-view').replaceWith(data);

            $('[data-toggle=\"popover\"]').popover();

            if($('.images-carousel .image-item').length > 1){
                $('.images-carousel').owlCarousel({
                    autoWidth:true,
                    margin:10,
                    rtl:true,
                    dots:true,
                    items:1,
                    loop:true,
                    lazyLoad:true
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
        },
        error: function(){
            $('#hotel-view').html('در انجام عملیات خطایی رخ داده است. لطفا مجددا تلاش کنید!');
        }
    });
", CClientScript::POS_END);?>
