 <div class="header">

    <a href="javascript:void(0);" id="toggle_btn">
        <i class="fas fa-bars"></i>
    </a>
            <a id="mobile_btn" class="mobile_btn pull-left" href="#sidebar"><i class="fas fa-bars"></i></a>
            <ul class="nav navbar-nav navbar-right user-menu float-right">
               
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle user-link" data-toggle="dropdown">
                        <span class="user-img">
                          <?php
                           $prof_img = $this->session->userdata('admin_profile_img');
                           $navprofile_img = (!empty($prof_img))?$prof_img:'assets/img/user.jpg';?>
                            <img class="img-circle" src="<?php echo $base_url.$navprofile_img; ?>" width="40" alt="Admin">
                        </span>
                        <span class="user-title">Admin</span>
                        <i class="caret"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo $base_url; ?>admin-profile">Profile</a></li>
                        <li><a href="<?php echo $base_url; ?>admin/logout">Logout</a></li>
                    </ul>
                </li>
            </ul>
            <div class="dropdown mobile-user-menu pull-right">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                <ul class="dropdown-menu pull-right">
                    <li><a href="<?php echo $base_url; ?>admin-profile">Profile</a></li>
                    <li><a href="<?php echo $base_url; ?>logout">Logout</a></li>
                </ul>
            </div>
        </div>
