  <?php
         $subscription = $language_content['language'];
         $subscription_array = !empty($subscription)?$subscription:'';
         ?>
	<section>
		<div class="block gray less-top less-bottom">
			<div class="container">
				<div class="row">
					<div class="col-lg-6">
						<div class="innertitle">
							<h2><?php echo $subscription_array['lg_subscription']; ?></h2>
							<span><?php echo $subscription_array['lg_select_your_payment_method']; ?></span>
						</div>
					</div>
					<div class="col-lg-6">
						<ul class="breadcrumbs">
            <li><a href="<?php echo $base_url; ?>home"><?php echo $subscription_array['lg_home']; ?></a></li>
							<li><a><?php echo $subscription_array['lg_select_your_payment_method']; ?></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>


<section>
   <div class="block">
      <div class="container">
         <div class="row justify-content-center">
            <div class="col-lg-10">
               <!-- PBox -->
                 <input type="text" name="sub_id" id="sub_id" value="<?php echo $postdata; ?>">
                 <input type="text" name="subs_fee" id="subs_fee" value="<?php echo $subs['fee'] ?> ">
               <div class="pbox border">
                  <div class="addlistingform">
                         <form action="#" method="post" id="payment_method">
                                            <div class="form-group">
                                                <div id="payment-method">
                                                    <h3><?php echo $subscription_array['lg_select_your_payment_method']; ?> </h3>
                                       <div class="gigs-form-01 wd-100">
                                          <?php if ($paypal_allow == 1) { ?>
                                          <span>
                                             <input type="radio" id="gigs_payment_radio3" name="group2" value="Direct">
                                             <label for="gigs_payment_radio3"> <img src="<?php echo base_url(); ?>assets/img/paypal.png" alt="Paypal"></label>
                                          </span>
                                          <?php }  ?>
                                          <?php if ($paytabs_allow == 1) { ?>
                                          <span>
                                             <input type="radio" id="gigs_payment_radio4" name="group2" value="PayTabs">
                                             <label for="gigs_payment_radio4"> <img src="<?php echo base_url(); ?>assets/img/paytabs.png" alt="PayTabs"></label>
                                          </span>
                                          <?php }  ?>
                                          <?php if ($stripe_allow == 1) { ?>
                                          <span onclick="callStripe(this)" data-id="<?php echo $postdata; ?>" data-amount="<?php echo $subs['fee']; ?>" id="stripe_wallet" >
                                             <input type="radio" id="gigs_payment_radio5" name="group2" value="stripe">
                                             <label for="gigs_payment_radio5"> <img src="<?php echo base_url(); ?>assets/img/stripe.png" alt="stripe"></label>
                                          </span>
                                          <?php } ?>
                                          <?php if ($razorpay_allow == 1) { ?>
                                          <span>
                                             <input type="radio" id="gigs_payment_radio6" name="group2" value="RazorPay">
                                             <label for="gigs_payment_radio6"> <img src="<?php echo base_url(); ?>assets/img/razorpay.png" alt="RazorPay"></label>
                                          </span>
                                          <?php } ?>
                                       </div>
                                                </div>
                                                
                      </form>
                  </div>
               </div>
               
              
            </div>
         </div>
      </div>
   </div>
</section>
 <script type="text/javascript">
   function get_paymethod ()
   {
    alert();
    $('#my_stripe_payyment').click();
   }

          $('#stripe_wallet').on('click', function (e) {
            var stripe_amt = $("#wallet_amt").val();
            var payment_type = $('input[name="group2"]:checked').val();   
      if (payment_type == "RazorPay" && payment_type != undefined) {
        var totalAmount = $('#wallet_amt').val();
        var product_id =  '123';
        var product_name =  'Wallet Topup';       
        var options = {
          "key": $('#razorpay_apikey').val(),
          "currency": "INR",
          "amount": totalAmount*100,
          "name": product_name,
          "description": product_name,
          "handler": function (response){
              $.ajax({
              url: base_url+'user/wallet/razor_payment_success',
              type: 'post',
              dataType: 'json',
              data: {
                razorpay_payment_id: response.razorpay_payment_id , totalAmount : totalAmount ,product_id : product_id,
              }, 
              success: function (msg) { 
                 window.location.href = base_url+'user/wallet/razorthankyou?res='+msg;
              }
            });
          },
          "theme": {
            "color": "#F37254"
          }
        }
        var rzp1 = new Razorpay(options);
        rzp1.open();
        e.preventDefault();
        return false;
      }
            if (payment_type == "PayTabs" && payment_type != undefined) {
                if (stripe_amt < 20) {
                    swal({
                        title: min_amount,
                        text: add_min_amount + " 21",
                        icon: "error",
                        button: "okay",
                        closeOnEsc: false,
                        closeOnClickOutside: false
                    });
                    return false;
                }
            }
            if (payment_type == undefined || payment_type == '') {
                swal({
                    title: payments,
                    text: payment_method,
                    icon: "error",
                    button: "okay",
                    closeOnEsc: false,
                    closeOnClickOutside: false
                });
                $("#wallet_amt").select();
                return false;
            }
            if (stripe_amt == '' || stripe_amt < 1) {
                swal({
                    title: empty_amount,
                    text: wallet_field,
                    icon: "error",
                    button: "okay",
                    closeOnEsc: false,
                    closeOnClickOutside: false
                });
                $("#wallet_amt").select();
                return false;
            }
            if (payment_type == "stripe") {
                var final_gig_amount = (stripe_amt * 100); //  dollar to cent
                var striep_currency = $('#user_currency_code').val();
                // Open Checkout with further options:
                handler.open({
                    name: base_url,
                    description: 'Wallet Recharge',
                    amount: final_gig_amount,
                    currency: striep_currency
                });
                e.preventDefault();
            } else {
                $('#paypal_payment').submit();
            }
        });
 </script>