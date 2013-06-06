
		<h2>Placing a Bid</h2>
		<p id="breadcrumb"><a href="index.php">Silent Auction</a> :: 
			<a href="categories.php?categoryID=<?php echo $category->ID ?>"><?php echo $category->name ?></a> ::
			<a href="items.php?itemID=<?php echo $item->ID ?>"><?php echo $item->name ?></a></p>
			
		<?php if( ($authorised == "valid") AND ($submitted == FALSE) AND ($itemokay == true)){ ?>
		
			<p>Please review and confirm your bid.</p>
			
			<p id="message"><?php echo $message ?></p>
			
			<form name="placebid" method="post" action="placebid.php">
			<input type="hidden" name="itemID" value="<?php echo $item->ID ?>" />
			<!-- <input type="hidden" name="debug" value="1" /> -->
			<input type="hidden" name="formdata" value="bid" />
			<table>
				<tr><th width="120px">Current price</th><td><?php echo $item->getCurrentPrice() ?></td></tr>
				<tr><th width="120px">Your bid</th><td><b><?php echo $bidamount ?></b></td></tr>
				<tr>
					<td colspan="2">
						By clicking on the button below, you commit to buy this item from <?php echo $COMPANY_NAME ?> if you're the winning bidder.<br /><br />
						To leave this page without placing a bid, return to the <a href="items.php?itemID=<?php echo $item->ID ?>"><?php echo $item->name ?></a> item listing page or navigate to another page on the site.<br /><br />
						<input type="submit" value="Confirm Bid" />
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<b>You are agreeing to a contract</b> -- You will enter into a legally binding contract 
						to purchase the item from <?php echo $COMPANY_NAME ?> if you're the winning bidder. 
						You are responsible for reading the full item listing, including Operation USA's 
						instructions and accepted payment methods. <?php echo $COMPANY_NAME ?> assumes all responsibility 
						for listing this item.
					</td>
				</tr>
			</table>
		<?php } elseif ($submitted == TRUE){ ?>
			<p id="message"><?php echo $message ?></p>
			<p>Please do NOT refresh this page, or your bid will be duplicated.</p>
			<p>You are welcome to continue browsing and bidding. 
				We also invite to <a href="submititem.php">contribute</a> your own items for auction.</p>
		<?php } elseif ($itemokay == false){ ?>
			<p id="message">You cannot place a bid on an item you are selling!</p>
		<?php } elseif ($authorised != true){ ?>
			<p id="message">You cannot place a bid unless you are <a href="loging.php">logged in</a>.</p>
		<?php } ?>					
	