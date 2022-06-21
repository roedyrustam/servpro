<?php

    $page = $this->uri->segment(1);
 ?>
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="<?php echo ($page == 'dashboard')?'active':'';?>">
                    <a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a>
                </li>
                <li class="<?php echo ($page == 'subscriptions')?'active':''; echo ($page == 'add-subscription')?'active':''; echo ($page == 'edit-subscription')?'active':'';?>"  >
                    <a href="<?php echo $base_url; ?>subscriptions"><i class="fa fa-money"></i> Subscriptions</a>
                </li> 
                <li class="<?php echo ($page == 'service-providers')?'active':'';?>" >
                    <a href="<?php echo $base_url; ?>service-providers"><i class="fa fa-address-card-o"></i> Service Providers</a>
                </li>
                <li class="<?php echo ($page == 'service-requests')?'active':'';?>" >
                    <a href="<?php echo $base_url; ?>service-requests"><i class="fa fa-newspaper-o"></i> Service Requests</a>
                </li>
                <li class="<?php echo ($page == 'language')?'active':'';?>" >
                    <a href="<?php echo $base_url; ?>language/pages"><i class="fa fa-language"></i> Language Settings</a>
                </li>
                <li class="<?php echo ($page == 'colour_settings')?'active':'';?>" >
                    <a href="<?php echo $base_url; ?>dashboard/colour_settings"><i class="fa fa-wrench"></i> Colour Settings</a>
                </li>
            </ul>
        </div>
    </div>
</div>
