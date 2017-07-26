<?php
/* @var $this DashboardController*/
/* @var $cancellationRequests CActiveDataProvider*/
/* @var $hotelBookings CActiveDataProvider*/
/* @var $flightBookings CActiveDataProvider*/
/* @var $sumTransactions Transactions*/
/* @var $commissionPercent string*/
?>
<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success fade in">
        <button class="close close-sm" type="button" data-dismiss="alert"><i class="icon-remove"></i></button>
        <?php echo Yii::app()->user->getFlash('success');?>
    </div>
<?php elseif(Yii::app()->user->hasFlash('failed')):?>
    <div class="alert alert-danger fade in">
        <button class="close close-sm" type="button" data-dismiss="alert"><i class="icon-remove"></i></button>
        <?php echo Yii::app()->user->getFlash('failed');?>
    </div>
<?php endif;?>

<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="panel-heading">آمار بازدیدکنندگان</div>
    <div class="panel-body">
        <label>افراد آنلاین : </label><?php echo Yii::app()->userCounter->getOnline(); ?><br />
        <label>بازدید امروز : </label><?php echo Yii::app()->userCounter->getToday(); ?><br />
        <label>بازدید دیروز : </label><?php echo Yii::app()->userCounter->getYesterday(); ?><br />
        <label>تعداد کل بازدید ها : </label><?php echo Yii::app()->userCounter->getTotal(); ?><br />
        <label>بیشترین بازدید : </label><?php echo Yii::app()->userCounter->getMaximal(); ?><br />
    </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="panel-heading">آمار مالی</div>
    <div class="panel-body">
        <label>مجموع تراکنش ها:</label><?php echo number_format($sumTransactions->amount/10).' تومان';?><br />
    </div>
</div>
<div class="clearfix"></div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="panel-heading">هتل</div>
    <div class="panel-body">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'hotel-bookings-grid',
            'dataProvider'=>$hotelBookings,
            'columns'=>array(
                array(
                    'header'=>'درخواست کننده',
                    'value'=>'$data->order->fullName'
                ),
                array(
                    'header'=>'موبایل',
                    'value'=>'$data->order->buyer_mobile'
                ),
                array(
                    'header'=>'نام هتل',
                    'value'=>'$data->hotel'
                ),
                array(
                    'header'=>'شهر',
                    'value'=>'$data->city.", ".$data->country'
                ),
                array(
                    'class'=>'CButtonColumn',
                    'template'=>'{view}',
                    'buttons'=>array(
                        'view'=>array(
                            'url'=>'Yii::app()->createUrl("/reservation/hotels/viewBooking", array("id"=>$data->id))',
                        ),
                    )
                ),
            ),
        )); ?>
    </div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="panel-heading">بلیط هواپیما</div>
    <div class="panel-body">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'flight-bookings-grid',
            'dataProvider'=>$flightBookings,
            'columns'=>array(
                array(
                    'header'=>'درخواست کننده',
                    'value'=>'$data->order->fullName'
                ),
                array(
                    'header'=>'موبایل',
                    'value'=>'$data->order->buyer_mobile'
                ),
                array(
                    'header'=>'مبدا',
                    'value'=>function($data){
                        Yii::import('airports.models.*');
                        /* @var BookingsFlight $data */
                        $flights = CJSON::decode($data->flights);
                        return Airports::getFieldByIATA($flights['oneWay']['legs'][0]['origin'],'city_fa');
                    }
                ),
                array(
                    'header'=>'مقصد',
                    'value'=>function($data){
                        Yii::import('airports.models.*');
                        /* @var BookingsFlight $data */
                        $flights = CJSON::decode($data->flights);
                        return Airports::getFieldByIATA($flights['oneWay']['legs'][0]['destination'],'city_fa');
                    }
                ),
                array(
                    'header'=>'تاریخ و ساعت حرکت',
                    'value'=>function($data){
                        /* @var BookingsFlight $data */
                        $flights = CJSON::decode($data->flights);
                        return JalaliDate::date("Y/m/d - H:i", strtotime($flights['oneWay']['legs'][0]['departureTime']));
                    }
                ),
                array(
                    'header'=>'نوع سفر',
                    'value'=>function($data){
                        /* @var BookingsFlight $data */
                        $flights = CJSON::decode($data->flights);
                        return isset($flights['return'])?'رفت و برگشت':'یکطرفه';
                    }
                ),
                array(
                    'class'=>'CButtonColumn',
                    'template'=>'{view}',
                    'buttons'=>array(
                        'view'=>array(
                            'url'=>'Yii::app()->createUrl("/reservation/flights/viewBooking", array("id"=>$data->id))',
                        ),
                    )
                ),
            ),
        )); ?>
    </div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="panel-heading"> درخواست انصراف</div>
    <div class="panel-body">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'cancellation-grid',
            'dataProvider'=>$cancellationRequests,
            'columns'=>array(
                array(
                    'header'=>'درخواست کننده',
                    'value'=>'$data->booking->order->fullName'
                ),
                array(
                    'header'=>'موبایل',
                    'value'=>'$data->booking->order->buyer_mobile'
                ),
                array(
                    'header'=>'نام هتل',
                    'value'=>'$data->booking->hotel'
                ),
                array(
                    'header'=>'شهر',
                    'value'=>'$data->booking->city.", ".$data->booking->country'
                ),
                array(
                    'name'=>'created_date',
                    'value'=>'JalaliDate::date("d F Y - H:i", $data->created_date)'
                ),
                array(
                    'class'=>'CButtonColumn',
                    'template'=>'{view}',
                    'buttons'=>array(
                        'view'=>array(
                            'url'=>'Yii::app()->createUrl("/reservation/hotels/viewCancellationRequest", array("id"=>$data->id))',
                        ),
                    )
                ),
            ),
        )); ?>
    </div>
</div>