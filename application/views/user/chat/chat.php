<!-- Breadcrub -->
<div class="breadcrub">
   <div class="container">
      <?php
         $chat = $language_content['language'];
         $chat_array = !empty($chat)?$chat:'';
         ?>
      <ul>
         <li><a href="<?php echo $base_url; ?>home"><?php echo $chat_array['lg_home'];?></a></li>
         <li><?php echo $chat_array['lg7_chat']; ?></li>
      </ul>
   </div>
</div>
<!-- /Breadcrub -->
<?php
   $user_id = $this->session->userdata('user_id');
   $all_data = $chats;
   $chats    = $all_data['chat_list'];
   
   ?>
<!-- Chat History -->
<div class="chat-history mb-5">
   <div class="container">
      <div class="row">
       
         <div class="col-12 col-lg-12">
            <div class="chat-user-content">
               <div class="chat-user-header">
                  <div class="user-widget">
                     <div class="chat-user-img">
                        <?php
                           $img = 	(!empty($chat_from['image']))?$chat_from['image']:'assets/img/user.jpg';
                           $img = base_url(). $img;
                            ?>
                        <a href="javascript:void(0)">
                        <img src="<?php echo $img; ?>" class="img-circle" alt="">
                        </a>
                     </div>
                     <div class="chat-user-details">
                        <div class="user-name">
                           <h4><?php echo ucfirst($chat_from['username']); ?></h4>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="chat-user-body">
                  <?php
                     $today = 0;
                     $yesterday = 0;
                     $chats_dates = array();
                     $last_id = 0;
                     	if(count($chats) > 0){
                     		foreach ($chats as $chat) {
                     			$datetime = $chat['chat_utc_time'];
                     			$time = $datetime;
                        
                            $time_format = $this->db->get_where('system_settings',array('key' => 'time_format'))->row()->value;
                              if($time_format == '12 Hours') {
                               $time = date('G:ia', strtotime($time));
                           } elseif($time_format == '24 Hours') {
                              $time = date('H:i:s', strtotime($time));
                           } else {
                               $time = date('G:ia', strtotime($time));
                           }
                     			$chat_date = date('Y-m-d',strtotime($time));
          			        date_default_timezone_set("Asia/Kuala_Lumpur");
                     
                     		$date_time = date('Y-m-d');
                     		$y_date_time = date('Y-m-d',strtotime("-1 days"));
                     
                     
                     if($chat['chat_to'] == $user_id){ ?>
                  <div class="message-box received">
                     <div class="message-text"><?php echo $chat['content']; ?></div>
                     <span class="time-col"><?php echo $time ?></span>
                  </div>
                  <?php } ?>
                  <?php if($chat['chat_from'] == $user_id){ ?>
                  <div class="message-box sent">
                     <div class="message-text"><?php echo $chat['content']; ?></div>
                     <span class="time-col"><?php echo $time ?></span>
                  </div>
                  <?php } ?>
                  <?php
                     $last_id = $chat['id'];
                     }
                     }  ?>
                  <div class="chat-footer">
                     <form id="chat_form" action="">
                        <div class="input-group">
                           <input type="hidden" id="from" value="<?php echo $user_id; ?>">
                           <input type="hidden" id="to" value="<?php echo ucfirst($chat_from['user_id']); ?>">
                           <input type="hidden" id="last_id" value="<?php echo $last_id; ?>">
                           <div class="type-col">
                              <input type="text" class="input-msg-send form-control" id="content"placeholder="Type something">
                           </div>
                           <div class="input-group-append">
                              <button type="submit" class="btn btn-link msg-send-btn" id="chat_button"><i class="fab fa-telegram-plane"></i></button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Chat History -->