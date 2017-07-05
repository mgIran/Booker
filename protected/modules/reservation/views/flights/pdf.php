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
            <td style="font-size: 18pt;line-height: 3;">بوکر 24</td>
        <?php endif;?>
    </tr>
    <tr>
        <td>کد ملی: <?php echo $passenger['nationalId'];?></td>
        <td>نام مسافر: <?php echo $passenger['nameFa'].' '.$passenger['familyFa'].' ( '.strtoupper($passenger['nameEn'].' / '.$passenger['familyEn']).' )';?></td>
    </tr>
    <tr>
        <td></td>
        <td>تاریخ صدور: <?php echo JalaliDate::date('Y/m/d', $booking->createdAt, false);?></td>
    </tr>
    <tr>
        <td colspan="2">
            <table>
                <tr>
                    <td style="background-color: #d9534f;text-align: left;color: #fff;line-height: 3;">نوع: <?php echo $flights['oneWay']['type']=='charter'?'چارتری':'سیستمی';?>&nbsp;&nbsp;&nbsp;</td>
                    <td style="font-size: 14pt;background-color: #d9534f;color: #fff;line-height: 2;">&nbsp;&nbsp;&nbsp;پرواز رفت</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table border="1" cellpadding="10">
                            <tr>
                                <td>شماره پرواز: <?php echo $flights['oneWay']['legs'][0]['flightNumber'];?></td>
                                <td style="background-color: #F0F0F0;">شناسه نرخی: <?php echo $flights['oneWay']['legs'][0]['bookingCode'];?></td>
                                <td>مقصد: <?php echo Airports::getFieldByIATA($flights['oneWay']['legs'][0]['destination'], 'city_fa');?></td>
                                <td style="background-color: #F0F0F0;">مبدا: <?php echo Airports::getFieldByIATA($flights['oneWay']['legs'][0]['origin'], 'city_fa');?></td>
                            </tr>
                            <tr>
                                <td>ساعت پرواز: <?php echo date('H:i',strtotime($flights['oneWay']['legs'][0]['departureTime']));?></td>
                                <td style="background-color: #F0F0F0;">تاریخ شمسی پرواز: <?php echo JalaliDate::date('Y/m/d',strtotime($flights['oneWay']['legs'][0]['departureTime']), false);?></td>
                                <td>تاریخ میلادی پرواز: <?php echo date('Y/m/d',strtotime($flights['oneWay']['legs'][0]['departureTime']));?></td>
                                <td style="background-color: #F0F0F0;">روز پرواز: <?php echo JalaliDate::date('l',strtotime($flights['oneWay']['legs'][0]['departureTime']));?></td>
                            </tr>
                            <tr>
                                <?php $oneWayPrice = 0;
                                foreach($flights['oneWay']['fares'] as $fare)
                                    $oneWayPrice += $fare['totalPrice'] * $fare['count'];
                                ?>
                                <td>مبلغ قابل پرداخت: <?php echo number_format($this->getFixedPrice($oneWayPrice/10, true, $flights['oneWay']['type'])['price']);?> تومان</td>
                                <td style="background-color: #F0F0F0;">شماره بلیط: <?php echo $flights['oneWay']['ticketIds'][$key];?></td>
                                <td>رفرنس: <?php echo $flights['oneWay']['pnr'];?></td>
                                <td style="background-color: #F0F0F0;">خط هوایی: <?php echo $flights['oneWay']['legs'][0]['carrierName'];?></td>
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
                    <td style="font-size: 14pt;background-color: #d9534f;color: #fff;line-height: 2;">&nbsp;&nbsp;&nbsp;پرواز برگشت</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table border="1" cellpadding="10">
                            <tr>
                                <td>شماره پرواز: <?php echo $flights['return']['legs'][0]['flightNumber'];?></td>
                                <td style="background-color: #F0F0F0;">شناسه نرخی: <?php echo $flights['return']['legs'][0]['bookingCode'];?></td>
                                <td>مقصد: <?php echo Airports::getFieldByIATA($flights['return']['legs'][0]['destination'], 'city_fa');?></td>
                                <td style="background-color: #F0F0F0;">مبدا: <?php echo Airports::getFieldByIATA($flights['return']['legs'][0]['origin'], 'city_fa');?></td>
                            </tr>
                            <tr>
                                <td>ساعت پرواز: <?php echo date('H:i',strtotime($flights['return']['legs'][0]['departureTime']));?></td>
                                <td style="background-color: #F0F0F0;">تاریخ شمسی پرواز: <?php echo JalaliDate::date('Y/m/d',strtotime($flights['return']['legs'][0]['departureTime']), false);?></td>
                                <td>تاریخ میلادی پرواز: <?php echo date('Y/m/d',strtotime($flights['return']['legs'][0]['departureTime']));?></td>
                                <td style="background-color: #F0F0F0;">روز پرواز: <?php echo JalaliDate::date('l',strtotime($flights['return']['legs'][0]['departureTime']));?></td>
                            </tr>
                            <tr>
                                <?php $returnPrice = 0;
                                foreach($flights['return']['fares'] as $fare)
                                    $returnPrice += $fare['totalPrice'] * $fare['count'];
                                ?>
                                <td>مبلغ قابل پرداخت: <?php echo number_format($this->getFixedPrice($returnPrice/10, true, $flights['return']['type'])['price']);?> تومان</td>
                                <td style="background-color: #F0F0F0;">شماره بلیط: <?php echo $flights['return']['ticketIds'][$key];?></td>
                                <td>رفرنس: <?php echo $flights['return']['pnr'];?></td>
                                <td style="background-color: #F0F0F0;">خط هوایی: <?php echo $flights['return']['legs'][0]['carrierName'];?></td>
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
            <div style="line-height: 2;">رعایت موارد ذیل الزامی خواهد بود:</div>
            <div style="line-height: 1.1;font-size: 8pt;">- حضور مسافر در فرودگاه یک ساعت و نیم قبل از پرواز</div>
            <div style="line-height: 1.1;font-size: 8pt;">- ارائه کارت شناسایی عکس دار و معتبر جهت پذیرش بلیط و سوارشدن به هواپیما و استرداد بلیط</div>
            <div style="line-height: 1.1;font-size: 8pt;">- از قراردادن دوربین ، موبایل ، نوت بوک، اشیاء گرانبها و مدارک مهم در بسته های تحویلی به هواپیما خودداری فرمایید. بر اساس مقررات ، شرکت هواپیمایی در خصوص مفقود شدن موارد فوق هیچگونه مسئولیتی ندارد</div>

            <div style="line-height: 2;">شرایط کلی حمل مسافر و توشه پذیرش شده:</div>
            <div style="line-height: 1.1;font-size: 8pt;">بلیط الکترونیک: سند و توافق قراردادی فی مابین مسافر و شرکت حمل کننده می باشد و تبیین کننده حدود و مسئولیتهای قراردادی طرفین میباشد</div>
            <div style="line-height: 1.1;font-size: 8pt;">حمل: مترادف است با حمل و نقل هوائی</div>
            <div style="line-height: 1.1;font-size: 8pt;">حمل کننده: یعنی کلیه شرکتهای حمل کننده هوایی که طبق این شرایط عهده دار حمل مسافر یا توشه وی بوده وبا ارائه هرگونه خدمات دیگرمربوط به این نوع ترابری اقدام به حمل مسافر یا توشه وی می نماید</div>
            <div style="line-height: 1.1;font-size: 8pt;">توشه حمل شده به موجب این شرایط به ارایه دهنده رسید توشه تحویل می گردد.در صورت خسارت وارده به توشه پذیرش شده، بایستی شکایت کتبی بلفاصله پس از کشف خسارت و نهایتا ظرف مدت هفت روز پس از دریافت توشه پذیرش شده ودرصورت تاخیر در تحویل توشه پذیرش شده ،شکایت کتبی بایستی ظرف دوازده روز از تاریخ تحویل توشه پذیرش شده تسلیم شرکت حمل کننده گردد.مسئولیت شرکت حمل کننده در قبال فقدان ،تاخیر و خسارت جامه دان محدود به معادل ریالی بیست دلار به ازاء هر کیلوگرم توشه پذیرش شده می باشد. مگر اینکه تحویل دهنده توشه به متصدی حمل و نقل ارزش ویژه ای اظهار و به شرکت حمل کننده وجه اضافی پرداخت نموده باشد.</div>
            <div style="line-height: 1.1;font-size: 8pt;">شرکت حمل کننده در قبال کالای شکستنی ، با ارزش و فاسد شدنی هیچ گونه مسئولیتی را تقبل نمی نماید. این بلیط از تاریخ صدور بمدت یکسال اعتباردارد، مگراینکه شرایط خاص دیگری توسط شرکت حمل کننده مقرر و اعلم گردد.کرایه حمل طبق این شرایط تا قبل از شروع عملیات حمل قابل تغییر است .درصورت عدم پرداخت کرایه مقرر، شرکت حمل کننده می تواند ازانجام حمل خودداری نماید.</div>
            <div style="line-height: 1.1;font-size: 8pt;">شرکت حمل کننده می تواند بدون اطلاع ، اقدام به تعویض شرکتهای حمل کننده یا هواپیما ، و در صورت لزوم اقدام به تغییر و یا حذف نقاط توقف مندرج دراین بلیط نماید . برنامه های پروازی بدون اطلاع قبلی قابل تغییر می باشند.</div>
            <div style="line-height: 1.1;font-size: 8pt;">بلیط مسافر غیر قابل انتقال می باشد و مسافر با خرید و ارائه آن تمام شرایط قرارداد را بدون استثناء قبول نموده است.</div>
            <div style="line-height: 1.1;font-size: 8pt;color: #d9534f;">-  حضور مسافر برای پرواز داخلی 2 ساعت و خارجی 3 ساعت قبل در فرودگاه الزامیست کانتر کنترل 30 دقیقه قبل پروازداخلی و90 دقیقه قبل پرواز خارجی بسته خواهد شد</div>
            <div style="line-height: 1.1;font-size: 8pt;color: #d9534f;">- تغییر نام و یا انتقال به غیر مجاز نمی باشد</div>
            <div style="line-height: 1.1;font-size: 8pt;color: #d9534f;"> -پرواز های داخلی شرکت های ایران ایر معراج اتا ایرتورنفت وقشم از ترمینال 2 مهرآباد و زاگرس کیش ایر از ترمینال 1 ودیگرشرکتها از ترمینال 4 انجام می شود</div>
            <div style="line-height: 1.5;text-align: center;">لطفا توجه فرمایید! در صورت هرگونه دستکاری یا فروش با نرخی بیش از نرخ مصوب موضوع از طریق مراجع قضایی پیگیری خواهد شد.</div>
        </td>
    </tr>
</table>