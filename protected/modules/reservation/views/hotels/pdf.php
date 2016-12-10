<?php
/* @var $booking Bookings */
$confirmationDetails=CJSON::decode($booking->confirmationDetails);
$cancelRules=CJSON::decode($booking->cancelRules);
?>
<page>
    <div style="width: 50%;height: 70px;position:absolute;top:0;left: 0;">
        <img src="<?php echo Yii::app()->createAbsoluteUrl('/').'/themes/frontend/images/logo.png'?>" style="height:80px;display: block;">
    </div>
    <div style="width: 50%;position:absolute;right: 0;text-align: right;">
        <qrcode value="Booking ID:<?php echo CHtml::encode($confirmationDetails[0]['confirmNumber'])?>-Hotel Name:<?php echo CHtml::encode($booking->hotel)?>-CheckIn:<?php echo CHtml::encode($booking->checkIn)?>-CheckOut:<?php echo CHtml::encode($booking->checkOut)?>-Passengers:<?php echo CHtml::encode($booking->passenger)?>-Meal:<?php echo CHtml::encode($booking->meal)?>-Order ID:<?php echo CHtml::encode($booking->orderId)?>" ec="H" style="height: 80px;"></qrcode>
    </div>
    <h2 style="text-align: center;position:relative;top: 0;width: 100%;height: 25px;">Hotel Voucher</h2>
    <div style="background: #fafafa;position:relative;font-size: 12px;margin-top: 30px;">
        <div style="margin: 50px;">
            <table>
                <tr>
                    <td>
                        <h4 style="margin: 0 0 5px;"><?php echo CHtml::encode($booking->hotel);?>
                            <span>
                                <?php for($i=1;$i<=3;$i++):?>
                                    <img src="<?php echo Yii::app()->createAbsoluteUrl('/').'/themes/frontend/images/star.png'?>" style="width: 10px;">
                                <?php endfor;?>
                            </span>
                        </h4>
                        <div style="font-size: 11px;margin-bottom: 4px;"><?php echo CHtml::encode($booking->country.' - '.$booking->city);?></div>
                        <table style="margin-top: 15px;">
                            <tr>
                            <td style="border-left: 2px solid #d9534f;padding: 0 30px 0 10px;">
                                <p style="margin: 0 0 8px;">Check-in from:</p>
                                <span style="font-weight: lighter;font-size: 16px;"><?php echo CHtml::encode($booking->checkIn.' - '.$booking->checkinFrom);?></span>
                            </td>
                            <td style="border-left: 2px solid #d9534f;padding: 0 30px 0 10px;">
                                <p style="margin: 0 0 8px;">Check-out until:</p>
                                <span style="font-weight: lighter;font-size: 16px;"><?php echo CHtml::encode($booking->checkOut.' - '.$booking->checkoutTo);?></span>
                            </td>
                            </tr>
                        </table>
                    </td>
                    <td style="padding-left: 35px;">
                        <h5 style="margin: 15px 0 5px;">Issue date</h5>
                        <span style="margin: 0;"><?php echo CHtml::encode($booking->createdAt);?></span>
                        <h5 style="margin: 15px 0 5px;">Order ID</h5>
                        <span style="margin: 0;"><?php echo CHtml::encode($booking->orderId);?></span>
                    </td>
                </tr>
            </table>
            <div style="height: 2px;background: #ccc;margin-bottom: 15px;"></div>
            <h4 style="margin-top: 0;">Confirmation Details</h4>
            <table cellspacing="0">
                <tr>
                    <td style="padding: 15px;background: #d9534f;color:#fff;font-weight: bold;">Passenger name</td>
                    <td style="padding: 15px;background: #d9534f;color:#fff;font-weight: bold;">Nationality</td>
                    <td style="padding: 15px;background: #d9534f;color:#fff;font-weight: bold;">Room</td>
                </tr>
                <?php $confirmNumber='';foreach($confirmationDetails as $confirmationDetail):$i=0;?>
                    <?php foreach($confirmationDetail['name'] as $passengerName):?>
                        <?php $confirmNumber=$confirmationDetail['confirmNumber'];?>
                        <tr>
                            <td style="border-left: 1px solid #ccc;border-bottom: 1px solid #ccc;padding: 15px;"><?php echo CHtml::encode($passengerName);?></td>
                            <td style="border-bottom: 1px solid #ccc;padding: 15px;"><?php echo CHtml::encode($booking->nationality);?></td>
                            <td style="border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;padding: 15px;">
                                <?php foreach($confirmationDetail['rooms'] as $room):?>
                                    <?php echo CHtml::encode($room['description'].' - Type:'.$room['type']);?>
                                <?php endforeach;?>
                            </td>
                        </tr>
                    <?php $i++;endforeach;?>
                <?php endforeach;?>
                <tr>
                    <td style="text-align:center;border-right: 1px solid #ccc;border-left: 1px solid #ccc;border-bottom: 1px solid #ccc;padding: 15px;font-size: 16px;font-weight:bold;color: #d9534f;" colspan="3">Booking ID: <?php echo CHtml::encode($confirmNumber);?></td>
                </tr>
            </table>
            <div style="height: 2px;background: #ccc;margin: 15px 0;"></div>
            <h4 style="margin-top: 0;">Summery</h4>
            <?php
            $stayTime=floor((strtotime($booking->checkOut)-strtotime($booking->checkIn))/(60*60*24));
            if($stayTime < 0)
                $stayTime=0;
            ?>
            <table cellspacing="0">
                <tr>
                    <td style="padding: 15px;background: #d9534f;color:#fff;font-weight: bold;">Nights</td>
                    <td style="padding: 15px;background: #d9534f;color:#fff;font-weight: bold;">Passengers</td>
                    <td style="padding: 15px;background: #d9534f;color:#fff;font-weight: bold;">Adults</td>
                    <td style="padding: 15px;background: #d9534f;color:#fff;font-weight: bold;">Children</td>
                    <td style="padding: 15px;background: #d9534f;color:#fff;font-weight: bold;">Meal</td>
                </tr>
                <tr>
                    <td style="border-left: 1px solid #ccc;border-bottom: 1px solid #ccc;padding: 15px;"><?php echo CHtml::encode($stayTime);?></td>
                    <td style="border-bottom: 1px solid #ccc;padding: 15px;"><?php echo CHtml::encode($booking->passenger);?></td>
                    <td style="border-bottom: 1px solid #ccc;padding: 15px;"><?php echo CHtml::encode($booking->getPassengersCount('adult'));?></td>
                    <td style="border-bottom: 1px solid #ccc;padding: 15px;"><?php echo CHtml::encode($booking->getPassengersCount('child'));?></td>
                    <td style="border-right: 1px solid #ccc;border-bottom: 1px solid #ccc;padding: 15px;"><?php echo CHtml::encode($booking->meal);?></td>
                </tr>
            </table>
            <div style="height: 2px;background: #ccc;margin: 15px 0;"></div>
            <h4 style="margin-top: 0;">Terms of cancellation</h4>
            <ul style="padding: 0;">
                <?php foreach($cancelRules as $cancelRule):?>
                    <li>Cancelling From <?php echo date('Y-m-d',(strtotime($booking->checkIn)-$cancelRule['remainDays']*60*60*24));?> To <?php echo CHtml::encode($booking->checkIn);?> has a cancellation penalty of <?php echo $cancelRule['ratio']*100;?>% of the price.</li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
    <page_footer>
    <div style="margin-top: 10px;border-top: 1px solid #ccc;padding: 20px 20px 0;font-size: 12px;color: #999;">
        <table>
            <tr>
                <td style="padding: 0 40px 0 0;vertical-align: middle;">Site: Booker24.net</td>
                <td style="padding: 0 40px 0 40px;vertical-align: middle;">Email: info@booker24.net</td>
                <td style="padding: 0 0 0 40px;vertical-align: middle;">Phone: +984533243543</td>
                <td style="padding: 0 0 0 140px;text-align: right;">
                    <img src="<?php echo Yii::app()->createAbsoluteUrl('/').'/themes/frontend/images/logo-gray.png'?>" style="height:30px;opacity:0.6;">
                </td>
            </tr>
        </table>
    </div>
    </page_footer>
</page>
<page>
    <div style="width: 50%;height: 70px;position:absolute;top:0;left: 0;">
        <img src="<?php echo Yii::app()->createAbsoluteUrl('/').'/themes/frontend/images/logo.png'?>" style="height:80px;display: block;">
    </div>
    <div style="width: 50%;position:absolute;right: 0;text-align: right;">
        <qrcode value="Booking ID:<?php echo CHtml::encode($confirmationDetails[0]['confirmNumber'])?>-Hotel Name:<?php echo CHtml::encode($booking->hotel)?>-CheckIn:<?php echo CHtml::encode($booking->checkIn)?>-CheckOut:<?php echo CHtml::encode($booking->checkOut)?>-Passengers:<?php echo CHtml::encode($booking->passenger)?>-Meal:<?php echo CHtml::encode($booking->meal)?>-Order ID:<?php echo CHtml::encode($booking->orderId)?>" ec="H" style="height: 80px;"></qrcode>
    </div>
    <h2 style="text-align: center;position:relative;top: 0;width: 100%;height: 25px;">Hotel Voucher</h2>
    <div style="background: #fafafa;position:relative;font-size: 12px;margin-top: 30px;">
        <div style="margin: 50px;">
            <h4 style="margin-top: 0;">Address</h4>
            <table>
                <tr>
                    <td><?php echo CHtml::encode($booking->address);?></td>
                    <td style="padding-right:20px;"><?php echo CHtml::encode('ZIP Code:'.$booking->zipCode);?></td>
                    <td style="padding-right:20px;"><?php echo CHtml::encode('Phone:'.$booking->phone);?></td>
                </tr>
            </table>
            <div style="text-align: center;">
                <img style="margin-top:10px;border: 1px solid #ccc;max-width: 100%;" src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo CHtml::encode($booking->latitude.','.$booking->longitude);?>&zoom=15&size=640x250&markers=color:red%7C<?php echo CHtml::encode($booking->latitude.','.$booking->longitude);?>&maptype=roadmap&key=AIzaSyBRyQvsBFWct4YvtN547f3ljpovifqgGYQ">
            </div>
            <div style="height: 2px;background: #ccc;margin: 15px 0;"></div>
            <h4 style="margin-top: 0;color: #d9534f;">Important</h4>
            <ul style="padding: 0;">
                <li>Early check-in will not be accommodated unless there is prearrangement. Early check-out will not follow refund policy. Late check-out may include additional charges, based on hotel policies.</li>
                <li>Unless otherwise indicated, all rooms all guaranteed on the day of arrival. In case of No-show, youe room(s) will be released and you will be subject to the terms and conditions of the cancellation policy specified in the confirmation booking e-mail or contact.</li>
                <li>The total price for this booking does`nt include mini-bar items, telephone usage, laundry service, etc. If applicable, the hotel will bill you directly.</li>
            </ul>
        </div>
    </div>
    <page_footer>
        <div style="margin-top: 10px;border-top: 1px solid #ccc;padding: 20px 20px 0;font-size: 12px;color: #999;">
            <table>
                <tr>
                    <td style="padding: 0 40px 0 0;vertical-align: middle;">Site: Booker24.net</td>
                    <td style="padding: 0 40px 0 40px;vertical-align: middle;">Email: info@booker24.net</td>
                    <td style="padding: 0 0 0 40px;vertical-align: middle;">Phone: +984533243543</td>
                    <td style="padding: 0 0 0 140px;text-align: right;">
                        <img src="<?php echo Yii::app()->createAbsoluteUrl('/').'/themes/frontend/images/logo-gray.png'?>" style="height:30px;opacity:0.6;">
                    </td>
                </tr>
            </table>
        </div>
    </page_footer>
</page>