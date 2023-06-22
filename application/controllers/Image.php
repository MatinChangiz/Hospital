<?php
/**
*@author: Aziz Matin
*@created Date: 28-Feb-2021
**/
defined('BASEPATH') OR exit('No direct script access allowed');

class Image extends CI_Controller {
    private $hidden_path = "uploads/";
    function __construct()
    {
        parent::__construct();
        $this->load->library("Image_lib");
    }
    function index($path = 0)
    {
        //echo $path;exit;
        if($path == 0){
            return false;
        }else{
            $atc_path = "";
            $atc_path = $this->hidden_path.$path;
            if(file_exists($atc_path) == TRUE){
                $atc_path = $this->hidden_path.$path;
            }else{
                return false;
            }
            //echo $atc_path;exit;
            $image_path = $atc_path;
            $config['image_ligrary']        =  'gd2';
            $config['source_image']         =  $image_path;
            $config['create_thumb']         =  FALSE;
            $config['dynamic_output']       =  TRUE;
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
            //return $image_path; 
        }
    }
}
