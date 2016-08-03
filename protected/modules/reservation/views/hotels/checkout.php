<?php
/* @var $this HotelsController */
/* @var $orderModel Order */
/* @var $passengersModel Passengers */
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
                        <li class="red-text">پر کردن همه فیلد ها الزامی است.</li>
                    </ul>

                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'order-create-form',
                        'enableAjaxValidation'=>true,
                        'htmlOptions'=>array(
                            'class'=>'overflow-fix'
                        )
                    )); ?>

                    <?php echo $form->errorSummary($orderModel); ?>

                    <div class="buyer-info overflow-fix">

                        <div class="input-field col-md-6">
                            <?php echo $form->textField($orderModel,'buyer_name'); ?>
                            <?php echo $form->labelEx($orderModel,'buyer_name'); ?>
                            <?php echo $form->error($orderModel,'buyer_name'); ?>
                        </div>

                        <div class="input-field col-md-6">
                            <?php echo $form->textField($orderModel,'buyer_family'); ?>
                            <?php echo $form->labelEx($orderModel,'buyer_family'); ?>
                            <?php echo $form->error($orderModel,'buyer_family'); ?>
                        </div>

                        <div class="input-field col-md-6">
                            <?php echo $form->textField($orderModel,'buyer_mobile'); ?>
                            <?php echo $form->labelEx($orderModel,'buyer_mobile'); ?>
                            <?php echo $form->error($orderModel,'buyer_mobile'); ?>
                        </div>

                        <div class="input-field col-md-6">
                            <?php echo $form->textField($orderModel,'buyer_email'); ?>
                            <?php echo $form->labelEx($orderModel,'buyer_email'); ?>
                            <?php echo $form->error($orderModel,'buyer_email'); ?>
                        </div>

                    </div>

                    <div class="room-passengers">

                        <h5 class="red-text">اطلاعات مسافران</h5>
                        <ul>
                            <li>این اطلاعات مربوط به مسافران است؛ افرادی که واچر به نام آنها صادر می شود.</li>
                            <li>اطلاعات را به انگلیسی و مطابق با گذرنامه پر کنید. هنگام ورود به هتل، اطلاعات واچر با گذرنامه مطابقت داده خواهد شد.</li>
                        </ul>

                        <?php foreach($details['services']['rooms'] as $key=>$room):?>
                            <div class="room-item overflow-fix">
                                <div class="container-fluid">
                                    <h6 class="col-md-1 room-label">اتاق <b><?php echo $this->parseNumbers(($key+1));?></b></h6>
                                    <div class="col-md-11 room-type"><b><?php echo CHtml::encode($room['type'].' '.$room['category']);?></b> <small><?php echo CHtml::encode($details['services']['meal']);?></small></div>
                                </div>
                                <?php for($i=1;$i<=$room['adult'];$i++):?>
                                    <div class="container-fluid passenger-item">
                                        <div class="passenger-type green-text col-md-1">بزرگسال<br><small>بالای 12 سال</small><i class="arrow"></i></div>
                                        <div class="col-md-11 fields">
                                            <div class="input-field col-md-3">
                                                <?php echo CHtml::textField('Passengers[room_'.($key+1).']['.$i.'][name]', '', array('id'=>'Passengers_room_'.($key+1).'_'.$i.'_name','maxlength'=>50)); ?>
                                                <?php echo CHtml::label('نام','Passengers_room_'.($key+1).'_'.$i.'_name'); ?>
                                            </div>
                                            <div class="input-field col-md-3">
                                                <?php echo CHtml::textField('Passengers[room_'.($key+1).']['.$i.'][family]', '', array('id'=>'Passengers_room_'.($key+1).'_'.$i.'_family','maxlength'=>50)); ?>
                                                <?php echo CHtml::label('نام خانوادگی','Passengers_room_'.($key+1).'_'.$i.'_family'); ?>
                                            </div>
                                            <div class="input-field col-md-3">
                                                <?php echo CHtml::textField('Passengers[room_'.($key+1).']['.$i.'][passport_num]', '', array('id'=>'Passengers_room_'.($key+1).'_'.$i.'_passport_num','maxlength'=>50)); ?>
                                                <?php echo CHtml::label('شماره گذرنامه','Passengers_room_'.($key+1).'_'.$i.'_passport_num'); ?>
                                            </div>
                                            <div class="col-md-3">
                                                <?php echo CHtml::label('جنسیت','',array('class'=>'gender-label')); ?>

                                                <?php echo CHtml::radioButton('Passengers[room_'.($key+1).']['.$i.'][gender]', false, array('id'=>'Passengers_room_'.($key+1).'_'.$i.'_male','value'=>'male','class'=>'with-gap')); ?>
                                                <?php echo CHtml::label('مرد','Passengers_room_'.($key+1).'_'.$i.'_male'); ?>

                                                <?php echo CHtml::radioButton('Passengers[room_'.($key+1).']['.$i.'][gender]', false, array('id'=>'Passengers_room_'.($key+1).'_'.$i.'_female','value'=>'female','class'=>'with-gap')); ?>
                                                <?php echo CHtml::label('زن','Passengers_room_'.($key+1).'_'.$i.'_female'); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endfor;?>
                                <?php for($i=1;$i<=$room['child'];$i++):?>
                                    <div class="container-fluid passenger-item">
                                        <div class="passenger-type green-text col-md-1">کودک<br><small>زیر 12 سال</small><i class="arrow"></i></div>
                                        <div class="col-md-11 fields">
                                            <div class="input-field col-md-3">
                                                <?php echo CHtml::textField('Passengers[room_'.($key+1).']['.$i.'][name]', '', array('id'=>'Passengers_room_'.($key+1).'_'.$i.'_name','maxlength'=>50)); ?>
                                                <?php echo CHtml::label('نام','Passengers_room_'.($key+1).'_'.$i.'_name'); ?>
                                            </div>
                                            <div class="input-field col-md-3">
                                                <?php echo CHtml::textField('Passengers[room_'.($key+1).']['.$i.'][family]', '', array('id'=>'Passengers_room_'.($key+1).'_'.$i.'_family','maxlength'=>50)); ?>
                                                <?php echo CHtml::label('نام خانوادگی','Passengers_room_'.($key+1).'_'.$i.'_family'); ?>
                                            </div>
                                            <div class="input-field col-md-3">
                                                <?php echo CHtml::textField('Passengers[room_'.($key+1).']['.$i.'][passport_num]', '', array('id'=>'Passengers_room_'.($key+1).'_'.$i.'_passport_num','maxlength'=>50)); ?>
                                                <?php echo CHtml::label('شماره گذرنامه','Passengers_room_'.($key+1).'_'.$i.'_passport_num'); ?>
                                            </div>
                                            <div class="col-md-3">
                                                <?php echo CHtml::label('جنسیت','',array('class'=>'gender-label')); ?>

                                                <?php echo CHtml::radioButton('Passengers[room_'.($key+1).']['.$i.'][gender]', false, array('id'=>'Passengers_room_'.($key+1).'_'.$i.'_male','value'=>'male','class'=>'with-gap')); ?>
                                                <?php echo CHtml::label('مرد','Passengers_room_'.($key+1).'_'.$i.'_male'); ?>

                                                <?php echo CHtml::radioButton('Passengers[room_'.($key+1).']['.$i.'][gender]', false, array('id'=>'Passengers_room_'.($key+1).'_'.$i.'_female','value'=>'female','class'=>'with-gap')); ?>
                                                <?php echo CHtml::label('زن','Passengers_room_'.($key+1).'_'.$i.'_female'); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endfor;?>
                            </div>
                        <?php endforeach;?>
                    </div>

                    <div class="pull-right terms-check">
                        <input type="checkbox" class="filled-in" id="filled-in-box" />
                        <label for="filled-in-box"><a href="#">شرایط خرید</a> را خوانده ام و با آنها موافقم.</label>
                    </div>

                    <div class="input-field buttons col-md-3 pull-left">
                        <?php echo CHtml::tag('button', array('class'=>'btn waves-effect waves-light green lighten-1 col-md-12', 'id'=>'search', 'type'=>'submit'), 'پرداخت');?>
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
