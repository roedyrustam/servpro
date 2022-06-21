<?php
   $lang = $this->data['lang_val'];
   $currency = $this->data["default_currency"]["value"];
   $stripe_show = $this->db->get('payment_gateways')->row()->status;
   $paypal_show = $this->db->get('paypal_details')->row()->status;
   $paytabs_show = $this->db->get('paytabs_details')->row()->status;
   $razor_show = $this->db->get('razorpay_gateway')->row()->status;
   $query = $this->db->query("SELECT * FROM offline_payment");
   $offline_payment = $query->row_array();
   ?>
<!-- Breadcrub -->
<div class="breadcrub">
   <div class="container">
      <?php
         $subscription = $language_content['language'];
         $subscription_array = !empty($subscription)?$subscription:'';
         ?>
      <ul>
            <li><a href="<?php echo $base_url; ?>home"><?php echo $subscription_array['lg_home']; ?></a></li>
         <li><?php echo $subscription_array['lg5_payment_process']; ?></li>
      </ul>
   </div>
</div>
<!-- /Breadcrub -->
<div class="content mb-5 pt-3">
<div class="container">
    <?php if($this->session->flashdata('error_message')) {  ?>
      <div class="alert alert-danger text-center in" id="flash_error_message"><?php echo $this->session->flashdata('error_message');?></div>
      <?php $this->session->unset_userdata('error_message');
         } ?>
      <?php if($this->session->flashdata('success_message')) {  ?>
      <div class="alert alert-success text-center in" id="flash_success_message"><?php echo $this->session->flashdata('success_message');?></div>
      <?php $this->session->unset_userdata('success_message');
         } ?>
   <div class="row"> 
      <?php
         if(!empty($list)){
           foreach ($list as $subscription) {  $subscription_name = $subscription['subscription_name']; ?>
      <div class="col-12 col-md-4 col-lg-3">
         <?php if(!empty($my_subscribe['subscription_id']) && $subscription['id'] == $my_subscribe['subscription_id']){ ?>
         <div class="pricing-box active">
            <?php } else { ?>
            <div class="pricing-box">
               <?php }
                  ?>
               <h3 class="pricing-title" data-toggle="tooltip" data-placement="top" title="<?php echo $subscription['subscription_name']; ?>">
                  <?php 	$nxt = 1;
                     foreach ($lang as $key => $value) { 
                     $sub_name = ucfirst($subscription_name);  
                     
                     if($value["lang_key"] === "lg_tit_rank_$sub_name"){
                     echo $lan_val = $value["lang_value"];
                     $nxt = 0;
                     }
                     }
                     if($nxt == 1){
                     echo $subscription_name;
                     }	
                     ?>	
               </h3>
               <?php 
                  $usercurrency_code = $this->session->userdata('usercurrency_code');
                  if($usercurrency_code){
                  	$curr_amt =$subscription['fee'];
                  	$ccode = $usercurrency_code;
                  }else{
                  	$curr_amt = $subscription['fee'];
                  	$ccode = $default_currency['value'];
                  }
                   ?>	
               <h1 class="pricing-rate"><span><?php echo $ccode; ?></span><?php echo $curr_amt; ?></h1>
               <input type="hidden" name="ccur_code" id="ccurr_code" value="<?php echo $ccode;?>">
               <p class="subs-duration">
                  <?php  $sub_desc = $subscription['fee_description'];
                     $nxt = 1;
                                 			foreach ($lang as $key => $value) { 
                             				  
                     	
                     	if($value["lang_key"] === "lg_per_subscription_mode_$sub_desc"){
                     		echo $lan_val = $value["lang_value"];
                     		$nxt = 0;
                     	}
                     }
                     if($nxt == 1){
                     	echo $sub_desc;
                     }	
                                 	 ?>	
               </p>
               <?php
               
              
                if(!empty($my_subscribe['subscription_id']) && $subscription['id'] == $my_subscribe['subscription_id'] && !empty($offline_subscribe['status']) != '1' && !empty($offline_subscribe['tokenid']) != 'Offline Payment'){  ?>
               <a href="javascript:void(0);" class="btn"><?php echo $subscription_array['lg5_subscribed']; ?></a>

               <?php } elseif (!empty($my_subscribe['subscription_id']) && $subscription['id'] == $my_subscribe['subscription_id'] && $offline_subscribe['status'] == '1' && $offline_subscribe['tokenid'] == 'Offline Payment') { ?>
                  <a href="javascript:void(0);" class="btn">pending</a>

               <?php }elseif (!empty($my_subscribe['subscription_id']) && $subscription['id'] == $my_subscribe['subscription_id'] && $offline_subscribe['status'] == '2' && $offline_subscribe['tokenid'] == 'Offline Payment') { ?>
                 <a href="javascript:void(0);" class="btn"><?php echo $subscription_array['lg5_subscribed']; ?></a>

               <?php } else { ?>
               <a data-target="#payment_methods" href="javascript:void(0);" onclick="get_all_payment_method('<?php echo $subscription['id']; ?>','<?php echo $subscription['fee']; ?>')" class="btn btn-primary rounded w-md" data-id="<?php echo $subscription['id']; ?>" data-amount="<?php echo $curr_amt; ?>" ><?php echo $subscription_array['lg5_buy']; ?></a>
            
               <?php }?>

     
            </div>
         </div>
         <?php } }  ?>
      </div>
      <div class="row">
         <div class="col-sm-8 col-md-8 col-lg-8">
            <div class="gigs-form-01 wd-100" id="payment_methods" style="display: none;">
               <h5>Buy Via</h5>
               <form action="<?php echo base_url().'user/subscription/payment'; ?>" method="post" id="subscriptionpayment_formid" name="payment_submit">
                  <input type="hidden" name="sub_id" id="sub_id" value="">
                  <input type="hidden" name="subs_amt" id="subs_amt" value="">
                  <?php if ($paypal_show == 1) { ?>
                  <span>
                  <input type="radio" id="gigs_payment_radio3" data-id="<?php echo '15'; ?>" data-amount="<?php echo "2"; ?>"  name="group2" value="Direct">
                  <label for="gigs_payment_radio3" > <img src="<?php echo base_url(); ?>assets/img/paypal.png" alt="Paypal"></label>
                  </span>
                  <?php }  ?>
                  <?php if ($paytabs_show == 1) { ?>
                  <span>
                  <input type="radio" id="gigs_payment_radio4" data-id="<?php echo '15'; ?>" data-amount="<?php echo "2"; ?>" name="group2"  value="PayTabs">
                  <label for="gigs_payment_radio4"> <img src="<?php echo base_url(); ?>assets/img/paytabs.png" alt="PayTabs"></label>
                  </span>
                  <?php }  ?>
                  <?php if ($stripe_show == 1) { ?>
                  <span>
                  <input type="radio" id="gigs_payment_radio5"   data-id="<?php echo '15'; ?>" data-amount="<?php echo "2"; ?>" name="group2" value="stripe">
                  <label for="gigs_payment_radio5"> <img src="<?php echo base_url(); ?>assets/img/stripe.png" alt="stripe"></label>
                  </span>
                  <?php } ?>
                  <?php if ($razor_show == 1) { ?>
                  <span>
                  <input type="radio" id="gigs_payment_radio6" name="group2"  data-id="<?php echo '15'; ?>" data-amount="<?php echo "2"; ?>" value="RazorPay">
                  <label for="gigs_payment_radio6"> <img src="<?php echo base_url(); ?>assets/img/razorpay.png" alt="RazorPay"></label>
                  </span>
                  <?php } ?>
                  <?php if ($offline_payment['status'] == 1) { ?>
                  <span>
                  <input type="radio" id="gigs_payment_radio6" name="group2"  data-id="<?php echo '15'; ?>" data-amount="<?php echo "2"; ?>" value="Offline">
                  <label>Offline Payment</label>
               </span>
                <?php } ?>
               <br><br>
                  <div class="col-sm-8 col-md-8 col-lg-8">
                     <a  class="btn btn-primary rounded w-md" onclick="callpaygateway()"  id="paysub"> Submit </a>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
   function get_all_payment_method(sub_id,subs_amt)
   {//alert();
   	if(subs_amt!=0.00)
   	{
   	document.getElementById('payment_methods').style.display='block';
   	document.getElementById('sub_id').value=sub_id;
   	document.getElementById('subs_amt').value=subs_amt;
   	}
   	else
   	{
   		free_subscription(sub_id,subs_amt);
   	}
   }
</script>
