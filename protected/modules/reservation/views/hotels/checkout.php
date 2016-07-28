<?php
/* @var $this HotelsController */
/* @var $details array */
?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/bootstrap-nav-wizard.css');?>
<div class="container">
    <div class="content page-box hotel-details">
        <div class="steps">
            <ul class="nav nav-wizard">
                <li class="done col-lg-2"><a>جستجوی هتل</a></li>
                <li class="done col-lg-2"><a>انتخاب هتل</a></li>
                <li class="done col-lg-2"><a>انتخاب اتاق</a></li>
                <li class="active col-lg-2"><a>ورود اطلاعات</a></li>
                <li class="col-lg-2"><a>پرداخت</a></li>
                <li class="col-lg-2"><a>دریافت واچر</a></li>
            </ul>
        </div>
        <div id="checkout">
            <?php var_dump($details);?>
            <?php var_dump($details['services']['rooms']);?>
            <div class="card-panel">
                <h5 class="red-text">اطلاعات رزرو</h5>
                <div class="reserve-information">
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
                <h5 class="red-text">شرایط کنسلی</h5>
                <div class="reserve-information">
                    <div class="overflow-fix">
                        <?php echo $this->getCancelRuleString($details['cancelRules'], $details['checkIn'], $details['price']*5000);?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
