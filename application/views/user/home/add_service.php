	
		<header class="s4 dark">
		<div class="container fluid">
			<div class="logo">
				<a href="<?php echo base_url();?>" title=""><img src="<?php echo base_url().$this->website_logo_front; ?>" alt="" /></a>
			</div>
			<div class="userdropsec">
			    <span><img src="<?php echo base_url();?>assets/front_end/images/ali.jpg" alt="">Ali Tufan <i class="fa fa-bars"></i></span>
			    <div class="userdrop">
			        <div class="userdopinfo">
			            <img src="<?php echo base_url();?>assets/front_end/images/ali.jpg" alt="">
			            <h3>Ali TUFAN</h3>
			            <span>Submission</span>
			        </div>
			        <a href="#" title=""><i class="flaticon-credit-card"></i>Dashboard</a>
			        <a href="#" title=""><i class="flaticon-avatar"></i>Profile</a>
			        <a href="#" title=""><i class="flaticon-coupon"></i>My Listings (1) </a>
			        <a href="#" title=""><i class="flaticon-note"></i>Notifications (0) </a>
			        <a href="#" title=""><i class="flaticon-heart"></i>Favorites (5)</a>
			        <a href="#" title=""><i class="flaticon-thumb-up"></i>Reviews</a>
			    </div>
			</div>
			<div class="extras">
				<a href="add-listing.html" title=""><i class="fa fa-plus-circle" aria-hidden="true"></i> Post an add</a>
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
                                    <span class="badge badge-pill badge-prof">Professional</span>
                                </div>
                            </div>
                                <div class="row">
                                    <div class="col-sm-10 offset-sm-2">

                            <div class="iamuserstats owl-carousel owl-theme">
                                <a class="active" href="#" title=""><i class="flaticon-credit-card"></i>Dashboard</a>
                                <a href="#" title=""><i class="flaticon-note"></i>Notifications (5) </a>
                                <a href="#" title=""><i class="flaticon-heart"></i>Favorites (5)</a>
                                <a href="#" title=""><i class="flaticon-heart"></i>Bookings (5)</a>
                                <a href="#" title=""><i class="flaticon-avatar"></i>Settings</a>
                                <a href="#" title=""><i class="flaticon-thumb-up"></i>Chats</a>
                                <a href="#" title=""><i class="flaticon-thumb-up"></i>Reviews</a>
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
               <!-- PBox -->
               <div class="pbox">
                  <div class="addlistingform">
                     <form>
                        <div class="row">
                           <div class="col-lg-6">
                              <div class="fieldformy">
                                 <span>Listing Title *</span>
                                 <input type="text">
                              </div>
                              <div class="fieldformy">
                                 <span>Listing Categories *</span>
                                 <div class="SumoSelect" tabindex="0" role="button" aria-expanded="true">
                                    <select class="cdropshere SumoUnder" tabindex="-1">
                                       <option value="Enginner">Enginner</option>
                                       <option value="Frachise">Frachise</option>
                                       <option value="Wiring">Wiring</option>
                                       <option value="Technical">Technical</option>
                                    </select>
                                    <p class="CaptionCont SelectBox" title=" Enginner"><span> Enginner</span><label><i></i></label></p>
                                    <div class="optWrapper">
                                       <ul class="options">
                                          <li class="opt selected"><label>Enginner</label></li>
                                          <li class="opt"><label>Frachise</label></li>
                                          <li class="opt"><label>Wiring</label></li>
                                          <li class="opt"><label>Technical</label></li>
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                              <div class="fieldformy">
                                 <span>Listing Location *</span>
                                 <div class="SumoSelect" tabindex="0" role="button" aria-expanded="false">
                                    <select class="cdropshere SumoUnder" tabindex="-1">
                                       <option value="England">England</option>
                                       <option value="Pakistan">Pakistan</option>
                                       <option value="Turkey">Turkey</option>
                                       <option value="Bangladesh">Bangladesh</option>
                                    </select>
                                    <p class="CaptionCont SelectBox" title=" England"><span> England</span><label><i></i></label></p>
                                    <div class="optWrapper">
                                       <ul class="options">
                                          <li class="opt selected"><label>England</label></li>
                                          <li class="opt"><label>Pakistan</label></li>
                                          <li class="opt"><label>Turkey</label></li>
                                          <li class="opt"><label>Bangladesh</label></li>
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                              <div class="fieldformy">
                                 <span>Google Address *</span>
                                 <input placeholder="Listing Address, Eg: Manchester, United Kingdom" type="text">
                              </div>
                              <div class="fieldformy">
                                 <span>Website *</span>
                                 <input placeholder="" type="text">
                              </div>
                              <div class="fieldformy">
                                 <span>Segmentation</span>
                                 <div class="SumoSelect" tabindex="0" role="button" aria-expanded="false">
                                    <select class="cdropshere SumoUnder" tabindex="-1">
                                       <option value="$$$ - Expensive">$$$ - Expensive</option>
                                       <option value="$$ - Medium">$$ - Medium</option>
                                       <option value="$ - Normal">$ - Normal</option>
                                    </select>
                                    <p class="CaptionCont SelectBox" title=" $$$ - Expensive"><span> $$$ - Expensive</span><label><i></i></label></p>
                                    <div class="optWrapper">
                                       <ul class="options">
                                          <li class="opt selected"><label>$$$ - Expensive</label></li>
                                          <li class="opt"><label>$$ - Medium</label></li>
                                          <li class="opt"><label>$ - Normal</label></li>
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                              <div class="fieldformy">
                                 <span>Segmentation</span>
                                 <div class="pf-field">
                                    <ul class="tags">
                                       <li class="addedTag">Web<span onclick="$(this).parent().remove();" class="tagRemove">x</span><input type="hidden" name="tags[]" value="Web Deisgn"></li>
                                       <li class="addedTag">Arts<span onclick="$(this).parent().remove();" class="tagRemove">x</span><input type="hidden" name="tags[]" value="Web Develop"></li>
                                       <li class="addedTag">SEO<span onclick="$(this).parent().remove();" class="tagRemove">x</span><input type="hidden" name="tags[]" value="SEO"></li>
                                       <li class="tagAdd taglist">  
                                          <input type="text" id="search-field">
                                       </li>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class="alform">
                                 <div class="row">
                                    <div class="col-lg-6">
                                       <div class="fieldformy">
                                          <span>Listing Title *</span>
                                          <input type="text">
                                       </div>
                                    </div>
                                    <div class="col-lg-6">
                                       <div class="fieldformy">
                                          <span>Phone</span>
                                          <input type="text">
                                       </div>
                                    </div>
                                    <div class="col-lg-6">
                                       <div class="fieldformy">
                                          <span>Email</span>
                                          <input type="text">
                                       </div>
                                    </div>
                                    <div class="col-lg-6">
                                       <div class="fieldformy">
                                          <span>Minimum Price</span>
                                          <input type="text">
                                       </div>
                                    </div>
                                    <div class="col-lg-6">
                                       <div class="fieldformy">
                                          <span>Maximum Price</span>
                                          <input type="text">
                                       </div>
                                    </div>
                                    <div class="col-lg-6">
                                       <div class="fieldformy">
                                          <span>Your Business video(Optional)</span>
                                          <input type="text">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-12">
                              <p class="c-label">
                                 <input name="cb" id="th1" type="checkbox"><label for="th1">Business Hours</label>
                              </p>
                           </div>
                           <div class="col-lg-12">
                              <div class="tabletime">
                                 <table>
                                    <thead>
                                       <tr>
                                          <td>Day</td>
                                          <td>Start time</td>
                                          <td>End time</td>
                                          <td>Closed</td>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                          <td>Monday</td>
                                          <td>
                                             <div class="tablewaqt">
                                                <input type="text" value="08:00">
                                                <input type="text" value="24:00">
                                                <div class="SumoSelect">
                                                   <select class="cdropshere SumoUnder">
                                                      <option value="AM">AM</option>
                                                      <option value="PM">PM</option>
                                                   </select>
                                                </div>
                                             </div>
                                          </td>
                                          <td>
                                             <div class="tablewaqt">
                                                <input type="text" value="08:00">
                                                <input type="text" value="24:00">
                                                <div class="SumoSelect">
                                                   <select class="cdropshere SumoUnder">
                                                      <option value="AM">AM</option>
                                                      <option value="PM">PM</option>
                                                   </select>
                                                </div>
                                             </div>
                                          </td>
                                          <td>
                                             <p class="c-label">
                                                <input name="cb" id="t1" type="checkbox"><label for="t1"></label>
                                             </p>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>Tuesday</td>
                                          <td>
                                             <div class="tablewaqt">
                                                <input type="text" value="08:00">
                                                <input type="text" value="24:00">
                                                <div class="SumoSelect">
                                                   <select class="cdropshere SumoUnder">
                                                      <option value="AM">AM</option>
                                                      <option value="PM">PM</option>
                                                   </select>
                                                </div>
                                             </div>
                                          </td>
                                          <td>
                                             <div class="tablewaqt">
                                                <input type="text" value="08:00">
                                                <input type="text" value="24:00">
                                                <div class="SumoSelect">
                                                   <select class="cdropshere SumoUnder">
                                                      <option value="AM">AM</option>
                                                      <option value="PM">PM</option>
                                                   </select>
                                                </div>
                                             </div>
                                          </td>
                                          <td>
                                             <p class="c-label">
                                                <input name="cb" id="t2" type="checkbox"><label for="t2"></label>
                                             </p>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>Wednesday</td>
                                          <td>
                                             <div class="tablewaqt">
                                                <input type="text" value="08:00">
                                                <input type="text" value="24:00">
                                                <div class="SumoSelect">
                                                   <select class="cdropshere SumoUnder">
                                                      <option value="AM">AM</option>
                                                      <option value="PM">PM</option>
                                                   </select>
                                                </div>
                                             </div>
                                          </td>
                                          <td>
                                             <div class="tablewaqt">
                                                <input type="text" value="08:00">
                                                <input type="text" value="24:00">
                                                <div class="SumoSelect">
                                                   <select class="cdropshere SumoUnder">
                                                      <option value="AM">AM</option>
                                                      <option value="PM">PM</option>
                                                   </select>
                                                </div>
                                             </div>
                                          </td>
                                          <td>
                                             <p class="c-label">
                                                <input name="cb" id="t3" type="checkbox"><label for="t3"></label>
                                             </p>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>Thursday</td>
                                          <td>
                                             <div class="tablewaqt">
                                                <input type="text" value="08:00">
                                                <input type="text" value="24:00">
                                                <div class="SumoSelect">
                                                   <select class="cdropshere SumoUnder">
                                                      <option value="AM">AM</option>
                                                      <option value="PM">PM</option>
                                                   </select>
                                                </div>
                                             </div>
                                          </td>
                                          <td>
                                             <div class="tablewaqt">
                                                <input type="text" value="08:00">
                                                <input type="text" value="24:00">
                                                <div class="SumoSelect">
                                                   <select class="cdropshere SumoUnder">
                                                      <option value="AM">AM</option>
                                                      <option value="PM">PM</option>
                                                   </select>
                                                </div>
                                             </div>
                                          </td>
                                          <td>
                                             <p class="c-label">
                                                <input name="cb" id="t4" type="checkbox"><label for="t4"></label>
                                             </p>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>Friday</td>
                                          <td>
                                             <div class="tablewaqt">
                                                <input type="text" value="08:00">
                                                <input type="text" value="24:00">
                                                <div class="SumoSelect">
                                                   <select class="cdropshere SumoUnder">
                                                      <option value="AM">AM</option>
                                                      <option value="PM">PM</option>
                                                   </select>
                                                </div>
                                             </div>
                                          </td>
                                          <td>
                                             <div class="tablewaqt">
                                                <input type="text" value="08:00">
                                                <input type="text" value="24:00">
                                                <div class="SumoSelect">
                                                   <select class="cdropshere SumoUnder">
                                                      <option value="AM">AM</option>
                                                      <option value="PM">PM</option>
                                                   </select>
                                                </div>
                                             </div>
                                          </td>
                                          <td>
                                             <p class="c-label">
                                                <input name="cb" id="t5" type="checkbox"><label for="t5"></label>
                                             </p>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>Saturday</td>
                                          <td>
                                             <div class="tablewaqt">
                                                <input type="text" value="08:00">
                                                <input type="text" value="24:00">
                                                <div class="SumoSelect">
                                                   <select class="cdropshere SumoUnder">
                                                      <option value="AM">AM</option>
                                                      <option value="PM">PM</option>
                                                   </select>
                                                </div>
                                             </div>
                                          </td>
                                          <td>
                                             <div class="tablewaqt">
                                                <input type="text" value="08:00">
                                                <input type="text" value="24:00">
                                                <div class="SumoSelect">
                                                   <select class="cdropshere SumoUnder">
                                                      <option value="AM">AM</option>
                                                      <option value="PM">PM</option>
                                                   </select>
                                                </div>
                                             </div>
                                          </td>
                                          <td>
                                             <p class="c-label">
                                                <input name="cb" id="t6" type="checkbox"><label for="t6"></label>
                                             </p>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>Sunday</td>
                                          <td>
                                             <div class="tablewaqt">
                                                <input type="text" value="08:00">
                                                <input type="text" value="24:00">
                                                <div class="SumoSelect">
                                                   <select class="cdropshere SumoUnder">
                                                      <option value="AM">AM</option>
                                                      <option value="PM">PM</option>
                                                   </select>
                                                </div>
                                             </div>
                                          </td>
                                          <td>
                                             <div class="tablewaqt">
                                                <input type="text" value="08:00">
                                                <input type="text" value="24:00">
                                                <div class="SumoSelect">
                                                   <select class="cdropshere SumoUnder">
                                                      <option value="AM">AM</option>
                                                      <option value="PM">PM</option>
                                                   </select>
                                                </div>
                                             </div>
                                          </td>
                                          <td>
                                             <p class="c-label">
                                                <input name="cb" id="t7" type="checkbox"><label for="t7"></label>
                                             </p>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                           <div class="col-lg-12">
                              <a title="" class="uploadfile">
                              <img src="<?php echo base_url();?>assets/front_end/images/cloud.png" alt="">
                              <span>Upload Featured images</span>
                              <input type="file">
                              </a>
                              <div class="fieldformy">
                                 <span>Listing Content *</span>
                                 <textarea></textarea>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
               <div class="pbox border">
                  <h3>Gallery</h3>
                  <div class="slistinggallery">
                     <div class="sgallery">
                        <a title="" class="uploadgallery">
                        <img src="images/cloud.png" alt="">
                        <span>Listing Gallery</span>
                        <input type="file">
                        </a>
                     </div>
                     <div class="sgallery">
                        <div class="sgallerybox"><img src="<?php echo base_url();?>assets/front_end/images/sg1.jpg" alt=""><i class="delgallery">x</i></div>
                     </div>
                     <div class="sgallery">
                        <div class="sgallerybox"><img src="<?php echo base_url();?>assets/front_end/images/sg2.jpg" alt=""><i class="delgallery">x</i></div>
                     </div>
                     <div class="sgallery">
                        <div class="sgallerybox"><img src="<?php echo base_url();?>assets/front_end/images/sg3.jpg" alt=""><i class="delgallery">x</i></div>
                     </div>
                  </div>
               </div>
               <!-- PBox -->
               <div class="pbox border">
                  <h3>Social Networks</h3>
                  <div class="socialnetworks">
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
                        </div>
                     </form>
                  </div>
               </div>
               <!-- PBox -->
            </div>
         </div>
      </div>
   </div>
</section>