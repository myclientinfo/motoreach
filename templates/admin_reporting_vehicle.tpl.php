<style>table.reporting {	margin: 0px auto;	}table.reporting td {	padding: 3px;}#admin_dates {	width: 400px;	margin: 0px auto;	margin-bottom: 15px;}#admin_dates label {	width: 40px;}#admin_dates #from_date, #admin_dates #to_date {	width: 100px;}#admin_dates #go {	margin-left: 10px;}</style><div id="inner_content_white">	<h2>Vehicle - <?php echo $data['vehicle']?></h2>		<a href="/admin/">Admin Home</a> :: <a href="/admin/reporting/">Reporting Home</a><br /><br />		Listed by <?php echo $data['fullname']?> at <a href="activity.php?id=<?php echo $data['userID']?>"><?php echo $data['dealership_name']?></a><br><br>		Listed from <?php echo date(DAY_MONTH_YEAR, $data['dateentered'])?><br>	Listed until <?php echo date(DAY_MONTH_YEAR, $data['auction_end'])?><br>	Requests <?php echo $stats['requests']?><br>	Sent to <?php echo count($log)?> dealers<br>		<?php//$GLOBALS['debug']->printr($data);//$GLOBALS['debug']->printr($stats);//$GLOBALS['debug']->printr($log);?>		</div>