<?php
/**
*@author: Aziz Matin
*@created Date: 03-July-2019
**/
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    /**
    * @desc construct function
    */
    function __construct()
    {
        parent::__construct();
        //load helper
        $this->load->helper('template');
        $this->load->helper('jdf');
        $this->load->library('pagination');
        $this->load->library('Ajax_pagination');
        $this->load->library('Clean_encrypt');  
        $this->load->library('Amc_auth');  
        //load libraries
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('user_agent');
        //load language file
        $this->lang->load("home");
        $this->lang->load("global");
        //load models
        $this->load->model(array('login/login_model','urn_model','document/document_model'));
        $this->amc_auth->is_logged_in();
    }

    /**
    * @desc index function
    */
    public function index()
    {
        redirect('login/home/user_list');
    }
    
    //users list 
    /**
    * @desc register list function
    */
    function user_list($page = 0)
    {
        /*******************************************************
        * @desc ************AJAX PAGINATION*********************
        ********************************************************/
         $config['base_url'] = base_url() . "index.php/login/home/user_list";
         $count = $this->login_model->getAllrecords(); 
         $total_row = count($count);
         $config["total_rows"] = $total_row;

         $config['per_page'] = 5;
         $perPage = $config['per_page'];

         $config['use_page_numbers'] = TRUE;
         $config['num_links'] = $total_row;
         $config['cur_tag_open'] = '&nbsp;<a class="current">';
         $config['cur_tag_close'] = '</a>';
         $config['next_link'] = $this->lang->line('next');
         $config['prev_link'] = $this->lang->line('prev');

         $this->pagination->initialize($config);
         if($this->uri->segment(3)){
             if($page != 0){
                $page = ($page*5)-5;
             }else{
                 $page = $page;
             }
         }
         else{
            $page = 1;
         }
         $str_links = $this->pagination->create_links();
         $data["links"] = explode('&nbsp;',$str_links );
         $register_list = $this->login_model->getAllrecords($perPage, $page);
         //echo "<pre>";print_r($register_list);exit; 
        /*******************************************************
        * @desc ************AJAX PAGINATION*********************
        ********************************************************/
        $data['title']      = $this->lang->line("user_list"); 
        $data['records']    = $register_list; 
        
        banner();
        sidebar();
        $modal = modal_popup();
        $content = $this->load->view('login/user_list',$data,true);
        content($content);
        footer();
    }
    
    /**
    * @desc add function 
    */
    function create_user()
    {
        if(0){
            echo "You are not loged in";exit;
        }else{
            $this->form_validation->set_rules('name', 'name', 'trim|required');
            $this->form_validation->set_rules('username', 'username', 'trim|required');
            $this->form_validation->set_rules('password', 'password', 'trim|required');
            $this->form_validation->set_rules('pass_again', 'pass_again', 'trim|required');
            if($this->form_validation->run() == FALSE){
                //load views and templates
                banner();
                sidebar();
                $modal = modal_popup(); 
                $data['title'] = $this->lang->line('create_user');
                $content = $this->load->view("login/signup",$data,true);
                content($content);
                footer();
            }
            else{    
                $name           = $this->input->post('name');    
                $username       = $this->input->post('username');    
                $password       = SHA1($this->input->post('password'));
                $pass_again     = SHA1($this->input->post('pass_again'));
                $contact        = $this->input->post('contact');
                $reception      = $this->input->post('reception');
                $expenses       = $this->input->post('expenses');
                $farmcy         = $this->input->post('farmcy');
                $report         = $this->input->post('report');
                $remains        = $this->input->post('remains');
                $next_visit     = $this->input->post('next_visit');
                $search         = $this->input->post('search');
                $xray_material  = $this->input->post('xray_material');
                $admin          = $this->input->post('admin');
                if($password != $pass_again){
                    $this->session->set_flashdata('msg','<div class="alert alert-danger">'.$this->lang->line('password_match_msg').' !</div>');
                    redirect("login/home/create_user");
                }else{
                    $data = array(
                        "full_name"             => $name,
                        "username"              => $username,
                        "password"              => $password,
                        "contact"               => $contact,
                        "admin"                 => $admin,
                        "reception"             => $reception,
                        "drug_store"            => $farmcy,
                        "remains"               => $remains,
                        "next_visit"            => $next_visit,
                        "report"                => $report,
                        "expense"               => $expenses,
                        "search"                => $search,
                        "xray_material"         => $xray_material,
                        "registerdate"          => date('Y-m-d H:i:s')
                    );
                    $urn = $this->urn_model->getURN('users','urn');
                    $update = $this->login_model->update('users',$urn,$data,1000001,"INSERT");
                    if($update){
                        $this->session->set_flashdata('msg','<div class="alert alert-success">'.$this->lang->line('insert_msg').' !</div>'); 
                        $this->user_list();
                    }else{
                        $this->session->set_flashdata('msg','<div class="alert alert-danger">'.$this->lang->line('faild_msg').' !</div>');
                    }
                }
            }
        }
    }
    
    /**
    * @desc view function
    */
    function view($urn = 0,$drug = '')
    {
        if(0){
            echo "You are not loged in.";exit;
        }else{
            $dec_urn = $this->clean_encrypt->decode($urn);
            $data = "";
            $records = false;
            //top title
            $data['title'] = $this->lang->line("login_view");
            $records = $this->login_model->getViewRecords($dec_urn);
            //echo "<pre>";print_r($records);exit;
            if($records){
                $data["record"]  = $records[0];
            }
            else
            {
                $data["record"]  = "";
            }
            //load views and templates
            banner();
            sidebar();
            $modal = modal_popup();
            $content = $this->load->view("login/user_view",$data,true);
            content($content);
            footer();   
        }
    }
    
    /**
    * @desc edit registered data
    */
    function edit_user($urn = 0)
    {
        if(0){
            echo "You are not loged in";exit;
        }else{
            $dec_urn = $this->clean_encrypt->decode($urn);
            $this->form_validation->set_rules('name', 'name', 'trim');
            $this->form_validation->set_rules('username', 'username', 'trim');
            $this->form_validation->set_rules('password', 'password', 'trim');
            $this->form_validation->set_rules('pass_again', 'pass_again', 'trim');
            if($this->form_validation->run() == FALSE){
                $data = "";
                $records = false;
                //top title
                $data['title'] = $this->lang->line("login_edit");
                $records = $this->login_model->getViewRecords($dec_urn);
                
                $data["record"]             = $records[0];
                $data["enc_urn"]            = $urn;
                
                //load views and templates
                banner();
                sidebar();
                $modal = modal_popup();
                //the views if the record is exist
                $content = $this->load->view("login/signup_edit",$data,true);
                content($content);
                footer(); 
            }
            else{
                $updateUser = "";
                $name           = $this->input->post('name');    
                $username       = $this->input->post('username'); 
                if(($this->input->post('password')== TRUE && $this->input->post('password') !='') || ($this->input->post('pass_again')== TRUE && $this->input->post('pass_again') !='')){
                    $password       = SHA1($this->input->post('password'));
                    $pass_again     = SHA1($this->input->post('pass_again'));
                }else{
                    $password       = "";
                    $pass_again     = "";
                }
                $contact        = $this->input->post('contact');
                $reception      = $this->input->post('reception');
                $expenses       = $this->input->post('expenses');
                $farmcy         = $this->input->post('farmcy');
                $report         = $this->input->post('report');
                $remains        = $this->input->post('remains');
                $next_visit     = $this->input->post('next_visit');
                $search         = $this->input->post('search');
                $xray_material  = $this->input->post('xray_material');
                $admin          = $this->input->post('admin');
                $user_data = array();
                if(($password == TRUE && $password != "") ||($pass_again == TRUE && $pass_again != "")){
                    if($password != $pass_again){
                        $this->session->set_flashdata('msg','<div class="alert alert-danger">'.$this->lang->line('password_match_msg').' !</div>');
                        redirect("login/home/edit_user/$urn");
                    }else{
                        $user_data = array(
                                "full_name"             => $name,
                                "username"              => $username,
                                "password"              => $password,
                                "contact"               => $contact,
                                "admin"                 => $admin,
                                "reception"             => $reception,
                                "drug_store"            => $farmcy,
                                "remains"               => $remains,
                                "next_visit"            => $next_visit,
                                "report"                => $report,
                                "expense"               => $expenses,
                                "search"                => $search,
                                "xray_material"         => $xray_material
                        );
                    }    
                }else{
                    $user_data = array(
                        "full_name"             => $name,
                        "username"              => $username,
                        "contact"               => $contact,
                        "admin"                 => $admin,
                        "reception"             => $reception,
                        "drug_store"            => $farmcy,
                        "remains"               => $remains,
                        "next_visit"            => $next_visit,
                        "report"                => $report,
                        "expense"               => $expenses,
                        "search"                => $search,
                        "xray_material"         => $xray_material
                );
                }
                $updateUser = $this->login_model->update('users',$dec_urn,$user_data,1000001,"UPDATE");
                if($updateUser){
                    $this->session->set_flashdata('msg','<div class="alert alert-success">'.$this->lang->line('update_msg').' !</div>');
                    redirect("login/home/view/$urn",'refresh');
                }     
            }
        }
    }
    
    /**
    * @desc login page
    */
    function login()
    {
        if(0){
            echo "You are not loged in";exit;
        }else{
            $this->form_validation->set_rules('username', 'username', 'trim|required');
            $this->form_validation->set_rules('password', 'password', 'trim|required');
            if($this->form_validation->run() == FALSE){
                $modal = modal_popup(); 
                $data['title'] = $this->lang->line('login_page');
                $this->load->view("login/login",$data);
            }
            else{       
                $username       = $this->input->post('username');    
                $password       = SHA1($this->input->post('password'));
                $users          = $this->login_model->authenticate($username,$password);
                if($users){
                    $data = array(
                        'urn'           => $users[0]->urn,
                        'username'      => $users[0]->username,
                        'full_name'     => $users[0]->full_name,
                        'is_logged_in'  => true
                    );

                    $is_logged_in = $this->session->set_userdata($data);
                    redirect('dashboard/home','refresh');
                }else{
                    $this->session->set_flashdata('msg','<div class="alert alert-danger">'.$this->lang->line('failed_login').' !</div>'); 
                    redirect('login/home/login','refresh');   
                }
            }
        }   
    }
    
    /**
    * @desc logout function
    */
    function logout()
    {
        //log out the session
        $this->amc_auth->logout();
    }
    
    /**
    * @desc check if user existe
    */
    function checkUser()
    {
        //echo "<pre>";print_r($_POST);exit;
        $username = $this->input->post("no");
        $check = $this->login_model->checkIfTaken($username);
        if($check){
            echo "<div class='alert alert-danger' style='margin-bottom:-20px;padding:6px'>".$this->lang->line("taken_user")."</div>";
            return false;
        }else{
            echo "";
            return true;
        }
    }
    
    /**
    * @desc change password
    */
    function change_password($urn=0){
        if(0){
            echo "You are not loged in";exit;
        }else{
            $this->form_validation->set_rules('password', 'password', 'trim|required');
            $this->form_validation->set_rules('new_password', 'new_password', 'trim|required');
            $this->form_validation->set_rules('new_pass_again', 'new_pass_again', 'trim|required');
            if($this->form_validation->run() == FALSE){
                //load views and templates
                banner();
                sidebar();
                $modal = modal_popup(); 
                $data['enc_urn'] = $this->session->userdata("urn");
                $data['record'] = "";
                $data['title'] = $this->lang->line('chang_password');
                $content = $this->load->view("login/change_password",$data,true);
                content($content);
                footer();
            }
            else{    
                //get pass by urn
                $old_pass = $this->login_model->getPassByUrn($urn);
                $old_password = $old_pass[0];  
                if($old_password->password == SHA1($this->input->post('password'))){
                    $new_password       = SHA1($this->input->post('new_password'));
                    $new_pass_again     = SHA1($this->input->post('new_pass_again'));    
                    
                    if($new_password != $new_pass_again){
                        $this->session->set_flashdata('msg','<div class="alert alert-danger">'.$this->lang->line('password_match_msg').' !</div>');
                        redirect("login/home/change_password","refresh");
                    }else{
                        $data = array(
                            "password"              => $new_password,
                            "is_updated"            => 1
                        );
                        //$urn = $this->urn_model->getURN('users','urn');
                        $update = $this->login_model->update('users',$urn,$data,1000001,"UPDATE");
                        if($update){
                            $this->session->set_flashdata('msg','<div class="alert alert-success">'.$this->lang->line('change_pass_msg').' !</div>'); 
                            redirect("login/home/change_password","refresh");
                        }else{
                            $this->session->set_flashdata('msg','<div class="alert alert-danger">'.$this->lang->line('faild_msg').' !</div>');
                        }
                    }
                }
                else{
                    $this->session->set_flashdata('msg','<div class="alert alert-danger">'.$this->lang->line('old_pass_err').' !</div>'); 
                    redirect("login/home/change_password",'refresh'); 
                }
            }
        }
    }
    
}

?>