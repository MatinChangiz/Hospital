<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author: Aziz Matin
 * @filesource
 */
class Amc_auth {
    
    //private $is_logged_in = false;
    //check if it is logged in
    private $is_logged_in = 0;
    function is_logged_in() 
    {
        $CI =& get_instance();
        $is_logged_in = $CI->session->userdata('is_logged_in');
        //echo "<pre>";print_r($is_logged_in);exit;
        if (!isset($is_logged_in) && $is_logged_in != true) {
            redirect('auth/home/login');
            return $is_logged_in;
        }
        else {
        
        }
    }
    
    //logout function
    function logout() 
    {
        $CI =& get_instance();
        $user_data = $CI->session->all_userdata();
            foreach ($user_data as $key => $value) {
                if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
                    $CI->session->unset_userdata($key);
                }
            }
        $CI->session->sess_destroy();
        redirect('auth/home/login');
    }
    
    /**
    * @desc check if I have the role
    */
    function check_myrole($section)
    {
        $CI =& get_instance();
        if($CI->session->userdata($section)==1)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    /**
    * @desc next_visit
    */
    function todayVisit()
    {
        $CI =& get_instance();
        //$CI->load->model(array('next_visit/next_model'));  
        //$today_rec = $CI->next_model->todayVisits();  
        $today_rec = false;   
        if($today_rec){
            return $today_rec; 
        }else{
            return false;
        }
    }
    
    /**
    * @desc check if next visit is done
    */
    function isDone($p_id = 0)
    {
        $CI =& get_instance();
        $CI->load->model(array('next_visit/next_model'));  
        $today_rec = $CI->next_model->isDone($p_id);     
        if($today_rec){
            return TRUE; 
        }else{
            return FALSE;
        }
    }

}
?>