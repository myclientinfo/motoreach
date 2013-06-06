

<div id="inner_content_blue">
<h2>Add Credit</h2>

<?php
echo Site::drawForm('credit_add');
echo Site::drawSelect('amount', array(3000=>'$30',5000=>'$50', 8000=>'$80', 10000=>'$100', 15000=>'$150', 20000=>'$200'), false, false, true);
echo Site::drawSubmitImage('submit_credit', '/images/button_credit.png');
echo Site::drawForm();
?>
<br><br>
</div>