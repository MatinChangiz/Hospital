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
                        //role
                        'admin'         => $users[0]->admin,
                        'reception'     => $users[0]->reception,
                        'drug_store'    => $users[0]->drug_store,
                        'remains'       => $users[0]->remains,
                        'next_visit'    => $users[0]->next_visit,
                        'report'        => $users[0]->report,
                        'expense'       => $users[0]->expense,
                        'search'        => $users[0]->search,
                        'xray_material' => $users[0]->xray_material,
                        'is_logged_in'  => true
                    );

                    $is_logged_in = $this->session->set_userdata("userdata",$data);
                    echo $is_logged_in;exit;
                    redirect('dashboard/home','refresh');
                }else{
                    $this->session->set_flashdata('msg','<div class="alert alert-danger">'.$this->lang->line('failed_login').' !</div>'); 
                    redirect('auth/home/login','refresh');   
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
}

?>