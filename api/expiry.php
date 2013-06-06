<?php

require_once '../include.php';

$exp = Auction::getExpiry($_POST['itemID']);
//print_r($exp);
if($exp['extended'] == 1){
	echo date('Y', $exp['auction_end']) ?>, <?php echo date('n', $exp['auction_end'])-1 ?>, <?php echo date('j', $exp['auction_end']) ?>, <?php echo date('G', $exp['auction_end']) ?>, <?php echo (int)date('i', $exp['auction_end']) ?>, <?php echo (int)date('s', $exp['auction_end']);
} else {
	echo '0';
}
?>