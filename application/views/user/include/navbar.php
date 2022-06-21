<?php
$header_settings = $this->db->get('header_settings')->row();
$language = $this->db->get_where('language',array('status'=>1,'deleted_status'=>0))->result_array();
?>
<header>
  <nav class="inner-header d-flex align-items-center navbar navbar-expand-lg header-nav">
    <a id="mobile_btn" href="javascript:void(0);">
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>
      <?php
      $header = $language_content['language'];
      $header_array = !empty($header)?$header:'';
      ?>
        <div class="logo">
          <a href="<?php echo $base_url; ?>home">
            <img src="<?php echo base_url().$this->website_logo_front; ?>" alt="servpro" height="52">
          </a>
        </div>
        <?php
        $lang = (!empty($this->session->userdata('lang')))?$this->session->userdata('lang'):'en';
        $lang_value = isset($language)?$language:"";
        $lang_full = "";
        if($lang_value){
        for($i=0; $i<count($lang_value);$i++){
          $language_value = $lang_value[$i]['language_value'];
          $language = $lang_value[$i]['language'];
    
          if($lang == $language_value){
              $lang_full = $language;
              $lang_img = $lang_value[$i]['flag_img'];
          }
        }
        }else{  
        switch ($lang) {
          case 'en':
          $lang_full ='English';
          break;
          case 'ar':
          $lang_full ='Arabic';
          break;
          case 'ma':
          $lang_full ='Malayalam';
          break;
          default:
          $lang_full ='English';
          break;
        }
        }
        ?>

        <div class="dropdown mobile-language language-selector">
          <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?php echo $base_url; ?>assets/img/<?php echo $lang;?>.png" alt=""> <?php echo ucfirst($lang_full); ?>
          </a>
          <span class="caret"></span>
          <ul class="dropdown-menu">
            <?php if($lang_value){ for($i=0; $i<count($lang_value);$i++){ ?>
            <li><a href="javascript:void(0)" onclick="setlanguage('<?php echo $lang_value[$i]['language_value']; ?>')"><img src="<?php echo $base_url.$lang_img; ?>"  alt=""> <?php echo $lang_value[$i]['language']; ?></a></li>
            <?php } }else{ ?>
            <li><a href="javascript:void(0)" onclick="setlanguage('en')"><img src="<?php echo $base_url."assets/img/en.png" ?>"  alt=""> <?php echo $lang_full; ?></a></li>
            <li><a href="javascript:void(0)" onclick="setlanguage('ar')"><img src="<?php echo $base_url."assets/img/ar.png" ?>"  alt="">Arabic</a></li>  
            <?php } ?>  
          </ul>
        </div>

        <div class="dropdown mobile-user-menu profile-dropdown">
          <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false">
            <span class="user-img">
              <?php
              $prof_img = $this->session->userdata('profile_img');
              $username = $this->session->userdata('username');
              $navprofile_img = (!empty($prof_img))?$prof_img:'assets/img/user.jpg';?>
              <img src="<?php echo $base_url.$navprofile_img; ?>" width="32" alt="">
            </span>
            <i class="caret"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-right">
            <li><a href="javascript:void(0)"><?php echo ucfirst(str_replace('_', ' ',$username)); ?></a></li>
            <li><a href="<?php echo $base_url; ?>user-profile"><?php echo $header_array['lg3_my_profile']; ?></a></li>
            <li><a href="<?php echo $base_url; ?>history"><?php echo $header_array['lg3_history']; ?></a></li>
            <li><a href="<?php echo $base_url; ?>add-request"><?php echo $header_array['lg3_add_request']; ?></a></li>
            <li><a href="<?php echo $base_url; ?>my-request"><?php echo $header_array['lg3_my_requests']; ?></a></li>

            <?php
            $chat_status = 0;
            $sub_count =0;
            if(isset($subscription_details)&& !empty($subscription_details)) {
				$sub_count = count($subscription_details);
				$subscription_id = $subscription_details['subscription_id'];
				$subscription_date = $subscription_details['subscription_date'];
				$expiry_date_time = $subscription_details['expiry_date_time'];			  
            }

            date_default_timezone_set('UTC');
            $current_date_time = date('Y-m-d H:i:s');
            if(($sub_count > 0) && ($current_date_time <= $expiry_date_time)){
             $chat_status = 0;
           } else {
             $chat_status = 1;
           }
           if($chat_status == 0){
             ?>
             <li><a href="<?php echo $base_url; ?>add-service"><?php echo $header_array['lg3_add_service']; ?></a></li>
           <?php  } else { ?>
            <li><a href="javascript:void(0);" data-toggle="modal" data-target="#subscribeConfirmModal"><?php echo $header_array['lg3_add_service']; ?></a></li>
          <?php  }  ?>
          <li><a href="<?php echo $base_url; ?>my-services"><?php echo $header_array['lg3_my_services']; ?></a></li>
          <li><a href="<?php echo $base_url; ?>requester-chat-history"><?php echo $header_array['lg3_chat_history']; ?><span class="btn btn-primary badge badge-notify position-style "><span class="requester-chat-count">0</span></span></a></li>
          <li><a href="<?php echo $base_url; ?>chat-history"><?php echo $header_array['lg3_provider_chat_h']; ?><span class="btn btn-primary badge badge-notify position-style "><span class="chat-count">0</span></span></a></li>
          <li><a href="<?php echo $base_url; ?>my-booking"><?php echo $header_array['lg3_my_booking']; ?></a></li>
          <li><a href="<?php echo $base_url; ?>booking-service"><?php echo $header_array['lg3_booking_service']; ?></a></li>
          <li><a href="<?php echo $base_url; ?>login"><?php echo $header_array['lg3_logout']; ?></a></li>
        </ul>
        </div>
       
        <div class="main-menu-wrapper">
          <div class="menu-header">
            <a href="index.html" class="menu-logo">
              <img src="assets/img/logo.png" class="img-fluid" alt="Logo">
            </a>
            <a id="menu_close" class="menu-close" href="javascript:void(0);">
              <i class="fas fa-times"></i>
            </a>
          </div>
          <ul class="main-nav">
            <?php if($header_settings->header_menu_option == 1) {
              if(!empty($header_settings->header_menus) && $header_settings->header_menus != 'null') { 
               $menus = json_decode($header_settings->header_menus);
                  foreach($menus as $menu) { 
                          if($menu->label != '' && $menu->link != '') {
                          ?>
                          <li><a href="<?php echo $menu->link; ?>"><?php echo $menu->label; ?></a></li>
                      <?php } }
                  } ?>
              
              <?php } else {
            ?>
            <li><a href="<?php echo $base_url; ?>request"><?php echo $header_array['lg3_request_a_servi']; ?></a></li>
            <li><a href="<?php echo $base_url; ?>service"><?php echo $header_array['lg3_provide_a_servi']; ?></a></li>
            <?php } if($this->session->userdata('user_id')){ ?>
              <li><a href="javascript:void(0)" onclick="change_location()"><?php echo $header_array['lg3_change_location']; ?></a>
              </li>
             <?php } else{ ?>
              <li><a href="<?php echo $base_url; ?>login"><?php echo $header_array['lg3_change_location']; ?></a>
              </li>
             <?php } ?>
          </ul>
        </div>

        
        <ul class="nav header-navbar-rht">
          <?php if($header_settings->language_option == 1) { ?>
         <?php if(!empty($this->session->userdata('user_id'))) { ?>
         <li class="language-menu dropdown dropdown-arrow language-selector">
          <a href="#" class="dropdown-toggle nav-link p-0" data-toggle="dropdown">
            <img src="<?php echo $base_url; ?>assets/img/<?php echo $lang;?>.png" alt=""> <?php echo ucfirst($lang_full); ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-right">
            <?php if($lang_value){ for($i=0; $i<count($lang_value);$i++){ ?>
            <li><a href="javascript:void(0)" class="dropdown-item" onclick="setlanguage('<?php echo $lang_value[$i]['language_value']; ?>')"><img src="<?php echo $base_url.$lang_value[$i]["flag_img"] ?>"  alt=""> <?php echo $lang_value[$i]['language']; ?></a></li>
            <?php } }else{ ?>
            <li><a href="javascript:void(0)" class="dropdown-item" onclick="setlanguage('en')"><img src="<?php echo $base_url."assets/img/en.png" ?>"  alt=""> <?php echo $lang_full; ?></a></li>  
            <li><a href="javascript:void(0)" class="dropdown-item" onclick="setlanguage('ar')"><img src="<?php echo $base_url."assets/img/ar.png" ?>"  alt=""> Arabic</a></li>
            <?php } ?>  
          </ul> 
        </li>

      <?php } } ?>
        <?php 
        if($this->session->userdata('user_id')){ 
            $usercurrency_code = $this->session->userdata('usercurrency_code');
            $defcurr_result = $this->db->query("SELECT value FROM `system_settings` WHERE `key` = 'default_currency'")->result_array();
            $dfcurval = $defcurr_result[0]['value'];
          ?>
       <?php  if($header_settings->currency_option == 1) { ?>
       <li class="currency-menu dropdown dropdown-arrow">
          <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
             <?php echo ($usercurrency_code != '') ? $usercurrency_code : $dfcurval; ?> </a>
          <ul class="dropdown-menu dropdown-menu-right">
            <?php
              
              $cuurency_result = $this->db->query("SELECT id,currency_code FROM `currency_rate`")->result_array();
              foreach($cuurency_result as $crest){
            ?>
              <li>
                <a href="javascript:void(0)" class="dropdown-item" onclick="user_currency('<?php echo $crest['currency_code'];?>')" <?php echo ($usercurrency_code == $crest['currency_code']) ? 'selected' : ''; ?>><?php echo $crest['currency_code'];?></a>
              </li>
              <?php
                }
              ?>
              
          </ul> 
        </li>
        <?php  }  ?>        
        
          <li class="dropdown dropdown-arrow profile-dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle hidearrow text-right" href="#" aria-expanded="false">
              <span class="user-img">
                <img src="<?php echo $base_url.$navprofile_img; ?>" width="32" alt="" class="rounded-circle">
              </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-right">
              <li><a href="javascript:void(0)"><b><?php echo ucfirst(str_replace('_', ' ',$username)); ?></b></a></li>
              <li><a href="<?php echo $base_url; ?>user-profile" class="dropdown-item"><?php echo $header_array['lg3_my_profile']; ?></a></li>
			  <li class="dropdown-title"><b>For Requester</b></li>
              <li><a href="<?php echo $base_url; ?>history" class="dropdown-item"><?php echo $header_array['lg3_history']; ?></a></li>
              <?php
              if($chat_status == 0){
                ?>
              <li><a href="<?php echo $base_url; ?>add-request" class="dropdown-item"><?php echo $header_array['lg3_add_request']; ?></a></li>
              <?php } else { ?>
                <li><a href="javascript:void(0);" data-toggle="modal" data-target="#ddsubscribeConfirmModal"><?php echo $header_array['lg3_add_request']; ?></a></li>
              <?php }  ?>
              <li><a href="<?php echo $base_url; ?>my-request" class="dropdown-item"><?php echo $header_array['lg3_my_requests']; ?></a></li>
			  <li class="dropdown-title"><b>For Provider</b></li>
              <?php
              if($chat_status == 0){
                ?>
                <li><a href="<?php echo $base_url; ?>add-service" class="dropdown-item"><?php echo $header_array['lg3_add_service']; ?></a></li>
              <?php } else { ?>
                <li><a href="javascript:void(0);" data-toggle="modal" data-target="#ddsubscribeConfirmModal"><?php echo $header_array['lg3_add_service']; ?></a></li>
              <?php }  ?>
              <li><a href="<?php echo $base_url; ?>my-services" class="dropdown-item"><?php echo $header_array['lg3_my_services']; ?></a></li>
              <li><a href="<?php echo $base_url; ?>chat-history" class="dropdown-item"><?php echo $header_array['lg3_provider_chat_h']; ?>&nbsp;&nbsp;<span class="btn btn-primary badge badge-notify"><span class="chat-count">0</span></span></a></li>
              <li><a href="<?php echo $base_url; ?>requester-chat-history" class="dropdown-item"><?php echo $header_array['lg3_chat_history']; ?>&nbsp;&nbsp;<span class="btn btn-primary badge badge-notify"><span class="requester-chat-count">0</span></span></a></li>
              <li><a href="<?php echo $base_url; ?>my-booking" class="dropdown-item"><?php echo $header_array['lg3_my_booking']; ?></a></li>
              <li><a href="<?php echo $base_url; ?>booking-service" class="dropdown-item"><?php echo $header_array['lg3_booking_service']; ?></a></li>
              <li><a href="<?php echo $base_url; ?>user/logout" class="dropdown-item"><?php echo $header_array['lg3_logout']; ?></a></li>
            </ul>
          </li>
        <?php } else{ ?>

          <li>
            <a class="nav-link header-login" href="<?php echo base_url();?>login">Login</a>
          </li>
          <li>
            <a class="nav-link header-signup" href="<?php echo base_url();?>signup">Signup</a>
          </li>
        <?php } ?>
        </ul>
</nav>
<script type="text/javascript">
  function setlanguage(lang) {
    $.post(base_url+'setlocation/language',{lang:lang},function(status){
      if(status){
        location.reload();
      }
    });
  }
  function getLocation() {
  if (navigator.geolocation) {
     navigator.geolocation.getCurrentPosition(showPosition);
  }
}
function showPosition(position) {

           var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            var geocoder = geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                console.log(results);
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[3]) 
                    {
                        if(session==1)
                        {
                            $('#user_address').val(results[3].formatted_address);
                            $('#user_latitude').val(position.coords.latitude);
                            $('#user_longitude').val(position.coords.longitude);

                            $.post(base_url+'home/set_location',{address:results[3].formatted_address,latitude:position.coords.latitude,longitude:position.coords.longitude})
                        }
                        else
                        {
                            if(user_address=='' && user_latitude=='' && user_longitude=='')
                            {
                                $('#user_address').val(results[3].formatted_address);
                                $('#user_latitude').val(position.coords.latitude);
                                $('#user_longitude').val(position.coords.longitude);

                                $.post(base_url+'home/set_location',{address:results[3].formatted_address,latitude:position.coords.latitude,longitude:position.coords.longitude})
                            }
                        }
                        
                    }
                }
            });
        }
        function user_currency(code) {

         if (code != "") {

             var csrf_token = $('#csrf_lang').val();
             $.ajax({
                 type: 'POST',
                 url: base_url+'home/updatemulticurrency',
                 data: {
                     code: code,
                     csrf_token_name: csrf_token
                 },
                 dataType: 'json',
                 success: function(response) {
                     if (response) {
                         window.location.reload();
                     } else {
                        window.location.reload();
                     }
                 }
             });
         }
      }
</script>
</header>
