<?php 

if(is_array($content) && !empty($content)){
	//echo '<!--'.json_encode($content[0]).'-->';
	
	//ob_start();
	foreach($content as $key => $v){ 
	//print_r();
	?>
<tr<?php echo isset($type) && $type== 'placebid'?' class="temp"':''?>>
	<td><?php echo $v['type'] ?></td>
	<td><b><a href="/items.php?itemID=<?php echo $v['itemID']?>"><?php echo $v['year']?> <?php echo $v['make']?> <?php echo $v['model']?> <?php echo $v['badge']?></a></b></td>
    <td><?php if($v['type'] != 'Extend'){ ?><span<?php echo $v['userID'] == $_SESSION['auction']->user->ID ?' style="font-weight:bold"':''?>>$<?php echo number_format($v['amount'])?></span><?php } ?></td>
	<td><?php echo date(DATE_TIME, $v['datesubmitted']) ?></td>
</tr>
<?php 

	
	}
	//$content = ob_get_clean();
}

//echo $content;
?>