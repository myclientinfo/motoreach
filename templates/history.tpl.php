<?php 

$user_id = $_SESSION['auction']->user->ID;


$is_items_page = $_SERVER['PHP_SELF']=='/items.php' ? true : false;


if(is_array($content) && !empty($content)){
	foreach($content as $key => $v){ 
	?>
<tr>
	<td><?php echo $v['type'];
	if($v['type'] == 'Bid'){
		echo  $v['bidder'] == $user_id? ' Entered' : ' Received';
	}
	?></td>
	<td><b><a href="/items.php?itemID=<?php echo $v['itemID']?>"><?php echo $v['year']?> <?php echo $v['make']?> <?php echo $v['model']?> <?php echo $v['badge']?></a></b></td>
	<td><span<?php echo $v['bidder'] == $user_id && $v['type'] == 'Bid Entered'  ?' style="font-weight:bold"':''?>>$<?php echo number_format($v['amount'])?></span></td>
	<td><?php echo date(DATE_TIME, $v['datesubmitted']) ?></td>
</tr>
<?php 
	}
} else {
?>
<tr>
	<td colspan="4">No results in this category</td>
</tr>
<?php	
}
?>