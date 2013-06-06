
jQuery(document).ready(function(){
	
	$('#login_nav').click(function(e){
	
		position = $('#login_nav').position();
		top_position = (position.top+27)+'px';
		left_position = (position.left-93)+'px';
		
		if($('#mini_login').css('display')=='none') $('#mini_login').slideDown('fast');
		else $('#mini_login').slideUp('fast');
		
		$('#mini_login').css('top', top_position);
		$('#mini_login').css('left', left_position);
		
	});

	$('.button, .button_small, .button_lg').bind('mouseup mousedown', function(ev){
		var bg_img = $(this).css('backgroundImage');
		
		if(bg_img.substring(bg_img.length - 10) == 'down.png")'||bg_img.substring(bg_img.length - 10) == '_down.png)'){
			$(this).css('backgroundImage', bg_img.replace('_down.png', '.png'))
		} else {
			$(this).css('backgroundImage', bg_img.replace('.png', '_down.png'))
		}
		
	});
	
	$('#alert_box_yes, #alert_box_ok, #alert_box_cancel, #add_prefs #add, .save').bind('mouseup mousedown', function(){
	
		if($(this).attr('src').substring($(this).attr('src').length - 8) == 'down.png'){
			$(this).attr('src', $(this).attr('src').replace('_down.png','.png'));
		} else {
			$(this).attr('src', $(this).attr('src').replace('.png','_down.png'));
		}
		
		
	});
	
	$('#header_image_overlay').click(function(){
		
		$('#header_image_overlay').hide();
		$('#header_image').animate({width: 800, height: 600, top: 100, left: 75}, 500, function(){
			$('#header_image_text').show();
		});
		$('#header_image_image').animate({top: 0, left: 0}, 500);
	});
	
	$('#header_image').click(function(){
			
		if($(this).css('width').replace('px', '')*1>600){
		
			$('#header_image').animate({width: 450, height: 100, top: 0, left: 490}, 500, 
				function(){ 
					$('#header_image_text').hide();
					$('#header_image_overlay').fadeIn();
				
				}
			);
			$('#header_image_image').animate({top: '-'+car.top, left: '-'+car.left}, 500);
			
		
		}
	});
	
	if($('#make_id') && $('#add_prefs').length == 0 ){
		
		$('#make_id').on('mouseup change blur', function(e){
				$.get("/api/get_models.php", {'make': $('#make_id').val()}, function(data){
				$('#model_id').html(data);
				$('#model_id').trigger('change');
			});
		});
		
		$('#model_id').on('change blur',function(e){
			if($('#model_id option:selected').text()=='select a make') return false;
			var size = 0;
			var mod = $('#make_id option:selected').text()+'_'+$('#model_id option:selected').text();
			$.get("/api/get_models.php", {'type': 'badge','model': mod}, function(data){
				$('#badge_id').html(data);
				if(data.length > 1){
					$('#badge_id, #badge_id_label').css('opacity', '1');
					$('#badge_id').attr('disabled', false);
				} else {
					$('#badge_id').val('');
					$('#badge_id, #badge_id_label').css('opacity', '0.5');
					$('#badge_id').attr('disabled', true);
				}
			});
			
			$.get("/api/get_models.php", {'type': 'series','model': mod}, function(data){
				$('#series_id').html(data);
				if(data.length > 1){
					$('#series_id, #series_id_label').css('opacity', '1');
					$('#series_id').attr('disabled', false);
				} else {
					$('#series_id').val('');
					$('#series_id, #series_id_label').css('opacity', '0.5');
					$('#series_id').attr('disabled', true);
				}
			});
			
		});
		
		$('#make_id').trigger('change');
		
	} else if($('#make_id') && $('#add_prefs').length != 0) {
		
		
		
		$('select.select_make').bind('blur change', function(e){ 
			if($('#make_id').val() != ''){
				
				$.get("/api/get_models.php", {'make': $('#make_id option:selected').text(), 'all_models': 1}, function(data){
					$('#model_id').html(data);
				});
				$('#model_id').show();
			} else {
				$('#model_id').hide();
			}
		});
		
		$('ul input[type=checkbox]').click(function(){
			if($('#make_id').val() == ''){
				if($(this).attr('id').replace('location_','') == user_state){
					//$('#location_'+user_state).attr('checked', false);
					//newAlert('You cannot disable your own state for all vehicles.', 'stop');
				}
			}
		});
		
		$('#location_all_label').click(function(e){
			e.preventDefault();
			$('#location_2, #location_3, #location_4, #location_5, #location_6, #location_7, #location_8').attr('checked', true);
			if($('#make_id').val() == ''){
				$('#location_'+user_state).attr('checked', false);
			}
		});
		
		$('#add_prefs input, #add_prefs button, #add_prefs select').bind('click blur change load', function(){
			
			var display_str = 'Show me ';
			var invalid_string = false;
			
			var state_string = '';
			var state_string2 = '';
			
			$('#add').attr('disabled', false);
			if($('#make_id').val() == ''){
				display_str += 'any vehicles';
			} else {
				if($('#model_id').val() == ''){
					display_str += ' any ' + $('#make_id option:selected').text();
				} else {
					display_str += $('#make_id option:selected').text() + ' ' + $('#model_id option:selected').text();
				}
			}
			if($('input.state_check:checked').length == 7) {
				state_string += ' all Australia';
			} else {
				$.each($('.state_check'), function(index, value){
					if($(value).attr('checked') == true){
						if(state_string.length != 0) state_string += ', ';
						state_string += $(value).attr('title');
					} else {
						if(state_string2.length != 0) state_string2 += ', ';
						state_string2 += $(value).attr('title');
					}
				});
			}
			
			n = state_string.lastIndexOf(',');
			if(n>0) state_string = state_string.substring(0, n) + ' or ' + state_string.substring(n+1);
			
			n = state_string2.lastIndexOf(',');
			if(n>0) state_string2 = state_string2.substring(0, n) + ' and ' + state_string2.substring(n+1);
			
			if(state_string.replace(' or ', '') != ''){
				$('#match_text_description').css('color', 'black');
			} else {
				invalid_string = true;
			}
			
			display_str += ' in ' + state_string;
			
			if($('#from_year').val() != '100') display_str += ' newer than ' + $('#from_year').val() + ' years';
			
			display_str += '.';
			
			if(state_string2 != '' || $('#model_id').val() != ''){
				display_str += '<br /><br />You will not see ';
				
				if(state_string2 != ''){
					if($('#make_id').val() == ''){
						display_str += 'any vehicles';
					} else {
						display_str += $('#make_id option:selected').text();
					}
					if($('#model_id').val() != ''){
						display_str += ' ' + $('#make_id option:selected').text();
					}
				
					display_str += ' from ' + state_string2;
				}
				
				if($('#model_id').val() != ''){
					if(state_string2 != '') display_str += ' and';
					display_str += ' any other model of ' + $('#make_id option:selected').text()+'.';
				}
			}
			
			if(!invalid_string){
				$('#match_text_description').html(display_str);
				$('#add').show();
			}
			else{
				$('#match_text_description').html('<strong>Please say what vehicles you are interested in.</strong>');
				$('#add').hide();
				//$('#add').attr('disabled', true);
			}
			return true;
		})
		
		$('#make_id').trigger('change');
	}
	
	$('div.button, div.button_small').click(function(){
		
		if($(this).parents('form:first').find('#email').length>0){
			if($(this).parents('form:first').find('#email').val()){
				var email_str = $(this).parents('form:first').find('#email').val();
				var inx_at = email_str.indexOf("@");
				var inx_dot = email_str.lastIndexOf(".");

				if(  inx_at < 1 || $(this).parents('form:first').find('#email').val().indexOf(".") < 1 || inx_at >  inx_dot || inx_dot == (email_str.length - 1)){
					newAlert('This is not a valid email address', 'stop');
					return false;
				}
			}
		}
		
		$(this).parents('form:first').submit();
		
	});
	
	$('#ob_close').click(function(){
		close_orange();
	});
	
	$('#ob_open').click(function(){
		open_orange();
	});
	
	if($('#set_count').length != 0){
		$('select#num').bind('blur change', function(e){
			$('#set_count').submit();
		});
	}
	
	
	if($('#match_interface').length != 0){
		
		$('#match_interface .header_state').click(function(){
			if($('ul', $(this).parent()).css('display') != 'block') $('#add_prefs ul').slideUp();
			$('ul', $(this).parent()).slideDown();
		});
		
		$('#match_interface .header_state input').click(function(event){
			event.stopPropagation();
			$('li', $(this).closest('.state')).click();
		});
		
		$('#match_interface #add_prefs li').click(function(ev){
			
			var target = ev.target;
			var clicked = target.tagName;
			var map_id = $('input', $(this)).val();
			
			
			if(clicked == 'LI'){
				
				var checkbox = $('input', $(this));
				
				if(checkbox.attr('checked')){
					$(this).css({backgroundColor: 'white'});
					checkbox.attr('checked', false);
					$('#map_region_'+map_id).animate({opacity: '0.4'});
				} else {
					$(this).css({backgroundColor: '#cccccc'});
					checkbox.attr('checked', true);
					$('#map_region_'+map_id).animate({opacity: '1'});
				}
			} else {
				
				if($(target).attr('checked')){
					$(target).parent().css({backgroundColor: '#cccccc'});
					$('#map_region_'+map_id).animate({opacity: '1'});
				} else {
					$(target).parent().css({backgroundColor: 'white'});
					$('#map_region_'+map_id).animate({opacity: '0.4'});
					
				}
			}
			checkMapImages();
		});
		
		
		$('#match_interface li').hover(
			function() {
				if($('#map_region_'+$('input', $(this)).val()).css('opacity') <= '0.7') $('#map_region_'+$('input', $(this)).val()).animate({opacity: '0.7'}, 100);
			}, 
			function() {
				if($('#map_region_'+$('input', $(this)).val()).css('opacity') <= '0.7') $('#map_region_'+$('input', $(this)).val()).animate({opacity: '0.4'}, 100);
			}
		);
		
		var last_added_match_pref = '';
		
		$('#add_prefs').submit(function(e){
			e.preventDefault();
			var form_serialize = $('#add_prefs').serialize();
			
			if(form_serialize.indexOf('region') < 0){
				newAlert('You have no areas selected to receive vehicles from.', 'stop');
				return false;
			}
			
			if($('#to_year').val() != '100' && $('#from_year').val() != '100' && $('#to_year').val()*1 > $('#from_year').val()*1){
				newAlert('A vehicle cannot be older than '+$('#to_year').val()+' years AND newer than '+$('#from_year').val()+' years.', 'stop');
				return false;
			}
			
			if(form_serialize == last_added_match_pref){
				newAlert('You have just added an identical preference.', 'stop');
				return false;
			} else {
				$.post("/api/add_pref.php", $('#add_prefs').serialize(), function(data){
					get_prefs($('#user_id').val());
				});
				last_added_match_pref = form_serialize;
			}
			$('#match_interface_border').show().animate({left: '50px', top: '600px', opacity: '0', height: '200px'}, 500, function(){
				$('#match_interface_border').hide().css({left: '0px', top: '0px', opacity: '1', height: '425px'});
			});
		});
		$('#list_region_'+region_id).trigger('click');
		get_prefs($('#user_id').val());
		
	}
	
	
	$('#blocker').click(function(){
		$('#blocker').fadeOut();
		$('#alert_box').fadeOut();
		$('#edit_form').fadeOut();
	});
	
});

var checkMapImages = function(){
	$('#match_map img').each(function(){
		if($(this).css('opacity').substring(0,3) == '0.7'){
			//console.log($(this));
			
		}
	});
}


function colorToHex(color) {
    if (color.substr(0, 1) === '#') {
        return color;
    }
	var digits = /(.*?)rgb\((\d+), (\d+), (\d+)\)/.exec(color);
    
    var red = parseInt(digits[2]);
    var green = parseInt(digits[3]);
    var blue = parseInt(digits[4]);
    
    var rgb = blue | (green << 8) | (red << 16);
    return digits[1] + '#' + rgb.toString(16);
};

var validate = function(){
	
	//event.preventDefault();
	
	var invalid = false;
	var failed = [];
	
	$.each(validate_array, function(key, value) {
	
		if(value == 'build_month' && $('#'+value).val()==0){
			failed.push(value);
		}
		
		if(value == 'mileage' && $('#'+value).val().length < 3){
			failed.push(value);
		}
		
		if($('#'+value).val() == ''){
			invalid = true;
			failed.push(value);
			if(value == 'model_id') failed.push('badge_id');
		}
	
	});
	
	if(failed.length > 0){
		$.each(failed, function(key, value) { 
			if($('#'+value).length>0) $('#'+value).css('background-color', '#FF7F00');
		});
		var str = 'You have not filled in all mandatory information. Please note the highlighted fields';
	}
	
	if($('#startprice').length > 0 && $('#buyoutprice').length > 0 && $('#startprice').val() != '' && $('#startprice').val() != 0){
		if( $('#buyoutprice').val() && parseInt($('#startprice').val()) >= parseInt($('#buyoutprice').val()) ){
			var str =  "Your 'own it' price must be higher than the 'offers over' price.";
				
			if(failed[0] != 'buyout_mismatch'){
				str += "\n\nYou have not filled in all mandatory information. Please note the highlighted fields";
			}
		}
	}
	
	if(typeof(str)!='undefined'){
	
		newAlert(str, 'stop');
		//alert(str);
		return false;
	}
	return true;
}

/*
var banner_curr = 1;	

var banner_fade_out = function(){
	banner_curr = $('#rotating_image img:visible').attr('id').replace('image_rotate', '');
	$('#rotating_image img:visible').fadeOut(2000);
	banner_fade_in();
};

var banner_fade_in = function(){
	banner_rn_num = (banner_curr * 1) + 1;

	if(banner_rn_num == $('#rotating_image img').length+1){
		banner_rn_num = 1;
	}
	$('#image_rotate'+banner_rn_num).fadeIn(2000);
};
*/

var interv;
		
var start_timer = function(){
	//interv = setInterval(poll_bids, 10000);
}

var place_bid = function(){
	$.post("/api/placebid.php", $("#bidform").serialize(), function(data){
		if(data!='FAILED'){
			$('#submit_button_req, #amount').hide();
			newAlert('Your request has been received and an email sent to you.', 'alert');
		}
	});
}

var newAlert = function(text, type, confirm_function){
	
	if($.browser.msie && $.browser.version == '6.0'){
		alert(text);
		return false;
	}
	
	$('#alert_box_cancel').hide();
	$('#alert_box_yes').hide();
	$('#alert_box_ok').hide();
	
	$('#blocker').css({width: $(document).width(), height:$(document).height() } );
	$('#blocker').css('opacity', '0.3');
	$('#blocker').fadeIn();
	
	$('#blocker').css({width: $(document).width(), height: $(document).height() } );
	$('#alert_text').text(text);
	vpos = $(document).scrollTop() + (($(window).height() / 2) - ($('#alert_box').height() / 2));
	hpos = ($(window).width() / 2) - ($('#alert_box').width() / 2)
	$('#alert_box').css({top: vpos, left: hpos});
	
	if(type == 'confirm'){
		$('#alert_box_cancel').show();
		$('#alert_box_yes').show();
	} else if(type == 'stop'){
		$('#alert_box_ok').show();
	}
	
	$('#alert_box_ok').click(function(){
		endAlert();
		return true;
	});
	
	$('#alert_box_yes').click(function(){
		if(type == 'confirm') eval(confirm_function);
		endAlert();
		return true;
	});
	
	$('#alert_box_cancel').click(function(){
		endAlert();
		return false;
	});
	
	$('#alert_box').show();
	
	if(type == 'alert'){
		setTimeout('endAlert()', 4000);
	}
	if(type == 'stop') return false;
}


var endAlert = function(){
	$('#alert_box').fadeOut();
	$('#blocker').fadeOut();
}

var gateBlock = function(){
	var gleft = $(window).width() / 2 - 330;
	var gtop = $(window).height() / 2 - 130;
	
	$('#gate_blocker').css({width: $(document).width(), height:$(document).height() } );
	$('#gate_blocker').css('opacity', '.6');
	$('#gate_blocker').fadeIn();
	
	$('#gate_content').css({top: gtop, left: gleft, display: 'block'});
	
}

var endGateBlock = function(){
	$('#gate_box').fadeOut();
	$('#gate_blocker').fadeOut();
}

function closeAuction(){
	open = false;
	$('#auction_ends').text('Sale Closed').show();
	$('#bidform').slideUp();
	$('#text_status').text('Closed');
	newAlert('This listing is now closed', 'stop');
}

function checktick(periods){
	if(!open){
		return false;
	}
	
	if(!extended){
		if(periods[6]%10==0){
		
			$.post("/api/expiry.php", $("#bidform").serialize(), function(data){
				
				if(data!='0'){
					expiry = 1;
					
					var date_split = data.split(', ');
					
					var auction_end = new Date(date_split[0], date_split[1], date_split[2], date_split[3], date_split[4], date_split[5]);
					$('#auction_ends').countdown('destroy');
					$('#auction_ends').countdown({
							until: auction_end, 
							format: 'dhms', 
							labels: ['yr', 'mth', 'wk', 'd', 'hr', 'm', 's'],
							labels1: ['yr', 'mth', 'wk', 'd', 'hr', 'm', 's'],
							onTick: checktick,
							onExpiry: closeAuction
						}
					);
				}
				
			});
		}
		
	}
}

var close_orange = function(){
	var speed = 700;
	if($.browser.msie) speed = 0;
	
	$.post("/api/save_promo_state.php", {action: '1'});
	
	$('#orange_bevel').fadeOut(speed, function(){
		$('#orange_right_box .user_details').css({backgroundImage: 'none', position: 'absolute', top: '0px'});
		$('#orange_mid_box').slideUp();
		$('#orange_left_box').slideUp();
		$('#quicklinks').fadeOut('fast', function(){
			$('#orange_inner').animate({height: '23px'}, 'slow', function(){
			
				$('#quicklinks').css({position: 'absolute', left: '184px', top: '0px', width: '766px'});
				$('#quicklinks li').css({float: 'left', marginLeft: '0px', top: '0px', marginRight: '25px' });
				$('#menu_listings, #menu_edit').hide();
				$('#orange_bevel_sm').fadeIn(speed, function(){
					
					$('#orange_right_box').animate({left: '0px'}, 'slow', function(){
						$('#quicklinks').fadeIn();
						$('#ob_close').hide();
						$('#ob_open').show();
					});
				});
				
			});
			$('#orange_box').animate({height: '42px'}, 'slow', function(){});
		});
	});
	
}

var open_orange = function(){

	var speed = 700;
	if($.browser.msie) speed = 0;

	$.post("/api/save_promo_state.php", {action: '0'});
	$('#orange_bevel_sm').fadeOut(speed, function(){
		
		
		$('#orange_right_box .user_details').fadeOut('fast', function(){
			$('#orange_inner').animate({height: '204px'}, 'slow', function(){
			$('#menu_listings, #menu_edit').show();
				$('#quicklinks').css({position: 'relative', left: '0px', top: '0px', width: '200px'});
				$('#quicklinks li').css({float: 'none', marginLeft: '0px', top: '0px', marginRight: '0px'});
				
				$('#orange_bevel').fadeIn(speed, function(){
					
					$('#orange_right_box').animate({left: '742px', height: '195px'}, 'slow', function(){
						$('#orange_right_box .user_details').css({backgroundImage: 'url("/images/header_details_bg.png")', position: 'relative', width: '227px', height: '142px' });
						$('#orange_right_box .user_details').fadeIn();
						
						$('#ob_close').show();
						$('#ob_open').hide();
						
						$('#orange_mid_box').slideDown();
						$('#orange_left_box').slideDown();
		
					});
				});
				
			});
			$('#orange_box').animate({height: '225px'}, 'slow', function(){});
		});
	});
	
}

$.fn.makeAbsolute = function(rebase) {
    return this.each(function() {
        var el = $(this);
        var pos = el.position();
        el.css({ position: "absolute",
            marginLeft: 0, marginTop: 0,
            top: pos.top, left: pos.left });
        if (rebase)
            el.remove().appendTo("body");
    });
}

var get_prefs = function(user){
	$.post("/api/get_prefs.php"+(user?'?ID='+user:''), $('#add_prefs').serialize(), function(data){
		$('#matches').html(data);
	});
}

var delete_pref = function(id){
	$.post("/api/add_pref.php", {'delete':id}, function(data){
		get_prefs($('#user_id').val());
	});
	
}

var alert_delete = function(id){
	newAlert('Are you sure that you do not wish to be sent these vehicles when they are added in future?', 'confirm', 'delete_pref('+id+')');
}

Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};


var update_kms = function(){
	
	var factor = 1.609344;
	
	if($('#mileage_miles').val()!=''){
		$('#mileage').val(Math.floor($('#mileage_miles').val()*factor));
	}
}

var update_miles = function(){
	
	var factor = 0.621371192;
	
	if($('#mileage').val()!=''){
		$('#mileage_miles').val(Math.floor($('#mileage').val()*factor));
	}
}

$.maxZIndex = $.fn.maxZIndex = function(opt) {
    /// <summary>
    /// Returns the max zOrder in the document (no parameter)
    /// Sets max zOrder by passing a non-zero number
    /// which gets added to the highest zOrder.
    /// </summary>    
    /// <param name="opt" type="object">
    /// inc: increment value, 
    /// group: selector for zIndex elements to find max for
    /// </param>
    /// <returns type="jQuery" />
    var def = { inc: 10, group: "*" };
    $.extend(def, opt);    
    var zmax = 0;
    $(def.group).each(function() {
        var cur = parseInt($(this).css('z-index'));
        zmax = cur > zmax ? cur : zmax;
    });
    if (!this.jquery)
        return zmax;

    return this.each(function() {
        zmax += def.inc;
        $(this).css("z-index", zmax);
    });
}

var pref_count = 0;