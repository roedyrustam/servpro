$(document).ready(function(){
$("#chat_form").on('submit',function(e){
    // e.preventDefault();
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
  });
 });


function prevoius_chat(e) {
    var from = $('#from').val();
    var to   = $('#to').val();
    var page   = $(e).attr('data-next');
    var datavalid = -1;
    if(page > 1){
      $.post(base_url+'load-previous-chat',{from:from,to:to,page:page},function(data){

        var previousdata = JSON.parse(data);
        var chat_list = previousdata.chat_list;
        var today_date = previousdata.today_date;
        var yesterday_date = previousdata.yesterday_date;
        $(e).attr('data-current',previousdata.current_page);
        datavalid = previousdata.next_page;
        $(e).attr('data-next',datavalid);

            var chats ='';
            var whochat='chat-left';
            var t_string = 0;
            var y_string = 0;
            var chat_dates = 0;
            var dates = [];

            if(chat_list.length > 0){
            
              $(chat_list).each(function(i,newdata){
            
                 last_id = newdata.id;
                var c_date  = newdata.date;
                if((today_date == c_date) && (t_string ==0)){
                  t_string = 1;
                  c_date = c_date.replace(/-/g, "");
                  dates.push(c_date);
                 chats +='<div class="chat-line"><span class="chat-date">Today</span></div>';
                } 
                
                
                if((yesterday_date == c_date) && (y_string ==0)){
                  y_string = 1;
                  c_date = c_date.replace(/-/g, "");
                  dates.push(c_date);
                  chats +='<div class="chat-line"><span class="chat-date">Yesterday</span></div>';
                } 
                
                
                var cdate = c_date.replace(/-/g, "");
                
                
                
                if(((jQuery.inArray(cdate,dates)) == -1)){
                  dates.push(cdate); 
                  chat_dates = 1;
                  chats +='<div class="chat-line"><span class="chat-date">'+c_date+'</span></div>';
                }
              
                
                
                
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
            if(datavalid == '-1'){
              $(e).hide();   
            }
            $('#conversations').prepend(chats);
      });  
    }
}

$(document).keypress(function(event){
  var keycode = (event.keyCode ? event.keyCode : event.which);
  if(keycode == '13'){
    //send_chat()
  }
});

$(document).ready(function(){
  if(page == 'chat'){
    setInterval(function(){ 
      var from = $('#from').val();
      var to = $('#to').val();
      var last_id = $('#last_id').val();

       $.post(base_url+'conversationcall',{from:from,to:to,last_id:last_id},function(data){
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
              
              $('#last_id').val(last_id);
              $('#conversations').append(chats);
              $(".slimscrollleft.chats").mCustomScrollbar("update");
              $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  
            }
              
          });
    }, 3000);


    $(".chat-box.slimscrollleft").mCustomScrollbar({
        theme:"minimal"
        });
    
    $(".slimscrollleft.chats").mCustomScrollbar("update");
    $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom"); 

    setInterval(function(){ 
      var from = $('#from').val();
      var to = $('#to').val();
      
       $.post(base_url+'readchat',{from:from,to:to},function(data){

             
          });
    }, 3000);
  }
});


function load_history() {
  
    var page = $('.chat_history_load_more').attr('data-next');
    
    if(page >0){
      $.post(base_url+'load_chat_history',{page:page},function(details){
            
            var details = JSON.parse(details);
            var data = details.chat_list;
            var next_page = details.next_page;
            var chats = '';
            if(data.length > 0){
              $(data).each(function(i,newdata){

                var chat_from = newdata.chat_from;
                var img;
                if(newdata.profile_img!=''){
                  img = base_url+newdata.profile_img;
                }else{
                  img = base_url+'assets/img/user.jpg';
                }

                chats +='<li>'+
                    '<a href="'+base_url+'chat/'+md5(chat_from)+'">'+
                      '<div class="chat-user">'+
                        '<img alt="'+newdata.username+'" src="'+img+'">'+
                        '<span class="btn btn-primary badge badge-notify position-style">'+newdata.unreadcount+'</span>'+
                      '</div>'+
                      '<div class="chat-user-info">'+
                        '<span class="chatter-name">'+newdata.username+'</span>'+
                        '<span class="chat-msg">'+newdata.content+'</span>'+
                      '</div>'+
                      '<div class="chat-last-time">'+
                        '<i class="fa fa-clock-o"></i> <span>'+newdata.ago+'</span>'+
                      '</div>'+
                    '</a>'+
                        '</li>';  
              });
               
            }
            
            $('.chat_history_load_more').attr('data-next',next_page);
            if(next_page === -1){
             $('.loadore_btn').hide();
            }
            $('.chat_history_load_more').append(chats);
        });  
    } 
    
}

//-------------------requester chat-----------------------------------

$(document).ready(function(){
  $("#chat_requester_form").on('submit',function(event){
    event.preventDefault();

    var from = $('#from').val();
    var to = $('#to').val();
    var last_id = $('#last_id').val();
    var content = $('#content').val();
   
    if($.trim(content)!=""){
       $('#chat_button').attr('disabled',true);
        $.post(base_url+'requester-chat-conversation',{from:from,to:to,content:content,last_id:last_id},function(data){

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
            $('#conversations').append(chats);
            $('#content').val('');
            $('#chat_button').attr('disabled',false);
        });
    }
});
});

function requester_prevoius_chat(e) {

    var from = $('#from').val();
    var to   = $('#to').val();
    var page   = $(e).attr('data-next');
    var datavalid = -1;
    if(page > 1){
      $.post(base_url+'requester-load-previous-chat',{from:from,to:to,page:page},function(data){

        var previousdata = JSON.parse(data);
        var chat_list = previousdata.chat_list;
        var today_date = previousdata.today_date;
        var yesterday_date = previousdata.yesterday_date;
        $(e).attr('data-current',previousdata.current_page);
        datavalid = previousdata.next_page;
        $(e).attr('data-next',datavalid);

            var chats ='';
            var whochat='chat-left';
            var t_string = 0;
            var y_string = 0;
            var chat_dates = 0;
            var dates = [];

            if(chat_list.length > 0){
            
              $(chat_list).each(function(i,newdata){
            
                 last_id = newdata.id;
                var c_date  = newdata.date;
                if((today_date == c_date) && (t_string ==0)){
                  t_string = 1;
                  c_date = c_date.replace(/-/g, "");
                  dates.push(c_date);
                 chats +='<div class="chat-line"><span class="chat-date">Today</span></div>';
                } 
                
                
                if((yesterday_date == c_date) && (y_string ==0)){
                  y_string = 1;
                  c_date = c_date.replace(/-/g, "");
                  dates.push(c_date);
                  chats +='<div class="chat-line"><span class="chat-date">Yesterday</span></div>';
                } 
                
                
                var cdate = c_date.replace(/-/g, "");
                
                
                
                if(((jQuery.inArray(cdate,dates)) == -1)){
                  dates.push(cdate); 
                  chat_dates = 1;
                  chats +='<div class="chat-line"><span class="chat-date">'+c_date+'</span></div>';
                }
              
                
                
                
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
            if(datavalid == '-1'){
              $(e).hide();   
            }
            $('#conversations').prepend(chats);
      });  
    }   
}

$(document).ready(function(){
  if(page == 'requester-chat'){
      setInterval(function(){ 
      var from = $('#from').val();
      var to = $('#to').val();
      var last_id = $('#last_id').val();

       $.post(base_url+'requester-conversationcall',{from:from,to:to,last_id:last_id},function(data){
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
              
              $('#last_id').val(last_id);
              $('#conversations').append(chats);
              $(".slimscrollleft.chats").mCustomScrollbar("update");
              $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom");  
            }
              
          });
    }, 3000);

    $(".chat-box.slimscrollleft").mCustomScrollbar({
        theme:"minimal"
    });
    
    $(".slimscrollleft.chats").mCustomScrollbar("update");
    $(".slimscrollleft.chats").mCustomScrollbar("scrollTo", "bottom"); 

    setInterval(function(){ 
      var from = $('#from').val();
      var to = $('#to').val();
      
       $.post(base_url+'requester-readchat',{from:from,to:to},function(data){

             
          });
    }, 3000);

  }
});


function requester_load_history() {
  
    var page = $('.chat_history_load_more').attr('data-next');
    
    if(page >0){
      $.post(base_url+'requester_load_chat_history',{page:page},function(details){
            
            var details = JSON.parse(details);
            var data = details.chat_list;
            var next_page = details.next_page;
            var chats = '';
            if(data.length > 0){
              $(data).each(function(i,newdata){

                var chat_from = newdata.chat_from;
                var img;
                if(newdata.profile_img!=''){
                  img = base_url+newdata.profile_img;
                }else{
                  img = base_url+'assets/img/user.jpg';
                }

                chats +='<li>'+
                    '<a href="'+base_url+'chat/'+md5(chat_from)+'">'+
                      '<div class="chat-user">'+
                        '<img alt="'+newdata.username+'" src="'+img+'">'+
                        '<span class="btn btn-primary badge badge-notify position-style">'+newdata.unreadcount+'</span>'+
                      '</div>'+
                      '<div class="chat-user-info">'+
                        '<span class="chatter-name">'+newdata.username+'</span>'+
                        '<span class="chat-msg">'+newdata.content+'</span>'+
                      '</div>'+
                      '<div class="chat-last-time">'+
                        '<i class="fa fa-clock-o"></i> <span>'+newdata.ago+'</span>'+
                      '</div>'+
                    '</a>'+
                        '</li>';  
              });
               
            }
            
            $('.chat_history_load_more').attr('data-next',next_page);
            if(next_page === -1){
             $('.loadore_btn').hide();
            }
            $('.chat_history_load_more').append(chats);
        });  
    } 
    
}