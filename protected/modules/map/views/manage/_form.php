<?php
/* @var $model GoogleMaps */
$mapLat = $model->map_lat!=''?$model->map_lat:34.6327505;
$mapLng = $model->map_lng!=''?$model->map_lng:50.8644157;
$mapZoom = $model->map_zoom!=''?$model->map_zoom:12;
$mapScript = "var map;
	var marker;
	var myCenter=new google.maps.LatLng(".$mapLat.",".$mapLng.");
	function initialize()
	{
		var mapProp = {
		center:myCenter,
		zoom:".$mapZoom.",
		mapTypeId: google.maps.MapTypeId.TERRAIN
		};
		map = new google.maps.Map(document.getElementById('googleMap'),mapProp);
		".($model->map_lat!=''&&$model->map_lng!=''?'placeMarker(myCenter,'.$mapZoom.');':'')."
		google.maps.event.addListener(map, 'click', function(event) {
			placeMarker(event.latLng,map.getZoom());
		});
	}

	function placeMarker(location,z) {
		if(marker != undefined)
			marker.setMap(null);
	  marker = new google.maps.Marker({
		position: location,
		map: map,
	  });
	  var content ='".$model->getAttributeLabel('map_lat')." : ' + location.lat() + '<br>".$model->getAttributeLabel('map_lng')." : ' + location.lng();
	  var infowindow = new google.maps.InfoWindow({
		content: content
	  });
	  infowindow.open(map,marker);
	  document.getElementById('map_lat').value = location.lat();
	  document.getElementById('map_lng').value = location.lng();
	  document.getElementById('map_zoom').value = z;
	}
	google.maps.event.addDomListener(window, 'load', initialize);
	";
// google map
Yii::app()->clientScript->registerScriptFile('http://maps.googleapis.com/maps/api/js');
Yii::app()->clientScript->registerScript('googleMap', $mapScript);
?>

<? $this->renderPartial('//layouts/_flashMessage'); ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'google-maps-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
));

echo $form->hiddenField($model , 'map_lat' ,array('id' => 'map_lat'));
echo $form->hiddenField($model , 'map_lng' ,array('id' => 'map_lng'));
echo $form->hiddenField($model , 'map_zoom' ,array('id' => 'map_zoom'));
?>
	<div class="row">
		<div class="map span12 pull-right">
			<div id="googleMap"></div>
		</div>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره' ,array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<?
Yii::app()->clientScript->registerCss('map','
.map{
	border-radius: 5px;
    display: block;
    height: 500px;
    overflow: hidden;
    position: relative;
}
.map #googleMap{
	 display: inline-block;
    height: 100%;
    width: 100%;
}
');