<?php
    $query = $this->db->query("select * from system_settings WHERE status = 1");
    $result = $query->result_array();
    $this->website_name = '';
    $this->website_logo_front ='assets/img/logo.png';
    $this->logo_image = "";
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

            if($data['key'] == 'login_image'){
                 $login_image = $data['value'];
            }

        }
    }
    if(!empty($favicon))
    {
        $fav = base_url().'uploads/logo/'.$favicon;
    }


    if(!empty($login_image))
        $login_image=base_url().$login_image;
    else $login_image = base_url().'assets/img/page-banner.jpg';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $fav ;?>">
    <title><?php echo $this->website_name;?></title>
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">
    <style type="text/css">
    </style>
    <?php
    $base_url = base_url();
    $page = $this->uri->segment(1);
    if($page == 'dashboard'){ ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/morris/morris.css">
    <?php }  ?>
    <?php if($page == 'admin-profile'){ ?>
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/cropper.min.css">
  		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/avatar.css">
    <?php } ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css">
<link href="<?php echo base_url(); ?>assets/css/bootstrap-toggle.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/summernote.css" rel="stylesheet">
  

    <style type="text/css">

        .account-box {
            position: relative !important;
            border-radius: 4px;
            margin: 50px auto;
            width: 400px;
            border: 1px solid #e7e7e7;
            background-color: #fff;
        }



        .login-bg:before {
            position:absolute;
            background: <?php echo "url('".$login_image."')"?> !important; content:""; top:0px; left:0px; background-position: center bottom;background-size: cover;width:100%; height: 302px;padding: 20px 0; z-index:0; border-radius: 0px 0px 50px 50px;
        }

    </style>
</head>

<body>
    <div class="main-wrapper">
