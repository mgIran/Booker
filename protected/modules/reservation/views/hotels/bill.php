<?php
/* @var $this HotelsController */
/* @var $order Order */
/* @var $details array */
/* @var $hotelDetails array */
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
                <li class="active col-lg-2"><a>پرداخت</a></li>
                <li class="col-lg-2"><a>دریافت واچر</a></li>
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
                        <li class="red-text">صورت حساب و واچر به پست الکترونیکی زیر ارسال خواهد شد.</li>
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
                        <li>این اطلاعات مربوط به مسافران است؛ افرادی که واچر به نام آنها صادر می شود.</li>
                        <li>هنگام ورود به هتل، اطلاعات واچر با گذرنامه مطابقت داده خواهد شد.</li>
                        <li class="red-text">مسئوليت كنترل گذرنامه از نظر اعتبار ( 6 ماه قبل از تاريخ انقضاء ) و ممنوعيت خروج از كشور بر عهده مسافر است .</li>
                    </ul>

                    <?php foreach($details['services']['rooms'] as $key=>$room):;?>
                        <div class="room-item overflow-fix">
                            <div class="container-fluid">
                                <h6 class="col-md-1 room-label">اتاق <b><?php echo $this->parseNumbers(($key+1));?></b></h6>
                                <div class="col-md-11 room-type"><b><?php echo CHtml::encode($room['type'].' '.$room['category']);?></b> <small><?php echo CHtml::encode($details['services']['meal']);?></small></div>

                                <div class="container-fluid">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>نام</th>
                                            <th>نام خانوادگی</th>
                                            <th>شماره گذرنامه</th>
                                            <th>جنسیت</th>
                                            <th>نوع مسافر</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $j=0;?>
                                        <?php foreach($order->passengers as $passenger):?>
                                            <?php if($passenger->room_num==$j):?>
                                                <tr>
                                                    <td><?php echo CHtml::encode($passenger->name);?></td>
                                                    <td><?php echo CHtml::encode($passenger->family);?></td>
                                                    <td><?php echo CHtml::encode($passenger->passport_num);?></td>
                                                    <td>
                                                        <?php if($passenger->type=='adult'):?>
                                                            <?php echo ($passenger->gender=='male')?'مرد':'زن';?>
                                                        <?php else:?>
                                                            <?php echo ($passenger->gender=='male')?'پسر':'دختر';?>
                                                        <?php endif;?>
                                                    </td>
                                                    <td>
                                                        <?php if($passenger->type=='adult'):?>
                                                            بزرگسال<small>(بالای 12 سال)</small>
                                                        <?php else:?>
                                                            کودک<small>(زیر 12 سال)</small>
                                                        <?php endif;?>
                                                    </td>
                                                </tr>
                                            <?php endif;?>
                                        <?php endforeach;?>
                                        <?php $j++;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">اطلاعات رزرو</div>
            <div class="container-fluid">
                <div class="panel-body">
                    <div class="reserve-information row">
                        <div class="overflow-fix">
                            <div class="col-lg-4"><b>تاریخ ورود : </b><?php echo JalaliDate::date('d F Y', strtotime($details['checkIn']));?></div>
                            <div class="col-lg-4"><b>تاریخ خروج : </b><?php echo JalaliDate::date('d F Y', strtotime($details['checkOut']));?></div>
                            <div class="col-lg-4"><b>تعداد شب : </b><?php echo $this->getStayingTime(strtotime($details['checkIn']), strtotime($details['checkOut']));?></div>
                        </div>
                        <div class="overflow-fix">
                            <div class="col-lg-4"><b>تعداد بزرگسال : </b><?php echo $this->getAdultsCount($details['services']['rooms']);?></div>
                            <div class="col-lg-4"><b>تعداد کودک : </b><?php echo $this->getChildsCount($details['services']['rooms']);?></div>
                            <div class="col-lg-4"><b>تعداد اتاق : </b><?php echo count($details['services']['rooms']);?></div>
                        </div>
                    </div>

                    <h6 class="red-text">شرایط کنسلی</h6>
                    <div class="reserve-information cancel-rules">
                        <div class="overflow-fix">
                            <?php echo $this->getCancelRuleString($details['cancelRules'], $details['checkIn'], $this->getFixedPrice($details['price']));?>
                        </div>
                    </div>

                    <div class="reserve-information reserve-basic-info">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="text-center">نوع اتاق</th>
                                <th>محل اقامت</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-center">
                                    <ol class="ltr">
                                        <?php foreach($details['services']['rooms'] as $room):?>
                                            <li><?php echo CHtml::encode($room['type'].' '.$room['category']);?> - <small><?php echo CHtml::encode($details['services']['meal']);?></small></li>
                                        <?php endforeach;?>
                                    </ol>
                                </td>
                                <td>
                                    <div class="hotel-details overflow-fix">
                                        <div class="col-lg-8 ltr">
                                            <b><?php echo CHtml::encode($hotelDetails['name']);?></b>
                                            <span class="stars overflow-fix">
                                                <?php for($i=1;$i<=5;$i++):?>
                                                    <?php if($i<=$hotelDetails['star']):?>
                                                        <div class="star"></div>
                                                    <?php else:?>
                                                        <div class="star off"></div>
                                                    <?php endif;?>
                                                <?php endfor;?>
                                            </span>
                                            <small><?php echo CHtml::encode($hotelDetails['city']);?></small>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="row">
                                                <img src="<?php echo CHtml::encode($hotelDetails['image']['original']);?>">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <h5 class="pull-right">
                        مبلغ قابل پرداخت:
                        <span class="red-text"><?php echo number_format($this->getFixedPrice($details['price']), 0);?></span>
                        <small class="red-text" style="margin-right: 10px;">تومان </small>
                    </h5>

                    <div class="input-field buttons col-md-3 pull-left bill-button">
                        <a href="<?php echo $this->createUrl('hotels/pay/'.$order->id);?>" class="btn waves-effect waves-light green lighten-1 col-md-12">پرداخت</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>