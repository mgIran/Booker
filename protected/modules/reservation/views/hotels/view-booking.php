<?php
/* @var $this HotelsController */
/* @var $model Bookings */
/* @var $transaction Transactions[] */
/* @var $id integer */
?>

<?php $this->renderPartial("//layouts/_flashMessage");?>

<h1>اطلاعات رزرو</h1>
<span id="email-loading" class="pull-left hidden" style="margin-top: -40px;">در حال ارسال ایمیل...</span>
<div class="pull-left" style="margin-top: -40px;">
    <?php echo CHtml::ajaxLink('ارسال مجدد واچر', $this->createUrl('/reservation/hotels/mail', array('order_id'=>$model->order_id,'booking_id'=>$model->id)), array(
        'dataType'=>'JSON',
        'beforeSend'=>'js:function(){
            $("#email-loading").removeClass("hidden");
            $("#email-sending").parent("div").addClass("hidden");
        }',
        'success'=>'js:function(data){
            if(data.status)
                alert("ایمیل تاییدیه رزرو هتل ارسال شد.");
            else
                alert("در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید.");

            $("#email-loading").addClass("hidden");
            $("#email-sending").parent("div").removeClass("hidden");
        }',
    ),array(
        'id'=>'email-sending',
        'class'=>'btn btn-success'
    ))?>
    <a href="<?php echo $this->createUrl("voucher", array('booking_id'=>$model->id));?>" target="_blank" class="btn btn-danger">مشاهده واچر</a>
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
            'name'=>'هتل',
            'value'=>$model->hotel,
        ),
        array(
            'name'=>'شهر',
            'value'=>$model->city.', '.$model->country,
        ),
        array(
            'name'=>'تاریخ و ساعت ورود',
            'value'=>$model->checkIn.' - '.$model->checkinFrom,
        ),
        array(
            'name'=>'تاریخ و ساعت خروج',
            'value'=>$model->checkOut.' - '.$model->checkoutTo,
        ),
        array(
            'name'=>'تعداد مسافر',
            'value'=>$model->passenger,
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
            'name'=>'پذیرایی',
            'value'=>$model->meal,
        ),
        array(
            'name'=>'قیمت (همراه با کمیسیون)',
            'value'=>number_format($this->getFixedPrice($model->price/10)['price'], 0).' تومان',
        ),
        array(
            'name'=>'قابل استرداد',
            'value'=>($model->nonrefundable == 0)?'هست':'نیست',
        ),
        array(
            'name'=>'شرایط کنسلی',
            'value'=>implode('<br>',$model->getCancelRulesAsString()),
            'type'=>'raw'
        ),
        array(
            'name'=>'Booking ID',
            'value'=>implode('<br>', $model->getConfirmationDetails('confirmNumber')),
            'type'=>'raw'
        ),
        array(
            'name'=>'مسافرین',
            'value'=>implode('<br>', $model->getConfirmationDetails('name')),
            'type'=>'raw'
        ),
        array(
            'name'=>'اتاق',
            'value'=>implode('<br>', $model->getRooms()),
            'type'=>'raw'
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
            'value'=>'B24H-'.$model->orderId,
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
            'value'=>'$data->name." ".$data->family'
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
            'value'=>'$data->typeLabels[$data->type]'
        ),
        array(
            'name'=>'age',
            'header'=>'سن',
            'value'=>'$data->age'
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
)); ?>