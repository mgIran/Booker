<?php
/* @var $this FlightsController */
/* @var $model CancellationRequests */
/* @var $transaction Transactions[] */
/* @var $id integer */

$this->menu=array(
    array('label'=>'کنسل شود', 'url'=>array('/reservation/flights/cancel', 'id'=>$id)),
    array('label'=>'امکان کنسل کردن وجود ندارد', 'url'=>array('/reservation/flights/refuseCancel', 'id'=>$id)),
);

$labelClass = 'warning';
if ($model->status == 'canceled')
    $labelClass = 'success';
elseif ($model->status == 'refused')
    $labelClass = 'danger';

$flights = CJSON::decode($model->booking->flights);
Yii::import('airports.models.*');
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
            'name'=>'مبدا',
            'value'=>Airports::getFieldByIATA($flights['oneWay']['legs'][0]['origin'],'city_fa'),
        ),
        array(
            'name'=>'مقصد',
            'value'=>Airports::getFieldByIATA($flights['oneWay']['legs'][0]['destination'],'city_fa'),
        ),
        array(
            'name'=>'شرایط کنسلی پرواز رفت',
            'value'=>function($model){
                $flights = CJSON::decode($model->booking->flights);
                $rules = '';
                foreach($flights['oneWay']['cancelRules'] as $key=>$value)
                    $rules .= '- '.CancellationRequests::$flightCancelRules[strtolower($key)].'<br>';
                return $rules;
            },
            'type'=>'raw'
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
            'name'=>'قیمت (همراه با کمیسیون)',
            'value'=>number_format($this->getFixedPrice($model->booking->totalPrice/10)['price']).' تومان',
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
            'value'=>'B24F-'.$model->booking->orderId,
        ),
        array(
            'name'=>'وضعیت درخواست',
            'value'=>'<span class="label label-'.$labelClass.'">'.$model->statusLabels[$model->status].'</span>',
            'type'=>'raw'
        ),
    ),
)); ?>

<h1>اطلاعات مسافرین</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'passengers-grid',
    'dataProvider'=>new CArrayDataProvider($model->booking->order->passengers),
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
