<?php
/* @var $this HotelsController */
/* @var $bankResponse array */
?>
<style>body{background: #fff;}</style>
<div style="margin: 200px auto;width: 40%;color: #333;text-align: center;">
    <h4>در حال انتقال به درگاه پرداخت</h4>
    <h5 style="margin-top: 30px;">لطفا شکیبا باشید...</h5>
</div>
<form id="kicapeyment" action="https://ikc.shaparak.ir/tpayment/payment/Index" method="POST">
    <input type="hidden" name="token" value="<?php echo $bankResponse['MakeTokenResult']['token']; ?>">
    <input type="hidden" name="merchantId" value="B0E2">
</form>
<script>document.forms["kicapeyment"].submit()</script>