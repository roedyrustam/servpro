<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_model extends CI_Model {

	public function __construct() {

        parent::__construct();
        $this->load->database();
    }

	var $column_order = array(null, 'P.title');
	var $column_search = array('P.title');
	var $order = array('P.page_id' => 'DESC'); // default order
	var $page_details  = 'pages P';
	private function p_get_datatables_query()
	{


		$this->db->select('P.*');
		$this->db->from($this->page_details);
			$i = 0;

			foreach ($this->column_search as $item) // loop column
			{
					if($_POST['search']['value']) // if datatable send POST for search
					{

							if($i===0) // first loop
							{
									$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
									$this->db->like($item, $_POST['search']['value']);
							}
							else
							{

								if($item == 'status'){
									if(strtolower($_POST['search']['value'])=='active'){
										$search_val = 1;
										$this->db->or_like($item, $search_val);
									}
									if(strtolower($_POST['search']['value'])=='inactive'){
										$search_val = 0;
										$this->db->or_like($item, $search_val);
									}


									}else{
										$search_val = $_POST['search']['value'];
										$this->db->or_like($item, $search_val);
									}

							}

							if(count($this->column_search) - 1 == $i) //last loop
									$this->db->group_end(); //close bracket
					}
					$i++;
			}

			if(isset($_POST['order'])) // here order processing
			{
					$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			}
			else if(isset($this->order))
			{
					$order = $this->order;
					$this->db->order_by(key($order), $order[key($order)]);
			}
	}

  public function page_list(){
      $this->p_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $this->db->group_by('P.page_id');
        $query = $this->db->get();
        return $query->result();
  }

  public function page_list_all(){

    $this->db->from($this->page_details);
        return $this->db->count_all_results();
  }

  public function page_list_filtered(){

        $this->p_get_datatables_query();
        $this->db->group_by('P.page_id');
        $query = $this->db->get();
        return $query->num_rows();
  }
}
