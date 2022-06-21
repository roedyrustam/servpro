<?php

    $google_analytics_showhide = $this->db->get_where('system_settings', array('key'=>'analytics_showhide'))->row()->value;
    $google_analytics_code = $this->db->get_where('system_settings', array('key'=>'google_analytics'))->row()->value;
    $query = $this->db->query("select * from system_settings WHERE status = 1");
    $result = $query->result_array();
    $this->website_name = '';
    $this->website_logo_front ='assets/img/logo.png';
    $logo_image = "";
    $fav=base_url().'assets/img/favicon.png';
    if(!empty($result))
    {
        foreach($result as $data){
            if($data['key'] == 'website_name'){
            $this->website_name = $data['value'];
            }
                if($data['key'] == 'favicon'){
                     $favicon = $data['value'];
            }
            if($data['key'] == 'logo_front'){ //logo_front
                     $this->website_logo_front =  $data['value'];
            }
            if($data['key'] == 'meta_title'){
                 $this->meta_title = $data['value'];
            }
            if($data['key'] == 'meta_keywords'){
                 $this->meta_keywords = $data['value'];
            }
            if($data['key'] == 'meta_description'){
                 $this->meta_description = $data['value'];
            }
            if($data['key'] == 'viewport'){
                 $this->viewport = $data['value'];
            }
           
        }
    }
    if(!empty($favicon))
    {
    $fav = base_url().'uploads/logo/'.$favicon;
    }


   

    $lang = (!empty($this->session->userdata('lang')))?$this->session->userdata('lang'):'en';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title><?php echo $this->website_name;?></title>
    <meta name="title" content="<?php echo $this->meta_title;?>">
	<meta content="<?php echo $this->meta_keywords; ?>" name="keywords">
	<meta content="<?php echo $this->meta_description; ?>" name="description">

    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $fav ;?>">
    <?php
        $base_url = base_url();
        $page = $this->uri->segment(1);
     ?>
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/owlcarousel/owl.theme.default.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/swiper/css/swiper.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/custom.css">
    <style type="text/css">
      .user-img{
        width: 100px !important;
      }
    </style>

       <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap-datetimepicker.min.css">
       <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/starrating.css">
       <?php if($page == 'chat' || $page == 'requester-chat'){ ?>
       <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery.mCustomScrollbar.min.css">
       <?php } ?>
       <?php if($page == 'signup' || $page == 'edit-profile'){ ?>
       <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/cropper.min.css">
    	   <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/avatar.css">
       <?php } ?>
       <?php if($page=='add-service' || $page=='edit-service'  || $page=='service'){ ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap-select.min.css">
        <?php } ?>
        <?php if($page == 'add-request' || $page=='add-service' || $page=='edit-service' || $page=='edit-request'){ ?>
       <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/cropper.min.css">
         <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/avatar.css">
       <?php } ?>
	   <?php
		 if($lang=='ar'){
			echo'<link rel="stylesheet" type="text/css" href="'.base_url().'assets/css/theme-rtl.css">';
		 }else{
			 echo '<link rel="stylesheet" type="text/css" href="'.base_url().'assets/css/theme.css">';
			 echo '<link rel="stylesheet" type="text/css" href="'.base_url().'assets/css/theme-new.css">';
		 }
		 ?>
 
    <?php
        $text = !empty($language_content['language'])?$language_content['language']:'';
    ?>
   <script type="text/javascript">
    var username_err_msg ='';
    var password_err_msg ='';
    var mobile_error  ='';
	var appointment_text = "<?php echo !empty($text['request_and_provider_list']['lg6_appointment'])?$text['request_and_provider_list']['lg6_appointment']:''; ?>";
    var edit_text ='';
    var delete_text ='';
    var new_pass_msg = '';
    var new_pass_valid_msg = '';
    var re_new_pass_msg = '';
    var same_pass_msg = '';
    var username_err_msg = '';
    var password_err_msg = '';
    var description_point = '';
    var accept_title = '';
    var accept_msg = '';
    var subscribe_title = '';
    var do_subscribe_msg = '';
    var delete_title = '';
    var delete_msg = '';
    var do_subscribe_msg1 = '';
    var chat_lang = '';
    var new_pass_msg='';
    var contact_number_txt='';
	var No_result_were_found = "<?php echo !empty($text['request_and_provider_list']['lg6_no_details_were'])?$text['request_and_provider_list']['lg6_no_details_were']:''; ?>";

  </script>


    <?php if($google_analytics_showhide == 1 && $google_analytics_code != '') { ?>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
             
                ga('create', '<?php echo $google_analytics_code; ?>', 'auto');
                ga('send', 'pageview');
        </script>
    <?php } ?>
</head>
<body>
