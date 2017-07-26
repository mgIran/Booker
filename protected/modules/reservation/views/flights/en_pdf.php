<?php
/* @var FlightsController $this */
/* @var BookingsFlight $booking */
/* @var array $passenger */
/* @var HTML2PDF $html2pdf */
/* @var integer $key */
$flights = CJSON::decode($booking->flights);
?>
<table style="text-align: right;font-size: 9pt;" cellpadding="5">
    <tr>
        <?php if(!isset($flights['return'])):?>
        <td><?php $html2pdf->pdf->Image('themes/frontend/images/logo.png', 5, 5, 29.2, 20, 'PNG');?></td>
        <td><?php $html2pdf->pdf->write2DBarcode($flights['oneWay']['ticketIds'][$key], 'QRCODE,H', 185, 5, 20, 20, [], 'N');?></td>
        <?php else:?>
            <td><?php $html2pdf->pdf->Image('themes/frontend/images/logo.png', 5, 5, 29.2, 20, 'PNG');?></td>
            <td style="font-size: 18pt;line-height: 3;">Booker 24</td>
        <?php endif;?>
    </tr>
    <tr>
        <td>National code: <?php echo $passenger['nationalId'];?></td>
        <td>Passenger Name: <?php echo strtoupper($passenger['nameEn'].' / '.$passenger['familyEn']);?></td>
    </tr>
    <tr>
        <td>Passport Num: <?php echo $passenger['passportNo'];?></td>
        <td>Issue Date: <?php echo date('Y/m/d', $booking->createdAt);?></td>
    </tr>
    <tr>
        <td colspan="2">
            <table>
                <tr>
                    <td style="background-color: #d9534f;text-align: left;color: #fff;line-height: 3;">Type: <?php echo $flights['oneWay']['type']=='charter'?'Charter':'System';?>&nbsp;&nbsp;&nbsp;</td>
                    <td style="background-color: #d9534f;text-align: left;color: #fff;line-height: 3;"></td>
                    <td style="font-size: 14pt;background-color: #d9534f;color: #fff;line-height: 2;">&nbsp;&nbsp;&nbsp;Departs Flight</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table border="1" cellpadding="10">
                            <tr>
                                <td>Flight Num: <?php echo $flights['oneWay']['legs'][0]['flightNumber'];?></td>
                                <td style="background-color: #F0F0F0;">Class: <?php echo $flights['oneWay']['legs'][0]['bookingCode'];?></td>
                                <td>Destination: <?php echo Airports::getFieldByIATA($flights['oneWay']['legs'][0]['destination'], 'city_en');?></td>
                                <td style="background-color: #F0F0F0;">Origin: <?php echo Airports::getFieldByIATA($flights['oneWay']['legs'][0]['origin'], 'city_en');?></td>
                            </tr>
                            <tr>
                                <td>Flight Time: <?php echo date('H:i',strtotime($flights['oneWay']['legs'][0]['departureTime']));?></td>
                                <td style="background-color: #F0F0F0;">Flight Date(Shamsi): <?php echo JalaliDate::date('Y/m/d',strtotime($flights['oneWay']['legs'][0]['departureTime']), false);?></td>
                                <td>Flight Date: <?php echo date('Y/m/d',strtotime($flights['oneWay']['legs'][0]['departureTime']));?></td>
                                <td style="background-color: #F0F0F0;">Flight Day: <?php echo date('l',strtotime($flights['oneWay']['legs'][0]['departureTime']));?></td>
                            </tr>
                            <tr>
                                <?php $oneWayPrice = 0;
                                foreach($flights['oneWay']['fares'] as $fare)
                                    $oneWayPrice += $fare['totalPrice'] * $fare['count'];
                                ?>
                                <td>Amount: <?php echo number_format($this->getFixedPrice($oneWayPrice, true, $flights['oneWay']['type'])['price']);?> Rial</td>
                                <td style="background-color: #F0F0F0;">Ticket Number: <?php echo $flights['oneWay']['ticketIds'][$key];?></td>
                                <td>PNR: <?php echo $flights['oneWay']['pnr'];?></td>
                                <td style="background-color: #F0F0F0;">Carrier: <?php echo $flights['oneWay']['legs'][0]['carrierName'];?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <?php if(isset($flights['return'])):?>
    <tr>
        <td colspan="2">
            <table>
                <tr>
                    <td style="background-color: #d9534f;text-align: left;color: #fff;line-height: 3;">نوع: <?php echo $flights['return']['type']=='charter'?'چارتری':'سیستمی';?>&nbsp;&nbsp;&nbsp;</td>
                    <td style="font-size: 14pt;background-color: #d9534f;color: #fff;line-height: 2;">&nbsp;&nbsp;&nbsp;Return Flight</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table border="1" cellpadding="10">
                            <tr>
                                <td>Flight Num: <?php echo $flights['return']['legs'][0]['flightNumber'];?></td>
                                <td style="background-color: #F0F0F0;">Class: <?php echo $flights['return']['legs'][0]['bookingCode'];?></td>
                                <td>Destination: <?php echo Airports::getFieldByIATA($flights['return']['legs'][0]['destination'], 'city_en');?></td>
                                <td style="background-color: #F0F0F0;">Origin: <?php echo Airports::getFieldByIATA($flights['return']['legs'][0]['origin'], 'city_en');?></td>
                            </tr>
                            <tr>
                                <td>Flight Time: <?php echo date('H:i',strtotime($flights['return']['legs'][0]['departureTime']));?></td>
                                <td style="background-color: #F0F0F0;">Flight Date(Shamsi): <?php echo JalaliDate::date('Y/m/d',strtotime($flights['return']['legs'][0]['departureTime']), false);?></td>
                                <td>Flight Date: <?php echo date('Y/m/d',strtotime($flights['return']['legs'][0]['departureTime']));?></td>
                                <td style="background-color: #F0F0F0;">Flight Day: <?php echo date('l',strtotime($flights['return']['legs'][0]['departureTime']));?></td>
                            </tr>
                            <tr>
                                <?php $returnPrice = 0;
                                foreach($flights['return']['fares'] as $fare)
                                    $returnPrice += $fare['totalPrice'] * $fare['count'];
                                ?>
                                <td>Amount: <?php echo number_format($this->getFixedPrice($returnPrice/10, true, $flights['return']['type'])['price']);?> تومان</td>
                                <td style="background-color: #F0F0F0;">Ticket Number: <?php echo $flights['return']['ticketIds'][$key];?></td>
                                <td>PNR: <?php echo $flights['return']['pnr'];?></td>
                                <td style="background-color: #F0F0F0;">Carrier: <?php echo $flights['return']['legs'][0]['carrierName'];?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <?php endif;?>
    <tr>
        <td colspan="2">
            <div style="line-height: 1.1;font-size: 8pt;">- Cancellation charges shall be as per airline rules. Service charge is applicable for issue, change, refund.</div>
            <div style="line-height: 1.1;font-size: 8pt;">- Date change charges as applicable.</div>

            <div style="line-height: 2;">E-Ticket Notice</div>
            <div style="line-height: 1.1;font-size: 8pt;">Carriage and other services provided by the carrier are subject to terms & conditions of carriage. These conditions may be obtained from the respective carrier.</div>
            <div style="line-height: 2;">Check-in Time</div>
            <div style="line-height: 1.1;font-size: 8pt;">We recommend the following minimum check-in time:- Domestic - 1 hour prior to departure. All other destinations (including USA) - 3 hours prior to departure.</div>
            <div style="line-height: 2;">Passport/Visa/Health</div>
            <div style="line-height: 1.1;font-size: 8pt;">Please ensure that you have all the required travel documents for your entire journey i.e., valid passport & necessary visas, and that you have had the recommended inoculations for your destination(s).</div>
            <div style="line-height: 2;">Reconfirmation of Flights</div>
            <div style="line-height: 1.1;font-size: 8pt;">Please reconfirm all flights at least 72 hours in advance directly with the airline concerned. Failure to do so could result in the cancellation of your reservation and possible 'no-show' charges.</div>
            <div style="line-height: 2;">Insurance</div>
            <div style="line-height: 1.1;font-size: 8pt;">We strongly recommend that you avail travel insurance for the entire journey.</div>
            <div style="line-height: 2;">Baggage</div>
            <div style="line-height: 1.1;font-size: 8pt;">Baggage info valid for adult and child</div>
        </td>
    </tr>
</table>