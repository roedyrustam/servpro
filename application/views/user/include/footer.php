<?php
$sticky_header = $this->db->get('header_settings')->row()->sticky_header;
?>
<style type="text/css">
	.pac-container{
		z-index:9999;
	}
	.pac-logo:after{
		display: none !important;
		width: 0;
		height: 0;
	}
</style>
		<script type="text/javascript" src="<?php echo $base_url;?>/assets/js/jquery-3.6.0.js"></script>
		<script type="text/javascript">
		var base_url = "<?php echo $base_url; ?>";
 		var userid = "<?php echo (!empty($this->session->userdata('user_id')))?$this->session->userdata('user_id'):''; ?>";
		</script>
		<script type="text/javascript" src="<?php echo $base_url; ?>assets/js/jquery-3.6.0.min.js"></script>
		<script type="text/javascript" src="<?php echo $base_url; ?>assets/js/popper.min.js"></script>
		<script type="text/javascript" src="<?php echo $base_url; ?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo $base_url; ?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<script type="text/javascript" src="<?php echo $base_url; ?>assets/js/moment.js"></script>
		<script type="text/javascript" src="<?php echo $base_url; ?>assets/js/bootstrap-datetimepicker.min.js"></script>
		<script type="text/javascript" src="<?php echo $base_url; ?>assets/js/theme.js"></script>
		<script type="text/javascript" src="<?php echo $base_url; ?>assets/js/starrating.js"></script>
		<script type="text/javascript" src="<?php echo $base_url; ?>assets/js/bootstrapValidator.min.js"></script>
		<script type="text/javascript" src="<?php echo $base_url; ?>assets/plugins/swiper/js/swiper.min.js"></script>
		<script type="text/javascript" src="<?php echo $base_url; ?>assets/js/theme-new.js"></script>
		<script type="text/javascript" src="<?php echo $base_url; ?>assets/js/app.js"></script>
		<script type="text/javascript" src="<?php echo $base_url; ?>assets/js/select2.full.min.js"></script>
		<script type="text/javascript" src="<?php echo $base_url; ?>assets/js/select2.min.js"></script>
		<script type="text/javascript" src="<?php echo $base_url; ?>assets/js/intlTelInput.js"></script>

		<?php
			$page = $this->uri->segment(1);
		?>
	<?php	if($page == 'signup' || $page == 'edit-profile'){ ?>
		<script type="text/javascript" src="<?php echo $base_url; ?>assets/js/cropper_profile.js"></script>
		<script type="text/javascript" src="<?php echo $base_url; ?>assets/js/cropper_ic_card.js"></script>
		<script type="text/javascript" src="<?php echo $base_url; ?>assets/js/cropper.min.js"></script>


		<script type="text/javascript" src="<?php echo $base_url;?>/assets/js/jquery.validate.js"></script>
	<?php } ?>

	<?php	if($page == 'add-request' || $page == 'add-service' || $page == 'edit-service' || $page == 'edit-request'){ ?>
		<script type="text/javascript" src="<?php echo $base_url; ?>assets/js/cropper_profile.js"></script>
		<script type="text/javascript" src="<?php echo $base_url; ?>assets/js/cropper.min.js"></script>


		<script type="text/javascript" src="<?php echo $base_url;?>/assets/js/jquery.validate.js"></script>
	<?php } ?>

		<script type="text/javascript" src="<?php echo $base_url; ?>assets/js/md5.js"></script>

		<?php	if($page == 'chat' || $page == 'chat-history' || $page == 'requester-chat' || $page == 'requester-chat-history'){ ?>
		<script type="text/javascript"> var page = "<?php echo $page; ?>";</script>
		<script type="text/javascript" src="<?php echo $base_url; ?>assets/js/chats.js"></script>
		<script type="text/javascript" src="<?php echo $base_url; ?>assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
		<?php }  ?>
		<?php if($page=='add-service' || $page=='edit-service'  || $page=='service'){ ?>
			<script type="text/javascript" src="<?php echo $base_url;?>/assets/js/jquery.validate.js"></script>
			<script type="text/javascript" src="<?php echo $base_url; ?>assets/js/bootstrap-select.min.js"></script>
			<script type="text/javascript">
				$(function () {
				    $('.select').selectpicker();
				});

				$(document).ready(function(){

					<?php if($page=='add-service' || $page=='service') { ?>


					$.ajax({
				        type: "GET",
				        url: "<?php echo base_url();?>user/service/get_category",
				        data:{id:$(this).val()},
				        beforeSend :function(){
				          $("#category option:gt(0)").remove();
				          $('#category').selectpicker('refresh');
				          $("#category").selectpicker();
				          $('#category').find("option:eq(0)").html("Please wait..");
				          $('#category').selectpicker('refresh');
				          $("#category").selectpicker();
				        },
				        success: function (data) {
				          $('#category').selectpicker('refresh');
				          $("#category").selectpicker();
				          $('#category').find("option:eq(0)").html("Select Category");
				          $('#category').selectpicker('refresh');
				          $("#category").selectpicker();
				          var obj=jQuery.parseJSON(data);
				          $('#category').selectpicker('refresh');
				          $("#category").selectpicker();
				          $(obj).each(function(){
				            var option = $('<option />');
				            option.attr('value', this.value).text(this.label);
				            $('#category').append(option);
				          });
				          $('#category').selectpicker('refresh');
				          $("#category").selectpicker();
				        }
				      });


				      $('#category').change(function(){

				      	$("#subcategory").val('default');
                        $("#subcategory").selectpicker("refresh");


				      	$.ajax({
				        type: "POST",
				        url: "<?php echo base_url();?>user/service/get_subcategory",
				        data:{id:$(this).val()},
				        beforeSend :function(){
				          $("#subcategory option:gt(0)").remove();
				          $('#subcategory').selectpicker('refresh');
				          $("#subcategory").selectpicker();
				          $('#subcategory').find("option:eq(0)").html("");
				          $('#subcategory').selectpicker('refresh');
				          $("#subcategory").selectpicker();
				        },
				        success: function (data) {
				          $('#subcategory').selectpicker('refresh');
				          $("#subcategory").selectpicker();
				          $('#subcategory').find("option:eq(0)").html("");
				          $('#subcategory').selectpicker('refresh');
				          var obj=jQuery.parseJSON(data);
				          $('#subcategory').selectpicker('refresh');
				          $("#subcategory").selectpicker();
				          $(obj).each(function(){
				            var option = $('<option />');
				            option.attr('value', this.value).text(this.label);
				            $('#subcategory').append(option);
				          });
				          $('#subcategory').selectpicker('refresh');
				          $("#subcategory").selectpicker();
				        }
				      });

				      });

				  <?php } ?>

				  <?php if($page=='edit-service') { ?>


					$.ajax({
				        type: "GET",
				        url: "<?php echo base_url();?>user/service/get_category",
				        data:{id:$(this).val()},
				        beforeSend :function(){
				          $("#category option:gt(0)").remove();
				          $('#category').selectpicker('refresh');
				          $("#category").selectpicker();
				          $('#category').find("option:eq(0)").html("Please wait..");
				          $('#category').selectpicker('refresh');
				          $("#category").selectpicker();
				        },
				        success: function (data) {
				          $('#category').selectpicker('refresh');
				          $("#category").selectpicker();
				          $('#category').find("option:eq(0)").html("Select Category");
				          $('#category').selectpicker('refresh');
				          $("#category").selectpicker();
				          var obj=jQuery.parseJSON(data);
				          $('#category').selectpicker('refresh');
				          $("#category").selectpicker();
				          $(obj).each(function(){
				            var option = $('<option />');
				            option.attr('value', this.value).text(this.label);
				            $('#category').append(option);
				          });
				          var values=$('#category_id').val();
				          var value=values.split(',');
				           $("#category").selectpicker();
				           $("#category").val(value);
				           $('#category').selectpicker('refresh');
				           $("#category").selectpicker();


				        }
				      });


					$.ajax({
				        type: "POST",
				        url: "<?php echo base_url();?>user/service/get_subcategorys",
				        data:{id:$('#category_id').val()},
				        beforeSend :function(){
				          $("#subcategory option:gt(0)").remove();
				          $('#subcategory').selectpicker('refresh');
				          $("#subcategory").selectpicker();
				          $('#subcategory').find("option:eq(0)").html("Please wait..");
				          $('#subcategory').selectpicker('refresh');
				          $("#subcategory").selectpicker();
				        },
				        success: function (data) {
				          $('#subcategory').selectpicker('refresh');
				          $("#subcategory").selectpicker();
				          $('#subcategory').find("option:eq(0)").html("");
				          $('#subcategory').selectpicker('refresh');
				          $("#subcategory").selectpicker();
				          var obj=jQuery.parseJSON(data);
				          $('#subcategory').selectpicker('refresh');
				          $("#subcategory").selectpicker();
				          $(obj).each(function(){
				            var option = $('<option />');
				            option.attr('value', this.value).text(this.label);
				            $('#subcategory').append(option);
				          });
				            var subvalues=$('#subcategory_id').val();
				            var subvalue=subvalues.split(',');
				           $("#subcategory").selectpicker();
				           $("#subcategory").val(subvalue);
				           $('#subcategory').selectpicker('refresh');
				           $("#subcategory").selectpicker();
				        }
				      });


				      $('#category').change(function(){

				      	$.ajax({
				        type: "POST",
				        url: "<?php echo base_url();?>user/service/get_subcategory",
				        data:{id:$(this).val()},
				        beforeSend :function(){
				          $("#subcategory option:gt(0)").remove();
				          $('#subcategory').selectpicker('refresh');
				          $("#subcategory").selectpicker();
				          $('#subcategory').selectpicker('refresh');
				          $("#subcategory").selectpicker();
				        },
				        success: function (data) {
				          $('#subcategory').selectpicker('refresh');
				          $("#subcategory").selectpicker();
				          $('#subcategory').selectpicker('refresh');
				          $("#subcategory").selectpicker();
				          var obj=jQuery.parseJSON(data);
				          $('#subcategory').selectpicker('refresh');
				          $("#subcategory").selectpicker();
				          $(obj).each(function(){
				            var option = $('<option />');
				            option.attr('value', this.value).text(this.label);
				            $('#subcategory').append(option);
				          });
				          $('#subcategory').selectpicker('refresh');
				          $("#subcategory").selectpicker();


				        }
				      });

				      });

				  <?php } ?>

				});
			</script>

		<?php } ?>
		<script type="text/javascript">

				setTimeout(function(){
					$('#flash_success_message').hide();
				}, 5000);
				setTimeout(function(){
					$('#flash_error_message').hide();
				}, 5000);
				<?php
				$page = $this->uri->segment(1);
				if($page == 'service' || $page == 'my-services' || $page == 'service_categories'){
					if($page == 'service'){
						$page_url = 'load_service';
					}
					if($page == 'my-services'){
						$page_url = 'load_myservice';
					}
					if($page == 'service_categories'){
						$page_url = 'load_my_service_categories';
					}
				?>
				var page = '<?php echo $page; ?>';
				$(window).scroll(function() {

   					if($(window).scrollTop() + $(window).height() > $(document).height() - 200) {

   						var nextpage = $('.loadmore_results').attr('data-next-page');
   						var loading = $('.loadmore_results').attr('data-loading');
						var search = $('.loadmore_results').attr('data-search');
						<?php if($page == 'service' || $page == "service_categories") { ?>
							if(nextpage !=-1 && loading == 0 && search == 0){
						<?php }else{ ?>
							if(nextpage !=-1 && loading == 0){
						<?php }  ?>

   							$('.loadmore_results').show();
   							$('.loadmore_results').attr('data-loading',1);
   							$.post(base_url+'<?php echo $page_url; ?>',{nextpage:nextpage},function(data){

       						var results = JSON.parse(data);
       						$('.loadmore_results').attr('data-loading',0);
       						$('.loadmore_results').attr('data-next-page',results['next_page']);

       						var records = results['provider_list'];
       						if(records.length > 0){
       							var html = '';
       							$(records).each(function(i,record){

       								p_id = md5(record.p_id);
											var provider_id =md5(record.provider_id);
       							var profile_img = (record.profile_img !='')?record.profile_img:'assets/img/placeholder.jpg';

										var chat_status = results['subscription_status'];


										html = html +' <div class="col-sm-6"><div class="service-list">';
										if(page == 'my-services'){
											html = html +'<ul class="user-set-menu nav">'+
												'<li class="dropdown">'+
													'<a href="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><img src="'+base_url+'assets/img/menu.png" alt=""></a>'+
													'<ul class="dropdown-menu">'+
													'<li><a href="'+base_url+'edit-service/'+provider_id+'">'+edit_text+'</a></li>'+
													'<li><a href="javascript:void(0)" class="si-delete-service" data-id="'+provider_id+'">'+delete_text+'</a></li>'+
													'</ul>'+
												'</li>'+
											'</ul>';
										 }
									html = html +
								'<a href="'+base_url+'service-view/'+p_id+'">'+
									'<div class="service-content">'+
										'<div class="user-img">'+
											'<img src="'+base_url+profile_img+'"  width="100" height="100" alt="">'+
										'</div>'+
										'<div class="service-det">	'+
											'<h4>'+record.title+'</h4>';
											var description_details =  JSON.parse(record.description_details);
											if(description_details.length > 0){
												var i =1;
											html = html + '<ul class="list-bullet">';
											$(description_details).each(function(j,description){
													if(i<=3){
														html = html +'<li>'+description+'</li>';
													}else{
												
													 }
													i++;
												});

										html = html +'</ul>';
									    }
										html = html +'</div>'+
									'</div>'+
								'</a>'+
								'<div class="service-bottom">'+
									'<div class="service-info clearfix">'+
										'<div class="service-left">'+
											'<ul>'+
												'<li>'+contact_number_txt+':</li>';
												if(chat_status == 0 || provider_id == md5(userid)){
													html = html + '<li><i class="fa fa-phone"></i> <span>'+record.contact_number+'</span></li>';
												}else{
													html = html + '<li><i class="fa fa-phone"></i> <span>-</span></li>';
												}
											html = html + '</ul>'+
										'</div>';
										if(provider_id != md5(userid)){
											if(chat_status == 0){
												html = html + '<div class="service-right"><a href="'+base_url+'chat/'+provider_id+'" class="service-amount">'+chat_lang+'</a></div>';
											}
											else if(chat_status == 1){
												html = html + '<div class="service-right"><a href="javascript:void(0);" class="service-amount si-chat-subscribe">'+chat_lang+'</a></div>';
											}
										}
									html = html + '</div>'+
								'</div>'+
							'</div>'+
						'</div>';

       							});
       							$('.loadmore_results').hide();
       							$('#provider_list').append(html);
       						}

       					 });
   						<?php if($page == 'service') { ?>

							}else{
   							if(loading == 0 && nextpage !=-1){
   								$('.loadmore_results').attr('data-loading',1);
   								service_search_list(1);
   							}
   						}
						<?php }else{ ?>
							}
						<?php }  ?>

   					}
				});

				<?php }  if($page == 'request' || $page == 'my-request'){

					$label = 0;
					if($page == 'request'){
						$page_url = 'load_request';
						$label =0;
					}
					if($page == 'my-request'){
						$page_url = 'load_myrequest';
						$label = 1;
					}
				?>
				var page = '<?php echo $page; ?>';
				$(window).scroll(function() {

   					if($(window).scrollTop() + $(window).height() > $(document).height() - 200) {

   						var nextpage = $('.loadmore_results').attr('data-next-page');
   						var loading = $('.loadmore_results').attr('data-loading');
						var search = $('.loadmore_results').attr('data-search');
						<?php if($page == 'request') { ?>
   						if(nextpage !=-1 && loading == 0 && search == 0){
   						<?php }else{ ?>
   							if(nextpage !=-1 && loading == 0){
   						<?php } ?>
   							$('.loadmore_results').show();
   							$('.loadmore_results').attr('data-loading',1);
   							$.post(base_url+'<?php echo $page_url; ?>',{nextpage:nextpage},function(data){

       						var results = JSON.parse(data);

       						$('.loadmore_results').attr('data-loading',0);
       						$('.loadmore_results').attr('data-next-page',results['next_page']);

       						var records = results['request_list'];
       						if(records.length > 0){
       							var html = '';
       							$(records).each(function(i,record){

       								
       								var r_id =md5(record.r_id);
       								var dr_id =record.r_id;
											var status = '';
									var sclass = '';
									if(record.status == -1){
										status = 'Expired';
										sclass = 'text-danger';
									}
									else if(record.status == 0){
										status = 'Pending';
										sclass = 'text-warning';
									}
									else if(record.status == 1){
										status = 'Accepted';
										sclass = 'text-primary';
									}
									else if(record.status == 2){
										status = 'Completed';
										sclass = 'text-success';
									}
									else if(record.status == 3){
										status = 'Declined';
										sclass = 'text-danger';
									}
       							var profile_img = (record.profile_img !='')?record.profile_img:'assets/img/placeholder.jpg';
       							var req_img = (record.request_image !='')?record.request_image:'assets/img/placeholder.jpg';

       								html = html +' <div class="col-sm-6">'+
										'<div class="service-list">';
											if(page == 'my-request'){
											html = html +'<ul class="user-set-menu nav navbar-right">'+
												'<li class="dropdown">'+
													'<a href="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><img src="'+base_url+'assets/img/menu.png" alt=""></a>'+
													'<ul class="dropdown-menu">';
													if(record.status == 0 || record.status == -1){
														html = html +'<li><a href="'+base_url+'edit-request/'+r_id+'">'+edit_text+'</a></li>';
													}
														html = html +'<li><a href="javascript:void(0)" class="si-delete-request" data-id="'+dr_id+'">'+delete_text+'</a></li>'+
													'</ul>'+
												'</li>'+
											'</ul>';
											 }
									html = html +'<a class="service-link" href="'+base_url+'request-view/'+r_id+'">'+
											'<div class="service-content">'+
											<?php if($label == 1){ ?>
											'<span class="pull-right '+sclass+'">'+status+'</span>'+
											<?php } ?>
												'<div class="user-img">'+
													'<img src="'+base_url+req_img+'" alt="" width="100" height="100">'+
												'</div>'+
												'<div class="service-det">	'+

													'<h4>'+record.title+'</h4>';
													var description =  JSON.parse(record.description);

											if(description.length > 0){

												var i =1;
											html = html + '<ul class="list-bullet">';
											$(description).each(function(j,description){
													if(i<=3){

															html = html +'<li>'+description+'</li>';
													}else{
													
													 }
													i++;
												});

										html = html +'</ul>';
									    }
										html = html +'</div>'+
											'</div>'+
											'<div class="service-bottom">'+
												'<div class="service-info clearfix">'+
													'<div class="service-left">'+
														'<ul>'+
															'<li>'+appointment_text+':</li>'+
															'<li><i class="fa fa-calendar"></i> <span>'+record.request_date+'</span></li>'+
															'<li><i class="fa fa-clock-o"></i> <span>'+record.request_time+'</span></li>'+
														'</ul>'+
													'</div>'+
													'<div class="service-right"><span class="service-amount">'+record.currency_code+' '+record.amount+'</span></div>'+
												'</div>'+
											'</div>'+
									'</a>'+
								'</div>'+
								'</div>';

       							});
       							$('.loadmore_results').hide();
       							$('#provider_list').append(html);
       						}

       					 });
   						<?php if($page == 'request') { ?>
   							}else{
   							if(loading == 0){
   							}
   						  }
   						<?php }else{ ?>
   							}
   						<?php } ?>


   					}
				});

				<?php }  ?>
		</script>

				<?php if($page == 'history'){	?>
				<script type="text/javascript">
					$(window).scroll(function() {

   						if($(window).scrollTop() + $(window).height() > $(document).height() - 200) {

   						var nextpage = $('.loadmore_results').attr('data-next-page');
   						var loading = $('.loadmore_results').attr('data-loading');

   						if(nextpage !=-1 && loading == 0){
   							$('.loadmore_results').show();
   							$('.loadmore_results').attr('data-loading',1);
   							$.post(base_url+'load_complete_history',{nextpage:nextpage},function(data){

       						var results = JSON.parse(data);

       						$('.loadmore_results').attr('data-loading',0);
       						$('.loadmore_results').attr('data-next-page',results['next_page']);

       						var records = results['request_list'];
       						if(records.length > 0){
       							var html = '';
       							$(records).each(function(i,record){


       							var profile_img = (record.profile_img !='')?record.profile_img:'assets/img/placeholder.jpg';
       							var req_img = (record.request_image !='')?record.request_image:'assets/img/placeholder.jpg';

       								html = html +' <div class="col-sm-6">'+
												'<div class="service-list">'+
									'<a class="service-link" href="'+base_url+'request-view/'+record.r_id+'">'+
											'<div class="service-content">'+
												'<div class="user-img">'+
													'<img src="'+base_url+req_img+'" alt="" width="100" height="100">'+
												'</div>'+
												'<div class="service-det">	'+

													'<h4>'+record.title+'</h4>';
													var description =  JSON.parse(record.description);

											if(description.length > 0){

												var i =1;
											html = html + '<ul class="list-bullet">';
											$(description).each(function(j,description){
													if(i<=3){

															html = html +'<li>'+description+'</li>';
													}else{
													
													 }
													i++;
												});

										html = html +'</ul>';
									    }
										html = html +'</div>'+
											'</div>'+
											'<div class="service-bottom">'+
												'<div class="service-info clearfix">'+
													'<div class="service-left">'+
														'<ul>'+
															'<li>'+appointment_text+':</li>'+
															'<li><i class="fa fa-calendar"></i> <span>'+record.request_date+'</span></li>'+
															'<li><i class="fa fa-clock-o"></i> <span>'+record.request_time+'</span></li>'+
														'</ul>'+
													'</div>'+
													'<div class="service-right"><span class="service-amount">'+record.currency_code+' '+record.amount+'</span></div>'+
												'</div>'+
											'</div>'+
									'</a>'+
								'</div>'+
								'</div>';

       							});
       							$('.loadmore_results').hide();
       							$('#completed_list').append(html);
       						}

       					 });

   						}
   					}
				});
		</script>
		<?php }  ?>
		<?php if($page == 'history'){	?>
				<script type="text/javascript">
					$(window).scroll(function() {

   					if($(window).scrollTop() + $(window).height() > $(document).height() - 200) {

   						var nextpage = $('.ploadmore_results').attr('data-next-page');
   						var loading = $('.ploadmore_results').attr('data-loading');

   						if(nextpage !=-1 && loading == 0){
   							$('.ploadmore_results').show();
   							$('.ploadmore_results').attr('data-loading',1);
   							$.post(base_url+'load_pending_history',{nextpage:nextpage},function(data){

       						var results = JSON.parse(data);

       						$('.ploadmore_results').attr('data-loading',0);
       						$('.ploadmore_results').attr('data-next-page',results['next_page']);

       						var records = results['request_list'];
       						if(records.length > 0){
       							var html = '';
       							$(records).each(function(i,record){

       							var profile_img = (record.profile_img !='')?record.profile_img:'assets/img/placeholder.jpg';

       								html = html +' <div class="col-sm-6">'+
												'<div class="service-list">'+
									'<a class="service-link" href="'+base_url+'history-view/'+record.r_id+'">'+
											'<div class="service-content">'+
												'<div class="user-img">'+
													'<img src="'+base_url+profile_img+'" alt="" width="100" height="100">'+
												'</div>'+
												'<div class="service-det">	'+

													'<h4>'+record.title+'</h4>';
													var description =  JSON.parse(record.description);

											if(description.length > 0){

												var i =1;
											html = html + '<ul class="list-bullet">';
											$(description).each(function(j,description){
													if(i<=3){

															html = html +'<li>'+description+'</li>';
													}else{
													 }
													i++;
												});

										html = html +'</ul>';
									    }
										html = html +'</div>'+
											'</div>'+
											'<div class="service-bottom">'+
												'<div class="service-info clearfix">'+
													'<div class="service-left">'+
														'<ul>'+
															'<li>'+appointment_text+':</li>'+
															'<li><i class="fa fa-calendar"></i> <span>'+record.request_date+'</span></li>'+
															'<li><i class="fa fa-clock-o"></i> <span>'+record.request_time+'</span></li>'+
														'</ul>'+
													'</div>'+
													'<div class="service-right"><span class="service-amount">'+record.currency_code+' '+record.amount+'</span></div>'+
												'</div>'+
											'</div>'+
									'</a>'+
								'</div>'+
								'</div>';

       							});
       							$('.ploadmore_results').hide();
       							$('#pending_list').append(html);
       						}

       					 });

   						}
   					}
				});
		</script>
		<?php }  ?>
			<!-- Search Start  -->
    <link href="<?php echo $base_url; ?>assets/css/jquery-ui.css" rel="Stylesheet">
    <script src="//code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
    <script src="<?php echo $base_url; ?>assets/js/search.js"></script>
    <!-- Search End   -->
    <?php
	        $text = (!empty($language_content['language']))?$language_content['language']:'';

	  ?>
	<?php 
		$cookies_showhide = $this->db->get_where('system_settings',array('key' => 'cookies_showhide'))->row()->value;
		$cookies = $this->db->get_where('system_settings',array('key' => 'cookies'))->row()->value;
	?>
	  <input type="hidden" id="cookies_showhide" value="<?php echo $cookies_showhide; ?>">
		<input type="hidden" id="cookies_content_text" value="<?php echo $cookies; ?>">

		<?php if($cookies_showhide == 1) { ?>
			<script src="<?php echo base_url()?>assets/js/cookie.min.js"></script>
		<?php } ?>
<input type="hidden" name="session_user_id" id="session_user_id" value="<?php echo ($this->session->userdata())?$this->session->userdata('user_id'):''; ?>">
<!-- Change Location Popup -->
<div id="my_map" class="modal fade custom-modal" role="dialog">
  	<div class="modal-dialog modal-lg">
	    <!-- Modal content-->
	    <div class="modal-content">
	      	<div class="modal-header">
	      		<h5 class="modal-title"><?php echo (!empty($text['lg7_map']))?$text['lg7_map']:''; ?></h5>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
	      	</div>
	     	<div class="modal-body">
	     		<p><?php echo (!empty($text['lg7_drag_and_point_']))?$text['lg7_drag_and_point_']:''; ?></p>
		        <div class="row">
		        	<div class="col-12">
		        		<input type="text" id="autocomplete"  onFocus="geolocate()"   class="form-control" name="address"  value="<?php echo (!empty($this->session->userdata('user_address')))?$this->session->userdata('user_address'):'Coimbatore, India'; ?>">
		        		<input type="hidden"  id="user_latitude" value="">
		        		<input type="hidden"  id="user_longitude" value="">
		        	</div>
		        </div>
		        <div class="row mb-3">
		        	<div class="col-12 col-md-4 mt-3"><button onclick="initMap()" class="btn btn-primary w-100"><?php echo (!empty($text['lg7_search']))?$text['lg7_search']:''; ?></button></div>
		        	<div class="col-12 col-md-4 mt-3"><button onclick="setlocation()" class="setlocation btn btn-primary w-100"><?php echo (!empty($text['lg7_set_location']))?$text['lg7_set_location']:''; ?></button></div>
		        	<div class="col-12 col-md-4 mt-3"><button onclick="addlocation()" style="display: none;" class="addlocation btn btn-primary w-100"><?php echo (!empty($text['lg7_add_location']))?$text['lg7_add_location']:''; ?></button></div>
		        </div>
	            <div id="map" style="height:400px;background:rgb(243, 243, 139)"></div>
	      	</div>
	    </div>
  	</div>
</div>
<?php $map_key = $this->db->get_where('system_settings',array('key' => 'map_key'))->row()->value; ?>
 <input type="hidden" class="form-control" id="map_key" value="<?php echo $map_key ?>" >

<!-- /Change Location Popup -->

<script type="text/javascript">
	var address = "<?php echo (!empty($this->session->userdata('user_address')))?$this->session->userdata('user_address'):''; ?>";
     <?php if(!empty($this->session->userdata('latitude'))) { ?>
    	var latitude = "<?php echo $this->session->userdata('latitude') ?>";
    <?php } else { ?>
    	var latitude = '3.021998';
    <?php } ?>;
     <?php if(!empty($this->session->userdata('longitude'))) { ?>
    	var longitude = "<?php echo $this->session->userdata('longitude') ?>";
    <?php } else { ?>
    	var latitude = '101.7055411';
    <?php } ?>;
     <?php if(!empty($this->session->userdata('latitude'))) { ?>
    	var popup_lat = "<?php echo $this->session->userdata('latitude') ?>";
    <?php } else { ?>
    	var popup_lat = '3.021998';
    <?php } ?>;
     <?php if(!empty($this->session->userdata('latitude'))) { ?>
    	var popup_lng = "<?php echo $this->session->userdata('latitude') ?>";
    <?php } else { ?>
    	var popup_lng = '3.021998';
    <?php } ?>;
    var userid = "<?php echo (!empty($this->session->userdata('user_id')))?$this->session->userdata('user_id'):''; ?>";
	if((popup_lat =='' && popup_lng =='') && userid!=''){

		$('#my_map').modal('show');
		 setTimeout(function() {
       			 load_msp_details(latitude,longitude)
    		}, 2000);
	}


/*
 * autocomplete location search
 */
var PostCodeid = '#address';
$(function () {
    $(PostCodeid).autocomplete({
        source: function (request, response) {
            geocoder.geocode({
                'address': request.term
            }, function (results, status) {
                response($.map(results, function (item) {
                    return {
                        label: item.formatted_address,
                        value: item.formatted_address,
                        lat: item.geometry.location.lat(),
                        lon: item.geometry.location.lng()
                    };
                }));
            });
        },
        select: function (event, ui) {
            $('.search_addr').val(ui.item.value);
            $('.search_latitude').val(ui.item.lat);
            $('.search_longitude').val(ui.item.lon);
            var latlng = new google.maps.LatLng(ui.item.lat, ui.item.lon);
            marker.setPosition(latlng);
            initialize();
        }
    });
});
  function initMap() {
	address  = $('#autocomplete').val();
	var key = $('#map_key').val();
    if(address == ''){
       address = 'Seri kembagan, selangor malaysia';
     }

    $.get('https://maps.googleapis.com/maps/api/geocode/json',{address:address,key:key},function(data, status){
        $(data.results).each(function(key,value){
        	 address   = value.formatted_address;
             latitude  = value.geometry.location.lat;
             longitude = value.geometry.location.lng;

             $('#autocomplete').val(address);
             $('#user_latitude').val(latitude);
             $('#user_longitude').val(longitude);
        });
    });

   setTimeout(function() {
        load_msp_details(latitude,longitude)
    }, 2000);

  }

  function load_msp_details(latitude,longitude){
     var uluru = {
                lat: parseFloat(latitude),
                lng:parseFloat(longitude)
                };
    var geocoder = new google.maps.Geocoder();
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 11,
      center: uluru
    });

    var marker = new google.maps.Marker({
      position: uluru,
      map: map,
      draggable: true
    });

    google.maps.event.addListener(marker, 'dragend', function() {

    geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                   address =results[0].formatted_address;
                   latitude = marker.getPosition().lat();
                   longitude = marker.getPosition().lng();
                  	 $('#autocomplete').val(address);
                  	$('#user_latitude').val(latitude);
             		$('#user_longitude').val(longitude);
               }
            }
        });
		 });
}

function setlocation() {
		$.post(base_url+'setlocation',{address:address,latitude:latitude,longitude:longitude},function(){
			$('#my_map').modal('hide');
			window.location.reload();
		});
}

function change_location() {
		$('#my_map').modal('show');
	initMap();
}

</script>
	
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/place.js"></script>
 <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYHKDyN1YX7hWTGtYdLb1F0UAOVwK1MKc&libraries=places&v=weekly"
      async
    ></script>
<?php  
if($page =='request-view' || $page == 'history-view') { ?>
<script type="text/javascript">


	let latText = document.getElementById("mylatitude");
	let longText = document.getElementById("mylongitude");
 	var lat  = '';
	
	  navigator.geolocation.getCurrentPosition(function(position) {
	    let lat = position.coords.latitude;
	    let long = position.coords.longitude;

	    latText.innerText = lat.toFixed(2);
	    longText.innerText = long.toFixed(2);
	    return lat;
	  });
    setTimeout(function myMap(){  showMap(); }, 3000);

	function showMap() {
	  var req_latitude = "<?php echo $request_details['latitude'] ?>";
	  var req_longitude = "<?php echo $request_details['longitude'] ?>";
	  var req_location = "<?php echo $request_details['location'] ?>";
	  var user_latitude = $('#mylatitude').html();
	  var user_longitude = $('#mylongitude').html();
	  
      var locations = [
        [req_location, req_latitude, req_longitude, 1],
        ['Your location', user_latitude, user_longitude, 2],
       
      ];

      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 5,
        center: new google.maps.LatLng(req_latitude, req_longitude),
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });

      var infowindow = new google.maps.InfoWindow();

      var marker, i;

      for (i = 0; i < locations.length; i++) {
        marker = new google.maps.Marker({
          position: new google.maps.LatLng(locations[i][1], locations[i][2]),
          map: map
        });

        google.maps.event.addListener(marker, 'click', (function(marker, i) {
          return function() {
            infowindow.setContent(locations[i][0]);
            infowindow.open(map, marker);
          }
        })(marker, i));
      }

	}

</script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&callback=myMap" type="text/javascript"></script>
<?php  } ?>


<?php if($page == 'subscription-list'){	?>
		<!-- Stripe Payment Gateway Start  -->


<script>
var final_gig_amount = 1;
var sub_id = '';
function callStripe(e)
{
	sub_id = $("#sub_id").val();
	final_gig_amount = $("#subs_amt").val();
	if(parseInt(final_gig_amount)==0)
	{
		free_subscription();

	}
	else
	{
		$('#my_stripe_payyment').click();
	}

}

function callpaypal(e)
{
	sub_id = $(e).attr('data-id');
	final_gig_amount = $(e).attr('data-amount');
	if(parseInt(final_gig_amount)==0)
	{
		free_subscription();

	}
	else
	{
		 $('#subscriptionpayment_formid').submit();

	}
}
function callpaytabs(e)
{
	sub_id = $(e).attr('data-id');
	final_gig_amount = $(e).attr('data-amount');
	if(parseInt(final_gig_amount)==0)
	{
		free_subscription();

	}
	else
	{
		
		$.ajax({
			url: base_url+'user/subscription/payment/',
			data: {sub_id:sub_id,final_gig_amount:final_gig_amount,source:'Paytabs'},
			type: 'POST',
			dataType: 'JSON',
			success: function(response){
				//window.location.href = base_url+'payment-gateway';
			},
			error: function(error){
				console.log(error);
			}
		});
	}
}
function free_subscription(sub_id,final_gig_amount)
{
	$.ajax({
			url: base_url+'user/subscription/stripe_payments/',
			data: {sub_id:sub_id,final_gig_amount:final_gig_amount},
			type: 'POST',
			dataType: 'JSON',
			success: function(response){
				window.location.href = base_url+'subscription-list';
			},
			error: function(error){
				console.log(error);
			}
		});
}
</script>
<input type="hidden" value="<?= $publishable_key; ?>" id="publishable_key">
		<?php
			if($razorpay_option == 1){
				echo '<input type="hidden" name="razorpay_apikey" id="razorpay_apikey" value="'.$razorpaylive_apikey.'">';
				echo '<input type="hidden" name="razorpay_apisecret" id="razorpay_apisecret" value="'.$razorpaylive_apisecret.'">';
			}else if($razorpay_option == 2){
				echo '<input type="hidden" name="razorpaylive_apikey" id="razorpay_apikey" value="'.$razorpaylive_apikey.'">';
				echo '<input type="hidden" name="razorpaylive_apisecret" id="razorpay_apisecret" value="'.$razorpaylive_apisecret.'">';
			}
		?>
		<input type="hidden" value="<?= $publishable_key; ?>" id="publishable_key">

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script src="https://checkout.stripe.com/checkout.js"></script>
<button id="my_stripe_payyment" style="display:none">Purchase</button>
<script>
var handler = StripeCheckout.configure({
  key: '<?php echo $publishable_key;?>',
  image: '<?php	echo base_url().$website_logo_front;?>',
  locale: 'auto',
  token: function(token,args) {
    // You can access the token ID with `token.id`.
    $('#access_token').val(token.id);
		var tokenid = token.id;
		var stramt=final_gig_amount*100;
		var sub_id = $("#sub_id").val();
		
    $.ajax({
			url: base_url+'user/subscription/stripe_payment/',
			data: {sub_id:sub_id,final_gig_amount:stramt,tokenid:tokenid,det:token},
			type: 'POST',
			dataType: 'JSON',
			success: function(response){
				window.location.href = base_url+'subscription-list';
			},
			error: function(error){
				console.log(error);
			}
		});
  }
});
$('#my_stripe_payyment').click(function(e) {
	final_gig_amount = (final_gig_amount * 100); //  dollar to cent
	striep_currency = $('#ccurr_code').val();
  // Open Checkout with further options:
  handler.open({
    name: base_url,
    description: 'Subscribe',
    amount: final_gig_amount,
    currency:striep_currency
  });
  e.preventDefault();
});
// Close Checkout on page navigation:
window.addEventListener('popstate', function() {
});
function callpaygateway(e)
{
        	var stripe_amt = $("#subs_amt").val();
            var subs_id = $("#sub_id").val();
            var payment_type = $('input[name="group2"]:checked').val();
            if(payment_type == undefined) {
            	alert('Please choose a payment option');
            	return false;
            }
            else 
            {


			if (payment_type == "RazorPay" && payment_type != undefined && parseInt(stripe_amt)!=0.00) {
				var totalAmount = stripe_amt;
				var product_id =  subs_id;
				var product_name =  'subscription';
				var options = {
					"key": $('#razorpay_apikey').val(),
					"currency": "INR",
					"amount": totalAmount*100,
					"name": product_name,
					"description": product_name,
					"handler": function (response){
						  $.ajax({
							url: base_url+'user/subscription/razor_payment_success',
							type: 'post',
							dataType: 'json',
							data: {
								razorpay_payment_id: response.razorpay_payment_id , totalAmount : totalAmount ,product_id : product_id,
							},
							success: function (msg) {
							   window.location.href = base_url+'user/subscription/razorthankyou?res='+msg;
							}
						});
					},
				}
				var rzp1 = new Razorpay(options);
				rzp1.open();
				e.preventDefault();
				return false;
			}
			else if(payment_type == "stripe" && payment_type != undefined && parseInt(stripe_amt)!=0.00)
			{
				callStripe();
			}
			else if(payment_type == "PayTabs" && payment_type != undefined && parseInt(stripe_amt)!=0.00)
			{
				 $('#subscriptionpayment_formid').submit();
			}
			else if(payment_type == "Direct" && payment_type != undefined && parseInt(stripe_amt)!=0.00)
			{
				 $('#subscriptionpayment_formid').submit();
			}
			else if(payment_type == "Offline" && payment_type != undefined)
			{
				window.location.href = base_url+'user/subscription/offlinepayment/'+subs_id;
			}
			else
			{
				free_subscription();
			}
			}
    }
function callrazorpay(e)
{
        	var stripe_amt = $("#subs_amt").val();
            var subs_id = $("#sub_id").val();
            var payment_type = $('input[name="group2"]:checked').val();
			if (payment_type == "RazorPay" && payment_type != undefined) {
				var totalAmount = stripe_amt;
				var product_id =  subs_id;
				var product_name =  'subscription';
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
							   window.location.href = base_url+'user/subscription/razorthankyou?res='+msg;
							}
						});
					},
				}
				var rzp1 = new Razorpay(options);
				rzp1.open();
				e.preventDefault();
				return false;
			}

    }
</script>
<?php } ?>

<?php


	$querys=$this->db->query("select * from system_settings WHERE status = 1");
	$results=$querys->result_array();
	$website_facebook_app_ids ='';
	$website_google_client_ids ='';
	if(!empty($results))
	{
		foreach($results as $datas){
			if($datas['key'] == 'website_facebook_app_id'){
			$website_facebook_app_ids = $datas['value'];
		}

		if($datas['key'] == 'website_google_client_id'){
			$website_google_client_ids = $datas['value'];
		}
		}
	}

if($page=='login' || $page=='' || $page=='signin')
{



?>

<script src="https://apis.google.com/js/api:client.js"></script>

<script>

  //fb
var googleUser = {};
 var startApp = function() {
   gapi.load('auth2', function(){
     // Retrieve the singleton for the GoogleAuth library and set up the client.
     auth2 = gapi.auth2.init({
       client_id: '<?php echo $website_google_client_ids;?>',
       cookiepolicy: 'single_host_origin',
       // Request scopes in addition to 'profile' and 'email'
       //scope: 'additional_scope'
     });
     attachSignin(document.getElementById('customBtn'));
   });
 };

function attachSignin(element) {
    auth2.attachClickHandler(element, {},
        function(googleUser) {

          var profileid=googleUser.getBasicProfile().getId();
          var firstname=googleUser.getBasicProfile().getGivenName();
          var lastname=googleUser.getBasicProfile().getFamilyName();
		  var profileurl=googleUser.getBasicProfile().getImageUrl();
          var email=googleUser.getBasicProfile().getEmail();
          var auth='Google';



           $.post(base_url+'login/sociallogin',{'profileid':profileid,'firstname':firstname,'lastname':lastname,'profileurl':profileurl,'email':email,'auth':auth,'firstname':firstname},function(response){
                    if (response == 1) {

                        location.reload();

                    }

                else {

                    window.location.href = base_url+'signup';

                }
          });

        }, function(error) {
        });
  }



//fb ------------
window.fbAsyncInit = function() {
   // FB JavaScript SDK configuration and setup
   FB.init({
       appId: '<?php echo $website_facebook_app_ids;?>', // FB App ID
       cookie: true, // enable cookies to allow the server to access the session
       xfbml: true, // parse social plugins on this page
       version: 'v2.8' // use graph api version 2.8
   });
   // Check whether the user already logged in
 
};
// Load the JavaScript SDK asynchronously
(function(d, s, id) {
   var js, fjs = d.getElementsByTagName(s)[0];
   if (d.getElementById(id)) return;
   js = d.createElement(s);
   js.id = id;
   js.src = "//connect.facebook.net/en_US/sdk.js";
   fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
// Facebook login with JavaScript SDK
function fbLogin() {
   FB.login(function(response) {
       if (response.authResponse) {
           // Get and display the user profile data
           getFbUserData();
       } else {
          
       }
   }, {
       scope: 'email'
   });
}
// Fetch the user profile data from facebook
function getFbUserData() {
   FB.api('/me', {
           locale: 'en_US',
           fields: 'id,name,first_name,last_name,email,link,gender,locale,picture'
       },
       function(response) {
           var profileid = response.id;
           var fullname = response.name;
           var firstname = response.first_name;
           var lastname = response.last_name;
           var profileurl = response.picture.data.url;
           var email = response.email;
           var auth = 'Facebook';
           $.post('http://brinejobs.com/home/seekar_login', {
               'profileid': profileid,
               'fullname': fullname,
               'firstname': firstname,
               'lastname': lastname,
               'profileurl': profileurl,
               'email': email,
               'auth': auth
           }, function(data) {
               var obj = jQuery.parseJSON(data);
               if (obj.result == 'yes') {
                   window.location.href = 'http://brinejobs.com/seekar';
               } else if (obj.result == 'no') {
                   //showNotification('bg-pink', obj.status, 'top', 'center', 'animated zoomIn', 'animated zoomOut');
               } else {
                   window.location.href = 'http://brinejobs.com/home';
               }
           });
       });
}

startApp();</script>

<?php } ?>
<?php if($page=='service-view') { ?>

    <script type="text/javascript">


	let latText = document.getElementById("mylatitude");
	let longText = document.getElementById("mylongitude");
 	var lat  = '';
	
	  navigator.geolocation.getCurrentPosition(function(position) {
	    let lat = position.coords.latitude;
	    let long = position.coords.longitude;

	    latText.innerText = lat.toFixed(2);
	    longText.innerText = long.toFixed(2);
	    return lat;
	  });
    setTimeout(function serviceMap(){  showServiceMap(); }, 3000);

	function showServiceMap() {
	  var req_latitude = service_latitude;
	  var req_longitude = service_longitude;
	  var req_location = "<?php echo $service_details['location'] ?>";
	  var user_latitude = $('#mylatitude').html();
	  var user_longitude = $('#mylongitude').html();

	  
      var locations = [
        [req_location, req_latitude, req_longitude, 1],
        ['Your location', user_latitude, user_longitude, 2],
       
      ];

      var map = new google.maps.Map(document.getElementById('location'), {
        zoom: 5,
        center: new google.maps.LatLng(req_latitude, req_longitude),
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });

      var infowindow = new google.maps.InfoWindow();

      var marker, i;

      for (i = 0; i < locations.length; i++) {
        marker = new google.maps.Marker({
          position: new google.maps.LatLng(locations[i][1], locations[i][2]),
          map: map
        });

        google.maps.event.addListener(marker, 'click', (function(marker, i) {
          return function() {
            infowindow.setContent(locations[i][0]);
            infowindow.open(map, marker);
          }
        })(marker, i));
      }

	}

</script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&callback=serviceMap" type="text/javascript"></script>

<?php } ?>


<script type="text/javascript">

	function post_reviews(booking_id,service_id)
	{
		$('#booking_id').val(booking_id);
		$('#service_id').val(service_id);
		$('#reviews').modal('show');
	}

	function view_rating_reviews(service_id)
	{
		$.post('<?php echo base_url();?>user/service/view_rating_reviews',{p_id:service_id},function(data){
			$('#view_rating_reviews').html(data);
			$('#reviews').modal('show');
		})

	}

	$(function() {
    $("#rating_star").star_rating_widget({
        starLength: '5',
        initialValue: '',
        callbackFunctionName: '',
        imageDirectory: '<?php echo base_url();?>assets/img/',
        inputAttr: 'postID'
    });
});
</script>

<?php $change = isset($_GET['tab'])?$_GET['tab']:""; ?>
<?php if($change == "change"){ ?>
<script>
$(document).ready(function(){
$('.nav-pills li:nth-child(1)').removeClass("active");
$('.nav-pills li:nth-child(2)').addClass("active");
$('#profile_cont').removeClass("active");
$('#change_password').addClass("active");
});
</script>
<?php } ?>

<?php if($this->session->userdata('user_id') != '') { ?>
	<script type="text/javascript">
		setInterval(function(){
	      var to = '<?php echo $this->session->userdata('user_id');?>';

	       $.post(base_url+'requester-unread-count',{to:to},function(data){
	              $('.requester-chat-count').html(data);
	          });

	       $.post(base_url+'unread-count',{to:to},function(data){
	              $('.chat-count').html(data);
	          });
	    }, 30000);
	</script>
<?php } ?>


<?php
	$msgrequest = $language_content['language'];
	$msgrequest_array = !empty($msgrequest)?$msgrequest:'';
?>
	<div class="modal fade" id="ddsubscribeConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">�</button>
			<h4 class="modal-title"><?php echo $msgrequest_array['lg6_subscribe']; ?></h4>
		</div>
		<div class="modal-body">
		<p><?php echo $msgrequest_array['lg6_please_do_subsc1'].", ".$msgrequest_array['lg6_are_you_sure_wa2']; ?></p>
		</div>
		<div class="modal-footer">
			<a href="<?php echo base_url();?>subscription-list" class="btn btn-success"><?php echo $msgrequest_array['lg6_yes']; ?></a>
			<button type="button" class="btn btn-danger si_accept_cancel" data-dismiss="modal"><?php echo $msgrequest_array['lg6_cancel']; ?></button>
		</div>
		</div>
	</div>
	</div>
<script type="text/javascript" src="<?php echo $base_url; ?>assets/plugins/owlcarousel/owl.carousel.min.js"></script>
	
   <?php
   $lang = (!empty($this->session->userdata('lang')))?$this->session->userdata('lang'):'en';
     if($lang=='ar'){
        echo'<script type="text/javascript" src="'.base_url().'assets/js/custom.js"></script>';
        echo'<script type="text/javascript" src="'.base_url().'assets/js/custom-rtl.js"></script>';
     }else{
         echo'<script type="text/javascript" src="'.base_url().'assets/js/custom.js"></script>';

     }
     ?>

	</body>
</html>
