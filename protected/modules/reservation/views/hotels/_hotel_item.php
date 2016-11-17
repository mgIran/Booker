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
            <img src="<?php echo CHtml::encode($data['image']['src']);?>" alt="<?php echo CHtml::encode($data['image']['tag']);?>">
        </div>
        <h6 class="name"><a href="#"><?php echo CHtml::encode($data['name']);?></a></h6>
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
        <button type="button" data-toggle="modal" data-target="#modal-rooms-<?= urlencode($data['traviaID']) ?>" href="#" class="pull-left">انتخاب اتاق</button>
    </div>
</div>
<div class="modal fade" id="modal-rooms-<?= urlencode($data['traviaID']) ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>اطلاعات اتاق ها</h5>
                <button data-dismiss="modal" type="button" class="close">&times;</button>
            </div>
            <div class="modal-body">
                <?php $this->renderPartial('_rooms_list', array('rooms'=>$data['rooms'], 'searchID'=>$data['searchID'], 'traviaID'=>$data['traviaID']));?>
            </div>
        </div>
    </div>
</div>