<?php 
	
	Class Servpro{


	
    public function send_mail($to,$subject,$message)
    {
         $from = 'alsughayer11@gmail.com';
         // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
         
        // Create email headers
        $headers .= 'From: '.$from."\r\n".
            'Reply-To: '.$from."\r\n" .
            'X-Mailer: PHP/' . phpversion();
         
         
        // Sending email
        if(mail($to, $subject, $message, $headers)){
           return true;
        } else{
            return false;
        }

    }
    
 public function send_mails($to,$subject,$message,$from)
    {
         //$from = 'alsughayer11@gmail.com';
         // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
         
        // Create email headers
        $headers .= 'From: '.$from."\r\n".
            'Reply-To: '.$from."\r\n" .
            'X-Mailer: PHP/' . phpversion();
         
         
        // Sending email
        if(mail($to, $subject, $message, $headers)){
           return true;
        } else{
            return false;
        }

    }

    public function send_email_ci($value='')
    {
        $config = array(
           'protocol'  => 'send',
            'smtp_host' => 'ssl://'.$smtp_host,
           'smtp_port' => $smtp_port,
           'smtp_user' => "$smtp_user",
           'smtp_pass' => "$smtp_pass", 
           'mailtype'  => 'html',
           'charset'   => 'utf-8'
         );
        
       $CI =& get_instance(); 
       $CI->load->helper('file'); 
       $CI->load->library('email');
       $CI->email->initialize($config);
       $CI->email->set_newline("\r\n");
       $CI->email->from($from); 
       $CI->email->to($to); 
       $CI->email->subject($subject);
       $CI->email->message($message);
       if($this->email->send())
   {
     echo "works";

   } else {

      $this->email->print_debugger();  
   }
    }
	}

 ?>