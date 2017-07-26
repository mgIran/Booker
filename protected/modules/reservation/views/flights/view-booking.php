<?php
/* @var $this FlightsController */
/* @var $model BookingsFlight */
/* @var $transaction Transactions[] */
/* @var $id integer */
?>

<?php $this->renderPartial("//layouts/_flashMessage");?>

<h1>اطلاعات بلیط</h1>
<span id="email-loading" class="pull-left hidden" style="margin-top: -40px;">در حال ارسال ایمیل...</span>
<div class="pull-left" style="margin-top: -40px;">
    <?php echo CHtml::ajaxLink('ارسال مجدد بلیط', $this->createUrl('/reservation/flights/mail', array('order_id'=>$model->order_id,'booking_id'=>$model->id)), array(
        'dataType'=>'JSON',
        'beforeSend'=>'js:function(){
            $("#email-loading").removeClass("hidden");
            $("#email-sending").parent("div").addClass("hidden");
        }',
        'success'=>'js:function(data){
            if(data.status == "success")
                alert("ایمیل حاوی بلیط هواپیما ارسال شد.");
            else
                alert("در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید.");

            $("#email-loading").addClass("hidden");
            $("#email-sending").parent("div").removeClass("hidden");
        }',
    ),array(
        'id'=>'email-sending',
        'class'=>'btn btn-success'
    ))?>
    <a href="<?php echo $this->createUrl("ticket", array('booking_id'=>$model->id));?>" target="_blank" class="btn btn-danger">مشاهده بلیط</a>
</div>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        array(
            'name'=>'خریدار',
            'value'=>$model->order->fullName,
        ),
        array(
            'name'=>'موبایل',
            'value'=>$model->order->buyer_mobile,
        ),
        array(
            'name'=>'پست الکترونیکی',
            'value'=>$model->order->buyer_email,
        ),
        array(
            'name'=>'مبدا',
            'value'=>function($data){
                Yii::import('airports.models.*');
                /* @var BookingsFlight $data */
                $flights = CJSON::decode($data->flights);
                return Airports::getFieldByIATA($flights['oneWay']['legs'][0]['origin'],'city_fa');
            }
        ),
        array(
            'name'=>'مقصد',
            'value'=>function($data){
                Yii::import('airports.models.*');
                /* @var BookingsFlight $data */
                $flights = CJSON::decode($data->flights);
                return Airports::getFieldByIATA($flights['oneWay']['legs'][0]['destination'],'city_fa');
            }
        ),
        array(
            'name'=>'تاریخ و ساعت حرکت',
            'value'=>function($data){
                /* @var BookingsFlight $data */
                $flights = CJSON::decode($data->flights);
                return JalaliDate::date("Y/m/d - H:i", strtotime($flights['oneWay']['legs'][0]['departureTime']));
            }
        ),
        array(
            'name'=>'نوع سفر',
            'value'=>function($data){
                /* @var BookingsFlight $data */
                $flights = CJSON::decode($data->flights);
                return isset($flights['return'])?'رفت و برگشت':'یکطرفه';
            }
        ),
        array(
            'name'=>'تاریخ ثبت در سایت',
            'value'=>JalaliDate::date('d F Y - H:i', $model->order->date),
        ),
        array(
            'name'=>'تاریخ ثبت در وب سرویس',
            'value'=>JalaliDate::date('d F Y - H:i', strtotime($model->createdAt)),
        ),
        array(
            'name'=>'قیمت (همراه با کمیسیون)',
            'value'=>number_format($this->getFixedPrice($model->totalPrice/10)['price']).' تومان',
        ),
        array(
            'name'=>'Order ID (مربوط به تراویا)',
            'value'=>$model->orderId,
        ),
        array(
            'name'=>'کد رهگیری تراکنش',
            'value'=>$model->order->payment_tracking_code,
        ),
        array(
            'name'=>'کد رهگیری رزرو',
            'value'=>'B24F-'.$model->orderId,
        )
    ),
)); ?>

<h1>اطلاعات مسافرین</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'passengers-grid',
    'dataProvider'=>new CArrayDataProvider($model->order->passengers),
    'columns'=>array(
        array(
            'name'=>'name',
            'header'=>'نام و نام خانوادگی',
            'value'=>'$data->name_fa." ".$data->family_fa." (".strtoupper($data->name_en." ".$data->family_en).")"'
        ),
        array(
            'name'=>'gender',
            'header'=>'جنسیت',
            'value'=>'$data->genderLabels[$data->gender]'
        ),
        array(
            'name'=>'passport_num',
            'header'=>'شماره پاسپورت',
            'value'=>'$data->passport_num'
        ),
        array(
            'name'=>'type',
            'header'=>'نوع',
            'value'=>'$data::$typeLabels[$data->type]'
        ),
    ),
)); ?>

<h1>اطلاعات تراکنش</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'transactions-grid',
    'dataProvider'=>new CArrayDataProvider($transaction),
    'columns'=>array(
        array(
            'header'=>'کد رهگیری',
            'value'=>'$data->tracking_code',
        ),
        array(
            'header'=>'مبلغ',
            'value'=>'number_format($data->amount/10)." تومان"',
        ),
        array(
            'header'=>'تاریخ و ساعت',
            'value'=>'JalaliDate::date("d F Y - H:i", $data->date)',
        )
    ),
));?>