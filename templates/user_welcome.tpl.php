	<script>
		var user_state = "<?php echo @$_SESSION['auction']->user->state ?>";
		jQuery(document).ready(function(){
			
			$('#add').click(function(e){
				e.preventDefault();
				
				$.post("/api/add_pref.php", $('#add_prefs').serialize(), function(data){
					get_prefs();
				});
				
				//get_prefs();
			});
			
			get_prefs();
			
		});
		
		</script>
		
<style>
.year {width: 40px; margin-right: 2px;}
.range {width: 20px; margin-left: 5px;}
.mileage {width: 50px; margin-left: 5px;}
label {margin-left: 10px; width: 95px; display: inline-block; height: 26px; margin-top: 3px;}
#from_year {margin-left: 5px;}
#matches {}
#match_outer {width: 385px; float: right;}



#matches ul {margin-left: 20px;	margin-top: 10px; list-style-type:disc; margin-bottom: 10px;}
.li_del {float: right; }
.alert {background-color: #FFC; border: 1px solid #cccccc; margin-right: 20px; margin-bottom: 20px; padding: 10px;}
.alert p { margin-bottom: 0px; }
#vehicle_matches {width: 95%; margin: 0px auto;}
#add_prefs {padding: 15px; background-color: #ebebeb; border: 1px solid #000000; width: 400px; float: left; margin-right: 20px; position: relative;}
#match_text_description {background-color: white; margin: 0px; padding: 5px; border: 1px solid #999999; margin-bottom: 5px;}

#make_model_box {
	position: relative;
	width: 202px;
	float: left;
	display: inline-block;
	margin: 0px 10px;
}

#model_id {
	display: none;
}

span.text {color:#FF7F00; font-size: 18px; float: left;}

#inc_box label {margin: 0px;}

</style>
		

<div id="inner_content_white">
	
	<?php if(User::hasPermission('Match')){ ?>
	<h2>Define your Interests</h2>
	
	<p>You will now receive an email about all of the vehicles that are listed for wholesale on MotoReach. If there are vehicles you do not want to see or locations you do not want to receive vehicles from, please enter them here to stop receiving these emails. </p>
	
	<p>You can also do this at any time by going to your <a href="/user/editdetails.php?edit=match">match preferences</a>.</p>
	<?php echo $matches_interface ?>
	
	<br style="clear: both" /><br /><br />
	<p>There are two ways to stop unwanted vehicles being sent to you. Either using this form, or requesting information not be sent to you once you recieve an email. There is a link at the bottom to ensure that you no longer get this type of vehicle. You can click either "do not show me this make" or "do not show me this model" to ensure you no longer receive these vehicle makes and/or models.</p>
	
	<?php } ?>
	
	<?php if(User::hasPermission('Request')){ ?>
	<h2>Buying on MotoReach</h2>
	
	<p>You will receive an email from the Motoreach website to say that a vehicle has been added that matches your interests. That email includes all of the information you would need to make an informed decision about whether the vehicle is relevant to your business interests.</p>
	
	<p>If you want to make an offer for this vehicle, simply click on "Request seller's contact information" on that email. Doing this will take you to the website, showing you the listing for the vehicle, and at the same time send you an email containing the seller's contact information.</p>
	
	<p>Once you receive this contact information simply call the seller, negotiate a suitable price and make arrangements to transport and make payment, if your offer is accepted.</p>
	
	<?php } ?>
	
	<?php if(User::hasPermission('List')){ ?>
	<h2>Wholesaling on MotoReach</h2>
	
	<p>Wholesaling a vehicle on Motoreach is intended to be almost identical to filling in an appraisal form. Click on the "Sell Wholesale" button to begin the process. Simply fill in the details on the form to provide information to potential buyers. Anything unusual or unique about the car, or any information about the condition, can be entered in the comments field.</p>
	
	<p>When you press "List" the vehicle is listed on the Motoreach website, and the vehicle is also sent out to all Motoreach member dealers or buyers who have indicated their interest in that type of vehicle.</p>
	
	<p>Almost immediately, dealers will begin to click on the email to request your contact information. When they do so, you will also receive <strong>their</strong> contact information. You can either wait for them to call you with an offer, or call them directly.</p>

	<p>Once you have received offers on the vehicle you can negotiate the best deal, and arrange payment and delivery.</p>
	<?php } ?>
	
</div>