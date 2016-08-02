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
        <?php $this->renderPartial('_rooms_list', array('rooms'=>$rooms));?>
    </div>
    <div class="feature-item">
        <div class="title">
            <h5 class="yekan-text">امکانات</h5>
            <div class="divider"></div>
        </div>
        <small>- امکانات ذکر شده، توسط هتل معرفی گردیده و سایت بوکر 24 هیچ مسئولیتی در قبال این امکانات ندارد.</small>
        <ul class="facilities first">
            <?php for($i=0;$i<6;$i++):?>
                <?php if(!isset($hotel['facilities'][$i]))break;?>
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
            <a class="center-block more" id="facilities-more" href="#facilities" data-toggle="collapse">همه ی امکانات</a>
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
                    <div class="image-item" data-toggle="modal" data-index="<?= $key ?>" data-target="#carousesl-modal">
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