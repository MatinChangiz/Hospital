<?php
/**
*@author: Aziz Matin
*@created Date: 28-Feb-2021
**/
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    
    /**
    * @desc construct function
    */
    function __construct()
    {
        parent::__construct(); 
        $this->load->helper('jdf');
        $this->load->library('Amc_auth');  
        $this->amc_auth->is_logged_in();
    }
    
	public function index()
	{
		redirect('dashboard/home/');
	}
}
