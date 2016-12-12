<?php
/* @var $this HotelsController */
/* @var $order Order */
/* @var $transaction Transactions */
/* @var $bookingResult boolean */
/* @var $bookingID integer */
?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/bootstrap-nav-wizard.css');?>
<div class="container">
    <div class="content page-box hotel-details">
        <div class="steps">
            <ul class="nav nav-wizard">
                <li class="done col-lg-2"><a>جستجوی هتل</a></li>
                <li class="done col-lg-2"><a>انتخاب هتل</a></li>
                <li class="done col-lg-2"><a>انتخاب اتاق</a></li>
                <li class="done col-lg-2"><a>ورود اطلاعات</a></li>
                <li class="done col-lg-2"><a>پرداخت</a></li>
                <li class="active col-lg-2"><a>دریافت واچر</a></li>
            </ul>
        </div>
        <?php $this->renderPartial('//layouts/_flashMessage');?>
        <?php $this->renderPartial('//layouts/_flashMessage', array('prefix'=>'reservation-'));?>
        <div id="bill-page" class="passengers-info">

            <div class="panel panel-success">
                <div class="panel-heading">اطلاعات پرداخت</div>

                <div class="panel-body">
                    جزئیات پرداخت شما به شرح ذیل می باشد:
                    <table class="table">
                        <thead>
                        <tr>
                            <th>زمان</th>
                            <th>مبلغ</th>
                            <th>شناسه خرید</th>
                            <th>کد رهگیری</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php echo JalaliDate::date('d F Y - H:i',$transaction->date);?></td>
                            <td><?php echo Controller::parseNumbers(number_format($this->getFixedPrice($transaction->amount/10), 0));?> تومان</td>
                            <td><?php echo CHtml::encode($transaction->order_id);?></td>
                            <td><?php echo CHtml::encode($transaction->tracking_code);?></td>
                        </tr>
                        </tbody>
                    </table>

                </div>

            </div>

            <?php if($bookingResult):?>
                <div class="alert alert-success"><h5 class="text-center">عملیات رزور هتل با موفقیت به پایان رسید.</h5></div>
                <div class="overflow-fix" style="padding: 15px;">
                    <a href="<?php echo $this->createUrl('/site');?>" class="btn waves-effect waves-light green lighten-1 col-md-2 pull-left">اتمام</a>
                    <a href="<?php echo $this->createUrl('/reservation/hotels/voucher', array('booking_id'=>$bookingID));?>" style="margin-left: 10px;" target="_blank" class="btn waves-effect waves-light amber darken-2 pull-left">دانلود فرم تاییدیه رزرو</a>
                    <?php echo CHtml::ajaxLink('ایمیل تاییدیه رزرو را دریافت نکردم', $this->createUrl('/reservation/hotels/mail', array('order_id'=>$order->id,'booking_id'=>$bookingID)), array(
                        'dataType'=>'JSON',
                        'beforeSend'=>'js:function(){
                            $("#email-loading").removeClass("hidden");
                            $("#email-sending").addClass("hidden");
                        }',
                        'success'=>'js:function(data){
                            if(data.status)
                                alert("ایمیل تاییدیه رزرو هتل ارسال شد.");
                            else
                                alert("در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید.");

                            $("#email-loading").addClass("hidden");
                            $("#email-sending").removeClass("hidden");
                        }',
                    ),array(
                        'id'=>'email-sending',
                        'class'=>'btn btn-sm waves-effect waves-light red lighten-1 pull-left',
                        'style'=>'margin-left: 10px;'
                    ))?>
                    <a id="email-loading" style="margin-left: 10px;" href="#" class="btn btn-sm waves-effect waves-light red lighten-1 pull-left hidden">در حال ارسال ایمیل...</a>
                </div>
            <?php else:?>
                <div class="alert alert-danger"><h5 class="text-center">عملیات رزور هتل با خطا مواجه شد. لطفا با بخش پشتیبانی تماس حاصل فرمایید.</h5></div>
            <?php endif;?>

        </div>

    </div>
</div>