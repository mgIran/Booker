<?php
/* @var $this FlightsController */
/* @var $order OrderFlight */
/* @var $transaction Transactions */
?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/bootstrap-nav-wizard.css');?>
<div class="container">
    <div class="content page-box hotel-details">
        <div class="steps flight-steps container-fluid">
            <ul class="nav nav-wizard">
                <li class="done"><a>جستجوی پروازها</a></li>
                <li class="done"><a>انتخاب پرواز</a></li>
                <li class="done"><a>ورود اطلاعات</a></li>
                <li class="done"><a>پرداخت</a></li>
                <li class="active"><a>دریافت بلیط</a></li>
            </ul>
        </div>
        <?php $this->renderPartial('//layouts/_flashMessage');?>
        <?php $this->renderPartial('//layouts/_flashMessage', array('prefix'=>'reservation-'));?>
        <div id="bill-page" class="passengers-info">
            <div class="panel panel-info">
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
                            <td><?php echo Controller::parseNumbers(number_format($this->getFixedPrice($transaction->amount)['price'], 0));?> تومان</td>
                            <td><?php echo CHtml::encode($transaction->order_id);?></td>
                            <td><?php echo CHtml::encode($transaction->tracking_code);?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card card-panel final-steps">
                <span>لطفا تا انجام مراحل زیر صبر کنید:</span>
                <ul>
                    <li class="doing">1. رزرو بلیط<i>لطفا صبر کنید...</i></li>
                    <li class="queue">2. صدور و ارسال آنی بلیط<i></i></li>
                </ul>
            </div>

            <div id="result"></div>
        </div>
    </div>
</div>
<?php Yii::app()->clientScript->registerScript('reserve', "
    $.ajax({
        url: '".$this->createUrl('booking')."',
        type: 'POST',
        dataType: 'JSON',
        data: {order_id: '".$order->id."', transaction_id: '".$transaction->id."'},
        success:function(data){
            if(data.status == 'success'){
                $('.final-steps li.doing').addClass('done').removeClass('doing').find('i').text('');
                $('.final-steps li.queue').addClass('doing').removeClass('queue').find('i').text('لطفا صبر کنید...');
                $.ajax({
                    url: '".$this->createUrl('mail')."',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {order_id: '".$order->id."', booking_id: data.bookingID},
                    success:function(data){
                        $('.final-steps li.doing').addClass('done').removeClass('doing').find('i').text('');
                        if(data.status == 'success'){
                            $('#result').append('<div class=\"alert alert-success\">عملیات رزرو با موفقیت انجام شد.</div>');
                            $('#result').append(data.html);
                        }else{
                            $('#result').append('<div class=\"alert alert-danger\">در انجام عملیات خطایی رخ داده است، لطفا با بخش پشتیبانی تماس بگیرید.</div>');
                            $('#result .alert').append(' می توانید از طریق <a href=\"".Yii::app()->createUrl('contactUs')."\" target=\"_blank\">این صفحه</a> با بخش پشتیبانی در تماس باشید.');
                        }
                    },
                    error:function(){
                        $('.final-steps li.doing').addClass('error').removeClass('doing').find('i').text('');
                        $('#result').append('<div class=\"alert alert-danger\">در انجام عملیات خطایی رخ داده است، لطفا با بخش پشتیبانی تماس بگیرید.</div>');
                        $('#result .alert').append(' می توانید از طریق <a href=\"".Yii::app()->createUrl('contactUs')."\" target=\"_blank\">این صفحه</a> با بخش پشتیبانی در تماس باشید.');
                    }
                });
            }else{
                $('.final-steps li.doing').addClass('error').removeClass('doing').find('i').text('');
                $('#result').append('<div class=\"alert alert-danger\">'+data.message+'</div>');
            }
        },
        error:function(){
            $('.final-steps li.doing').addClass('error').removeClass('doing').find('i').text('');
            $('#result').append('<div class=\"alert alert-danger\">در انجام عملیات خطایی رخ داده است، لطفا با بخش پشتیبانی تماس بگیرید.</div>');
            $('#result .alert').append(' می توانید از طریق <a href=\"".Yii::app()->createUrl('contactUs')."\" target=\"_blank\">این صفحه</a> با بخش پشتیبانی در تماس باشید.');
        }
    });
", CClientScript::POS_LOAD);?>