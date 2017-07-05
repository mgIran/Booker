<?php
/* @var $this FlightsController */
/* @var $data array */
/* @var $searchID string */
/* @var $dirType string */
?>

<div class="overflow-fix card-panel flight-item" data-traviaID="<?php echo $data['traviaId'];?>" data-price="<?php echo $this->getFixedPrice($data['totalPrice']/10, true, $data['type'])['price'];?>" data-depart="<?php echo date('G', strtotime($data['legs'][0]['departureTime']));?>" data-type="<?php echo $data['type'];?>" data-airline="<?php echo $data['legs'][0]['carrier'];?>" data-airlinename="<?php echo $data['legs'][0]['carrierName'];?>">
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 right-col">
        <small class="gray-text">شماره پرواز: <?php echo $data['legs'][0]['flightNo'];?></small>
        <?php if($data['legs'][0]['carrierName']):?>
            <small class="gray-text pull-left text-center"><img src="<?php echo Yii::app()->baseUrl.'/uploads/airlines-logo/dom/'.$data['legs'][0]['carrier'].'.png';?>"><div><?php echo $data['legs'][0]['carrierName'];?></div></small>
        <?php endif;?>
        <div class="route">
            <span><?php echo Airports::getFieldByIATA($data['legs'][0]['origin'], 'city_fa');?><small><?php echo date('H:i', strtotime($data['legs'][0]['departureTime']));?></small></span>
            <i class="material-icons">keyboard_backspace</i>
            <span><?php echo Airports::getFieldByIATA($data['legs'][0]['destination'], 'city_fa');?><small><?php echo date('H:i', strtotime($data['legs'][0]['arrivalTime']));?></small></span>
        </div>
        <span class="label label-primary"><?php echo $data['type']=='charter'?'چارتری':'سیستمی';?></span>
        <span class="label label-default"><?php echo $data['legs'][0]['availableSeat'];?> صندلی باقیمانده</span>
        <?php if($data['legs'][0]['airCraft']):?>
        <span class="label label-success">نوع هواپیما: <?php echo $data['legs'][0]['airCraft'];?></span>
        <?php endif;?>
        <?php if($data['legs'][0]['flightTime']):?>
            <small class="gray-text pull-left" style="line-height: 27px;">مدت پرواز: <?php echo $data['legs'][0]['flightTime'];?> دقیقه</small>
        <?php endif;?>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-center left-col">
        قیمت
        <span class="red-text price"><?php echo number_format($this->getFixedPrice($data['totalPrice']/10, true, $data['type'])['price']);?> تومان</span>
        <?php echo CHtml::button('انتخاب پرواز', array(
            'class'=>'btn waves-effect waves-light red lighten-1 select-flight',
            'data-dirtype'=>$dirType,
            'id'=>$data['traviaId'],
        ));?>
    </div>
</div>
