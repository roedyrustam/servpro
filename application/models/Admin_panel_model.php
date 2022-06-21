<?php
class admin_panel_model extends CI_Model
{
	Public function get_updates()
    {

       $ch = curl_init();
        $options = array(
            CURLOPT_URL => 'https://www.dreamguys.co.in/gigs_updates/',
            CURLOPT_RETURNTRANSFER => true
            );

       if (!ini_get('safe_mode') && !ini_get('open_basedir')) {
            $options[CURLOPT_FOLLOWLOCATION] = true;
        }
        curl_setopt_array($ch, $options);
       $output = curl_exec($ch);
        curl_close($ch);

       $updates = json_decode($output, TRUE);

       $where = array('build' => $updates['build'] );
        $check_updates =  $this->db->get_where('version_updates',$where)->num_rows();
        if($check_updates!=0){
           $this->session->set_userdata(array('updates'=>1));
        }


   }
	public function edit_profession($id)
	{
		$query = $this->db->query(" SELECT * FROM `profession` WHERE `id` = $id ");
		$result = $query->row_array();
		return $result;
	}
		public function terms()
	{
		$query = $this->db->query(" SELECT * FROM `terms` WHERE `status` = 1");
		$result = $query->row_array();
		return $result;
	}
			public function get_terms()
	{
		$query = $this->db->query("SELECT * FROM `term` WHERE 1");
		$result = $query->result_array();
        return $result;
	}

    public function all_admin_list()
    {
        $query = $this->db->query("SELECT * FROM `administrators` WHERE 1");
        $result = $query->result_array();
        return $result;
    }

	public function footercount()
	{
		$query = $this->db->query("SELECT id
FROM  `footer_menu`
WHERE STATUS =1");
		$result = $query->num_rows();
		return $result;
	}
		     public function catagorycheck($category_name,$catagory_id)
    {
		$join='';
		if($catagory_id!=''){
			$join="AND CATID != '".$catagory_id."'";
		}
        $query = $this->db->query("SELECT * FROM `categories` WHERE `name` ='".$category_name."' ".$join);

        $result = $query->num_rows();
        return $result;
    }
     public function country_check($country_name,$id=NULL)
    {
        $join='';
        if($id!=''){
            $join="AND id != '".$id."'";
        }
        $query = $this->db->query("SELECT * FROM `currency` WHERE `currency_name` ='".$country_name."' ".$join);

        $result = $query->num_rows();
        return $result;
    }
		public function admin_commision()
	{
		$query = $this->db->query(" SELECT `value` FROM `system_settings` WHERE `key` = 'admin_commision' ");
		$result = $query->row_array();
		return $result;
	}
		public function delete_seo_setting($seo_id)
	{
		$query = $this->db->query("DELETE FROM seo_details WHERE id	='".$seo_id."'");
		$result = 1;
		return $result;
	}
	public function gig_price()
	{
		$query = $this->db->query("SELECT `value` FROM `system_settings` WHERE `key` = 'gig_price' ");
		$result = $query->row_array();
		return $result;
	}

	public function get_rupee_dollar_rate()
	{
		$query = $this->db->query(" SELECT * FROM `currency` ORDER BY `created_date` DESC LIMIT 0 , 1  ;");
        $result = $query->row_array();
        return $result;
	}

	public function all_profession($start,$end)
	{
		$query = $this->db->query(" SELECT * FROM  `profession` LIMIT $start , $end ");
		$result = $query->result_array();
		return $result;
	}

	 public function all_gigs($return_type,$start,$end)
    {
        $append_sql = "";
         if($start>0||$end>0)
         {
     	 $append_sql = " LIMIT $start , $end"; }
        $query= $this->db->query("SELECT sell_gigs.id as gig_id , ( SELECT gigs_image.`gig_image_thumb` FROM `gigs_image`
		 WHERE gigs_image.gig_id = sell_gigs.id   LIMIT 0 , 1  ) AS gig_image ,  sell_gigs.`title`,  sell_gigs.`currency_type` , members.fullname , members.username , categories.name as         category_name , sell_gigs.`gig_price` , sell_gigs.`status`, sell_gigs.`created_date`  FROM `sell_gigs`
    	INNER JOIN members ON members.USERID = sell_gigs.user_id
		INNER JOIN categories ON categories.CATID = sell_gigs.category_id ORDER BY sell_gigs.`created_date` DESC ".$append_sql." ");
        if($return_type==0)
        { $result = $query->num_rows(); }
        else { $result = $query->result_array();


		}
        return $result;

    }

     public function all_currency($return_type,$start,$end)
    {
        $append_sql = "";
         if($start>0||$end>0)
         {
         $append_sql = " LIMIT $start , $end"; }
        $query= $this->db->query("SELECT *  FROM `currency`
        ORDER BY currency.`id` asc ".$append_sql." ");
        if($return_type==0)
        { $result = $query->num_rows(); }
        else { $result = $query->result_array();


        }
        return $result;

    }

	public function release_payments($return_type,$start,$end)
	{
        $append_sql = "";
	if($return_type==1)
        {
         if($start>0||$end>0)
         { $append_sql = " LIMIT $start , $end"; }
		}
		$query =$this->db->query("SELECT a.*, s.fullname as buyer_name,va.paypal_email_id as buyer_paybalemail,s.email as buyer_email,sg.title,sm.email as selleremail, sm.fullname as seller_name ,ba.paypal_email_id FROM  `payments`as a
                            LEFT JOIN bank_account as ba ON ba.user_id = a.USERID
                            LEFT JOIN sell_gigs as sg ON sg.id = a.gigs_id
                            LEFT JOIN members as s ON s.USERID = a.USERID
                            LEFT JOIN members as sm ON sm.USERID = a.seller_id
							 LEFT JOIN bank_account as va ON va.user_id = a.seller_id
							WHERE  (a.payment_status = 1 OR a.cancel_accept = 1 OR a.decline_accept = 1 OR a.seller_status= 9) AND a.payment_status != 2 ".$append_sql."");
	
		 if($return_type==0)
        {
		$result = $query->num_rows(); }
        else {
		$result = $query->result_array();
		}
		return $result;
	}
		public function Completed_payments($return_type,$start,$end)
	{
        $append_sql = "";
		if($return_type==1)
        {
			if($start>0||$end>0)
			 { $append_sql = " LIMIT $start , $end"; }
		}
		 $query = $this->db->query(" SELECT a . * , s.fullname AS buyer_name, sm.fullname AS seller_name, s.email AS buyeremil
										FROM  `payments` AS a
										LEFT JOIN members AS s ON s.USERID = a.USERID
										LEFT JOIN members AS sm ON sm.USERID = a.seller_id
										WHERE a.payment_status = 2 ORDER BY a.`created_at` DESC ".$append_sql." ");

		 if($return_type==0)
        {
		$result = $query->num_rows(); }
        else {
		$result = $query->result_array(); }
        return $result;
	}
	public function copy_right_year()
	{
		$query = $this->db->query("SELECT `value` FROM `system_settings` WHERE `key` = 'copy_rit_year';");
		$result = $query->row_array();
		return $result;

	}

	public function total_gigs()
	{
	    return $this->db->get('sell_gigs')->num_rows();

	}

    public function total_user()
    {
        return $this->db->get('members')->num_rows();

    }

     public function total_orders()
    {
        return $this->db->get('payments')->num_rows();

    }

     public function completed_orders()
    {
        return $this->db->where('seller_status',6)->get('payments')->num_rows();

    }

	public function dashboard_recent_gigs()
	{
        $query = $this->db->query("	SELECT gigs_image.`gig_image_thumb` , payments.paypal_uid, payments.item_amount,payments.currency_type, payments.created_at
									FROM  `gigs_image`
									INNER JOIN payments ON payments.gigs_id = gigs_image.`gig_id`
                                    GROUP BY  payments.id
									ORDER BY payments.created_at DESC
									LIMIT 0 , 6 ");
        $result = $query->result_array();
        return $result;
	}

	public function dashboard_popular_gigs()
	{
        $query = $this->db->query(" SELECT sell_gigs.`title`,sell_gigs.`gig_price`,sell_gigs.currency_type,sell_gigs.`created_date`,sell_gigs.`total_views`,(SELECT gig_image_thumb FROM `gigs_image` WHERE `gig_id` = sell_gigs.id LIMIT 0 , 1 ) AS gig_image FROM `sell_gigs` ORDER BY `total_views` DESC  LIMIT 0 , 6  ");
        $result = $query->result_array();
        return $result;
	}


    public function get_policy_settings($start,$end)
    {
        $query = $this->db->query("SELECT * FROM  `policy_settings` LIMIT $start , $end  ");
        $result = $query->result_array();
        return $result;
    }

    public function get_seo_settings($start,$end)
    {
        $query = $this->db->query("SELECT * FROM `seo_details` LIMIT $start , $end  ");
        $result = $query->result_array();
        return $result;
    }
     public function edit_adminlist_details($id)
    {
        $query = $this->db->query("SELECT * FROM `administrators` WHERE ADMINID = $id");
        $result = $query->row_array();
        return $result;
    }
    public function edit_seo_settings($id)
    {
        $query = $this->db->query("SELECT * FROM `seo_details` WHERE id = $id");
        $result = $query->row_array();
        return $result;
    }
	    public function edit_paypal_settings($id)
    {
        $query = $this->db->query("SELECT * FROM `paypal_details` WHERE id = $id");
        $result = $query->row_array();
        return $result;
    }

      public function edit_paytabs_settings($id)
    {
        $query = $this->db->query("SELECT * FROM `paytabs_details` WHERE id = $id");
        $result = $query->row_array();
        return $result;
    }

    public function edit_razorpay_settings($id)
    {
        $query = $this->db->query("SELECT * FROM `razorpay_gateway` WHERE id = $id");
        $result = $query->row_array();
        return $result;
    }


    public function edit_policy_settings($id)
    {
        $query = $this->db->query("SELECT * FROM  `policy_settings` WHERE `id` = $id ");
        $result = $query->row_array();
        return $result;
    }

    public function edit_client_list($client_id)
    {
        $query = $this->db->query("SELECT * FROM `client` WHERE `id` = '".$client_id."' ; ");
        $result = $query->row_array();
        return $result;
    }
    public function all_category()
    {
        $query = $this->db->query("SELECT c.*,(c2.`CATID`) as parent_id,(c2.name) as parent_name FROM categories c
LEFT join `categories` as c2 ON c2.CATID = c.parent where c.delete_sts =0 ");
        $result = $query->result_array();
        return $result;
    }
    public function categories()
    {
        $query = $this->db->query(" SELECT * FROM `categories` WHERE `status` = 0 ");
        $result = $query->result_array();
        return $result;
    }
    public function edit_category($category_id)
    {
        $query = $this->db->query("SELECT * FROM `categories` WHERE `CATID` = '".$category_id."' ; ");
        $result = $query->row_array();
        return $result;
    }
    public function parent_category()
    {
        $query = $this->db->query("SELECT * FROM `categories` WHERE `parent` = 0 AND `status` = 0 ");
        $result = $query->result_array();
        return $result;
    }
    public function default_extra_gigs()
    {
        $query = $this->db->query("SELECT * FROM `default_extra_gigs` ");
        $result = $query->result_array();
        return $result;
    }
    public function all_sub_category()
    {
        $query = $this->db->query("SELECT * FROM `categories` WHERE `status` = 0");
        $result = $query->result_array();
        return $result;
    }
    public function edit_gigs($gig_id)
    {
        $query = $this->db->query("SELECT * FROM `default_extra_gigs` WHERE `default_gig_id` = '".$gig_id."' ");
        $result = $query->row_array();
        return $result;
    }
     public function edit_currency($gig_id)
    {
        $query = $this->db->query("SELECT * FROM `currency` WHERE `id` = '".$gig_id."' ");
        $result = $query->row_array();
        return $result;
    }
    public function get_meta_settings()
    {
        $query = $this->db->query("SELECT * FROM `meta_settings`");
        $result = $query->row_array();
        return $result;
    }
    public function get_setting_list() {
        $data = array();
        $stmt = "SELECT a.*"
                . " FROM system_settings AS a"
                . " ORDER BY a.`id` ASC";
        $query = $this->db->query($stmt);
        if ($query->num_rows()) {
            $data = $query->result_array();
        }
        return $data;
    }
    public function get_theme_setting_list() {
        $data = array();
        $stmt = "SELECT a.*"
                . " FROM theme_settings AS a"
                . " ORDER BY a.`id` ASC";
        $query = $this->db->query($stmt);
        if ($query->num_rows()) {
            $data = $query->result_array();
        }
        return $data;
    }
    public function get_static_page($end,$start)
    {
        $query = $this->db->query("SELECT * FROM  `page` LIMIT $start , $end");
        $result = $query->result_array();
        return $result;
    }
    public function edit_static_page($id)
    {
        $query = $this->db->query("SELECT * FROM  `page` WHERE page_id = $id ");
        $result = $query->result_array();
        return $result;
    }
    public function site_name()
    {
        $query = $this->db->query("SELECT `value` FROM `system_settings` WHERE `key` = 'website_name';");
        $result = $query->row_array();
        return $result;
    }
    public function get_ban_ip()
    {
        $query = $this->db->query("SELECT * FROM `bans_ips`;");
        $result = $query->result_array();
        return $result;
    }
    public function check_ip($ip_address)
    {
        $query = $this->db->query("SELECT * FROM `bans_ips` WHERE `ip_addr` = '$ip_address';");
        $result = $query->num_rows();
        return $result;
    }
     public function is_valid_menu_name($menu_name)
    {
        $query = $this->db->query("SELECT * FROM `footer_menu` WHERE `title` =  '$menu_name';");
        $result = $query->num_rows();
        return $result;
    }
	     public function check_profession($Profession)
    {
        $query = $this->db->query("SELECT * FROM `profession` WHERE `profession_name` =  '$Profession';");
        $result = $query->num_rows();
        return $result;
    }
    public function is_valid_submenu($menu_name)
    {
        $query = $this->db->query("SELECT * FROM `footer_submenu` WHERE `title` =  '$menu_name';");
        $result = $query->num_rows();
        return $result;
    }
    public function edit_footer_menu($id)
    {
        $query = $this->db->query("SELECT * FROM `footer_menu` WHERE `id` =  $id;");
        $result = $query->result_array();
        return $result;
    }
    public function edit_ip($ip_address)
    {
        $query = $this->db->query("SELECT * FROM `bans_ips` WHERE `id` = '$ip_address';");
        $result = $query->row_array();
        return $result;
    }
    public function get_all_request()
    {
        $query = $this->db->query("
            SELECT req.*,members.fullname,(categories.name) AS main_category,sub_cat.name as sub_category FROM `request` as req
	    LEFT JOIN members ON members.USERID = req.posted_by
            LEFT JOIN categories ON categories.CATID = req.`main_cat`
            LEFT JOIN categories as sub_cat ON sub_cat.CATID = req.`sub_cat`;");
        $result = $query->result_array();
        return $result;
    }
    public function edit_request($id)
    {
        $query = $this->db->query("SELECT * FROM `request` WHERE `id` = $id ;");
        $result = $query->row_array();
        return $result;
    }
    public function get_user()
    {
        $query = $this->db->query("SELECT `USERID`,`email`,`username`,`fullname`,`verified`,`status` FROM `members`  ;");
        $result = $query->result_array();
        return $result;
    }
    public function edit_user($id)
    {
        $query = $this->db->query("SELECT `USERID`,`email`,`username`,`fullname`,`verified`,`status` FROM `members`  WHERE `USERID` = $id ;");
        $result = $query->row_array();
        return $result;
    }
    public function get_ads($start,$end)
    {
        if(empty($start)&&empty($end))
        {
        $query = $this->db->query("SELECT * FROM `ads` ;");
        $result = $query->result_array();
        return $result;
        }
        else
        {
        $query = $this->db->query("SELECT * FROM `ads` LIMIT $start , $end ;");
        $result = $query->result_array();
        return $result;
        }
    }
    public function edit_ads($id)
    {
        $query = $this->db->query("SELECT * FROM `ads` WHERE `ads_id` = $id ");
        $result = $query->row_array();
        return $result;
    }
    public function get_review($start,$end)
    {
		$last_append = '';
        if($start||$end!=0)
        {
        $last_append = " LIMIT $start , $end";
        }
        /*$query = $this->db->query("SELECT gigs_reviews.review_id,gigs_reviews.`review`,members.fullname,gigs.gig_title,gigs_reviews.`created_date`,gigs_reviews.`status` FROM `gigs_reviews`
                                    INNER JOIN members ON members.USERID = gigs_reviews.`user_id`
                                    INNER JOIN gigs ON gigs.id = gigs_reviews.`gig_id`");*/
		$query = $this->db->query("SELECT  feedback.*,members.fullname,sell_gigs.title FROM `feedback`
                                    INNER JOIN members ON members.USERID = feedback.`from_user_id`
                                    INNER JOIN sell_gigs ON sell_gigs.id = feedback.`gig_id`
									ORDER BY feedback.id DESC ".$last_append." ");
        $result = $query->result_array();
        return $result;
    }
    public function edit_review($id)
    {
        $query = $this->db->query("SELECT gigs_reviews.review_id,gigs_reviews.`review`,members.fullname,gigs.gig_title,gigs_reviews.`created_date`,gigs_reviews.`status` FROM `gigs_reviews`
                                    INNER JOIN members ON members.USERID = gigs_reviews.`user_id`
                                    INNER JOIN gigs ON gigs.id = gigs_reviews.`gig_id`
                                    WHERE gigs_reviews.`review_id` = $id ");
        $result = $query->row_array();
        return $result;
    }
    public function get_admin_profile($id)
    {
        $query = $this->db->query("SELECT * FROM `administrators` WHERE `ADMINID` = $id");
        $result = $query->row_array();
        return $result;
    }
    public function get_client_list()
    {
        $query = $this->db->query("SELECT * FROM  `client` ");
        $result = $query->result_array();
        return $result;
    }
    public function get_footer_menu($end , $start)
    {
        $query = $this->db->query("SELECT * FROM  `footer_menu` LIMIT $start , $end ");
        $result = $query->result_array();
        return $result;
    }
    public function get_footer_submenu($end , $start)
    {
        $query = $this->db->query("SELECT footer_submenu.*,footer_menu.title FROM `footer_submenu`
                                    INNER JOIN footer_menu ON footer_menu.id = footer_submenu.`footer_menu`
                                    LIMIT $start , $end ");
        $result = $query->result_array();
        return $result;
    }
    public function get_all_footer_menu()
    {
        $query  = $this->db->query("SELECT * FROM  `footer_menu` ");
        $result = $query->result_array();
        return $result;
    }
    public function update_data($table, $data, $where = []) {
        if (count($where) > 0) {
            $this->db->where($where);
            $status = $this->db->update($table, $data);
            return $status;
        } else {
            $this->db->insert($table, $data);
            return $this->db->insert_id();
        }
    }
    public function get_all_footer_submenu()
    {
        $query = $this->db->query("SELECT footer_submenu.*,footer_menu.title FROM `footer_submenu`
                                    INNER JOIN footer_menu ON footer_menu.id = footer_submenu.`footer_menu` ");
        $result = $query->num_rows();
        return $result;
    }
	    public function edit_terms($id)
    {
        $query = $this->db->query("SELECT *
                                    FROM  term
                                    WHERE id= $id ");
            $result = $query->result_array();
        return $result;
    }
    public function edit_submenu($id)
    {
        $query = $this->db->query("SELECT footer_submenu . * , footer_menu.title
                                    FROM  `footer_submenu`
                                    INNER JOIN footer_menu ON footer_menu.id = footer_submenu.`footer_menu`
                                    WHERE footer_submenu.id = $id ");
            $result = $query->result_array();
        return $result;
    }

	 public function new_notification()
	{
		$query = $this->db->query("SELECT * FROM
			(SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'buyed' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments`
			INNER JOIN members ON payments.`USERID` =  `members`.`USERID`
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 1
			AND payments.admin_notification_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'completed' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments`
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID`
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.admin_notification_status =1
			UNION
			SELECT sell_gigs.id, `members`.`fullname` AS buyer_name, sell_gigs.created_date AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'new_gig' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id = sell_gigs.id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `sell_gigs`
			INNER JOIN members ON sell_gigs.`user_id` =  `members`.`USERID`
			WHERE sell_gigs.notification_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_request' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments`
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID`
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.payment_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_decline' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments`
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID`
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 5 AND payments.decline_accept =1 AND payment_status!=2
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_cancel' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments`
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID`
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.cancel_accept =1 AND payment_status!=2

            UNION
            SELECT buyer_rejected_list.id, `members`.`fullname` AS buyer_name, buyer_rejected_list.created_time AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'buyer_reject_complete_accept' as status
            , (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  buyer_rejected_list.gig_id LIMIT 0 , 1 ) AS gig_image_thumb
            FROM  `buyer_rejected_list`
            INNER JOIN members ON buyer_rejected_list.`seller_id` =  `members`.`USERID`
            INNER JOIN sell_gigs ON buyer_rejected_list.`gig_id` = sell_gigs.id
            WHERE buyer_rejected_list.status =0 AND buyer_rejected_list.rejected_request=0 AND buyer_rejected_list.notification_seen=0

			) a ORDER BY a.created_date DESC ");
		$result = $query->result_array();
		return $result;


	}
	 public function get_allpayment_list($start,$end)
    {
		$last_append = '';
        if($start||$end!=0)
        {
        $last_append = " LIMIT $start , $end";
        }
        $query = $this->db->query("SELECT a.*,a.id as newid,g.*,gi.*, s.fullname as buyer_name,s.user_thumb_image as buyerimage, s.description ,s.user_profile_image as sellerimage, sm.fullname as seller_name ,sm.user_thumb_image,ba.paypal_email_id
                                    FROM  `payments`as a
                                    LEFT JOIN bank_account as ba ON ba.user_id = a.seller_id
									LEFT JOIN members as s ON s.USERID = a.USERID
									LEFT JOIN sell_gigs as g ON g.user_id =a.seller_id
									LEFT JOIN gigs_image as gi ON gi.gig_id =g.id
									LEFT JOIN members as sm ON sm.USERID = a.seller_id group by a.id ".$last_append." ");
            $result = $query->result_array();
        return $result;
    }
	public function get_completepayment_list($type, $start, $end)
    {
		$last_append = '';
        if($type==1)
        {
        $last_append = "LIMIT $start , $end";
        }
        $query = $this->db->query("SELECT a.*, s.fullname as buyer_name, sm.fullname as seller_name ,ba.paypal_email_id
                                    FROM  `payments`as a
                                    LEFT JOIN bank_account as ba ON ba.user_id = a.seller_id
                                    LEFT JOIN members as s ON s.USERID = a.USERID
                                    LEFT JOIN members as sm ON sm.USERID = a.seller_id
                                    WHERE a.seller_status = 6 ".$last_append."" );


              // SELECT a.*, s.fullname as buyer_name, sm.fullname as seller_name ,ba.paypal_email_id
              //                       FROM  `payments`as a
              //                       LEFT JOIN bank_account as ba ON ba.user_id = a.seller_id
              //                       LEFT JOIN members as s ON s.USERID = a.USERID
              //                       LEFT JOIN members as sm ON sm.USERID = a.seller_id
              //                       WHERE a.seller_status=6 ".$last_append."

            if($type==0){
			 $result = $query->num_rows();
			}else {

				$result = $query->result_array();
			}


        return $result;
    }
	public function get_declinepayment_list($type, $start, $end)
    {
		$last_append = '';
        if($type==1)
        {
        $last_append = " LIMIT $start , $end";
        }
        $query = $this->db->query("SELECT a.*, s.fullname as buyer_name, sm.fullname as seller_name ,ba.paypal_email_id
                                    FROM  `payments`as a
                                    LEFT JOIN bank_account as ba ON ba.user_id = a.USERID
									LEFT JOIN members as s ON s.USERID = a.USERID
									LEFT JOIN members as sm ON sm.USERID = a.seller_id
									WHERE a.seller_status=5 ".$last_append." ");

            if($type==0){
			 $result = $query->num_rows();
			}else {
				$result = $query->result_array();
			}
        return $result;
    }
	public function get_Pendingpayment_list($type, $start, $end)
    {
		$last_append = '';
        if($type==1)
        {
        $last_append = " LIMIT $start , $end";
        }
        $query = $this->db->query("SELECT a.*, s.fullname as buyer_name, sm.fullname as seller_name ,ba.paypal_email_id
                                    FROM  `payments`as a
                                    LEFT JOIN bank_account as ba ON ba.user_id = a.seller_id
									LEFT JOIN members as s ON s.USERID = a.USERID
									LEFT JOIN members as sm ON sm.USERID = a.seller_id
									WHERE (a.seller_status=2 OR a.seller_status=3) ".$last_append." ");

			if($type==0){
			 $result = $query->num_rows();
			}else {
				$result = $query->result_array();
			}
        return $result;
    }


    public function get_rejected_list()

    {

        /*$query = $this->db->query("SELECT br.*,m.username as seller_name,m1.username as buyer_name,p.seller_status,p.payment_status,sg.title FROM buyer_rejected_list br LEFT JOIN members m on m.USERID = br.seller_id LEFT JOIN members m1 on m1.USERID = br.buyer_id LEFT JOIN payments p on p.seller_status = m.USERID LEFT JOIN sell_gigs sg on sg.user_id = br.seller_id");*/


        $query = $this->db->query("SELECT BRL.*,M.fullname as buyername ,M1.fullname as sellername,SG.title as gig_name,p.id as                        seller_order FROM buyer_rejected_list BRL
                                    LEFT JOIN sell_gigs SG ON SG.id= BRL.gig_id
                                    LEFT JOIN members M ON M.USERID= BRL.buyer_id
                                    LEFT JOIN payments p on p.id = BRL.order_id
                                    LEFT JOIN members M1 ON M1.USERID= BRL.seller_id ORDER by id desc");

        $result = $query->result_array();

        return $result;

    }

    public function reject_accept($change_reject_status,$id,$order_id,$current_time)
    {
        $query = $this->db->query("UPDATE buyer_rejected_list SET status = '".$change_reject_status."',created_time='".$current_time."',rejected_request = 1 WHERE id = '".$id."'");

        $query = $this->db->query("UPDATE payments SET seller_status = 3 WHERE id = '".$order_id."'");


        return $query;
    }


    public function cancel_request($list_id)
    {


            $request = $this->db->query("SELECT b.*,m.username as seller_name,m.email as seller_email, a.name as admin_name,a.email as                                  admin_email,m1.username as buyer_name,s.title from buyer_rejected_list b
                                LEFT JOIN members m on m.USERID = b.seller_id
                                LEFT JOIN members m1 on m1.USERID = b.buyer_id
                                LEFT JOIN sell_gigs s on s.user_id = b.seller_id
                                LEFT JOIN administrators a on a.ADMINID = 2
                                WHERE b.id = $list_id");




        $result = $request->row_array();


        return $result;
    }


	public function get_cancelpayment_list($type, $start, $end)
    {
		$last_append = '';
        if($type==1)
        {
        $last_append = " LIMIT $start , $end";
        }
        $query = $this->db->query("SELECT a.*,s.email as buyer_email, s.fullname as buyer_name, sm.fullname as seller_name ,ba.paypal_email_id
                                    FROM  `payments`as a
                                    LEFT JOIN bank_account as ba ON ba.user_id = a.USERID
									LEFT JOIN members as s ON s.USERID = a.USERID
									LEFT JOIN members as sm ON sm.USERID = a.seller_id
									WHERE a.buyer_status=1 ".$last_append." ");

		if($type==0){
			 $result = $query->num_rows();
		}else {
			$result = $query->result_array();
		}
        return $result;
    }
      // All Payment Details (Incoming withdrawl , cancel , decline )
     public function get_all_list($type, $start, $end)
    {
        $last_append = '';
        if($type==1)
        {
        }
				$query_string ="SELECT a.*, s.fullname as buyer_name,va.paypal_email_id as buyer_paybalemail,s.email as buyer_email,sg.title,sm.email as selleremail, sm.fullname as seller_name ,ba.paypal_email_id FROM  `payments`as a
                            LEFT JOIN bank_account as ba ON ba.user_id = a.USERID
                            LEFT JOIN sell_gigs as sg ON sg.id = a.gigs_id
                            LEFT JOIN members as s ON s.USERID = a.USERID
                            LEFT JOIN members as sm ON sm.USERID = a.seller_id
							 LEFT JOIN bank_account as va ON va.user_id = a.seller_id
							WHERE  (a.payment_status = 1 OR a.cancel_accept = 1 OR a.decline_accept = 1) AND a.payment_status != 2 ".$last_append."";
			$query = $this->db->query($query_string);
			// Where condition apply need request payment and cancel or decline
				//WHERE  (a.buyer_status=1 OR a.seller_status=5) AND a.payment_status != 2
				//WHERE  a.payment_status = 2 OR a.buyer_status=1 OR a.seller_status=5
				//WHERE (a.payment_status != 2 AND a.buyer_status=1) OR (a.payment_status != 2 AND a.seller_status=5) ".$last_append."
				//WHERE (a.payment_status != 2 AND a.buyer_status=1) OR (a.payment_status != 2 AND (a.seller_status=5 OR a.seller_status=6))

        if($type==0){
             $result = $query->num_rows();
        }else {
            $result = $query->result_array();
        }

        return $result;
    }
  

     public function edit_payment_gateway($id)
    {
        $query = $this->db->query(" SELECT * FROM `payment_gateways` WHERE `id` = $id ");
        $result = $query->row_array();
        return $result;
    }

     public function all_payment_gateway()
    {
      $this->db->select('*');
        $this->db->from('payment_gateways');
        //$this->db->where('Id',$id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function gig_preview($id){

        $query = $this->db->query("SELECT * FROM  sell_gigs WHERE  md5(id) = '".$id."'");

        if($query->num_rows() > 0){
            $data = $query->row_array();
            $gig_id = $data['id'];
            $data['extra_gigs'] = array();
            $data['gig_images'] = array();

            $query1 = $this->db->query("SELECT * FROM  extra_gigs WHERE   gigs_id = $gig_id");
            if($query1->num_rows() > 0){
               $extra_gig = $query1->result_array();
               $data['extra_gigs'] = $extra_gig;
            }
            $query2 = $this->db->query("SELECT * FROM gigs_image WHERE   gig_id = $gig_id");
            if($query2->num_rows() > 0){
               $gig_images = $query2->result_array();
               $data['gig_images'] = $gig_images;
            }
            return $data;
        }else{
            return FALSE;
        }

    }
    public function smtp_setting() {
       $data = array();
       $stmt = "SELECT * FROM system_settings ORDER BY id ASC";
       $query = $this->db->query($stmt);
       if ($query->num_rows()) {
           $data = $query->result_array();
       }
       return $data;
   }

}
?>