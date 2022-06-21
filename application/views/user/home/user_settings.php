<header class="s4 dark">
<div class="container fluid">
	<div class="logo">
		<a href="<?php echo base_url();?>" title=""><img src="<?php echo base_url().$this->website_logo_front; ?>" alt="" /></a>
	</div>
	<div class="extras">
		<a href="add-listing.html" title=""><i class="fa fa-plus-circle" aria-hidden="true"></i> Post an add</a>
		<span class="accountbtn"><i class="flaticon-avatar"></i></span>
	</div>
	<nav>
		<ul>
            <li><a href="index.html" title="">Home</a></li>
            <li class="menu-item-has-children">
                <a href="categories.html" title="">Categories</a>
                <ul>
                    <li><a href="#" title="">Featured Categories</a></li>
                    <li><a href="#" title="">Popular Categories</a></li>
                    <li><a href="#" title="">Premium Categories</a></li>
                </ul>
            </li>
            <li class="menu-item-has-children">
                <a href="services.html" title="">Services</a>
                <ul>
                    <li><a href="#" title="">Featured Services</a></li>
                    <li><a href="#" title="">Popular Services</a></li>
                    <li><a href="#" title="">Premium Services</a></li>
                </ul>
            </li>
            <li><a href="find-a-professional.html" title="">Find a Professional</a></li>
        </ul>
	</nav>
</div>
</header>
<section>
	<div class="block remove-bottom double-gap-top position-relative user-banner-blk">
		<div class="layer blackish">
			<div data-velocity="-.1" style="background: url('<?php echo base_url();?>assets/front_end/images/banner.jpg') repeat scroll 50% 422.28px transparent;" class="no-parallax parallax scrolly-invisible user-bg-banner"></div><!-- PARALLAX BACKGROUND IMAGE -->	
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="iamusersec">
							<div class="iamuser">
								<div class="userimg"><img src="<?php echo base_url();?>assets/front_end/images/user.jpg" alt=""></div>
								<div class="userinfos">
									<h3>Ali TUFAN</h3>
									<span>Submission</span>
								</div>
							</div>
								<div class="row">
									<div class="col-sm-10 offset-sm-2">

							<div class="iamuserstats owl-carousel owl-theme">
								<a href="#" title=""><i class="flaticon-credit-card"></i>Dashboard</a>
								<a href="#" title=""><i class="flaticon-note"></i>Notifications (5) </a>
								<a href="#" title=""><i class="flaticon-heart"></i>Favorites (5)</a>
								<a href="#" title=""><i class="flaticon-heart"></i>Bookings (5)</a>
								<a class="active" href="#" title=""><i class="flaticon-avatar"></i>Settings</a>
								<a href="#" title=""><i class="flaticon-thumb-up"></i>Chats</a>
							</div>
									</div>
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section>
   <div class="block gray mt-3">
      <div class="container">
         <div class="row justify-content-center">
            <div class="col-lg-10">
               <div class="dashboradsec">
                  <h3>My Settings</h3>
                  <div class="pbox">
                     <div class="mltabsec tab">
                        <ul class="tabs active">
                           <li class="current"><a href="#" title="">Profile Settings</a></li>
                           <li><a href="#" title="">Security Settings</a></li>
                           <li><a href="#" title="">Social Settings</a></li>
                        </ul>
                        <div id="contents" class="tab_content">
                           <div class="tabs_item" id="ones" style="display: block;">
                              <div class="profileimageaction">
                        <div class="row">
                           <div class="col-lg-5">
                              <div class="changeimg">
                                 <h3>Change Avatar</h3>
                                 <div class="uploadimage">
                                    <img src="<?php echo base_url();?>assets/front_end/images/ca1.jpg" alt="">
                                    <a href="#" title="">Cancel</a>
                                 </div>
                                 <div class="jstinput"><a href="#" title="" class="browsephoto">Browse</a><input type="file"></div>
                                 <p>Max file size is 1MB, Minimum dimension: <br>270x210 And Suitable</p>
                              </div>
                           </div>
                           <div class="col-lg-7">
                              <div class="changeimg">
                                 <h3>Change Background</h3>
                                 <div class="uploadimage">
                                    <img src="<?php echo base_url();?>assets/front_end/images/cc1.jpg" alt="">
                                    <a href="#" title="">Cancel</a>
                                 </div>
                                 <div class="jstinput"><a href="#" title="" class="browsephoto">Browse</a><input type="file"></div>
                                 <p>Max file size is 1MB, Minimum dimension: 1920x400 And Suitable  <br>files are .jpg &amp; .png</p>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="pbox">
                        <div class="addlistingform">
                           <form>
                              <div class="row">
                                 <div class="col-lg-6">
                                    <div class="fieldformy">
                                       <span>First Name</span>
                                       <input type="text">
                                    </div>
                                    <div class="fieldformy">
                                       <span>Nicname</span>
                                       <input type="text">
                                    </div>
                                    <div class="fieldformy">
                                       <span>Address</span>
                                       <input type="text">
                                    </div>
                                    <div class="fieldformy">
                                       <span>Phone</span>
                                       <input type="text">
                                    </div>
                                 </div>
                                 <div class="col-lg-6">
                                    <div class="fieldformy">
                                       <span>Last Name</span>
                                       <input type="text">
                                    </div>
                                    <div class="fieldformy">
                                       <span>Display Name</span>
                                       <input type="text">
                                    </div>
                                    <div class="fieldformy">
                                       <span>Website</span>
                                       <input type="text">
                                    </div>
                                    <div class="fieldformy">
                                       <span>Email </span>
                                       <input type="text">
                                    </div>
                                 </div>
                                 <div class="col-lg-12">
                                    <div class="fieldformy">
                                       <span>Intro your self</span>
                                       <textarea></textarea>
                                    </div>
                                 </div>
                                 <div class="col-lg-12">
                                    <div class="formaction">
                                       <a href="#" title="" class="updatebtn">Update</a>
                                       <a href="#" title="" class="cancelbtn">Cancel</a>
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
                           <div class="tabs_item" id="twos">
                              <div class="pbox">
                        <h3>Change Password</h3>
                        <div class="addlistingform">
                           <form>
                              <div class="row">
                                 <div class="col-lg-12">
                                    <div class="fieldformy">
                                       <span>Current</span>
                                       <input type="text" value="Ali">
                                    </div>
                                    <div class="fieldformy">
                                       <span>New Password</span>
                                       <input type="password">
                                    </div>
                                    <div class="fieldformy">
                                       <span>Confirm New Password</span>
                                       <input type="password">
                                    </div>
                                 </div>
                                 <div class="col-lg-12">
                                    <div class="formaction">
                                       <a href="#" title="" class="updatebtn">Update</a>
                                       <a href="#" title="" class="cancelbtn">Cancel</a>
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                           </div>
                           <div class="tabs_item" id="threes">
                              <div class="pbox">
                        <h3>Social Networks</h3>
                        <div class="addlistingform">
                           <form>
                              <div class="row">
                                 <div class="col-lg-6">
                                    <div class="fieldformy">
                                       <span>Facebook</span>
                                       <input type="text">
                                       <i class="fa fa-facebook"></i>
                                    </div>
                                    <div class="fieldformy">
                                       <span>Twitter</span>
                                       <input type="text">
                                       <i class="fa fa-twitter"></i>
                                    </div>
                                 </div>
                                 <div class="col-lg-6">
                                    <div class="fieldformy">
                                       <span>Linkedin</span>
                                       <input type="text">
                                       <i class="fa fa-linkedin"></i>
                                    </div>
                                    <div class="fieldformy">
                                       <span>Google Plus</span>
                                       <input type="text">
                                       <i class="fa fa-google"></i>
                                    </div>
                                 </div>
                                 <div class="col-lg-12">
                                    <div class="formaction">
                                       <a href="#" title="" class="updatebtn">Update</a>
                                       <a href="#" title="" class="cancelbtn">Cancel</a>
                                    </div>
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
            </div>
         </div>
      </div>
   </div>
</section>