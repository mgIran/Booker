<?php
/* @var $this HotelsController */
/* @var $hotelsDataProvider CArrayDataProvider */
/* @var $country string */
/* @var $searchID string */
/* @var $nextPage string */
?>
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
));?>
