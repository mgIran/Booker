<?php
/* @var $hotel array */
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
        <h2 class="yekan-text" style="margin-top: 100px;">
            <?php echo CHtml::encode($hotel['name'])?>
            <span class="stars overflow-fix">
                <?php for($i=1;$i<=5;$i++):?>
                    <?php if($i<=$hotel['star']):?>
                        <div class="star"></div>
                    <?php else:?>
                        <div class="star off"></div>
                    <?php endif;?>
                <?php endfor;?>
            </span>
        </h2>
        <div class="container-fluid">
            <div class="feature-item">
                <div class="title">
                    <h5 class="yekan-text">امکانات</h5>
                    <div class="divider"></div>
                </div>
                <ul class="facilities">
                    <?php foreach($hotel['facilities'] as $facility):?>
                        <li><?php echo CHtml::encode($facility);?></li>
                    <?php endforeach;?>
                </ul>
            </div>
            <?php if(isset($hotel['images']) and !empty($hotel['images'])):?>
                <div class="feature-item">
                    <div class="title">
                        <h5 class="yekan-text">تصاویر</h5>
                        <div class="divider"></div>
                    </div>
                    <div class="images-carousel thumbnail">
                        <?php $imager=new Imager();
                        foreach($hotel['images'] as $key => $image):
                            $imageInfo=$imager->getImageInfo($image['original']);
                            $ratio=$imageInfo['width']/$imageInfo['height'];?>
                            <div class="image-item" style="width: <?php echo ceil(300*$ratio);?>px;" data-toggle="modal" data-index="<?= $key ?>" data-target="#carousesl-modal">
                                <a href="<?php echo CHtml::encode($image['original']);?>"><img src="<?php echo CHtml::encode($image['original']);?>"></a>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>
            <?php endif;?>
            <div class="feature-item">
                <div class="title">
                    <h5 class="yekan-text">آدرس</h5>
                    <div class="divider"></div>
                </div>
                <div id="map-point"></div>
                <span>شهر: <?php echo CHtml::encode($hotel['city']);?></span>
            </div>
            <div class="feature-item card-panel">
                <h5>درباره هتل</h5>
                <div class="text-left ltr"><?php echo CHtml::encode($hotel['description'])?></div>
            </div>
        </div>
    </div>
</div>
<?php
if(count($hotel['images']) > 1) {
    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/owl.carousel.min.js');
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/owl.carousel.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/owl.theme.default.min.css');
    Yii::app()->clientScript->registerScript('images-carousel', "
        $('.images-carousel').owlCarousel({
            autoWidth:true,
            margin:10,
            rtl:true,
            dots:true,
            items:1,
            loop:true
        });
    ");
}

Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery.magnific-popup.min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/magnific-popup.css');
Yii::app()->clientScript->registerScript('callImageGallery',"
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
			tError: '<a href=\"%url%\">The image #%curr%</a> could not be loaded.',
			titleSrc: function(item) {
				return '';
			}
		}
	});
");

Yii::app()->clientScript->registerScriptFile('http://maps.googleapis.com/maps/api/js?key=AIzaSyBRyQvsBFWct4YvtN547f3ljpovifqgGYQ');
Yii::app()->clientScript->registerScript('google-map', "
        var map;
        var marker;
        var myCenter=new google.maps.LatLng(" . $hotel['latitude'] . "," . $hotel['langitude'] . ");
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
        google.maps.event.addDomListener(window, 'load', initialize);
    ");
?>

