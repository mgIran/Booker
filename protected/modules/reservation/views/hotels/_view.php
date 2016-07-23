<?php
/* @var $this HotelsController */
/* @var $hotel array */
/* @var $rooms array */
?>
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
            <h5 class="yekan-text">اتاق ها</h5>
            <div class="divider"></div>
        </div>
        <div class="rooms overflow-fix">
            <?php foreach($rooms as $room):?>
                <?php foreach($room['rooms'] as $roomInfo):?>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 room-item">
                        <div class="thumbnail">
                            <div class="caption overflow-fix">
                                <div class="ltr text-left">
                                    <b><?php echo CHtml::encode($roomInfo['type'].' '.$roomInfo['category']);?></b>
                                    <small><?php echo CHtml::encode($room['meal']);?></small>
                                    <?php if(isset($roomInfo['description'])):?>
                                        <button class="description" data-toggle="popover" data-trigger="focus" title="توضیحات" data-content="<?php echo CHtml::encode($roomInfo['description']);?>"></button>
                                    <?php endif;?>
                                    <div class="capacity pull-right">
                                        <span><i class="adult"></i> × <?php echo CHtml::encode($roomInfo['adult']);?></span>
                                        <span><i class="child"></i> × <?php echo (is_null($roomInfo['child']))?0:CHtml::encode($roomInfo['child']);?></span>
                                    </div>
                                </div>
                                <div class="features">
                                    <?php if(isset($room['nonrefundable']) and !is_null($room['nonrefundable'])):?>
                                        <p><?php echo $room['nonrefundable']?'- غیر قابل استرداد':'- قابل استرداد';?></p>
                                    <?php endif;?>
                                    <?php if(isset($room['cancel_support']) and !is_null($room['cancel_support'])):?>
                                        <p><?php echo $room['cancel_support']?'- امکان کنسل کردن وجود دارد':'- امکان کنسل کردن وجود ندارد';?></p>
                                    <?php endif;?>
                                    <?php if(isset($room['offer']) and !is_null($room['offer'])):?>
                                        <p><?php echo $room['offer']?'- تخفیف دارد':'- تخفیف ندارد';?></p>
                                    <?php endif;?>
                                    <?php if(isset($room['view']) and !is_null($room['view'])):?>
                                        <p><?php echo $room['view']?'- ویو و نمای خاص دارد':'- ویو و نمای خاص ندارد';?></p>
                                    <?php endif;?>
                                </div>
                                <div class="price pull-right red-text">
                                    <b>قیمت برای <?php echo floor(((Yii::app()->session['outDate']-Yii::app()->session['inDate'])/(3600*24)));?> شب: </b><?php echo number_format($room['price']*5000, 0).' تومان';?>
                                </div>
                                <div class="clear pull-left"><a href="#" class="btn btn-primary" role="button">رزرو</a></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            <?php endforeach;?>
        </div>
    </div>
    <div class="feature-item">
        <div class="title">
            <h5 class="yekan-text">امکانات</h5>
            <div class="divider"></div>
        </div>
        <small>- امکانات ذکر شده، توسط هتل معرفی گردیده و سایت بوکر 24 هیچ مسئولیتی در قبال این امکانات ندارد.</small>
        <ul class="facilities first">
            <?php for($i=0;$i<6;$i++):?>
                <li><?php echo CHtml::encode($hotel['facilities'][$i]);?></li>
            <?php endfor;?>
        </ul>
        <ul id="facilities" class="facilities second<?php echo (count($hotel['facilities']) > 6)?' collapse':'';?>">
            <?php foreach($hotel['facilities'] as $key => $facility):?>
                <?php if($key>5):?>
                    <li><?php echo CHtml::encode($facility);?></li>
                <?php endif;?>
            <?php endforeach;?>
        </ul>
        <?php if(count($hotel['facilities']) > 6):?>
            <a class="center-block more" href="#facilities" data-toggle="collapse">همه ی امکانات</a>
        <?php endif;?>
    </div>
    <?php if(isset($hotel['images']) and !empty($hotel['images'])):?>
        <div class="feature-item">
            <div class="title">
                <h5 class="yekan-text">تصاویر</h5>
                <div class="divider"></div>
            </div>
            <div class="images-carousel thumbnail">
                <?php foreach($hotel['images'] as $key => $image): ?>
                    <div class="image-item" style="width: 300px;" data-toggle="modal" data-index="<?= $key ?>" data-target="#carousesl-modal">
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
        <div id="map-point" data-lat="<?= CHtml::encode($hotel['latitude']) ?>" data-lng="<?= CHtml::encode($hotel['langitude']) ?>"></div>
        <span>منطقه: <?php echo CHtml::encode($hotel['city']);?></span>
    </div>
    <div class="feature-item card-panel">
        <h5>درباره هتل</h5>
        <div class="text-left ltr text-justify"><?php echo CHtml::encode($hotel['description'])?></div>
    </div>
</div>