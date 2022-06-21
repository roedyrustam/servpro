<?php
	$this->load->view($view.'/include/header');
	if($view == 'admin' && $model != 'login'){
		$this->load->view('admin/include/navbar');
		$this->load->view('admin/include/sidebar');
	}
	elseif($view == 'user' && $model != 'login' && $model != 'signup' && $model != 'forgot_password'){
		$this->load->view('user/include/navbar');
	}
	$this->load->view($view.'/'.$model.'/'.$page);
	if($view == 'user' && $model != 'login' && $model != 'signup' && $model != 'forgot_password'){
		$this->load->view($view.'/include/sub_footer');
	}
	$this->load->view($view.'/include/footer');

 ?>
