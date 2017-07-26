<?php
/* @var $this FlightsController */
/* @var $data array */
/* @var $origin string */
/* @var $destination string */
usort($data['oneWay'], function($a, $b) {
    return $a['totalPrice'] > $b['totalPrice'] ? 1 : -1;
});
if(isset($data['return'])) {
    usort($data['return'], function ($a, $b) {
        return $a['totalPrice'] > $b['totalPrice'] ? 1 : -1;
    });
}
$imageUrl = Yii::app()->baseUrl.'/uploads/airlines-logo/';
$imageExt = '';
if(Yii::app()->session['domestic']) {
    $imageUrl .= 'dom/';
    $imageExt = '.png';
}else {
    $imageUrl .= 'airline/';
    $imageExt = '.gif';
}
?>

<div class="overflow-fix card-panel package-item">
    <div class="package-info row">
        <?php if(isset($data['return'])):?>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><?php echo $origin.' به '.$destination;?></div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">تعداد پرواز رفت: <?php echo count($data['oneWay']);?></div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-left">تعداد پرواز برگشت: <?php echo count($data['return']);?></div>
        <?php else:?>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><?php echo $origin.' به '.$destination;?></div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-left">تعداد پرواز رفت: <?php echo count($data['oneWay']);?></div>
        <?php endif;?>
    </div>
    <hr>
    <h5 class="red-text">پرواز های رفت</h5>
    <table class="striped">
        <thead>
        <tr>
            <th>ایرلاین</th>
            <?php if(Yii::app()->session['domestic']):?>
                <th>نوع</th>
            <?php else:?>
                <th>توقف</th>
            <?php endif;?>
            <th>قیمت<?php echo ($data['isTotalPrice'] and isset($data['return']))?' <small>(رفت و برگشت)</small>':'';?></th>
            <th>تاریخ و ساعت پرواز</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($data['oneWay'] as $oneWay):?>
            <?php preg_match("/(\d{2}:){2}/", $oneWay['legs'][0]['departureTime'], $matches);?>
            <tr data-price="<?php echo $oneWay['totalPrice']/10;?>" data-depart="<?php echo intval(substr($matches[0], 0, 2));?>" data-airline="<?php echo $oneWay['legs'][0]['carrier'];?>" data-airlinename="<?php echo $oneWay['legs'][0]['carrierName'];?>" data-type="<?php echo $oneWay['type'];?>">
                <td><img src="<?php echo $imageUrl.$oneWay['legs'][0]['carrier'].$imageExt;?>"><?php echo $oneWay['legs'][0]['carrierName'];?></td>
                <?php if(Yii::app()->session['domestic']):?>
                    <td><?php echo $oneWay['type']=='charter'?'چارتری':'سیستمی'?></td>
                <?php else:?>
                    <td><?php echo (count($oneWay['legs'])-1)==0?'بدون توقف':'دارد <small>('.(count($oneWay['legs'])-1).' توقف)</small>';?></td>
                <?php endif;?>
                <td><?php echo number_format($this->getFixedPrice($oneWay['totalPrice']/10, true, $oneWay['type'])['price']);?> تومان</td>
                <td><?php echo JalaliDate::date('Y/m/d - H:i', strtotime($oneWay['legs'][0]['departureTime']), false);?></td>
                <td class="text-left">
                    <?php echo CHtml::hiddenField('flight_details', json_encode($oneWay), array('class'=>'flight-details'));?>
                    <?php echo CHtml::link('جزئیات پرواز', '#details-modal', array('class'=>'flight-details-link', 'data-toggle'=>'modal'));?>
                    <?php echo CHtml::button('انتخاب پرواز', array('id'=>$oneWay['traviaId'],'data-type'=>'one-way','class'=>'btn btn-sm waves-effect waves-light red lighten-1 select-flight'));?>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <?php if(isset($data['return'])):?>
        <h5 class="red-text">پرواز های برگشت</h5>
        <table class="striped">
            <thead>
            <tr>
                <th>ایرلاین</th>
                <th>توقف</th>
                <th>قیمت<?php echo ($data['isTotalPrice'] and isset($data['return']))?' <small>(رفت و برگشت)</small>':'';?></th>
                <th>تاریخ و ساعت پرواز</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($data['return'] as $return):?>
                <?php preg_match("/(\d{2}:){2}/", $return['legs'][0]['departureTime'], $matches);?>
                <tr data-price="<?php echo $return['totalPrice']/10;?>" data-depart="<?php echo intval(substr($matches[0], 0, 2));?>" data-airline="<?php echo $return['legs'][0]['carrier'];?>" data-airlinename="<?php echo $return['legs'][0]['carrierName'];?>">
                    <td><img src="<?php echo $imageUrl.$return['legs'][0]['carrier'].$imageExt;?>"><?php echo $return['legs'][0]['carrierName'];?></td>
                    <?php if(Yii::app()->session['domestic']):?>
                        <td><?php echo $return['type']=='charter'?'چارتری':'سیستمی'?></td>
                    <?php else:?>
                        <td><?php echo (count($return['legs'])-1)==0?'بدون توقف':'دارد <small>('.(count($return['legs'])-1).' توقف)</small>';?></td>
                    <?php endif;?>
                    <td><?php echo number_format($this->getFixedPrice($return['totalPrice']/10, true, $return['type'])['price']);?> تومان</td>
                    <td><?php echo JalaliDate::date('Y/m/d - H:i', strtotime($return['legs'][0]['departureTime']), false);?></td>
                    <td class="text-left">
                        <?php echo CHtml::hiddenField('flight_details', json_encode($return), array('class'=>'flight-details'));?>
                        <?php echo CHtml::link('جزئیات پرواز', '#details-modal', array('class'=>'flight-details-link', 'data-toggle'=>'modal'));?>
                        <?php echo CHtml::button('انتخاب پرواز', array('id'=>$return['traviaId'],'data-type'=>'return','class'=>'btn btn-sm waves-effect waves-light red lighten-1 select-flight'));?>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    <?php endif;?>
</div>