<?php

$page = $this->uri->segment(1);
$active =$this->uri->segment(2);
    $access_result_data_array = $this->session->userdata('access_module');  
    
?>
<div class="sidebar" id="sidebar">
    <div class="sidebar-logo">           
     <a href="<?php echo $base_url; ?>dashboard" class="logo">
        <img src="<?php echo $base_url.$this->website_logo_front; ?>" alt="" class="img-responsive" >
    </a>
</div>    
<div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu">
        <ul>
            <li class="<?php echo ($page == 'dashboard' && $active == '')?'active':'';?>">
                <a href="<?php echo $base_url; ?>dashboard"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
            </li>
            <?php if(in_array(2,$access_result_data_array))
{ ?>
            <li class="<?php echo ($page == 'adminlist')?'active':''; echo ($page == 'add-adminlist')?'active':''; echo ($page == 'edit-adminlist')?'active':'';?>"  >
                <a href="<?php echo $base_url; ?>adminlist"><i class="fas fa-cube"></i> <span>Adminlist</span></a>
            </li>
        <?php } ?>
        <?php if(in_array(3,$access_result_data_array))
{ ?>
            <li class="<?php echo ($page == 'categories')?'active':''; echo ($page == 'add-category')?'active':''; echo ($page == 'edit-category')?'active':'';?>"  >
                <a href="<?php echo $base_url; ?>categories"><i class="fas fa-cube"></i> <span>Categories</span></a>
            </li>
        <?php } ?>
        <?php if(in_array(4,$access_result_data_array))
{ ?>
            <li class="<?php echo ($page == 'subcategories')?'active':''; echo ($page == 'add-subcategories')?'active':''; echo ($page == 'edit-subcategories')?'active':'';?>"  >
                <a href="<?php echo $base_url; ?>subcategories"><i class="fas fa-cubes"></i> <span>Sub Categories</span></a>
            </li>       
            <?php } ?>

        <?php if(in_array(8,$access_result_data_array))
{ ?>
            <li class="<?php echo ($page == 'service-providers')?'active':'';?>" >
                <a href="<?php echo $base_url; ?>service-providers"><i class="fas fa-life-ring"></i> <span>Service Providers</span></a>
            </li>
        <?php } ?>
        <?php if(in_array(9,$access_result_data_array))
{ ?>
            <li class="<?php echo ($page == 'service-requests')?'active':'';?>" >
                <a href="<?php echo $base_url; ?>service-requests"><i class="fas fa-paper-plane"></i> <span>Service Requests</span></a>
            </li>
        <?php } ?>			
            <?php if(in_array(5,$access_result_data_array))
{ ?>                
            <li class="<?php echo ($page == 'ratingstype')?'active':''; echo ($page == 'add-ratingstype')?'active':''; echo ($page == 'edit-ratingstype')?'active':'';?>"  >
                <a href="<?php echo $base_url; ?>ratingstype"><i class="fas fa-star"></i> <span>Rating Type</span></a>
            </li>                   
<?php } ?>
<?php if(in_array(6,$access_result_data_array))
{ ?>
            <li class="<?php echo ($page == 'subscriptions')?'active':''; echo ($page == 'add-subscription')?'active':''; echo ($page == 'edit-subscription')?'active':'';?>"  >
                <a href="<?php echo $base_url; ?>subscriptions"><i class="fab fa-cc-mastercard"></i> <span>Subscriptions</span></a>
            </li>
        <?php } ?>
            <li class="<?php echo  ($active =='offlinepayment_details')? 'active':''; ?>"  >
                <a href="<?php echo base_url().'admin/offlinepayment_details'; ?>"><i class="fab fa-cc-mastercard"></i> <span>Offline Payments</span></a>
            </li>
        <?php if(in_array(7,$access_result_data_array))
{ ?>
            <li class="<?php echo ($page == 'users')?'active':'';?>" >
                <a href="<?php echo $base_url; ?>users"><i class="fas fa-users" aria-hidden="true"></i> <span>Users</span></a>
            </li>
        <?php } ?>

<?php if(in_array(13,$access_result_data_array))
{ ?>
         <li class="<?php echo ($active == 'currency')? 'active':''; ?>">
            <a href="<?php echo base_url().'admin/currency'; ?>"><i class="fas fa-money-bill-alt"></i><span>Currency</span> </a>
        </li>
    <?php } ?>
            <?php if(in_array(12,$access_result_data_array))
{ ?>
            <li>
                <a href="javascript:void(0);" class=""><i class="fas fa-language"></i> <span>Language</span> <span class="menu-arrow"></span></a>
                <ul class="sub-menu" <?php echo ($page =='language-add' || $page =='web-keywords' || $active == 'pages')? '':'style="display:none;"'; ?>> 
                 <li class="<?php echo ($page == 'language-add')? 'active':''; ?>"> <a href="<?php echo $base_url; ?>language-add"><i class="fas fa-language"></i> <span>Add Language</span></a> </li>
                 <li class="<?php echo ($page == 'web-keywords')? 'active':''; ?>"> <a href="<?php echo $base_url; ?>web-keywords"><i class="fas fa-language"></i> <span>Web Language Keywords</span></a> </li>
                 <li class="<?php echo ($active == 'pages')? 'active':''; ?>"> <a href="<?php echo $base_url; ?>language/pages"><i class="fas fa-language"></i> <span>App Language</span></a> </li> 
             </ul>
         </li>
<?php } ?>

  
     <?php $active_1 = $this->uri->segment(3);    ?>
     <?php if(in_array(14,$access_result_data_array))
{ ?>

    <li>
        <a href="#" class=""><i class="fas fa-cog"></i> <span>Settings</span> <span class="menu-arrow"></span></a>
        <ul class="sub-menu" <?php echo ($active =='general-settings' ||$active =='paypal_payment_gateway' ||$active =='razor_payment_gateway' ||$active =='stripe_payment_gateway' ||$active =='paytab_payment_gateway' ||$active =='seo-settings' ||$active =='other-settings' ||$active =='localization' ||$active =='system-settings' ||$active =='emailsettings' || $active =='settings' || $active =='stripe_payment_gateway')? '':'style="display:none;"'; ?>> 
     
        <li  class="<?php echo ($active == 'general-settings')? 'active':''; ?>">
            <a href="<?php echo $base_url; ?>admin/general-settings"> <span> General Settings</span></a>
        </li>
        <li class="<?php echo ($active =='emailsettings')? 'active':''; ?>"><a href="<?php echo base_url().'admin/emailsettings';?>" > Email Settings </a></li> 
        <li class="<?php echo  ($active =='other-settings')? 'active':''; ?>"><a href="<?php echo base_url().'admin/other-settings'; ?>">Other Settings</a></li>
        <li class="<?php echo  ($active =='seo-settings')? 'active':''; ?>"><a href="<?php echo $base_url; ?>admin/seo-settings">SEO Settings</a></li>
        <li class="<?php echo  ($active =='system-settings')? 'active':''; ?>"><a href="<?php echo $base_url; ?>admin/system-settings">System Settings</a></li>
        <li class="<?php echo  ($active =='localization')? 'active':''; ?>"><a href="<?php echo $base_url; ?>admin/localization">Localization</a></li>
        <li class="<?php echo ($active == 'stripe_payment_gateway' ||$active == 'paypal_payment_gateway' || $active == 'paytab_payment_gateway' || $active == 'razor_payment_gateway')?'active':'';?>">
            <a href="<?php echo $base_url; ?>admin/paypal_payment_gateway"> <span>Payment Settings</span></a>
        </li>
		<li class="<?php echo ($active == 'colour_settings' && $page == 'dashboard')?'active':'';?>" >
			<a href="<?php echo $base_url; ?>dashboard/colour_settings"><i class="fas fa-adjust"></i> <span>Colour Settings</span></a>
		</li>

        </ul>
    </li>
     <li>
        <a href="#" class=""><i class="fas fa-cog"></i> <span> Frontend Settings</span> <span class="menu-arrow"></span></a>
        <ul class="sub-menu" <?php echo ($active =='frontend-settings' || $active =='footer-settings' || $active =='page'|| $active == 'home-page'|| $active == 'about-us'|| $active == 'cookie-policy'|| $active == 'faq'|| $active == 'help'|| $active == 'privacy-policy'|| $active == 'terms-service')? '':'style="display:none;"'; ?>> 

        <li class="<?php echo ($active =='frontend-settings')? 'active':''; ?>"><a href="<?php echo $base_url; ?>admin/frontend-settings" > <span> Header Settings</span></a></li>

        <li class="<?php echo ($active == 'footer-settings')?'active':'';?>"><a href="<?php echo $base_url; ?>admin/footer-settings" > <span>Footer Settings</span></a></li>

        <li class="<?php echo ($active == 'page' || $active == 'home-page'|| $active == 'about-us'|| $active == 'cookie-policy'|| $active == 'faq'|| $active == 'help'|| $active == 'privacy-policy'|| $active == 'terms-service')?'active':'';?>"><a href="<?php echo $base_url; ?>admin/page"> <span>Pages </span></a></li> 

        </ul>
    </li>

                    <?php } ?>


                     

                    </ul>
                </div>
            </div>
        </div>
