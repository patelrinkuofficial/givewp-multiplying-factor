<?php
/*
  Plugin Name: Give - Multiplying factor
  Plugin URI: https://resolutesolutions.in
  description: Give WP Multiplying factor
  Version: 1.2
  Author: Resolute Solutions
  Author URI: https://resolutesolutions.in
  License: GPL2
*/

function wporg_add_custom_box() {
  	$screens = [ 'give_forms'];
  	foreach ( $screens as $screen ) {
		add_meta_box(
			'wporg_box_id',
			'Multiplying Option',
			'wporg_custom_box_html',
			$screen
		);
  	}
}
add_action( 'add_meta_boxes', 'wporg_add_custom_box' );

function wporg_custom_box_html( $post ) {
	$_give_wp_give_multiplying_field_option = give_get_meta(  $_GET['post'], '_give_wp_give_multiplying_field_option', true );
	$_give_wp_give_multiplying_field_option_input = give_get_meta(  $_GET['post'], '_give_wp_give_multiplying_field_input', true );
	$_receiver_name = give_get_meta($_GET['post'], '_receiver_name', true );
	$_bonus_round = give_get_meta($_GET['post'], '_bonus_round', true );
	
	echo '<ul class="give-radios">';
		if($_give_wp_give_multiplying_field_option == 1){
			echo '<li><label><input checked="checked" name="_give_wp_give_multiplying_field_option" value="1" type="radio" style="" class="give-field  _give_wp_give_multiplying_field_option give-radio">Enable</label></li>';
			echo '<li><label><input name="_give_wp_give_multiplying_field_option" value="0" type="radio" style="" class="give-field _give_wp_give_multiplying_field_option  give-radio">Disable</label></li>';
		}else{
			echo '<li><label><input name="_give_wp_give_multiplying_field_option" value="1" type="radio" style="" class="give-field  _give_wp_give_multiplying_field_option give-radio">Enable</label></li>';
			echo '<li><label><input checked="checked" name="_give_wp_give_multiplying_field_option" value="0" type="radio" style="" class="give-field _give_wp_give_multiplying_field_option  give-radio">Disable</label></li>';
		}
		echo '<li class="_give_wp_give_multiplying_field_option_input"><label><input placeholder="Multiplying factor" name="_give_wp_give_multiplying_field_input" value="'.$_give_wp_give_multiplying_field_option_input.'" type="number" style="" class="give-field _give_wp_give_multiplying_field_input give-radio"></label></li>';
		echo '<li class=""><label><input placeholder="Receiver Name" name="_receiver_name" value="'.$_receiver_name.'" type="text"  class="give-field _receiver_name"></label></li>';
		echo '<li class=""><label><input placeholder="Bonus Goal" name="_bonus_round" value="'.$_bonus_round.'" type="text"  class="give-field _bonus_round"></label></li>
		</ul>';
  ?>
      <script>
        var give_wp_give_multiplying_field_option = jQuery('input[name="_give_wp_give_multiplying_field_option"]:checked').val();
        if(give_wp_give_multiplying_field_option == 1){
          jQuery('._give_wp_give_multiplying_field_option_input').show();
          jQuery('._receiver_name').show();
        }else{
          jQuery('._give_wp_give_multiplying_field_option_input').hide();
          jQuery('._receiver_name').hide();
        }
        jQuery(document).on('change keypress keyup copy paste', '._give_wp_give_multiplying_field_option,._give_wp_give_multiplying_field_input,._receiver_name,._bonus_round', function () {
          var _give_wp_give_multiplying_field_option = jQuery('input[name="_give_wp_give_multiplying_field_option"]:checked').val();
          var _give_wp_give_multiplying_field_input = jQuery('input[name="_give_wp_give_multiplying_field_input"]').val();
          var _receiver_name = jQuery('._receiver_name').val();
		  var _bonus_round = jQuery('._bonus_round').val();
          var post_id = jQuery("#post_ID").val();
          if(_give_wp_give_multiplying_field_option == 1){
            jQuery('._give_wp_give_multiplying_field_option_input').show();
			jQuery('._receiver_name').show();
          }else{
            jQuery('._give_wp_give_multiplying_field_option_input').hide();
			jQuery('._receiver_name').hide();
          }
          jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
              "action" : "update_give_wp_give_multiplying_field_option",
              "_give_wp_give_multiplying_field_option" : _give_wp_give_multiplying_field_option,
              "_give_wp_give_multiplying_field_input" : _give_wp_give_multiplying_field_input,
              "_receiver_name" : _receiver_name,
			  "_bonus_round" : _bonus_round,
              "post_id" : post_id
            },
            success: function (data) { 
              console.log(data);
            }
          });
        });
      </script>
		</ul>
  <?php
}

// Update multipling factor
function update_give_wp_give_multiplying_field_option_functuon(){

	global $wpdb;
	$_give_wp_give_multiplying_field_option = $_POST['_give_wp_give_multiplying_field_option'];
	$_receiver_name = $_POST['_receiver_name'];
	$_bonus_round = $_POST['_bonus_round'];
	if($_give_wp_give_multiplying_field_option == 1){
		$_give_wp_give_multiplying_field_input = $_POST['_give_wp_give_multiplying_field_input'];
	}else{
		$_give_wp_give_multiplying_field_input = 1;
	}
	$post_id = $_POST['post_id'];

	global $wpdb;
	$result = give_get_meta(  $post_id, '_give_wp_give_multiplying_field_option', true );
	
	if($result == ''){
		echo 1;
		give_update_meta($post_id,'_give_wp_give_multiplying_field_option',$_give_wp_give_multiplying_field_option);
		give_update_meta($post_id,'_give_wp_give_multiplying_field_input',$_give_wp_give_multiplying_field_input);
		give_update_meta($post_id,'_receiver_name',$_receiver_name);
		give_update_meta($post_id,'_bonus_round',$_bonus_round);
	}else{
		echo 2;
		give_update_meta($post_id,'_give_wp_give_multiplying_field_option',$_give_wp_give_multiplying_field_option);
		give_update_meta($post_id,'_give_wp_give_multiplying_field_input',$_give_wp_give_multiplying_field_input);
		give_update_meta($post_id,'_receiver_name',$_receiver_name);
		give_update_meta($post_id,'_bonus_round',$_bonus_round);
	}
	
}	
add_action( 'wp_ajax_update_give_wp_give_multiplying_field_option', 'update_give_wp_give_multiplying_field_option_functuon' );

// Donor List Shortcode
function give_donor_list_shortcode_function_example( $atts ) {
	ob_start();
	if ( ! class_exists( 'Give_Payments_Query' ) ) {
		return;
	}

	$atts = shortcode_atts( array(
		'number'  => 30,
		'form_id' => null,
		'heading' => 'We\'d like to thank the following gracious donors:',
	), $atts, 'my_donor_list' );
	
	$args = array(
		'output' => 'payments',
		'number' => $atts['number'],
		'status' => 'publish',
        'give_forms' => $atts['form_id'],

	);

	$payments = new Give_Payments_Query( $args );
	$payments = $payments->get_payments();

	$_give_wp_give_multiplying_field_input = give_get_meta(  $atts['form_id'], '_give_wp_give_multiplying_field_input', true );
	$_multiplying_field_input = '1';
	if($_give_wp_give_multiplying_field_input != ''){
		$_multiplying_field_input = $_give_wp_give_multiplying_field_input;
	}
	
	$args = array(
		'post_type' => 'give_team_account',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'meta_query'    => array(
			'relation' => 'AND',
			array(
				'key'       => 'team_status',
				'value'     => '1',
				'compare'   => '=',
			)
		) 
	);
	$loop = new WP_Query($args);

	$current_page_id = get_the_ID();
	global $table_prefix, $wpdb;
	$_team_option_data = array();

	global $table_prefix, $wpdb;
	$_team_option_data = array();
	$_team_enable = get_post_meta($current_page_id,'_team_enable',true);
	if($_team_enable == 1){
		$_team_option_data = $wpdb->get_results("SELECT * FROM ".$table_prefix."give_team_module WHERE status = 1 AND page_id = ".$current_page_id);
	}
	?>
	<style>
		.donars_section{padding-bottom:0;width:100%;margin:0}
		.donars_section .donar_header{position:relative;padding:7px 15px;text-transform:capitalize;display:flex;align-items:center;justify-content:space-between;height:50px;background:#dfdfdf none repeat scroll 0 0}
		.donars_section .donar_header h2{margin:0;color:#0085ad;font-size:16px}
		.donars_section .donor-listing{max-height:280px;overflow-y:auto}
		.donars_section .donar_block{padding:5px 10px;min-height:70px;display:flex;align-items:center;justify-content:space-between}
		.donars_section .donar_block:nth-child(2n+1){background-color:#fff}
		.donars_section .donar_block:nth-child(2n){background-color:#daf4fd;}
		.donars_section .donar_block .donor_info{display:flex;flex-direction:column;padding-left:5px;text-align:center}
		.donars_section .donar_block .amount{font-size:14px;color:#0085ad;margin:0;min-width:52px;text-align:center}
		.donars_section .donar_block .donor_info .alias{margin:0}
		.donars_section .donar_block .donor_info .message{font-size:10px;font-weight:300;color:#8a8b8c;margin:5px 0 0}
		.donar_hide.donar_block{display:none}
		.sidebar-blue-btn{background:#0085ad;border:2px solid #0085ad;border-radius:5px;color:#fff;cursor:pointer;float:left;font-size:15px;line-height:30px;margin:15px 0 0;padding:0;text-transform:uppercase;width:100%}
	</style>
	<style>
		.team-card-ul{padding:0;list-style:none;max-height:470px;overflow-y:auto;margin-bottom:15px}
		.team-card-ul{-webkit-box-shadow:0 0 3px -1px #777;box-shadow:0 0 3px -1px #777;margin:10px;padding-bottom:15px;padding-top:15px;min-height:470px}
		.team-card-item{padding-bottom:10px;-webkit-box-shadow:0 2px 4px 0 rgba(0,0,0,.5);box-shadow:0 2px 4px 0 rgba(0,0,0,.5);border-radius:8px;margin-left:10px;margin-right:10px;margin-top:10px;margin-bottom:10px;position:relative;padding-left:15px;padding-right:15px;background-color:#fff}
		.td-link{text-align:right;margin-top:10px;color:#717171;cursor:pointer}
		a:not([href]):not([tabindex]){color:inherit;text-decoration:none}
		.td-link-container{display:-webkit-inline-box;display:-ms-inline-flexbox;display:inline-flex;color:#717171}
		.tdl-text{display:block;font-weight:700}
		.td-img-block{text-align:center}
		.td-img{width:62px;height:62px;border-radius:50%!important}
		.td-name{min-height:62px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;color:#4a4a4a;}
		.td-title{font-size:17px;font-weight:600;color:#4a4a4a;text-align:center;width:100%;}
		.tc-progress-area{margin-left:auto;margin-right:auto;-webkit-box-ordinal-group:2;-ms-flex-order:1;order:1;margin-bottom:5px;margin-top:30px}
		.tc-progress-area{height:auto;margin:20px 10px;display:block}
		.tc-pa-bar{height:20px;border-radius:14px;background-color:#d8d8d8;position:relative;width:100%;margin-bottom:5px}
		.tc-pa-bar i{position:absolute;left:0;top:0;height:100%;border-radius:10px;width:70%;background-color:#2bde73}
		.pa-bar-hint.sechalf{margin-left:-10px}
		.pa-bar-hint{font-size:14px;font-weight:700;color:#4c4c4c;position:absolute;top:-31px;left:100%;margin-left:-5px;text-align:right}
		.tc-pa-details{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;font-size:20px;color:#616161;margin:0 5px;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;align-items:center}
		.tc-pa-details{font-size:20px;color:#616161}
		.tc-pad-goal-text{color:#4b4b4b;font-weight:800;font-size:26px}
		.tc-pad-text{display:block}.tc-pad-subtext{font-size:15px;display:block;color:#989898}
		.tc-pad-donors{text-align:center}.tc-pad-text{display:block}
		.tc-pad-subtext{font-size:15px;display:block;color:#989898}
		.tdl-icon{font-size:18px;display:block;margin-top:2px;margin-left:5px;margin-right:5px;}
		#team-card-list .col-sm-6{float:left;width:50%;list-style:none;}
		.donars_section .tabcontent{display:none;}
		.donars_section .tab{box-shadow:0 2px 4px 0 rgba(0,0,0,.5);margin:10px;border-radius:3px;padding:15px;height:70px;}
		.donars_section .tablinks{border:0;background-color:transparent;color:#000;font-weight:700;font-size:24px;width:50%;float:left;}
		.donars_section .tablinks.active{border-bottom:2px solid #5d4496;color:#4a4a4a;f}
		.dbtn-extc{color:#000;border:2px solid #ffc107;padding:10px 15px;border-radius:10px;text-transform:uppercase;font-weight:700}
		.td-img-extc{border-radius:50px!important}
		.extc-close{font-size:22px;color:#717171;font-weight:700;float:left}
		.rdp-card-item{min-height:210px;height:auto;box-shadow:0 2px 4px 0 rgba(0,0,0,.5);border-radius:8px;margin-left:10px;margin-right:10px;margin-top:10px;margin-bottom:10px;position:relative;padding-left:15px;padding-right:15px;background-color:#fff;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:center;-ms-flex-align:center;align-items:center;display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap}
		.rdp-item-row{height:90px;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:normal;-ms-flex-align:normal;align-items:normal;padding:15px 10px;-ms-flex-wrap:wrap;flex-wrap:wrap;width:100%}
		.media{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:start;-ms-flex-align:start;align-items:flex-start}
		.rdp-item-details{text-align:center;padding-right:1em;margin-right:-1em}
		.media-body{-webkit-box-flex:1;-ms-flex:1;flex:1}
		.rci-team{color:#838383;font-size:11px;text-align:center;}
		.rcit-ml{color:#838383;font-size:11px;text-align:center}
		.rcit-name{color:#838383;font-size:11px;text-align:center}
		.rid-name{overflow:hidden;position:relative;line-height:1.4em;max-height:2.8em;color:#4a4a4a;font-weight:700;padding-right:1em;margin-right:-1em;font-weight:700!important}
		.rid-amount{color:#4451f5!important;font-weight:700!important}
		.rid-note{color:#4a4a4a;font-size:12px;font-style:italic;overflow:hidden;position:relative;line-height:1.4em;max-height:2.8em;padding-right:1.2em;margin-right:-1em}
		#Teams #expandeteamcontainer,#Teams #rdp-card-list{display:none;}
		#rdp-card-list .col-sm-6{float:left;width:50%;min-height:230px;height:auto;}
		.rid-name{font-size:20px!important;font-weight:700!important;color:#4a4a4a!important;}
		.rid-amount{font-weight:700!important;font-size:24px!important;}
		.pabh-text.sechalf{margin-left: 0px;}
		.team-card-item.team-card-item_click{cursor:pointer}
		.ctm_cardknox_popup{position:fixed;z-index:99999;background:rgba(0,0,0,0.5);height:100%;width:100%;top:0;left:0;display:none;}
		.ctm_cardknox_popup_text{margin:130px auto;width:400px;box-shadow:0 2px 4px 0 rgba(0,0,0,.5);background:#fff;padding:20px;}
		.ctm_cardknox_popup_close{margin-top:-30px;margin-left:-27px;font-size:30px;font-weight:700;color:#000;padding-bottom:0;cursor:pointer;}
		.tc-pad-dbtn.extc{margin-top:20px;}
		@media only screen and (max-width: 600px) {
			#team-card-list .col-sm-6 ,#rdp-card-list .col-sm-6{width: 100%;}
		}
	</style>
	<div class="ctm_cardknox_popup">
		<div class="ctm_cardknox_popup_text">
		<p class="ctm_cardknox_popup_close">X</p>
			<p class="ctm_cardknox_popup_text_child">daf</p>
		</div>
	</div>
	<section class="donars_section">
		<div class="tab">
			<button class="tablinks active" onclick="opengive_multifactor(event, 'Donors')"><?php echo count($payments); ?> Donors</button>
			<?php if($_team_enable == 1){ ?>
				<button class="tablinks" onclick="opengive_multifactor(event, 'Teams')"><?php echo count($_team_option_data); ?> Teams</button>
			<?php } ?>
		</div>
		<br>
		<div id="Donors" class="tabcontent" style="display: block;">
			<div id="rdp-card-list" class="team-card-ul rdp-cards-container row effect2 rdp-card-list" >
				<?php foreach ( $payments as $payment ) : ?>
				<?php
					$first_name = $payment->get_meta( '_give_donor_billing_first_name', true);
					$last_name = $payment->get_meta( '_give_donor_billing_last_name', true );
					$_give_payment_form_id = $payment->get_meta('_give_payment_form_id',true);
					
					$give_team_id = $payment->get_meta('give_team_id',true);
					$_give_completed_date = date_format(date_create($payment->get_meta('_give_completed_date',true)),"m/d/Y");
					
					global $table_prefix, $wpdb;
					$comment_content = $wpdb->get_results("SELECT * FROM ".$table_prefix."give_comments  WHERE comment_type = 'donor_donation' AND comment_parent = ".$payment->ID);
					if(count($comment_content) > 0){
						$comment_content = $comment_content[0]->comment_content;
						$comment_content_short = substr($comment_content, 0, 50).' <a href="javascript:void(0)" class="get_the_content" content="'.$comment_content.'">Read More</a>';
					}else{
						$comment_content  = '';
						$comment_content_short = '';
					}

					$team_name_result = $wpdb->get_results("SELECT * FROM ".$table_prefix."give_team_module  WHERE id = ".$give_team_id);
					$team_name = '';
					if($team_name_result[0]->name != ''){
						$team_name = '<span class="rcit-ml">Donation through </span><span class="rcit-name">'.$team_name_result[0]->name.'</span>';;
					}
					$total  = give_donation_amount( $payment->ID );
					$_give_anonymous_donation = $payment->get_meta('_give_anonymous_donation',true);
					if($_give_anonymous_donation == 1){
						$full_name = 'Anonymous';
					}else{
						$full_name = $first_name.' '.$last_name;
					}

					echo '<div class="col-sm-6">
						<div class="rdp-card-item">
							<div class="media rdp-item-row ">
								<div class="media-body rdp-item-details">
									<h5 class="rid-name" title="David Ergas">'.$full_name.'</h5>
									<h4 class="rid-amount">$'.$total * $_multiplying_field_input.'</h4>
								</div>
							</div>
							<div class="rci-team">'.$team_name.'</div>
							<div class="rci-team">Date :- '.$_give_completed_date.'</div>
							<div class="rci-team">'.$comment_content_short.'</div>
						</div>
					</div>';
				endforeach; ?>
			</div>
		</div>
		<div id="Teams" class="tabcontent">
		<?php
			$defaulty_team_id = 0;
			if(isset($_GET['team'])){
				$defaulty_team_id = $wpdb->get_results("SELECT * FROM ".$table_prefix."give_team_module WHERE page_id = ".$current_page_id." AND name = '".$_GET['team']."'");
				$defaulty_team_id = $defaulty_team_id[0]->id;
			}
			if(count($_team_option_data) > 0){
				foreach ( $_team_option_data as $_team_data ) :
					$Team_ID = $_team_data->id;
					$team_name =  $_team_data->name;
					$team_img = $_team_data->image;
					$team_img = wp_get_attachment_image_src($team_img,'thumbnail',true);
					$goal_b = $_team_data->goal;
					$bonus_goal = $_team_data->bonus_goal;
					$total_donation = 0;
					$total_done = 0;
					$args      = [
						'output'                 => 'post',
						'cache_results'          => false,
						'no_found_rows'          => true,
						'update_post_meta_cache' => false,
						'update_post_term_cache' => false,
						'fields'                 => 'ids',
						'meta_query'             => [
							[
								'key'     => 'give_team_id',
								'value'   => $Team_ID,
								'type'    => 'numeric',
								'compare' => '=',
							]
						],
					];

					$payments2  = new Give_Payments_Query( $args );
					$donations = $payments2->get_payments();
					
					foreach ( $donations as $donation ) :
						$donation_id = $donation->ID;
						$_give_payment_total = give()->payment_meta->get_meta($donation,'_give_payment_total',true);
						$total_donation = $total_donation + $_give_payment_total;
					endforeach;
					$total_donation = $total_donation * $_multiplying_field_input;

					$total_done = $total_donation * 100 / $goal_b;
					$total_done = (int) $total_done;
					if($total_donation > $goal_b){
						$goal_b = $bonus_goal;
					}

					?>
						<div id="expandeteamcontainer" class="card-exp-container expandeteamcontainer expandeteamcontainer_<?php echo $Team_ID; ?>">
							<div class="team-card-item">
								<div class="tc-overlay extc-tcoverlay"></div>
								<div class="team-details-area row">
									<div class="col-12 td-link td-link-extc">
										<span class="extc-close" title="Close">X</span>
										<a class="tdl-atag-extc" href="?team=<?php echo $team_name; ?>">
											<div class="td-link-container">
												<?php if(!isset($_GET['team'])){  echo '<span class="tdl-text">View Page </span>'; }?>
												<i class="tdl-icon fas fa-external-link-square-alt" aria-hidden="true"></i>
											</div>
										</a>
									</div>
									<div class="col-3 td-img-block">
										<img class="td-img-extc" src="<?php echo $team_img[0]; ?>">
									</div>
									<div class="col-9 td-name">
										<span class="td-title td-title-extc"><?php echo $team_name; ?></span>
									</div>
								</div>
								<div class="section tc-progress-area">
									<?php
										if($total_done > 100){
											$total_done_2 = ($total_done / 100);
											$total_done_2 = round(100 / $total_done_2);
										?>
										<div class="tc-pa-bar tcpabar-extc" style="background-color:#2bde73">
											<i style="width: <?php echo $total_done_2; ?>%; max-width:100%;background-color:#4252f5">
												<span class="pa-bar-hint teamcard dir-ltr sechalf ">
													<span class="pabh-text teamcard sechalf"><?php echo $total_done; ?>%</span>
												</span>
											</i>
										</div>
									<?php }else{ ?>
										<div class="tc-pa-bar tcpabar-extc">
											<i style="width: <?php echo $total_done; ?>%; max-width:100%">
												<span class="pa-bar-hint teamcard dir-ltr sechalf ">
													<span class="pabh-text teamcard sechalf"><?php echo $total_done; ?>%</span>
												</span>
											</i>
										</div>
									<?php } ?>
									<div class="tc-pa-details extc">
										<div class="tc-pad-goal">
											<span class="tc-pad-goal-text tc-pad-text">$ <span class="padgt-amt pb-team-amt pbtamt-extc"><?php echo $total_donation; ?></span></span>
											<span id="extc-goal-text" class="tc-pad-goal-subtext tc-pad-subtext">of $ <span class="pbtgoal-extc"><?php echo $goal_b; ?></span> raised </span>
										</div>
										<div class="tc-pad-donors">
											<span class="tc-pad-donors-text tc-pad-text tcdn-extc"><?php echo count($donations); ?></span><span class="tc-pad-donors-subtext tc-pad-subtext">Donors</span>
										</div>
										<div class="tc-pad-dbtn extc">
											<a class="dbtn-extc" href="?team=<?php echo $team_name; ?>">Donate Now</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php

				endforeach;
			}
		?>
			<div id="rdp-card-list" class="team-card-ul rdp-cards-container row effect2 rdp-card-list2" >
				<?php foreach ( $payments as $payment ) : ?>
				<?php
					$first_name = $payment->get_meta( '_give_donor_billing_first_name', true);
					$last_name = $payment->get_meta( '_give_donor_billing_last_name', true );
					$_give_payment_form_id = $payment->get_meta('_give_payment_form_id',true);
					$give_team_id = $payment->get_meta('give_team_id',true);
					
					$_give_completed_date = date_format(date_create($payment->get_meta('_give_completed_date',true)),"m/d/Y");
					
					global $table_prefix, $wpdb;
					$comment_content = $wpdb->get_results("SELECT * FROM ".$table_prefix."give_comments  WHERE comment_type = 'donor_donation' AND comment_parent = ".$payment->ID);
					if(count($comment_content) > 0){
						$comment_content = $comment_content[0]->comment_content;
						$comment_content_short = substr($comment_content, 0, 50).' <a href="javascript:void(0)" class="get_the_content" content="'.$comment_content.'">Read More</a>';
					}else{
						$comment_content  = '';
						$comment_content_short = '';
					}
					
					$team_name_result = $wpdb->get_results("SELECT * FROM ".$table_prefix."give_team_module  WHERE id = ".$give_team_id);
					$team_name = '';
					if($team_name_result[0]->name != ''){
						$team_name = '<span class="rcit-ml">Donation through </span><span class="rcit-name">'.$team_name_result[0]->name.'</span>';;
					}
					$total  = give_donation_amount( $payment->ID );
					$_give_anonymous_donation = $payment->get_meta('_give_anonymous_donation',true);
					if($_give_anonymous_donation == 1){
						$full_name = 'Anonymous';
					}else{
						$full_name = $first_name.' '.$last_name;
					}


					echo '<div class="col-sm-6 give_team_id give_team_id_'.$give_team_id.'">
						<div class="rdp-card-item">
							<div class="media rdp-item-row ">
								<div class="media-body rdp-item-details">
									<h5 class="rid-name" title="David Ergas">'.$full_name.'</h5>
									<h4 class="rid-amount">$'.$total * $_multiplying_field_input.'</h4>
								</div>
							</div>
							<div class="rci-team">'.$team_name.'</div>
							<div class="rci-team">'.$_give_completed_date.'</div>
							<div class="rci-team">'.$comment_content_short.'</div>
						</div>
					</div>';
				endforeach; ?>
			</div>
			
			<ul id="team-card-list" class="team-card-ul row effect2">
				<?php
					if(count($_team_option_data) > 0){
						foreach ( $_team_option_data as $_team_data ) :
							$Team_ID = $_team_data->id;
							$team_name =  $_team_data->name;
							$team_img = $_team_data->image;
							$team_img = wp_get_attachment_image_src($team_img,'thumbnail',true);
							$goal_b = $_team_data->goal;
							$bonus_goal = $_team_data->bonus_goal;
							$total_donation = 0;
							$total_done = 0;
							if($Team_ID != ''){
								$args      = [
									'output'                 => 'post',
									'cache_results'          => false,
									'no_found_rows'          => true,
									'update_post_meta_cache' => false,
									'update_post_term_cache' => false,
									'fields'                 => 'ids',
									'meta_query'             => [
										[
											'key'     => 'give_team_id',
											'value'   => $Team_ID,
											'type'    => 'numeric',
											'compare' => '=',
										]
									],
								];

								$payments  = new Give_Payments_Query( $args );
								$donations = $payments->get_payments();
								
								foreach ( $donations as $donation ) :
									$donation_id = $donation->ID;
									$_give_payment_total = give()->payment_meta->get_meta($donation,'_give_payment_total',true);
									$total_donation = $total_donation + $_give_payment_total;
								endforeach;
								$total_donation = $total_donation * $_multiplying_field_input;

								$total_done = $total_donation * 100 / $goal_b;
								$total_done = (int) $total_done;
								if($total_donation > $goal_b){
									$goal_b = $bonus_goal;
								}
								
							}
							?>
							<li class="col-sm-6">
								<div class="team-card-item team-card-item_click" data-tid="<?php echo $Team_ID; ?>">
									<div class="team-details-area row">
										<div class="col-12 td-link">
											<a class="tdl-atag" data-tid="<?php echo $Team_ID; ?>">
												<div class="td-link-container">
													<span class="tdl-text">View </span>
													<i class="tdl-icon fas fa-external-link-square-alt" aria-hidden="true"></i>
												</div>
											</a>
										</div>
										<div class="col-3 td-img-block">
											<img class="td-img" src="<?php echo $team_img[0]; ?>">
										</div>
										<div class="col-9 td-name">
											<span class="td-title"><?php echo $team_name; ?></span>
										</div>
									</div>
									<div class="section tc-progress-area">
										<?php
											if($total_done > 100){
												$total_done_2 = ($total_done / 100);
												$total_done_2 = round(100 / $total_done_2);
											?>
											<div class="tc-pa-bar" style="background-color:#2bde73">
												<i style="width: <?php echo $total_done_2; ?>%; max-width:100%;background-color:#4252f5">
													<span class="pa-bar-hint teamcard dir-ltr sechalf ">
														<span class="pabh-text teamcard sechalf"><?php echo $total_done; ?>%</span>
													</span>
												</i>
											</div>
										<?php }else{ ?>
											<div class="tc-pa-bar">
												<i style="width: <?php echo $total_done; ?>%; max-width:100%">
													<span class="pa-bar-hint teamcard dir-ltr sechalf ">
														<span class="pabh-text teamcard sechalf"><?php echo $total_done; ?>%</span>
													</span>
												</i>
											</div>
										<?php } ?>
										<div class="tc-pa-details dir-rtl">
											<div class="tc-pad-goal">
												<span class="tc-pad-goal-text tc-pad-text">$<span class="padgt-amt pb-team-amt"><?php echo $total_donation; ?></span>
												</span><span class="tc-pad-goal-subtext tc-pad-subtext">of $<?php echo $goal_b; ?> raised</span>
											</div>
											<div class="tc-pad-donors">
												<span class="tc-pad-donors-text tc-pad-text"><?php echo count($donations); ?></span>
												<span class="tc-pad-donors-subtext tc-pad-subtext">Donors</span>
											</div>
										</div>
									</div>
								</div>
							</li>
							<?php
						endforeach;
					}
				?>
			</ul>
		</div>
		
		<script>
			jQuery('.sidebar-blue-btn').click(function(){
				jQuery(this).hide();
				jQuery(".donar_block").removeClass("donar_hide");
			});
			jQuery('.dbtn-extc').click(function(){
				var temp_team_id = jQuery(this).attr('team_id');
				var temp_team_name = jQuery(this).attr('team_name');
				jQuery('.give_team_id').val(temp_team_id);
				jQuery('.give_team_title').html('Donation through '+temp_team_name);
			});

			jQuery('.get_the_content').click(function(){
				var content = jQuery(this).attr('content');
				jQuery('.ctm_cardknox_popup_text_child').html(content);
				jQuery('.ctm_cardknox_popup').show();
			});
			jQuery('.ctm_cardknox_popup_close,.ctm_cardknox_popup').click(function(){
				jQuery('.ctm_cardknox_popup').hide();
			});

			

			
			function opengive_multifactor(evt, cityName) {
				var i, tabcontent, tablinks;
				tabcontent = document.getElementsByClassName("tabcontent");
				for (i = 0; i < tabcontent.length; i++) {
					tabcontent[i].style.display = "none";
				}
				tablinks = document.getElementsByClassName("tablinks");
				for (i = 0; i < tablinks.length; i++) {
					tablinks[i].className = tablinks[i].className.replace(" active", "");
				}
				document.getElementById(cityName).style.display = "block";
				evt.currentTarget.className += " active";
			}
		</script>
	</div>
	<script>
		jQuery( document ).ready(function($) {
			$(".tdl-atag,.team-card-item_click").click(function(){
				var data_tid = $(this).attr('data-tid');
				$('.expandeteamcontainer_'+data_tid).show();
				$('.give_team_id').hide();
				
				$('.give_team_id_'+data_tid).show();
				$('.rdp-card-list2').show();
				$('#team-card-list').hide();
			});
			$(".extc-close").click(function(){
				<?php if(isset($_GET['team'])){ ?>
					window.location.href = "<?php echo get_page_link($current_page_id); ?>";
					return false;
				<?php } ?>
				$('#team-card-list').show();
				$('.expandeteamcontainer').hide();
				$('.give_team_id').hide();
				$('.rdp-card-list2').hide();
			});

			<?php if(isset($_GET['team'])){ ?>
				var defaulty_team_id = '<?php echo $defaulty_team_id; ?>';
				$("#Donors,.donars_section .tab, #team-card-list").hide();
				$('.expandeteamcontainer_'+defaulty_team_id).show();
				$('.rdp-card-list2').show();
				$('.give_team_id').hide();
				$('.give_team_id_'+defaulty_team_id).show();
				$("#Teams").show();
			<?php } ?>
		});
	</script>
	<?php
	return ob_get_clean();
}
add_shortcode( 'my_donor_list', 'give_donor_list_shortcode_function_example',100 );

// Goal List Shortcode
function give_goal_list_shortcode_function_example( $atts ) {
	ob_start();
	
	$_give_wp_give_multiplying_field_input = give_get_meta(  $atts['form_id'], '_give_wp_give_multiplying_field_input', true );
	$_multiplying_field_input = '1';
	if($_give_wp_give_multiplying_field_input != ''){
		$_multiplying_field_input = $_give_wp_give_multiplying_field_input;
	}

	$_give_form_earnings = give_get_meta(  $atts['form_id'], '_give_form_earnings', true ) * $_multiplying_field_input;
	$_give_set_goal = give_get_meta(  $atts['form_id'], '_give_set_goal', true );
	$total_p_earn = round($_give_form_earnings * 100 / $_give_set_goal);
	$_bonus_round = give_get_meta(  $atts['form_id'], '_bonus_round', true );
	?>
	<style>
		.goals{margin-bottom:20px}
		.goals .bouns_goal_div{margin-bottom:20px;text-align:center}
		.goals .bouns-goal-point{text-transform:uppercase;color:#579e19;font-size:24px;margin-top:20px;margin-bottom:10px!important;font-weight:700;}
		.text-center{text-align:center}
		.product_pledged{color:#333;float:left;font-size:30px;font-weight:bolder;margin:0 0 10px;text-align:center;width:100%;line-height:60px;margin-bottom:10px!important}
		.product_pledged span{font-size: 15px;color: #909090;}
		.RSPBprogressBar{height:10px;line-height:1;border-radius:10px;position:relative;background-color:hsla(0,0%,82.7%,.6);display:flex;justify-content:space-between;align-items:center;z-index:0}
		.RSPBprogressBar{overflow:hidden;position:relative}
		.RSPBprogressBar .RSPBprogression{position:absolute;transition:width .3s ease;left:0;top:0;bottom:0;border-radius:10px;background:rgba(0,116,217,.8);z-index:-1}
		.percent_br{display:block;margin:20px 0;color:#909090;font-size:16px;position:relative;font-weight:700;}
		.percent_br,.shr_trsur_box{text-align:center;float:left;width:100%}
	</style>
		<div class="side-clock aos-init aos-animate">
			<section class="goals">
				<div class="bouns_goal_div">
					<img src="<?php echo get_site_url(); ?>/wp-content/plugins/give-multiplying-factor/assets/images/goal_successful.png" alt="Success">
				</div>
				<p class="bouns-goal-point text-center">
				<?php
				if($total_p_earn > 100){
					echo 'BONUS ROUND</p>';
				}else{
					echo 'GOAL '.number_format($_give_set_goal,0).' USD</p>';
				}
				?>
			</section>
			<section>
				<?php if($total_p_earn > 100){
					$total_p_earn_2 = ($total_p_earn / 100);
					$total_p_earn_2 = round(100 / $total_p_earn_2);
					?>
					<span class="percent_br" style="position: absolute;float: right;text-align: right;margin-top: -25px;font-size: 15px;"><?php echo $total_p_earn; ?>% </span>
					<div class="RSPBprogressBar" style="background: #29df72; width: 100%; height: 20px;box-shadow: inset 0 1px 4px ##29df72;">
						<div class="RSPBprogression" style="#4252f5 none repeat scroll 0% 0%; width: <?php echo $total_p_earn_2; ?>%;">
						</div>
					</div>
					<p class="product_pledged">$<?php echo number_format($_give_form_earnings,0); ?><span> of $<?php echo $_bonus_round; ?></span></p>
					<div> <i class="far fa-check-circle" style="color: #2995c3;margin-right: 5px;"></i>Original goal: $<?php echo number_format($_give_set_goal,0); ?></div>
				<?php }else{ ?>
					<p class="product_pledged">$<?php echo number_format($_give_form_earnings,0); ?></p>
					<div class="RSPBprogressBar" style="background: #f1f1f1; width: 100%; height: 20px;box-shadow: inset 0 1px 4px rgba(0,0,0,.09487);">
						<div class="RSPBprogression" style="background: #29df72 none repeat scroll 0% 0%; width: <?php echo $total_p_earn; ?>%;">
						</div>
					</div>
					<span class="percent_br"><?php echo number_format($total_p_earn); ?>% </span>
				<?php } ?>
			</section>
		</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'my_goal_list', 'give_goal_list_shortcode_function_example',100 );

function multiplying_form_function() {
    ?>
	<script>
		jQuery( document ).ready(function() {
			setTimeout(function(){
				var give_form_id = jQuery('[name="give-form-id"]').val();
				if (typeof give_form_id == "undefined"){
					give_form_id = jQuery('[name="give-embed-form"]').contents().find('[name="give-form-id"]').val();
				}
				<?php if(isset($_GET['team_id'])){ ?>
					var team_id = '<?php echo $_GET['team_id']; ?>';
				<?php }else{ ?>
					var team_id = '';
				<?php } ?>

				<?php if(isset($_GET['team'])){ ?>
					var team_name = '<?php echo $_GET['team']; ?>';
				<?php }else{ ?>
					var team_name = '';
				<?php } ?>
				var get_the_ID = '<?php echo get_the_ID(); ?>';
				if(typeof give_form_id != "undefined"){
					jQuery.ajax({
						type: 'POST',
						url: '<?php echo get_site_url(); ?>/wp-admin/admin-ajax.php',
						data: {
							"action" : "get_multiplying_data",
							"post_id" : give_form_id,
							"team_id" : team_id,
							"team_name" : team_name,
							"get_the_ID" : get_the_ID
						},
						success: function (data) {
							var myFrame = jQuery('[name="give-embed-form"]').contents().find('.give-total-wrap'); 
							myFrame.append(data); 
							jQuery('.give-total-wrap').append(data); 
						}
					});
				}
			},1000);
		});
	</script>
	<?php
}
add_action('wp_footer', 'multiplying_form_function',100,1);

function get_multiplying_data(){
	global $wpdb;
	$wp_give_multiplying = 1;
	$_receiver_name = '';
	$form_id = $_POST['post_id'];
	$get_the_ID = $_POST['get_the_ID'];

	$wp_give_multiplying = give_get_meta( $form_id, '_give_wp_give_multiplying_field_input', true );
	if($wp_give_multiplying != ''){
		$_receiver_name = give_get_meta( $form_id, '_receiver_name', true );
		$_give_form_earnings = give_get_meta( $form_id, '_give_form_earnings', true );
		$_give_form_template = give_get_meta( $form_id, '_give_form_template', true );
	}
	$_bonus_round = give_get_meta(  $form_id, '_bonus_round', true );
	if($wp_give_multiplying != 1 && $wp_give_multiplying != '' ){ ?>
		<?php if($_give_form_template == 'sequoia'){ ?>
			<div class="ctm_round_div">
				<p style="font-size: 20px;margin-left: 30px;">Combined with Matched Pledges <span style="background: #4fa651;color: #fff;padding: 5px;border-radius: 50%;font-weight: 700;">X<?php echo $wp_give_multiplying; ?></span></p>
				<p style="font-size: 20px;margin-left: 30px;" class="ctm_round_div_price"><?php echo $_receiver_name; ?> Receives = <span>$<?php echo $default_amount * $wp_give_multiplying; ?></span></p>
			</div>
		<?php }else{ ?>
			<div class="ctm_round_div" style="float:left;">
				<p style="font-size: 20px;margin: 0;">Combined with Matched Pledges <span style="background: #4fa651;color: #fff;padding: 5px;border-radius: 50%;font-weight: 700;">X<?php echo $wp_give_multiplying; ?></span></p>
				<p style="font-size: 20px;margin-bottom: 10px;" class="ctm_round_div_price"><?php echo $_receiver_name; ?> Receives = <span>$<?php echo $default_amount * $wp_give_multiplying; ?></span></p>
			</div>
		<?php } ?>
		<script>
			var wp_give_multiplying = '<?php echo $wp_give_multiplying ?>';
			var bonus_round = '<?php echo $_bonus_round ?>';
			<?php if($_give_form_template == 'sequoia'){ ?>
				var goal = jQuery('.goal .number').html();
				if(goal != ''){
					var goal_array = goal.split("$");
					var goal_number = Number(goal_array[1].replace(/[^0-9.-]+/g,""));

					var raised = jQuery('.raised .number').html();
					var raised_array = raised.split("$");
					var raised_number = Number(raised_array[1].replace(/[^0-9.-]+/g,""));
					var raised_val = raised_number;
					jQuery('.raised .number').html('$'+raised_val);

					var progress_bar = 	raised_val * 100 / goal_number;
					progress_bar = Math.round(progress_bar);
					jQuery('.give-progress-bar span').css("width", progress_bar+"%");
					if(progress_bar > 100){
						temp = progress_bar/100;
						var progress_bar_par = Math.round(100 / temp);
						jQuery('.give-progress-bar').hide();
						jQuery('.progress-bar').append('<br><section class="goals"><p class="bouns-goal-point text-center">BONUS ROUND</p></section><section><span class="percent_br" style="position: absolute;float: right;text-align: right;margin-top: -25px;font-size: 15px;">'+progress_bar+'% </span><div class="RSPBprogressBar" style="background: #29df72;  height: 20px;box-shadow: inset 0 1px 4px #29df72;margin: 0 15px;width: calc(100% - 30px);"><div class="RSPBprogression" style="background: #4252f5 none repeat scroll 0% 0%; width: '+progress_bar_par+'%;"></div></div><p class="product_pledged">$'+raised_val+'<span> of $'+bonus_round+'</span></p><div style="float: left;margin-left: 15px;"> <i class="far fa-check-circle" style="color: #2995c3;margin-right: 5px;"></i>Original goal: $'+goal_number+'</div></section>');
					}

				}
			<?php }else{ ?>
				var goal = jQuery('.raised .goal-text').html();
				if(goal != ''){
					var goal_array = goal.split("$");
					var goal_number = Number(goal_array[1].replace(/[^0-9.-]+/g,""));

					var raised = jQuery('.raised .income').html();
					var raised_array = raised.split("$");
					var raised_number = Number(raised_array[1].replace(/[^0-9.-]+/g,""));
					var raised_val = raised_number * wp_give_multiplying;
					jQuery('.raised .income').html('$'+raised_val);

					var progress_bar = 	raised_val * 100 / goal_number;
					progress_bar = Math.round(progress_bar);
					jQuery('.give-progress-bar span').css("width", progress_bar+"%");
					if(progress_bar > 100){
						temp = progress_bar/100;
						var progress_bar_par = Math.round(100 / temp);
						jQuery('.raised').hide();
						jQuery('.give-progress-bar').hide();
						jQuery('.give-goal-progress').append('<section class="goals"><p class="bouns-goal-point text-center">BONUS ROUND</p></section><section><span class="percent_br" style="text-align: right;margin-top: -25px;margin-bottom: 0;">'+progress_bar+'% </span><div class="RSPBprogressBar" style="background: #29df72;  height: 20px;box-shadow: inset 0 1px 4px #29df72;margin: 0 15px;width: calc(100% - 30px);"><div class="RSPBprogression" style="background: #4252f5 none repeat scroll 0% 0%; width: '+progress_bar_par+'%;"></div></div><p class="product_pledged">$'+raised_val+'<span> of $'+bonus_round+'</span></p><div style="float: left;margin-left: 15px;"> <i class="far fa-check-circle" style="color: #2995c3;margin-right: 5px;"></i>Original goal: $'+goal_number+'</div></section>');
					}
				}
			<?php
			} ?>
			setInterval(function(){ 
				var give_amount = jQuery('#give-amount').val();
				give_amount = Number(give_amount.replace(/[^0-9.-]+/g,""));
				var ttl = give_amount * wp_give_multiplying;
				jQuery('.ctm_round_div_price span').html('$'+ttl);
			}, 300);
		</script>
			<style>
				.goals{margin-bottom:20px}
				.goals .bouns_goal_div{margin-bottom:20px;text-align:center}
				.goals .bouns-goal-point{text-transform:uppercase;color:#579e19;font-size:24px;margin-top:20px;margin-bottom:10px!important;font-weight:700;}
				.text-center{text-align:center}
				.product_pledged{font-weight:600 !important;color:#333;float:left;font-size:30px;font-weight:bolder;margin:0 0 10px 15px;text-align:left;width:100%;line-height:60px;margin-bottom:10px!important}
				.product_pledged span{font-size: 15px;color: #909090;}
				.RSPBprogressBar{height:10px;line-height:1;border-radius:10px;position:relative;background-color:hsla(0,0%,82.7%,.6);display:flex;justify-content:space-between;align-items:center;z-index:0}
				.RSPBprogressBar{overflow:hidden;position:relative}
				.RSPBprogressBar .RSPBprogression{position:absolute;transition:width .3s ease;left:0;top:0;bottom:0;border-radius:10px;background:rgba(0,116,217,.8);z-index:-1}
				.percent_br{display:block;margin:20px 0;color:#909090;font-size:16px;position:relative;font-weight:700;}
				.percent_br,.shr_trsur_box{text-align:center;float:left;width:100%}
			</style>
	<?php }
	
	if(isset($_POST['team_id']) && $_POST['team_id'] != ''){
		if($_give_form_template == 'sequoia'){
			echo '<div class="ctm_round_div" style="padding-left: 30px;clear:both">';
			echo '<input type="hidden" name="give_team_id" id="give_team_id" class="give_team_id give-select required" value="'.$_POST['team_id'].'">';
			
			global $table_prefix, $wpdb;
			$get_team_name = $wpdb->get_results("SELECT * FROM ".$table_prefix."give_team_module WHERE id = ".$_POST['team_id']);
			echo '<label style="font-size: 20px;">Donation through  '.$get_team_name[0]->name.'</label>';

			echo '</div>';
		}else{
			echo '<div class="ctm_round_div" style="margin-bottom:20px;clear:both">';
			echo '<input type="hidden" name="give_team_id" id="give_team_id" class="give_team_id give-select required" value="'.$_POST['team_id'].'">';
			
			global $table_prefix, $wpdb;
			$get_team_name = $wpdb->get_results("SELECT * FROM ".$table_prefix."give_team_module WHERE id = ".$_POST['team_id']);
			echo '<label style="font-size: 20px;">Donation through  '.$get_team_name[0]->name.'</label>';

			echo '</div>';
		}
	}else{
		if(isset($_POST['team_name']) && $_POST['team_name'] != ''){
			if($_give_form_template == 'sequoia'){
				global $table_prefix, $wpdb;
				$get_team_name = $wpdb->get_results("SELECT * FROM ".$table_prefix."give_team_module WHERE name = '".$_POST['team_name']."' AND page_id = ".$get_the_ID);
				echo '<div class="ctm_round_div" style="padding-left: 30px;clear:both">';
				echo '<input type="hidden" name="give_team_id" id="give_team_id" class="give_team_id give-select required" value="'.$get_team_name[0]->id.'	">';
				echo '<label style="font-size: 20px;">Donation through  '.$_POST['team_name'].'</label>';
				echo '</div>';
			}else{
				global $table_prefix, $wpdb;
				$get_team_name = $wpdb->get_results("SELECT * FROM ".$table_prefix."give_team_module WHERE name = '".$_POST['team_name']."' AND page_id = ".$get_the_ID);
				echo '<div class="ctm_round_div" style="margin-bottom:20px;clear:both">';
				echo '<input type="hidden" name="give_team_id" id="give_team_id" class="give_team_id give-select required" value="'.$get_team_name[0]->id.'">';
				echo '<label style="font-size: 20px;">Donation through  '.$_POST['team_name'].'</label>';
				echo '</div>';
			}
		}else{
			echo '<div class="ctm_round_div" style="margin-bottom:20px;clear:both">';
			echo '<input type="hidden" name="give_team_id" id="give_team_id" class="give_team_id give-select required" value="0">';
			echo '<label style="font-size: 20px;" class="give_team_title"></label>';
			echo '</div>';
		}
	}
	
    die;
}
add_action( 'wp_ajax_nopriv_get_multiplying_data', 'get_multiplying_data' );
add_action( 'wp_ajax_get_multiplying_data', 'get_multiplying_data' );

function myprefix123_give_team( $payment_id ) {
	if ( isset( $_POST['give_team_id'] ) ) {
		$message = wp_strip_all_tags( $_POST['give_team_id'], true );
    	give_update_payment_meta( $payment_id, 'give_team_id', $message );
  	}
}
add_action( 'give_insert_payment', 'myprefix123_give_team' );

// Update multipling factor
function update_give_wp_give_team_option(){
	global $wpdb;
	$_team_option = $_POST['_team_option'];
	$post_id = $_POST['post_id'];

	$result = give_get_meta(  $post_id, '_team_option', true );
	
	if($result == ''){
		echo 1;
		give_update_meta($post_id,'_team_option',$_team_option);
	}else{
		echo 2;
		give_update_meta($post_id,'_team_option',$_team_option);
	}
	die;
}	
add_action( 'wp_ajax_update_give_wp_give_team_option', 'update_give_wp_give_team_option' );

function create_plugin_database_table2()
{
    global $table_prefix, $wpdb;

    $tblname = 'give_team_module';
    $wp_track_table = $wpdb->prefix . "$tblname ";

    #Check to see if the table exists already, if not, then create it

    if($wpdb->get_var( "show tables like $wp_track_table" ) != $wp_track_table) 
    {
      $sql = "CREATE TABLE $wp_track_table (
          id int NOT NULL PRIMARY KEY auto_increment,
          page_id varchar(255), 
          name varchar(255),
          image varchar(255),
          status varchar(255),
          goal varchar(255),
          bonus_goal varchar(255)
      )";
      require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
      dbDelta($sql);
    }
}
register_activation_hook( __FILE__, 'create_plugin_database_table2' );

function wporg_add_custom_box4() {
	$screens = [ 'page'];
	foreach ( $screens as $screen ) {
		add_meta_box(
			'wporg_box_id4',                 // Unique ID
			'Team Option',      // Box title
			'wporg_custom_box_html4',  // Content callback, must be of type callable
			$screen                            // Post type
		);
	}
}

add_action( 'add_meta_boxes', 'wporg_add_custom_box4' );
function wporg_custom_box_html4( $post ) {
	$_post_id = $_GET['post'];
	$_team_enable = get_post_meta($_post_id,'_team_enable',true);
	global $table_prefix, $wpdb;
	$_team_option_data = array();
	if(isset($_GET['post'])){
		$_team_option_data = $wpdb->get_results("SELECT * FROM ".$table_prefix."give_team_module WHERE page_id = ".$_GET['post']);
	}
	?>
	<form  method="POST" action="#">
		<div style="margin-bottom:10px;">
			<label style="width: 20%;display: block;margin-bottom:5px;"></label>
			<input type="radio" name="_team_enable" value="1" <?php if($_team_enable == 1){echo 'checked';} ?>> Enable
			<input type="radio" name="_team_enable" value="0" <?php if($_team_enable == 0){echo 'checked';} ?>> Disable
		</div>
		<div class="form_enabel_div" <?php if($_team_enable != 1){echo 'style="display:none"';} ?>>
			<div style="margin-bottom:10px;">
				<label style="width: 20%;display: block;margin-bottom:5px;">Name:</label>
				<input type="text" class="form-control" name="keyword"  placeholder="Name" value="" style="width:20%" id="Name">
			</div>
			
			<div style="margin-bottom:10px;">
				<label style="width: 20%;display: block;margin-bottom:5px;">Image:</label>
				<a href="#" class="team-upl" style="height: 0;">Upload Profile</a>
				<input type="hidden" name="team-img" class="team-img" value="">
			</div>

			<div style="margin-bottom:10px;">
				<label style="width: 20%;display: block;margin-bottom:5px;">Goal:</label>
				<input type="text" class="form-control" name="goal" placeholder="Goal" value="" style="width:20%" id="goal">
			</div>
			
			<div style="margin-bottom:10px;">
				<label style="width: 20%;display: block;margin-bottom:5px;">Bonus Goal:</label>
				<input type="text" class="form-control" name="bonus_goal" placeholder="Bonus Goal" value="" style="width:20%" id="bonus_goal">
			</div>
			<div style="margin-bottom:10px;">
				<label style="width: 20%;display: block;margin-bottom:5px;">Status:</label>
				<input type="radio" name="team_status" value="1"  checked> Active
				<input type="radio" name="team_status" value="0"> Inactive
			</div>
			<br>
			<div style="margin-bottom:10px;">
				<label style="width: 20%;display: block;margin-bottom:5px;"></label>
				<input type="button" class="form-control button"  placeholder="Description" value="Save" name="update_entry" style="width:20%" id="add_team_option">
			</div>
			<br />
			<table id="team_option_table" class="display" style="width:100%;text-align:left;">
				<thead>
					<tr>
						<th>Name</th>
						<th>Image</th>
						<th>Goal</th>
						<th>Bonus Goal</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					for($i=0;$i<count($_team_option_data);$i++){
						$active = 'Inactive';
						if($_team_option_data[$i]->status == 1){
							$active = 'Active';
						}
						$img_src = wp_get_attachment_image_src($_team_option_data[$i]->image);

						$view_style = '';
						if($_team_option_data[$i]->status != 1){
							$view_style = 'style="display:none"';
						}
						echo '<tr class="team_option_'.$_team_option_data[$i]->id.'">
							<input type="hidden" class="team_option_name_'.$_team_option_data[$i]->id.'" value="'.$_team_option_data[$i]->name.'">
							<input type="hidden" class="team_option_img_'.$_team_option_data[$i]->id.'" value="'.$_team_option_data[$i]->image.'">
							<input type="hidden" class="team_option_img_src_'.$_team_option_data[$i]->id.'" value="'.$img_src[0].'">
							<input type="hidden" class="team_option_goal_'.$_team_option_data[$i]->id.'" value="'.$_team_option_data[$i]->goal.'">
							<input type="hidden" class="team_option_bonus_goal_'.$_team_option_data[$i]->id.'" value="'.$_team_option_data[$i]->bonus_goal.'">
							<input type="hidden" class="team_option_status_'.$_team_option_data[$i]->id.'" value="'.$_team_option_data[$i]->status.'">
							<td>'.$_team_option_data[$i]->name.'</td>
							<td><img style="width: 40px;" src="'.$img_src[0].'"></td>
							<td>$'.$_team_option_data[$i]->goal.'</td>
							<td>$'.$_team_option_data[$i]->bonus_goal.'</td>
							<td>'.$active.'</td>
							<td>
								<a href="'.get_permalink($_post_id).'?team='.$_team_option_data[$i]->name.'" target="_blank" '.$view_style.'>View</a>
								<a href="javascript:void(0)" edit_id="'.$_team_option_data[$i]->id.'" class="edit_team_option">Edit</a>
								<a href="javascript:void(0)" del_id="'.$_team_option_data[$i]->id.'" class="delete_team_option">Delete</a>
							</td>
						</tr>';
					}
					?>
					
				</tbody>
				<tfoot>
					<tr>
						<th>Name</th>
						<th>Image</th>
						<th>Goal</th>
						<th>Bonus Goal</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</form>
	
	<script>
		jQuery(function($){
			$('body').on( 'click', '.team-upl', function(e){
				e.preventDefault();
				var button = $(this),
				custom_uploader = wp.media({
					title: 'Insert image',
					library : {
						type : 'image'
					},
					button: {
						text: 'Use this image'
					},
					multiple: false
				}).on('select', function() {
					var attachment = custom_uploader.state().get('selection').first().toJSON();
					console.log(attachment.id);
					button.html('<img src="' + attachment.url + '">').next().val(attachment.id).next().show();
					$('[name="team-img"]').val(attachment.id);
					$('[name="team-img"]').attr('src',attachment.url);
				}).open();
			});

			var edit_id = 0;
			jQuery(document).on('click', '#add_team_option', function () {
                var team_img = jQuery(".team-img").val();
				var team_img_src = jQuery(".team-img").attr('src');
				var Name = jQuery("#Name").val();
				var goal = jQuery("#goal").val();
				var bonus_goal = jQuery("#bonus_goal").val();
				var team_status = $('input[name="team_status"]:checked').val();
				var post_id = jQuery("#post_ID").val();

				if(Name == ''){
					alert('Name is required');
					return false;
				}
				if(team_img == ''){
					alert('Image is required');
					return false;
				}
				if(goal == ''){
					alert('Goal is required');
					return false;
				}
				if(bonus_goal == ''){
					alert('Bonus Goal is required');
					return false;
				}
                var dataString = {
					post_id : post_id,
					Name : Name,
					team_img : team_img,
					goal : goal,
					bonus_goal : bonus_goal,
					team_status : team_status,
					status : 1,
					edit_id : edit_id,
					action : 'add_team_ajax_funtion'
				};

				jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: dataString,
					success: function (data) {
						edit_id = 0;
						alert('Data Saved successfully!');
						var table_column = '<tr class="team_option_'+data+'">';
						table_column +='<input type="hidden" class="team_option_name_'+data+'" value="'+Name+'">';
						table_column +='<input type="hidden" class="team_option_img_'+data+'" value="'+team_img+'">';
						table_column +='<input type="hidden" class="team_option_img_src_'+data+'" value="'+team_img_src+'">';
						table_column +='<input type="hidden" class="team_option_goal_'+data+'" value="'+goal+'">';
						table_column +='<input type="hidden" class="team_option_bonus_goal_'+data+'" value="'+bonus_goal+'">';
						table_column +='<input type="hidden" class="team_option_status_'+data+'" value="'+team_status+'">';
						var active = 'Inactive';
						if(team_status == 1){
							active = 'Active';
						}
						table_column +='<td>'+Name+'</td>';
						table_column +='<td><img style="width: 40px;" src="'+team_img_src+'"></td>';
						table_column +='<td>$'+goal+'</td>';
						table_column +='<td>$'+bonus_goal+'</td>';
						table_column +='<td>'+active+'</td>';
						table_column +='<td>';
						
						if(team_status == 1){
							table_column +='<a href="<?php echo get_permalink($_post_id); ?>?team='+Name+'" target="_blank">View</a>';
						}

						table_column +=' <a href="javascript:void(0)" edit_id="'+data+'" class="edit_team_option">Edit</a>';
						table_column +=' <a href="javascript:void(0)" del_id="'+data+'" class="delete_team_option">Delete</a>';
						table_column +='</td>';
						table_column +='</tr>';
						$('#team_option_table tbody').append(table_column);


						$('#Name').val('');
						$('.team-img').val('');
						$('.team-upl').html('Upload Profile');
						$('#goal').val('');
						$('#bonus_goal').val('');
						$('#Name').focus();
					}
				});
			});
		
			jQuery(document).on('keypress', '#goal,#bonus_goal', function () {
				if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
				{
					return false;
				}
			});
			jQuery(document).on('change', 'input[name="_team_enable"]', function () {
				var _team_enable = jQuery('input[name="_team_enable"]:checked').val();
				var post_id = jQuery("#post_ID").val();

				var dataString = {
					_team_enable : _team_enable,
					post_id : post_id,
					status : 0,
					action : 'add_team_ajax_funtion'
				};

				jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: dataString,
					success: function (data) {
						if(_team_enable == 1){
							$('.form_enabel_div').show();
						}else{
							$('.form_enabel_div').hide();
						}
					}
				});
			});

			jQuery(document).on('click', '.edit_team_option', function () {
				var txt;
				var r = confirm("Are you sure you want to edit the data?");
				if (r == true) {
					edit_id = $(this).attr('edit_id');
					var name = $(".team_option_name_"+edit_id).val();
					var image = $(".team_option_img_"+edit_id).val();
					var image_src = $(".team_option_img_src_"+edit_id).val();
					var goal = $(".team_option_goal_"+edit_id).val();
					var bonus_goal = $(".team_option_bonus_goal_"+edit_id).val();
					var status = $(".team_option_status_"+edit_id).val();
					
					$('#Name').val(name);
					$('.team-img').val(image);
					$('.team-img').attr('src',image_src);
					$('.team-upl').html('<img src="'+image_src+'">');
					$('#goal').val(goal);
					$('#bonus_goal').val(bonus_goal);
					$("input[name=team_status][value='"+status+"']").prop("checked",true);
					$('.team_option_'+edit_id).remove();
					$('#Name').focus();
				}
			});

			jQuery(document).on('click', '.delete_team_option', function () {
				var txt;
				var r = confirm("Are you sure you want to delete the data?");
				if (r == true) {
					del_id = $(this).attr('del_id');
					
					$('.team_option_'+del_id).remove();
					$('#Name').focus();

					var dataString = {
						del_id : del_id,
						status : 2,
						action : 'add_team_ajax_funtion'
					};

					jQuery.ajax({
						type: 'POST',
						url: ajaxurl,
						data: dataString,
						success: function (data) {
						}
					});
				}
			});
			
			$('body').on('click', '.team-rmv', function(e){
				e.preventDefault();
				var button = $(this);
				button.next().val('');
				button.hide().prev().html('Upload Profile');
			});
		});
	</script>
	<?php
}

// Update multipling factor
function add_team_ajax_funtion(){
	if($_POST['status'] == 0){
		$post_id = $_POST['post_id'];
		$_team_enable = $_POST['_team_enable'];
		update_post_meta($post_id,'_team_enable',$_team_enable);
	}
	if($_POST['status'] == 1){
		$post_id = $_POST['post_id'];
		$team_img = $_POST['team_img'];
		$Name = $_POST['Name'];
		$goal = $_POST['goal'];
		$bonus_goal = $_POST['bonus_goal'];
		$team_status = $_POST['team_status'];
		$edit_id = $_POST['edit_id'];
		global $table_prefix, $wpdb;
		if($edit_id == 0){
			$wpdb->query("INSERT INTO ".$table_prefix."give_team_module(page_id, name, image, status, goal, bonus_goal) VALUES ('$post_id', '$Name', '$team_img', '$team_status', '$goal', '$bonus_goal')");
			echo $wpdb->insert_id;
		}else{
			$wpdb->query("UPDATE ".$table_prefix."give_team_module SET name = '$Name', image = '$team_img', status = '$team_status', goal = '$goal', bonus_goal = '$bonus_goal' WHERE id = $edit_id");
			echo $edit_id;
		}
	}
	if($_POST['status'] == 2){
		$del_id = $_POST['del_id'];
		global $table_prefix, $wpdb;
		$wpdb->query("DELET FROM  wp_give_team_module WHERE id = $del_id");
	}
	die;
}	
add_action( 'wp_ajax_add_team_ajax_funtion', 'add_team_ajax_funtion' );
?>