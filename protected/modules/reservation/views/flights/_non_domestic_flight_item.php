<?php
/* @var $data array */
/* @var $origin string */
/* @var $destination string */
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
            <th>توقف</th>
            <th>قیمت بزرگسال<?php echo ($data['isTotalPrice'] and isset($data['return']))?' <small>(رفت و برگشت)</small>':'';?></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($data['oneWay'] as $oneWay):?>
            <?php preg_match("/(\d{2}:){2}/", $oneWay['legs'][0]['departureTime'], $matches);?>
            <tr data-price="<?php echo $oneWay['totalPrice']/10;?>" data-depart="<?php echo intval(substr($matches[0], 0, 2));?>" data-airline="<?php echo $oneWay['legs'][0]['carrier'];?>" data-airlinename="<?php echo $oneWay['legs'][0]['carrierName'];?>">
                <td><img src="<?php echo Yii::app()->baseUrl.'/uploads/airlines-logo/airline/'.$oneWay['legs'][0]['carrier'].'.gif';?>"><?php echo $oneWay['legs'][0]['carrierName'];?></td>
                <td><?php echo (count($oneWay['legs'])-1)==0?'بدون توقف':'دارد <small>('.(count($oneWay['legs'])-1).' توقف)</small>';?></td>
                <td><?php echo number_format($oneWay['totalPrice']/10);?> تومان</td>
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
                <th>قیمت بزرگسال<?php echo ($data['isTotalPrice'] and isset($data['return']))?' <small>(رفت و برگشت)</small>':'';?></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($data['return'] as $return):?>
                <?php preg_match("/(\d{2}:){2}/", $return['legs'][0]['departureTime'], $matches);?>
                <tr data-price="<?php echo $return['totalPrice']/10;?>" data-depart="<?php echo intval(substr($matches[0], 0, 2));?>" data-airline="<?php echo $return['legs'][0]['carrier'];?>" data-airlinename="<?php echo $return['legs'][0]['carrierName'];?>">
                    <td><img src="<?php echo Yii::app()->baseUrl.'/uploads/airlines-logo/airline/'.$return['legs'][0]['carrier'].'.gif';?>"><?php echo $return['legs'][0]['carrierName'];?></td>
                    <td><?php echo (count($return['legs'])-1)==0?'بدون توقف':'دارد <small>('.(count($return['legs'])-1).' توقف)</small>';?></td>
                    <td><?php echo number_format($return['totalPrice']/10);?> تومان</td>
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
