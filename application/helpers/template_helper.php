<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//banner TPL
/**
*@author: Aziz Matin
*@created Date: 20-Feb-2019
**/
if ( !function_exists('banner'))
{
     function banner(){
     	$CI = &get_instance();
     	$banner = $CI->load->view('main/banner');
     	return $banner;
     }  
}

//sidebar TPL
if ( !function_exists('sidebar'))
{
     function sidebar(){
     	$CI = &get_instance();
     	$sidebar = $CI->load->view('main/sidebar');
     	return $sidebar;
     }  
}

//footer TPL
if ( !function_exists('footer'))
{
     function footer(){
          $CI = &get_instance();
          $footer = $CI->load->view('main/footer');
          return $footer;
     }  
}

//content TPL
if ( !function_exists('content'))
{
     function content($content = ""){
          $CI = &get_instance();
          if($content != ""){
               $data['content'] = $content;
               $CI->load->view('main/content',$data);
          }else{
               $data['content'] = "";
               $CI->load->view('main/content',$data);
          }
     }  
}

//modal popup
if ( !function_exists('modal_popup'))
{
     function modal_popup(){
          $CI = &get_instance();
          $CI->load->view('main/modal',"",false);
     }  
}