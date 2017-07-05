<?php
/* @var $this FlightsController */
/* @var $order OrderFlight */
/* @var $details array */
/* @var $oneWayPrice double */
/* @var $returnPrice double */
$totalPrice = 0;
$totalPrice += $this->getFixedPrice($oneWayPrice/10, true, $details['flights']['oneWay']['type'])['price'];
if(isset($details['flights']['return']))
    $totalPrice += $this->getFixedPrice($returnPrice/10, true, $details['flights']['return']['type'])['price'];
?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/bootstrap-nav-wizard.css');?>
<div class="container">
    <div class="content page-box hotel-details">
        <div class="steps flight-steps container-fluid">
            <ul class="nav nav-wizard">
                <li class="done"><a>جستجوی پروازها</a></li>
                <li class="done"><a>انتخاب پرواز</a></li>
                <li class="done"><a>ورود اطلاعات</a></li>
                <li class="active"><a>پرداخت</a></li>
                <li><a>دریافت بلیط</a></li>
            </ul>
        </div>
        <?php $this->renderPartial('//layouts/_flashMessage');?>
        <div id="bill-page" class="passengers-info">

            <div class="panel panel-success">
                <div class="panel-heading">اطلاعات خریدار</div>

                <div class="panel-body">

                    <ul>
                        <li>این اطلاعات مربوط به شماست که فرآیند خرید را انجام می دهید.</li>
                        <li>تیم پشتیبانی بوکر 24 در صورت نیاز از طریق اطلاعات وارد شده در این قسمت با شما تماس خواهد گرفت.</li>
                        <li class="red-text">صورت حساب و بلیط به پست الکترونیکی زیر ارسال خواهد شد.</li>
                    </ul>

                    <div class="container-fluid">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>نام</th>
                                <th>نام خانوادگی</th>
                                <th>تلفن همراه</th>
                                <th>پست الکترونیکی</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><?php echo CHtml::encode($order->buyer_name);?></td>
                                <td><?php echo CHtml::encode($order->buyer_family);?></td>
                                <td><?php echo CHtml::encode($order->buyer_mobile);?></td>
                                <td><?php echo CHtml::encode($order->buyer_email);?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>

            <div class="panel panel-success room-passengers">

                <div class="panel-heading">اطلاعات مسافران</div>

                <div class="panel-body">
                    <ul>
                        <li>این اطلاعات مربوط به مسافران است؛ افرادی که بلیط به نام آنها صادر می شود.</li>
                        <li class="red-text">مسئوليت كنترل گذرنامه از نظر اعتبار ( 6 ماه قبل از تاريخ انقضاء ) و ممنوعيت خروج از كشور بر عهده مسافر است .</li>
                    </ul>
                    <div class="room-item overflow-fix">
                        <div class="container-fluid">
                            <div class="container-fluid">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>نام</th>
                                        <th>نام خانوادگی</th>
                                        <th>کد ملی</th>
                                        <th>جنسیت</th>
                                        <th>نوع مسافر</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($order->passengers as $passenger):?>
                                        <tr>
                                            <td><?php echo CHtml::encode($passenger->name_fa).'('.CHtml::encode($passenger->name_en).')';?></td>
                                            <td><?php echo CHtml::encode($passenger->family_fa).'('.CHtml::encode($passenger->family_en).')';?></td>
                                            <td><?php echo CHtml::encode($passenger->national_id);?></td>
                                            <td>
                                                <?php if($passenger->type=='ADT'):?>
                                                    <?php echo ($passenger->gender=='male')?'مرد':'زن';?>
                                                <?php else:?>
                                                    <?php echo ($passenger->gender=='male')?'پسر':'دختر';?>
                                                <?php endif;?>
                                            </td>
                                            <td><?php echo PassengersFlight::$typeLabels[$passenger->type];?></td>
                                        </tr>
                                    <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">اطلاعات پرواز</div>
            <div class="container-fluid">
                <div class="panel-body">

                    <div class="reserve-information reserve-basic-info flight-information">
                        <table class="table" style="margin-bottom: 50px;">
                            <thead>
                            <tr>
                                <th></th>
                                <th>تاریخ و ساعت</th>
                                <th>مبدا</th>
                                <th>مقصد</th>
                                <th>ایرلاین</th>
                                <th>قیمت</th>
                                <?php if(!Yii::app()->session['domestic']):?>
                                    <th></th>
                                <?php endif;?>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="title-td">پرواز رفت</td>
                                <td><?php echo JalaliDate::date('Y/m/d - H:i', strtotime($details['flights']['oneWay']['legs'][0]['departureTime']));?></td>
                                <td><?php echo Airports::getFieldByIATA($details['flights']['oneWay']['legs'][0]['origin'], 'city_fa').' - '.Airports::getFieldByIATA($details['flights']['oneWay']['legs'][0]['origin'], 'airport_fa');?></td>
                                <td><?php echo Airports::getFieldByIATA($details['flights']['oneWay']['legs'][0]['destination'], 'city_fa').' - '.Airports::getFieldByIATA($details['flights']['oneWay']['legs'][0]['destination'], 'airport_fa');?></td>
                                <td><img src="<?php echo Yii::app()->baseUrl.'/uploads/airlines-logo/dom/'.$details['flights']['oneWay']['legs'][0]['carrier'].'.png';?>"><?php echo $details['flights']['oneWay']['legs'][0]['carrierName'];?></td>
                                <td><?php echo number_format($this->getFixedPrice($oneWayPrice/10, true, $details['flights']['oneWay']['type'])['price']);?> تومان</td>
                            </tr>
                            <?php if(isset($details['flights']['return'])):?>
                                <tr>
                                    <td class="title-td">پرواز برگشت</td>
                                    <td><?php echo JalaliDate::date('Y/m/d - H:i', strtotime($details['flights']['return']['legs'][0]['departureTime']));?></td>
                                    <td><?php echo Airports::getFieldByIATA($details['flights']['return']['legs'][0]['origin'], 'city_fa').' - '.Airports::getFieldByIATA($details['flights']['return']['legs'][0]['origin'], 'airport_fa');?></td>
                                    <td><?php echo Airports::getFieldByIATA($details['flights']['return']['legs'][0]['destination'], 'city_fa').' - '.Airports::getFieldByIATA($details['flights']['return']['legs'][0]['destination'], 'airport_fa');?></td>
                                    <td><img src="<?php echo Yii::app()->baseUrl.'/uploads/airlines-logo/dom/'.$details['flights']['return']['legs'][0]['carrier'].'.png';?>"><?php echo $details['flights']['return']['legs'][0]['carrierName'];?></td>
                                    <td><?php echo number_format($this->getFixedPrice($returnPrice/10, true, $details['flights']['return']['type'])['price']);?> تومان</td>
                                </tr>
                            <?php endif;?>
                            </tbody>
                        </table>
                    </div>

                    <h5 class="pull-right">
                        مبلغ قابل پرداخت:
                        <span class="red-text"><?php echo number_format($totalPrice, 0);?></span>
                        <small class="red-text" style="margin-right: 10px;">تومان </small>
                    </h5>

                    <div class="input-field buttons col-md-3 pull-left bill-button">
                        <a href="<?php echo $this->createUrl('flights/pay/'.$order->id);?>" class="btn waves-effect waves-light green lighten-1 col-md-12">پرداخت</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
