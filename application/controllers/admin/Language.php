<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Language extends CI_Controller {

 public $data;

 public function __construct() {

  parent::__construct();
  $this->load->model('language_model','language');
          $this->load->model('common_model','common_model');

  $this->load->model('language_web_model','web_language');
  $this->data['view'] = 'admin';
  $this->data['base_url'] = base_url();
  $this->session->keep_flashdata('error_message');
  $this->session->keep_flashdata('success_message');
  $this->load->helper('user_timezone_helper');

}



public function index()
{
          $this->common_model->checkAdminUserPermission(12);

  redirect(base_url('pages'));
}
public function pages()
{
            $this->common_model->checkAdminUserPermission(12);

  if($this->session->userdata('admin_id'))
  {
    $this->data['page'] = 'page_list';
    $this->data['model'] = 'language';
    $this->data['pages'] = $this->language->page_list();
    $this->load->vars($this->data);
    $this->load->view('template');
  }
  else {
   redirect(base_url()."admin");
 }
}

public function language_add(){

          $this->common_model->checkAdminUserPermission(12);


  if($this->input->post()){

    if($this->session->userdata('admin_id'))

    {
      $result = $this->language->language_model();

      if($result==true){

        $this->session->set_flashdata('message','The Language has been added successfully...');

      }else{

        $this->session->set_flashdata('message','Already exists');

      }

      redirect(base_url('admin/language/language_add'));



    }else{

      $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');    
      redirect(base_url().'admin/language/language_add');

    }
  }
  $this->data['page'] = 'language_add';
  $this->data['list'] = $this->language->lang_data();
  $this->data['model'] = 'language';
  $this->load->vars($this->data);
  $this->load->view('template');
}

public function delete_addlang(){
            $this->common_model->checkAdminUserPermission(12);

  $this->db->where('id', $this->uri->segment(2));
   
    $result = $this->db->delete('language');
    if(!empty($result))
    {
      $this->session->set_flashdata('success_message','Language deleted successfully');
      redirect(base_url()."language-add");
    }
   else
    {
      $this->session->set_flashdata('error_message','Something wrong, Please try again');
      redirect(base_url()."language-add");
    }
  }

public function language()
{
            $this->common_model->checkAdminUserPermission(12);

  if($this->session->userdata('admin_id'))
  {
    $this->data['page'] = 'language';
    $this->data['model'] = 'language';
    $this->load->vars($this->data);
    $this->load->view('template');
  }
  else {
   redirect(base_url()."admin");
 }
}
public function language_list()
{
            $this->common_model->checkAdminUserPermission(12);

  $page_key = $this->input->post('page_key');
  $lists = $this->language->language_list($page_key);
  $data = array();
  $no = $_POST['start'];
  $active_language = array('en','ma','ar');
  foreach ($lists as $keyword) {
    $no++;
    $row    = array();
    $row[] = $no;
    $exist_key = array();
    if (!empty($active_language))
    {
      $l = 0;
      foreach ($active_language as $lang)
      {
       $lg_language_name = $keyword['lang_key'];
       $language_key = $lang;



       $key = $keyword['language'];
       $value = ($language_key == $key)?$keyword['lang_value']:'';
       $page_key = $keyword['page_key'];
       $key = $keyword['language'];
       $this->data['currenct_page_key_value'] = $this->language->currenct_page_key_value($lists);
       $value = (!empty($this->data['currenct_page_key_value'][$lg_language_name][$language_key]))?$this->data['currenct_page_key_value'][$lg_language_name][$language_key]:'';


       $row[] = '<input type="text" class="form-control" name="'.$lg_language_name.'['.$language_key.']" value="'.$value.'" onchange=update_language(\''.$lg_language_name.'\',\''.$language_key.'\',\''.$page_key.'\')>
       <input type="hidden" class="form-control" name="prev_'.$lg_language_name.'['.$language_key.']" value="'.$value.'">';

       $l++;
     }

   }
   $data[] = $row;
 }

 $output = array(
  "draw" => $_POST['draw'],
  "recordsTotal" => $this->language->language_list_all($page_key),
  "recordsFiltered" => $this->language->language_list_filtered($page_key),
  "data" => $data,
);

          //output to json format
 echo json_encode($output);

}


public function add_keyword()
{
            $this->common_model->checkAdminUserPermission(12);

  if($this->session->userdata('admin_id'))
  {
    $this->data['page'] = 'add_keyword';
    $this->data['model'] = 'language';
    $this->load->vars($this->data);
    $this->load->view('template');
  }
  else {
   redirect(base_url()."admin");
 }

}

public function save_keywords()
{
            $this->common_model->checkAdminUserPermission(12);

  $data = array();
  $pdata = array();
  $page_key = $this->input->post('page_key');
  $multiple = $this->input->post('multiple_key');
  $multiple_keyword = explode(',',$multiple);
  $multiple_keyword = array_filter($multiple_keyword);

  if(!empty($multiple_keyword)) {
   foreach($multiple_keyword as $lang) {
    $lang = trim($lang);
    if($lang != null) {
      $lang_for_key = preg_replace("/[^ \w]+/", "", $lang);
      $count = strlen($lang_for_key);
      if($count > 15)
      {
        $lang_for_key = substr($lang_for_key, 0, 15);
      }
      $lang_det = $this->language->get_language_id($page_key);
      $lang_id = $lang_det['p_id'];

      $language = 'lg'.$lang_id.'_'.str_replace(array(' ','!','&'),'_',strtolower($lang_for_key));
      $data['page_key'] = $pdata['page_key'] = $page_key;
      $data['lang_key'] = $language;
      $data['lang_value'] = $pdata['lang_value'] = $lang;
      $data['language'] = $pdata['language'] = 'en';
      $this->db->where($pdata);
      $record = $this->db->count_all_results('language_management');
      if($record > 0)
      {
        $already_exits[] = $lang;
      }else{
        $cdata['page_key'] = $page_key;
        $cdata['lang_key'] = $language;
        $cdata['language'] = 'en';
        $this->db->where("page_key = '".$page_key."' AND lang_key LIKE '".$language."%' AND language = 'en'");
        $chk_record = $this->db->count_all_results('language_management');
        if($chk_record > 0){
          $data['lang_key'] = $language.$chk_record;
        }
        $result = $this->db->insert('language_management', $data);
      }
    }

  }
}
if(!empty($already_exits))
{
  $this->session->set_flashdata('success_message','Keywords added successfully, But some keywords already exist');
}
else
{
 $this->session->set_flashdata('success_message','Keywords added successfully');
}
echo 1;
}


public function update_language()
{
            $this->common_model->checkAdminUserPermission(12);

 $lang_key = $insert['lang_key'] = $this->input->post('lang_key');
 $lang = $insert['language'] = $this->input->post('lang');
 $page_key = $insert['page_key'] = $this->input->post('page_key');
 $data['lang_value'] = $insert['lang_value'] = $this->input->post('cur_val');
 $this->db->where('lang_key',$lang_key);
 $this->db->where('language',$lang);
 $this->db->from('language_management');
 $ext = $this->db->count_all_results();
 if($ext >0 ){
  if($lang == 'en')
  {
    if(!empty($data['lang_value']))
    {
            $lang_det = $this->language->get_language_id($page_key);
            $lang_id = $lang_det['p_id'];

            $check['page_key'] = $page_key;
            $check['lang_value'] = $data['lang_value'];
            $check['language'] = 'en';
            $this->db->where($check);
            $record = $this->db->count_all_results('language_management');
            if($record == 0)
            {
             $this->db->where('page_key',$page_key);
             $this->db->where('lang_key',$lang_key);
             $this->db->where('language',$lang);
             $result = $this->db->update('language_management',$data);
            }
            else {
              $result = 0;
            }
          }
          else {
            $result = 2;
          }
        }
        else{
         $this->db->where('page_key',$page_key);
         $this->db->where('lang_key',$lang_key);
         $this->db->where('language',$lang);
         $result = $this->db->update('language_management',$data);
       }
     }
     else {
      $result = $this->db->insert('language_management',$insert);
    }
    echo $result;
    die();
  }

  public function update_language_status()

  {
          $this->common_model->checkAdminUserPermission(12);

   $id = $this->input->post('id');

   $status = $this->input->post('update_language');

   if($status==2)
   {
    $this->db->where('id',$id);
    $this->db->where('default_language',1);
    $data=$this->db->get('language')->result_array();

    if(!empty($data))
    {
      echo "0";
    }
    else
    {
      $this->db->query(" UPDATE `language` SET `status` = ".$status." WHERE `id` = ".$id." ");
      echo "1";
    }

  }
  else
  {
    $this->db->query(" UPDATE `language` SET `status` = ".$status." WHERE `id` = ".$id." ");
    echo "1";
  }

}
public function update_language_default()

{

 $id = $this->input->post('id');

 $this->db->where('id',$id);
 $this->db->where('status',1);
 $data=$this->db->get('language')->result_array();

 if(!empty($data))
 {
  $this->db->query("UPDATE language SET default_language = ''");
  $this->db->query(" UPDATE `language` SET `default_language` = 1 WHERE `id` = ".$id." ");
  echo "1";
}
else
{
  echo "0";
}
}

public function keywords()
{
            $this->common_model->checkAdminUserPermission(12);

  $this->data['page'] = 'web_language_keywords';
  $this->data['model'] = 'language';
  $this->data['active_language'] = $this->language->active_language();
  $this->load->vars($this->data);
  $this->load->view('template');
}

public function language_web_list()
{
            $this->common_model->checkAdminUserPermission(12);

  $lists = $this->web_language->language_list();

  $data = array();
  $no = $_POST['start'];
  $active_language = $this->web_language->active_language();
  foreach ($lists as $keyword) {
    $row    = array();
    if (!empty($active_language))
    {
      foreach ($active_language as $rows)
      { 

       $lg_language_name = $keyword['lang_key'];   
       $language_key = $rows['language_value']; 


       $key = $keyword['language'] ;
       $value = ($language_key == $key)?$keyword['lang_value']:'';
       $key = $keyword['language'];
       $currenct_page_key_value = $this->web_language->currenct_page_key_value($lists);



       $name =(!empty($currenct_page_key_value[$lg_language_name][$language_key]['name']))?$currenct_page_key_value[$lg_language_name][$language_key]['name']:'';
       $lang_key =(!empty($currenct_page_key_value[$lg_language_name][$language_key]['lang_key']))?$currenct_page_key_value[$lg_language_name][$language_key]['lang_key']:'';

       $readonly = '';


       $row[] = '<input type="text" class="form-control" placeholder="Name" name="'.$lg_language_name.'['.$language_key.'][lang_value]" value="'.$name.'" '.$readonly.' ><br>
       <input type="text" class="form-control" value="'.$lang_key.'" readonly >
       ';
     }

   }

   $data[] = $row;
 }
 $output = array(
  "draw" => $_POST['draw'],
  "recordsTotal" => $this->web_language->language_list_all(),
  "recordsFiltered" => $this->web_language->language_list_filtered(),
  "data" => $data,
);

          //output to json format
 echo json_encode($output);

}
public function add_web_keyword()

{
          $this->common_model->checkAdminUserPermission(12);


  if($this->input->post()){

   if($this->session->userdata('admin_id')){

    $result = $this->web_language->keyword_model();

    if($result == true){

      $this->session->set_flashdata('message','The Keyword has been added successfully...');

    }elseif(is_array($result) && count($result)==0){

      $this->session->set_flashdata('message','The Keyword has been added successfully...');

    }elseif(is_array($result) && count($result)> 0){

      $this->session->set_flashdata('message','Already exists'.implode(',',$result));

    } else{

      $this->session->set_flashdata('message','Already exists');

    }


  }else{

    $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');    
    redirect(base_url().'add-web-keyword');
  }

  redirect(base_url().'add-web-keyword');

}

$this->data['page'] = 'add_web_keyword';
$this->data['model'] = 'language';
$this->load->vars($this->data);
$this->load->view('template');
}



    public function update_multi_web_language() {          
        $this->common_model->checkAdminUserPermission(12);

        if ($this->input->post()) {
            if(isset($this->data['admin_id']) && $this->data['admin_id'] > 1){
              $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');    
              redirect(base_url().'language/keywords');
            } else {
              $data = $this->input->post();
                foreach($data as $row => $object) {
                    if(is_array($object)) {
                        foreach ($object as $key => $value) {
                            $this->db->where('language', $key);
                            $this->db->where('lang_key', $row);

                            $record = $this->db->count_all_results('language_management');
                            if ($record==0) {
                                $array = array(
                                    'language' =>$key,
                                    'lang_key' =>$row,
                                    'lang_value' =>$value['lang_value'],
                                );
                                $this->db->insert('language_management', $array);
                            } else {
                                $this->db->where('language', $key);
                                $this->db->where('lang_key', $row);
                                $array = array(
                                    'lang_value' =>$value['lang_value'],
                                );
                                $this->db->update('language_management', $array);
                            }
                        }
                    }
                }
                redirect(base_url()."web-keywords");
            }
        }
    }

}
