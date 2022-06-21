<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Categories_model extends CI_Model
{

	 function __construct() { 
        // Set table name 
        $this->table = 'categories'; 
    } 
     
    
    function get_category($params = array()){ 
        $this->db->select('c.id,c.category_name,c.category_image, (SELECT COUNT(s.id) FROM services AS s WHERE s.category=c.id AND s.status=1 ) AS category_count');
               $this->db->from('categories c');
               $this->db->where('c.status',1);
               $this->db->order_by('category_count','DESC');
         
        if(array_key_exists("where", $params)){ 
            foreach($params['where'] as $key => $val){ 
                $this->db->where($key, $val); 
            } 
        } 
         
        if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){ 
            $result = $this->db->count_all_results(); 
        }else{ 
            if(array_key_exists("id", $params) || (array_key_exists("returnType", $params) && $params['returnType'] == 'single')){ 
                if(!empty($params['id'])){ 
                    $this->db->where('id', $params['id']); 
                } 
                $query = $this->db->get(); 
                $result = $query->row_array(); 
            }else{ 
               
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
                    $this->db->limit($params['limit'],$params['start']); 
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
                    $this->db->limit($params['limit']); 
                } 
                 
                $query = $this->db->get(); 
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE; 
            } 
        } 
         
        // Return fetched data 
        return $result; 
    } 

	function show_category(){
        $this->db->select('c.id,c.category_name,c.category_image, GROUP_CONCAT(p_id) as categories, p.title, count(p_id) as p_count');
       $this->db->from('categories c');
       $this->db->join('provider_details p', 'p.category IN(`c`.`id`)', 'left');
       $this->db->where('c.status',1);
       $this->db->order_by('id', 'DESC'); 
       $this->db->group_by('c.id','DESC');     
       return $this->db->get()->result_array();
    }	

    function select_provide_bycategory($pid = ''){
        $this->db->select('c.id,c.category_name,c.category_image, GROUP_CONCAT(p_id) as categories, p.title, count(p_id) as p_count');
       $this->db->from('categories c');
       $this->db->join('provider_details p', 'p.category IN('.$pid.')', 'left');
       $this->db->where('c.status',1);
       $this->db->where('c.id', $pid);
       $this->db->order_by('p_count', 'DESC'); 
       $this->db->group_by('c.id','DESC');     
       return $this->db->get()->result_array();
    }   
}
?>
