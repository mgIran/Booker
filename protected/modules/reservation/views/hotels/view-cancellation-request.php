<?php
/* @var $this HotelsController */
/* @var $model CancellationRequests */
/* @var $id integer */

$this->menu=array(
    array('label'=>'کنسل شود', 'url'=>array('/reservation/hotels/cancel', 'id'=>$id)),
    array('label'=>'امکان کنسل کردن وجود ندارد', 'url'=>array('/reservation/hotels/refuseCancel', 'id'=>$id)),
);

$labelClass = 'warning';
if ($model->status == 'canceled')
    $labelClass = 'success';
elseif ($model->status == 'refused')
    $labelClass = 'danger';
?>

<h1>اطلاعات رزرو</h1>

<?php $this->renderPartial('//layouts/_flashMessage');?>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        array(
            'name'=>'خریدار',
            'value'=>$model->booking->order->fullName,
        ),
        array(
            'name'=>'موبایل',
            'value'=>$model->booking->order->buyer_mobile,
        ),
        array(
            'name'=>'پست الکترونیکی',
            'value'=>$model->booking->order->buyer_email,
        ),
        array(
            'name'=>'هتل',
            'value'=>$model->booking->hotel,
        ),
        array(
            'name'=>'شهر',
            'value'=>$model->booking->city.', '.$model->booking->country,
        ),
        array(
            'name'=>'تاریخ و ساعت ورود',
            'value'=>$model->booking->checkIn.' - '.$model->booking->checkinFrom,
        ),
        array(
            'name'=>'تاریخ و ساعت خروج',
            'value'=>$model->booking->checkOut.' - '.$model->booking->checkoutTo,
        ),
        array(
            'name'=>'تعداد مسافر',
            'value'=>$model->booking->passenger,
        ),
        array(
            'name'=>'تاریخ ثبت در سایت',
            'value'=>JalaliDate::date('d F Y - H:i', $model->booking->order->date),
        ),
        array(
            'name'=>'تاریخ ثبت در وب سرویس',
            'value'=>JalaliDate::date('d F Y - H:i', strtotime($model->booking->createdAt)),
        ),
        array(
            'name'=>'پذیرایی',
            'value'=>$model->booking->meal,
        ),
        array(
            'name'=>'قیمت (همراه با کمیسیون)',
            'value'=>number_format($this->getFixedPrice($model->booking->price/10)['price'], 0).' تومان',
        ),
        array(
            'name'=>'قابل استرداد',
            'value'=>($model->booking->nonrefundable == 0)?'هست':'نیست',
        ),
        array(
            'name'=>'شرایط کنسلی',
            'value'=>implode('<br>',$model->booking->getCancelRulesAsString()),
            'type'=>'raw'
        ),
        array(
            'name'=>'Booking ID',
            'value'=>$model->booking->getConfirmationDetails('confirmNumber'),
        ),
        array(
            'name'=>'مسافرین',
            'value'=>implode('<br>', $model->booking->getConfirmationDetails('name')),
            'type'=>'raw'
        ),
        array(
            'name'=>'اتاق',
            'value'=>implode('<br>', $model->booking->getRooms()),
            'type'=>'raw'
        ),
        array(
            'name'=>'Order ID (مربوط به تراویا)',
            'value'=>$model->booking->orderId,
        ),
        array(
            'name'=>'کد رهگیری تراکنش',
            'value'=>$model->booking->order->payment_tracking_code,
        ),
        array(
            'name'=>'کد رهگیری رزرو',
            'value'=>'B24H-'.$model->booking->orderId,
        ),
        array(
            'name'=>'وضعیت درخواست',
            'value'=>'<span class="label label-'.$labelClass.'">'.$model->statusLabels[$model->status].'</span>',
            'type'=>'raw'
        ),
    ),
)); ?>