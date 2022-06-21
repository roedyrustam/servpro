<?php
$date_formats = $this->db->get_where('system_settings',array('key' => 'date_format'))->row()->value;
$time_format = $this->db->get_where('system_settings',array('key' => 'time_format'))->row()->value;
?>
<!-- Breadcrub -->
<div class="breadcrub">
   <div class="container">
      <?php
         $chat = $language_content['language'];
         $chat_array = !empty($chat)?$chat:'';
         ?>
      <ul>
         <li><a href="<?php echo $base_url; ?>home"><?php echo $chat_array['lg_home']; ?></a></li>
         <li><?php echo $chat_array['lg7_chat_history']; ?></li>
      </ul>
   </div>
</div>
<!-- /Breadcrub -->

<!-- Chat History -->
<div class="chat-history mb-5">
   <div class="container">
      <div class="row">
         <div class="col-12 col-lg-4">
            <?php
               $chats = $history['chat_list'];
               $next_page = $history['next_page'];
               $current_page = $history['current_page'];
               
               if(count($chats) > 0 ){ ?>
            <div class="chat-user-list" style="cursor: pointer;">
               <?php
                  foreach ($chats as $chat) {
                  $user_id = $this->session->userdata('user_id');
                  $img = 	(!empty($chat['profile_img']))?$chat['profile_img']:'assets/img/user.jpg';
                  $img = base_url(). $img;
                  $name = $chat['username'];
                  $id = md5($chat['chat_from']);
                  $time = $chat['chat_utc_time'];
                  date_default_timezone_set("Asia/Kolkata");
                  $date_time = date('Y-m-d H:i:s');
                  $ago = time_differences_ago($time,$date_time);
                  ?>
               <div class="user-widget" data-getid="<?php echo $id; ?>">
                  <div class="chat-user-img">
                     <img src="<?php echo $img; ?>" alt="<?php echo $name; ?>" width="60">
                  </div>
                  <div class="chat-user-details">
                     <div class="user-name">
                        <h4><?php echo ucfirst($name); ?></h4>
                     </div>
                     <div class="user-text text-truncate"><?php echo $chat['content'];?></div>
                  </div>
                  <div class="time-details">
                     <div class="time-col mt-2 mb-1"><?php echo $ago;?></div>
                     <div class="unread-msg"><span><?php echo $chat['unreadcount'];?></span></div>
                  </div>
               </div>
               <?php } ?>
               <?php if($next_page > 1){ ?>
               <a href="javascript:void(0)" onclick="load_history()" class="btn btn-primary loadore_btn" > <?php echo $chat_array['beban']; ?></a>
               <?php }  ?>
               <?php }else{ ?>
               <a href="javascript:void(0)" class="alert alert-danger col-md-12"><?php echo $chat_array['lg7_no_details_were']; ?></a>
               <?php }  ?>
            </div>
         </div>
         <div class="col-12 col-lg-8 show_single_chat">
         	<img src="assets/img/loading.gif" alt="" class="loading_gif" style="display: none;">
           
         </div>
      </div>
   </div>
</div>
<!-- Chat History -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">
   $(".user-widget").click(function() {
   	var chat_id = $(this).attr('data-getid');
   	var user_id = "<?php echo $this->session->userdata('user_id') ?>";
    $('.loading_gif').show();
   
   	$.ajax({
           type: "GET",
           url: "<?php echo $base_url; ?>get-chats/"+ chat_id,	       
           success: function (data) {
            $('.loading_gif').hide();
             const myArray = JSON.parse(data);
             myArray.forEach(function(obj){ 
             	var chat_userdetails = obj.chat_from;
             	var chat_details = obj.chats;
             	var chats = chat_details.chat_list;
             	var chat_record = obj.last_record;
              var current_day = 0;
              var yday = 0;
              var chats_dates = [];
              var last_id = 0;

   
   			   if($('.show_single_chat').length > 0)
             {
             	$('.show_single_chat').html('');
             	$('<div class="chat-user-content">' +
   				'<div class="chat-user-header">' +
   					'<div class="user-widget">' +
   						'<div class="chat-user-img">' +
   							'<img src="assets/img/user.jpg" alt="" width="60">' +
   						'</div>' +
   						'<div class="chat-user-details">' +
   							'<div class="user-name chat-user-name"><h4>'+chat_userdetails.username+'</h4></div>' +
   						'</div>' +
   					'</div>' +
   				'</div>' +
   				'<div class="chat-user-body">'+
   				
   				
   				'div').appendTo('.show_single_chat');
   				
   			if(chats.length > 0) {
   		 		chats.forEach(function(chat) { 
            var chattime = chat.chat_utc_time;
            var fields = chattime.split('');
            var date = fields[0];

            var chat_date = chat.date;

            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            var date_time = yyyy + '-' + mm + '-' + dd;

            var yesterday = '2021-08-17';

            console.log(chat_date);
            console.log(date_time);
            console.log('today',today);
            console.log('yday',yesterday);

            if((chat_date == date_time) && (current_day == 0)) {
              console.log('true');
                  current_day = 1;
                  var chats_dates = chat_date;
                  $('<div class="chat-line"><span class="chat-date">Today</span></div>').appendTo('.chat-user-body');
            } else if((chat_date == yesterday) && (yday == 0)) {
                    yday = 1;
                    chats_dates = chat_date;

                     $('<div class="chat-line"><span class="chat-date">Yesterday</span></div>').appendTo('.chat-user-body');
            } else if(($.inArray(chat_date,chats_dates) == -1) && (chat_date !== yesterday) && (chat_date !== date_time)){
                    chats_dates = chat_date;

                  $('<div class="chat-line"><span class="chat-date">'+chat.date+'</span></div>').appendTo('.chat-user-body');
              }



   		 			if(user_id == chat.chat_to) {
   		 				$('<div class="message-box received">'+
   						'<div class="message-text">'+chat.content+'</div>'+
   						'<span class="time-col">'+chat.time+'</span>'+'</div>').appendTo('.chat-user-body');
   		 			}
   		 			if(user_id == chat.chat_from) {
   		 				$('<div class="message-box sent">'+
   						'<div class="message-text">'+chat.content+'</div>'+
   						'<span class="time-col">'+chat.time+'</span>'+'</div>').appendTo('.chat-user-body');
   				
   					}
   
   					last_id = chat.id;		
   				});
   				
   			}
   
   			$('<div class="chat-footer">'+
   				'<form id="chat_form" action="">' +
   						'<div class="input-group">' +
   						'<input type="hidden" id="from" value='+user_id+'>' +
   						'<input type="hidden" id="to" value='+chat_userdetails.user_id+'>' +
   						'<input type="hidden" id="last_id" value='+chat_record.id+'>' +
   							
   						
   							'<div class="type-col">' +
               			'<input type="text" class="input-msg-send form-control" id="content" placeholder="Type something">' +
               		'</div>'+
   						
   						'<span class="input-group-append">'+
   							'<button type="button" id="chat_button" class="btn btn-link msg-send-btn" onclick="loadForm()"><i class="fab fa-telegram-plane"></i></button>'+
   						'</span>'+
   					'</div>' +
   				'</form>' +
   				'</div>' +
   				'</div>').appendTo('.chat-user-body');
             }
   		  });
             
             
            
             
           }
   	});
   
      
   });
   
   
</script>
<script>
   var loadForm = function(){
       $('form#chat_form').submit();
       var from = $('#from').val();
     var to = $('#to').val();
     var last_id = $('#last_id').val();
     var content = $('#content').val();
     if($.trim(content)!=""){
       $('#chat_button').attr('disabled',true);
         $.post(base_url+'chat-conversation',{from:from,to:to,content:content,last_id:last_id},function(data){
             data = JSON.parse(data);
             var chats ='';
             var whochat='chat-left';
             if(data.length > 0){
               $(data).each(function(i,newdata){
                 last_id = newdata.id;
                 
                 if(newdata.chat_to == from){
                   whochat=' chat-left';  
                 }else{
                   whochat='';
                 }
                 chats +='<div class="chat'+whochat+'">'+
                         '<div class="chat-body">'+
                          '<div class="chat-content">'+
                           '<p>'+newdata.content+'</p>'+
                           '<span class="chat-time">'+newdata.time+'</span>'+
                            '</div>'+
                             '</div>'+
                              '</div>';  
               });              
             }
             $('#last_id').val(last_id);
             $('.conversations').append(chats);
             $('#content').val('');
             $('#chat_button').attr('disabled',false);
         });
     }
   
   
   };
</script>
