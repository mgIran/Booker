<?php
/* @var $this SiteController */
/* @var $error array */
/* @var $mapLat string */
/* @var $mapLng string */
/* @var $mapZoom string */

$this->pageTitle= Yii::app()->name . ' - '.$model->title;
$this->breadcrumbs=array(
    $model->title=>array(''),
);
?>

<div class="container">
    <div class="content page-box">
        <h2 class="yekan-text"><?= $model->title; ?></h2>
        <div class="container-fluid">
            <?= $model->summary; ?>
        </div>
    </div>
</div>

<?php
if($this->pageName=='contact') {
    Yii::app()->clientScript->registerScriptFile('http://maps.googleapis.com/maps/api/js');
    Yii::app()->clientScript->registerScript('google-map', "
        var map;
        var marker;
        var myCenter=new google.maps.LatLng(" . $mapLat . "," . $mapLng . ");
        function initialize()
        {
            var mapProp = {
                center:myCenter,
                zoom:" . $mapZoom . ",
                scrollwheel: false
            };
            map = new google.maps.Map(document.getElementById('contact'),mapProp);
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
}?>