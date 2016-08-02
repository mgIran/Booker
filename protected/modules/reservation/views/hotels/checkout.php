<?php
/* @var $this HotelsController */
/* @var $model Order */
/* @var $availability boolean */
/* @var $hotelDetails array */
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
        <?php if($availability):?>
            <div id="checkout">
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
                    <div class="reserve-information cancel-rules">
                        <div class="overflow-fix">
                            <?php echo $this->getCancelRuleString($details['cancelRules'], $details['checkIn'], $details['price']*5000);?>
                        </div>
                    </div>
                    <div class="reserve-information reserve-basic-info">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 hotel-details">
                                <h5 class="red-text">محل اقامت</h5>
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
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <h5 class="red-text">نوع اتاق</h5>
                                <ol class="ltr">
                                    <?php foreach($details['services']['rooms'] as $room):?>
                                        <li><?php echo CHtml::encode($room['type'].' '.$room['category']);?> - <small><?php echo CHtml::encode($details['services']['meal']);?></small></li>
                                    <?php endforeach;?>
                                </ol>
                                <h5 class="red-text">قیمت</h5>
                                <h5 class="ltr blue-text text-darken-2 overflow-fix">
                                    <small class="blue-text text-darken-2 pull-left" style="margin-right: 10px;">تومان </small>
                                    <span class="pull-left"><?php echo number_format($details['price']*5000, 0);?></span>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-panel passengers-info">
                    <h5 class="red-text">اطلاعات خریدار</h5>
                    <ul>
                        <li>این اطلاعات مربوط به شماست که فرآیند خرید را انجام می دهید.</li>
                        <li>تیم پشتیبانی بوکر 24 در صورت نیاز از طریق اطلاعات وارد شده در این قسمت با شما تماس خواهد گرفت.</li>
                        <li class="red-text">لطفا همه اطلاعات را به زبان انگلیسی وارد کنید.</li>
                        <li class="red-text">فیلدهای ستاره دار اجباری هستند.</li>
                    </ul>
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'order-create-form',
                        'enableAjaxValidation'=>true,
                    )); ?>

                    <?php echo $form->errorSummary($model); ?>

                    <div class="input-field">
                        <?php echo $form->textField($model,'buyer_name'); ?>
                        <?php echo $form->labelEx($model,'buyer_name'); ?>
                        <?php echo $form->error($model,'buyer_name'); ?>
                    </div>

                    <div class="input-field">
                        <?php echo $form->textField($model,'buyer_family'); ?>
                        <?php echo $form->labelEx($model,'buyer_family'); ?>
                        <?php echo $form->error($model,'buyer_family'); ?>
                    </div>

                    <div class="input-field">
                        <?php echo $form->textField($model,'buyer_mobile'); ?>
                        <?php echo $form->labelEx($model,'buyer_mobile'); ?>
                        <?php echo $form->error($model,'buyer_mobile'); ?>
                    </div>

                    <div class="input-field">
                        <?php echo $form->textField($model,'buyer_email'); ?>
                        <?php echo $form->labelEx($model,'buyer_email'); ?>
                        <?php echo $form->error($model,'buyer_email'); ?>
                    </div>

                    <div class="input-field buttons">
                        <?php echo CHtml::submitButton('Submit'); ?>
                    </div>

                    <?php $this->endWidget(); ?>
                </div>
            </div>
        <?php else:?>
            <div id="checkout">
                <div class="card-panel">
                    <h5>کاربر گرامی</h5>
                    <p>متاسفانه اتاق مورد نظر شما در این مدت، توسط فرد دیگری رزرو شده است.</p>
                    <p>می‌توانید برای انتخاب اتاق دیگری از همین هتل به <a onclick="window.history.back()" href="#">صفحه قبلی</a> و برای انتخاب هتلی دیگر به <a href="<?php echo $this->createUrl('/site')?>">صفحه جستجو</a> برگردید.</p>
                </div>
            </div>
        <?php endif;?>
    </div>
</div>
