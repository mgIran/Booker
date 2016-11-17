<?php
/* @var $this HotelsController */
/* @var $rooms array */
/* @var $searchID string */
?>
<div class="rooms overflow-fix">
    <?php foreach($rooms as $key=>$room):?>
        <?php if($key>1)break;?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 room-item">
            <div class="thumbnail">
                <div class="caption overflow-fix">
                    <?php foreach($room['rooms'] as $roomIndex=>$roomInfo):?>
                        <div class="ltr text-left">
                            <b><?php echo CHtml::encode(($roomIndex+1).'- '.$roomInfo['type'].' '.$roomInfo['category']);?></b>
                            <small><?php echo CHtml::encode($room['meal']);?></small>
                            <?php if(isset($roomInfo['description'])):?>
                                <button class="description" data-toggle="popover" data-trigger="focus" data-placement="bottom" title="توضیحات" data-content="<?php echo CHtml::encode($roomInfo['description']);?>"></button>
                            <?php endif;?>
                            <div class="capacity pull-right">
                                <span><i class="adult"></i> × <?php echo CHtml::encode($roomInfo['adult']);?></span>
                                <span><i class="child"></i> × <?php echo (is_null($roomInfo['child']))?0:count(explode(',', $roomInfo['child']));?></span>
                            </div>
                        </div>
                    <?php endforeach;?>
                    <div class="features row">
                        <?php if(isset($room['cancel_support']) and !is_null($room['cancel_support'])):?>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><p><?php echo $room['cancel_support']?'- امکان کنسل کردن وجود دارد':'- امکان کنسل کردن وجود ندارد';?></p></div>
                        <?php endif;?>
                        <?php if(isset($room['view']) and !is_null($room['view'])):?>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><p><?php echo $room['view']?'- ویو و نمای خاص دارد':'- ویو و نمای خاص ندارد';?></p></div>
                        <?php endif;?>
                        <?php if(isset($room['nonrefundable']) and !is_null($room['nonrefundable'])):?>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><p><?php echo $room['nonrefundable']?'- غیر قابل استرداد':'- قابل استرداد';?></p></div>
                        <?php endif;?>
                        <?php if(isset($room['offer']) and !is_null($room['offer'])):?>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><p><?php echo $room['offer']?'- تخفیف دارد':'- تخفیف ندارد';?></p></div>
                        <?php endif;?>
                    </div>
                    <div class="price pull-right red-text">
                        <b>قیمت برای <?php echo floor(((Yii::app()->session['outDate']-Yii::app()->session['inDate'])/(3600*24)));?> شب: </b><?php echo number_format(($this->getFixedPrice($room['price'])/10), 0).' تومان';?>
                    </div>
                    <div class="clear pull-left">
<!--                        --><?php //if(isset($room['cancel_support']) and !is_null($room['cancel_support'])):?>
<!--                            <a href="#cancel-rules-modal" data-url="--><?php //echo $this->createUrl('/reservation/hotels/getCancelRule',array('tid'=>$room['traviaId'], 'price'=>($this->getFixedPrice($room['price'])/10), 'search_id'=>$searchID));?><!--" class="cancel-rule modal-trigger">شرایط کنسلی</a>-->
<!--                        --><?php //endif;?>
                        <a href="<?php echo $this->createUrl('/reservation/hotels/checkout',array('tid'=>$room['traviaId'], 'sid'=>$searchID));?>" class="btn btn-primary light-blue darken-3 waves-effect" role="button">رزرو</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach;?>
</div>
<?php if(count($rooms)>2):?>
    <div id="modal-rooms-more-<?= $traviaID ?>" class="rooms overflow-fix collapse">
        <?php foreach($rooms as $key=>$room):?>
            <?php if($key<1)continue;?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 room-item">
                <div class="thumbnail">
                    <div class="caption overflow-fix">
                        <?php foreach($room['rooms'] as $roomIndex=>$roomInfo):?>
                            <div class="ltr text-left">
                                <b><?php echo CHtml::encode(($roomIndex+1).'- '.$roomInfo['type'].' '.$roomInfo['category']);?></b>
                                <small><?php echo CHtml::encode($room['meal']);?></small>
                                <?php if(isset($roomInfo['description'])):?>
                                    <button class="description" data-toggle="popover" data-trigger="focus" data-placement="bottom" title="توضیحات" data-content="<?php echo CHtml::encode($roomInfo['description']);?>"></button>
                                <?php endif;?>
                                <div class="capacity pull-right">
                                    <span><i class="adult"></i> × <?php echo CHtml::encode($roomInfo['adult']);?></span>
                                    <span><i class="child"></i> × <?php echo (is_null($roomInfo['child']))?0:count(explode(',', $roomInfo['child']));?></span>
                                </div>
                            </div>
                        <?php endforeach;?>
                        <div class="features row">
                            <?php if(isset($room['cancel_support']) and !is_null($room['cancel_support'])):?>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><p><?php echo $room['cancel_support']?'- امکان کنسل کردن وجود دارد':'- امکان کنسل کردن وجود ندارد';?></p></div>
                            <?php endif;?>
                            <?php if(isset($room['view']) and !is_null($room['view'])):?>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><p><?php echo $room['view']?'- ویو و نمای خاص دارد':'- ویو و نمای خاص ندارد';?></p></div>
                            <?php endif;?>
                            <?php if(isset($room['nonrefundable']) and !is_null($room['nonrefundable'])):?>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><p><?php echo $room['nonrefundable']?'- غیر قابل استرداد':'- قابل استرداد';?></p></div>
                            <?php endif;?>
                            <?php if(isset($room['offer']) and !is_null($room['offer'])):?>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><p><?php echo $room['offer']?'- تخفیف دارد':'- تخفیف ندارد';?></p></div>
                            <?php endif;?>
                        </div>
                        <div class="price pull-right red-text">
                            <b>قیمت برای <?php echo floor(((Yii::app()->session['outDate']-Yii::app()->session['inDate'])/(3600*24)));?> شب: </b><?php echo number_format(($this->getFixedPrice($room['price'])/10), 0).' تومان';?>
                        </div>
                        <div class="clear pull-left">
<!--                            --><?php //if(isset($room['cancel_support']) and !is_null($room['cancel_support'])):?>
<!--                                <a href="#cancel-rules-modal" data-url="--><?php //echo $this->createUrl('/reservation/hotels/getCancelRule',array('tid'=>$room['traviaId'], 'price'=>($this->getFixedPrice($room['price'])/10), 'search_id'=>$searchID));?><!--" class="cancel-rule modal-trigger">شرایط کنسلی</a>-->
<!--                            --><?php //endif;?>
                            <a href="<?php echo $this->createUrl('/reservation/hotels/checkout',array('tid'=>$room['traviaId'], 'sid'=>$searchID));?>" class="btn btn-primary light-blue darken-3 waves-effect" role="button">رزرو</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
    <a class="center-block more" id="rooms-more" href="#" data-target="#modal-rooms-more-<?= $traviaID ?>" data-toggle="collapse">همه ی اتاق ها</a>
<?php endif;?>