<?php
/* @var $data array */
/* @var $duration integer */
/* @var $country string */
/* @var $searchID string */
/* @var $city string */

if(is_null(Yii::app()->session['minPrice'])) {
    Yii::app()->session['minPrice'] = intval($data['price']/1000);
    Yii::app()->session['maxPrice'] = intval($data['price']/1000);
}else {
    if (intval($data['price']/1000) < Yii::app()->session['minPrice'])
        Yii::app()->session['minPrice'] = intval($data['price']/1000);

    if (intval($data['price']/1000) > Yii::app()->session['maxPrice'])
        Yii::app()->session['maxPrice'] = intval($data['price']/1000);
}
?>

<div class="hotel-item col-lg-3 col-md-3 col-sm-4 col-xs-12" data-stars="<?= CHtml::encode($data['star']) ?>" data-name="<?= CHtml::encode(strtolower($data['name'])) ?>" data-price="<?= CHtml::encode($data['price']) ?>">
    <div class="hotel-item-body card-panel">
        <div class="img-container">
            <a href="<?php echo Yii::app()->createUrl('reservation/hotels/view/'.urlencode($country)/*.'/'.urlencode($city)*/.'/'.urlencode($data['name']).'/'.urlencode($data['traviaID']).'/'.urlencode($searchID));?>" target="_blank"></a>
            <img src="<?php echo CHtml::encode($data['image']['src']);?>" alt="<?php echo CHtml::encode($data['image']['tag']);?>">
        </div>
        <h6 class="name"><a href="<?php echo Yii::app()->createUrl('reservation/hotels/view/'.urlencode($country)/*.'/'.urlencode($city)*/.'/'.urlencode($data['name']).'/'.urlencode($data['traviaID']).'/'.urlencode($searchID));?>" target="_blank"><?php echo CHtml::encode($data['name']);?></a></h6>
        <div class="stars overflow-fix">
            <?php for($i=1;$i<=5;$i++):?>
                <?php if($i<=$data['star']):?>
                    <div class="star"></div>
                <?php else:?>
                    <div class="star off"></div>
                <?php endif;?>
            <?php endfor;?>
        </div>
        <small>قیمت برای <span><?php echo $duration;?></span> شب از</small>
        <h6 class="red-text text-accent-2"><?php echo number_format($data['price'], 0).' تومان';?></h6>
        <a href="#rooms-modal-<?= CHtml::encode(str_replace(' ','-',strtolower($data['name']))); ?>" data-toggle="modal" class="pull-left">انتخاب اتاق</a>
        <a href="<?php echo Yii::app()->createUrl('reservation/hotels/view/'.urlencode($country)/*.'/'.urlencode($city)*/.'/'.urlencode($data['name']).'/'.urlencode($data['traviaID']).'/'.urlencode($searchID));?>" target="_blank" class="pull-right">جزئیات هتل</a>
    </div>
    <div id="rooms-modal-<?= CHtml::encode(str_replace(' ','-',strtolower($data['name']))); ?>" class="modal">
        <div class="modal-content">
            <h5 class="yekan-text">اتاق ها</h5>
            <?php $this->renderPartial('_rooms_list', array('rooms'=>$data['rooms'], 'searchID'=>$searchID));?>
        </div>
        <div class="modal-footer">
            <a href="#" data-dismiss="modal" class="waves-effect waves-red btn-flat">انصراف</a>
        </div>
    </div>
</div>
