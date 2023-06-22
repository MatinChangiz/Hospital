<?php
/**
 * @desc: Police 119 emergency call main controller
* @author : Matin
* @date: 22 Oct 2021
*/

class Home extends CI_Controller
{
    //--- initialization function (constroctor)
    function __construct()
    {
        parent::__construct();
        //load helper
        $this->load->helper('template');
        $this->load->helper('jdf');
        //$this->load->library('pagination');
        //$this->load->library('Ajax_pagination');
        $this->load->library('Ajax_pagination_new');
        $this->load->library('Clean_encrypt');  
        $this->load->library('Amc_auth');  
        //load libraries
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('user_agent');
        //helper
        $this->load->helper('datecheck');
        //load language file
        $this->lang->load("home");
        $this->lang->load("global");
        //load models
        $this->load->model(array('register/register_model','urn_model','document/document_model'));
        
        $this->amc_auth->is_logged_in();

    }

    function index()
    {
        // First take all the stored emergency reports and load emergency calls (119) police list
        $this->listRecords();
        // If user is logged in
    }

    /**
    * @desc this function show list of all available records.
    */
    /**
    * @desc register list function
    */
    function listRecords($page = 0)
    {
        /*******************************************************
        * @desc ************AJAX PAGINATION*********************
        ********************************************************/
        $str_post_str  = '&ajax=1';  
        $recpage  = $this->config->item('recordperpage')/2;//number of records per page
        $starting = $this->input->post('starting');         //get counter which page record
        //if its the first page than show starting from 0
        if(!$starting)
        {
            $starting =0;
        }
        //materials
        $material            = $this->register_model->material();
        $data['material']    = $material;
        $records   = $this->register_model->getAllrecords($starting,$recpage,FALSE);
        $rec_total = $this->register_model->getAllrecords($starting,$recpage,TRUE);
        if($records)
        {
            //echo "<pre/>"; print_r($records->result()); exit;
            $data['records'] = $records;
        }
        else
        {
            $data['records'] = '';
        }
        $this->ajax_pagination_new->make_search(
            $rec_total,
            $starting,
            $recpage,
            $this->lang->line('first'),
            $this->lang->line('last'),
            $this->lang->line('prev'),
            $this->lang->line('next'),
            $this->lang->line('page'),
            $this->lang->line('of'),
            $this->lang->line('total'),
            base_url()."index.php/register/home/listRecords",
            'list_div1',
            $str_post_str
        );
         
        $data["search"] = FALSE;
        $data['page']   = $starting;
        $data['total']  = $this->ajax_pagination_new->total;
        $data['links']  = $this->ajax_pagination_new->anchors; 
           
        //date and time dropdown data
        $data['days']           = $this->getDateDetails('days');
        $data['months']         = $this->getDateDetails('months');
        $data['years']          = $this->getDateDetails('years');
        $data['title']      = $this->lang->line("register_list"); 
        $data['filter']  = $this->load->view("filter/register_filter",$data,true); 
        if($this->input->post('ajax')==1)
        {
            $data["search"] = TRUE;
            $this->load->view('filter/reg_filter_list',$data);
        }else{                                                   
            banner();
            sidebar();
            $modal = modal_popup();
            $content = $this->load->view('register/list',$data,true);
            content($content);
            footer();
        }
    }

    /**
    * @desc add to the register
    */
    function add()
    {
        if(0){
            echo "You are not loged in";exit;
        }else{
            $this->form_validation->set_rules('amount', 'amount', 'trim');
            $this->form_validation->set_rules('shade', 'shade', 'trim');
            $this->form_validation->set_rules('job_code', 'job_code', 'trim');
            if($this->form_validation->run() == FALSE){
                //doctors
                $doctors            = $this->register_model->doctors();
                $data['doctors']    = $doctors;

                //materials
                $material            = $this->register_model->material();
                $data['material']    = $material;
               
                //load views and templates
                banner();
                sidebar();
                $modal = modal_popup();
                $data['position']       = $this->load->view("register/position",$data,true);
                $content = $this->load->view("register/add",$data,true);
                content($content);
                footer();
            }
            else{
                $dr_name        = $this->input->post('dr_name');    
                $dr_code        = $this->input->post('dr_code');       
                $amount         = $this->input->post('amount');       
                $material       = $this->input->post('material');       
                $shade          = $this->input->post('shade');       
                $job_code       = $this->input->post('job_code');       
                $price          = $this->input->post('price');       
                $total_price    = $this->input->post('total_price');       
                
                $urn        = $this->urn_model->getURN('registeration','urn');
                $data = array(
                    "dr_name"               => $dr_name,
                    "dr_code"               => $dr_code,
                    "amount"                => $amount,
                    "material"              => $material,
                    "shade"                 => $shade,
                    "job_code"              => $job_code,
                    "price"                 => $price,
                    "total_price"           => $total_price,
                    "registerdate"          => date("Y-m-d")
                );
                //echo "<pre>";print_r($data);exit;
                $update = $this->register_model->update('registeration',$urn,$data,1000001,"INSERT");
                if($update == true){
                    $this->fill_teeth_add($urn);        
                }
                if($update){
                    redirect("register/home/view/".$this->clean_encrypt->encode($urn));
                }

            }
        }
    }

    /**
    * @desc fill teeth add function
    */
    function fill_teeth_add($register_urn = 0)
    {
        if($register_urn != 0){
            /****************************fill teeth starts*/
            //top right teeth
            $topr1       = $this->input->post('topr1');    
            $topr2       = $this->input->post('topr2');    
            $topr3       = $this->input->post('topr3');    
            $topr4       = $this->input->post('topr4');    
            $topr5       = $this->input->post('topr5');    
            $topr6       = $this->input->post('topr6');    
            $topr7       = $this->input->post('topr7');    
            $topr8       = $this->input->post('topr8');  
            //top left teeth  
            $topl1     = $this->input->post('topl1');
            $topl2     = $this->input->post('topl2');
            $topl3     = $this->input->post('topl3');
            $topl4     = $this->input->post('topl4');
            $topl5     = $this->input->post('topl5');
            $topl6     = $this->input->post('topl6');
            $topl7     = $this->input->post('topl7');
            $topl8     = $this->input->post('topl8');
            //bottom right teeth       
            $bottomr1    = $this->input->post('bottomr1'); 
            $bottomr2    = $this->input->post('bottomr2'); 
            $bottomr3    = $this->input->post('bottomr3'); 
            $bottomr4    = $this->input->post('bottomr4'); 
            $bottomr5    = $this->input->post('bottomr5'); 
            $bottomr6    = $this->input->post('bottomr6'); 
            $bottomr7    = $this->input->post('bottomr7'); 
            $bottomr8    = $this->input->post('bottomr8'); 
            //bottom left teeth      
            $bottoml1      = $this->input->post('bottoml1');     
            $bottoml2      = $this->input->post('bottoml2');     
            $bottoml3      = $this->input->post('bottoml3');     
            $bottoml4      = $this->input->post('bottoml4');     
            $bottoml5      = $this->input->post('bottoml5');     
            $bottoml6      = $this->input->post('bottoml6');     
            $bottoml7      = $this->input->post('bottoml7');     
            $bottoml8      = $this->input->post('bottoml8');
            if(1)
            {
                $ill_type = 1;
                $fill_data = array(
                    "register_urn"              => $register_urn,
                    
                    "topright1"                 => $topr1,
                    "topright2"                 => $topr2,
                    "topright3"                 => $topr3,
                    "topright4"                 => $topr4,
                    "topright5"                 => $topr5,
                    "topright6"                 => $topr6,
                    "topright7"                 => $topr7,
                    "topright8"                 => $topr8,
                    
                    "topleft1"                  => $topl1,
                    "topleft2"                  => $topl2,
                    "topleft3"                  => $topl3,
                    "topleft4"                  => $topl4,
                    "topleft5"                  => $topl5,
                    "topleft6"                  => $topl6,
                    "topleft7"                  => $topl7,
                    "topleft8"                  => $topl8,
                    
                    
                    "bottomright1"              => $bottomr1,
                    "bottomright2"              => $bottomr2,
                    "bottomright3"              => $bottomr3,
                    "bottomright4"              => $bottomr4,
                    "bottomright5"              => $bottomr5,
                    "bottomright6"              => $bottomr6,
                    "bottomright7"              => $bottomr7,
                    "bottomright8"              => $bottomr8,
                    
                    "bottomleft1"               => $bottoml1,
                    "bottomleft2"               => $bottoml2,
                    "bottomleft3"               => $bottoml3,
                    "bottomleft4"               => $bottoml4,
                    "bottomleft5"               => $bottoml5,
                    "bottomleft6"               => $bottoml6,
                    "bottomleft7"               => $bottoml7,
                    "bottomleft8"               => $bottoml8
                );
                //echo "<pre>";print_r($fill_data);exit;
                $fill_urn = $this->urn_model->getURN('teeth','urn');
                $update = $this->register_model->update('teeth',$fill_urn,$fill_data,1000001,"INSERT");    
            } 
            /****************************fill teeth ends*/
        }
    }

    /**
    * @desc view function
    */
    function view($urn = 0)
    {
        if(0){
            echo "You are not loged in.";exit;
        }else{
            $dec_urn = $this->clean_encrypt->decode($urn);
            $data = "";
            $records = false;
            $teeth_records = false;
            //top title
            $records = $this->register_model->getViewRecords($dec_urn);
            //echo "<pre>";print_r($records);exit;
            if($records){
                $teeth_records  = $this->register_model->getTeethRecords($records[0]->urn);
            }
            
            $data["record"]             = $records[0];
            $data["teeth_record"]       = $teeth_records;
            
            //load views and templates
            banner();
            sidebar();
            $modal = modal_popup();
            $data['position_view'] = $this->load->view("register/position_view",$data,true); 
            $content = $this->load->view("register/view",$data,true);
            content($content);
            footer();   
        }
    }

    /**
    * @desc add to the register
    */
    function edit($urn=0)
    {
        if(0){
            echo "You are not loged in";exit;
        }else{
            $dec_urn = $this->clean_encrypt->decode($urn);
            $this->form_validation->set_rules('amount', 'amount', 'trim');
            $this->form_validation->set_rules('shade', 'shade', 'trim');
            $this->form_validation->set_rules('job_code', 'job_code', 'trim');
            if($this->form_validation->run() == FALSE){
                $data = "";
                $records = false;
                $teeth_records = false;
                //doctors
                $doctors            = $this->register_model->doctors();
                $data['doctors']    = $doctors;
                //materials
                $material            = $this->register_model->material();
                $data['material']    = $material;
                
                $records = $this->register_model->getViewRecords($dec_urn);
                if($records){
                    $teeth_records  = $this->register_model->getTeethRecords($records[0]->urn);
                }
                $data["record"]             = $records[0];
                $data["teeth_record"]       = $teeth_records;
                $data["enc_urn"]            = $urn;
                //load views and templates
                banner();
                sidebar();
                $modal = modal_popup();
                $data['position_edit']       = $this->load->view("register/position_edit",$data,true);
                $content = $this->load->view("register/edit",$data,true);
                content($content);
                footer();
            }
            else{
                $dr_name        = $this->input->post('dr_name');    
                $dr_code        = $this->input->post('dr_code');       
                $amount         = $this->input->post('amount');       
                $material       = $this->input->post('material');       
                $shade          = $this->input->post('shade');       
                $job_code       = $this->input->post('job_code');       
                $price          = $this->input->post('price');       
                $total_price    = $this->input->post('total_price');       
                $data = array(
                    "dr_name"               => $dr_name,
                    "dr_code"               => $dr_code,
                    "amount"                => $amount,
                    "material"              => $material,
                    "shade"                 => $shade,
                    "job_code"              => $job_code,
                    "price"                 => $price,
                    "total_price"           => $total_price,
                    "is_updated"            => "1"
                );
                //echo "<pre>";print_r($data);exit;
                $update = $this->register_model->update('registeration',$dec_urn,$data,1000001,"UPDATE");
                if($update){
                    $this->position_edit($dec_urn);      
                    redirect("register/home/view/".$this->clean_encrypt->encode($dec_urn));
                }

            }
        }
    }

    /**
    * @desc fill teeth edit function
    */
    function position_edit($register_urn = 0)
    {
        if($register_urn != 0){
            /****************************fill teeth starts*/
            $urn         = $this->input->post('fill_urn');
            //top right teeth               
            $topr1       = $this->input->post('topr1');    
            $topr2       = $this->input->post('topr2');    
            $topr3       = $this->input->post('topr3');    
            $topr4       = $this->input->post('topr4');    
            $topr5       = $this->input->post('topr5');    
            $topr6       = $this->input->post('topr6');    
            $topr7       = $this->input->post('topr7');    
            $topr8       = $this->input->post('topr8');  
            //top left teeth  
            $topl1     = $this->input->post('topl1');
            $topl2     = $this->input->post('topl2');
            $topl3     = $this->input->post('topl3');
            $topl4     = $this->input->post('topl4');
            $topl5     = $this->input->post('topl5');
            $topl6     = $this->input->post('topl6');
            $topl7     = $this->input->post('topl7');
            $topl8     = $this->input->post('topl8');
            //bottom right teeth       
            $bottomr1    = $this->input->post('bottomr1'); 
            $bottomr2    = $this->input->post('bottomr2'); 
            $bottomr3    = $this->input->post('bottomr3'); 
            $bottomr4    = $this->input->post('bottomr4'); 
            $bottomr5    = $this->input->post('bottomr5'); 
            $bottomr6    = $this->input->post('bottomr6'); 
            $bottomr7    = $this->input->post('bottomr7'); 
            $bottomr8    = $this->input->post('bottomr8'); 
            //bottom left teeth      
            $bottoml1      = $this->input->post('bottoml1');     
            $bottoml2      = $this->input->post('bottoml2');     
            $bottoml3      = $this->input->post('bottoml3');     
            $bottoml4      = $this->input->post('bottoml4');     
            $bottoml5      = $this->input->post('bottoml5');     
            $bottoml6      = $this->input->post('bottoml6');     
            $bottoml7      = $this->input->post('bottoml7');     
            $bottoml8      = $this->input->post('bottoml8');
            if($topl1 != '' || $topl2 != '' || $topl3 != '' || $topl4 != '' || $topl5 != '' || $topl6 != '' || $topl7 != '' || $topl8 != '' || $topr1 != '' || $topr2 != '' || $topr3 != '' || $topr4 != '' || $topr5 != '' || $topr6 != '' || $topr7 != '' || $topr8 != '' || $bottomr1 != '' || $bottomr2 != '' || $bottomr3 != '' || $bottomr4 != '' || $bottomr5 != '' || $bottomr6 != '' || $bottomr7 != '' || $bottomr8 != '' || $bottoml1 != '' || $bottoml2 != '' || $bottoml3 != '' || $bottoml4 != '' || $bottoml5 != '' || $bottoml6 != '' || $bottoml7 != '' || $bottoml8 != '')
            {
                $fill_data = array(
                    "register_urn"              => $register_urn,
                    
                    "topright1"                 => $topr1,
                    "topright2"                 => $topr2,
                    "topright3"                 => $topr3,
                    "topright4"                 => $topr4,
                    "topright5"                 => $topr5,
                    "topright6"                 => $topr6,
                    "topright7"                 => $topr7,
                    "topright8"                 => $topr8,
                    
                    "topleft1"                  => $topl1,
                    "topleft2"                  => $topl2,
                    "topleft3"                  => $topl3,
                    "topleft4"                  => $topl4,
                    "topleft5"                  => $topl5,
                    "topleft6"                  => $topl6,
                    "topleft7"                  => $topl7,
                    "topleft8"                  => $topl8,
                    
                    "bottomright1"              => $bottomr1,
                    "bottomright2"              => $bottomr2,
                    "bottomright3"              => $bottomr3,
                    "bottomright4"              => $bottomr4,
                    "bottomright5"              => $bottomr5,
                    "bottomright6"              => $bottomr6,
                    "bottomright7"              => $bottomr7,
                    "bottomright8"              => $bottomr8,
                    
                    "bottomleft1"               => $bottoml1,
                    "bottomleft2"               => $bottoml2,
                    "bottomleft3"               => $bottoml3,
                    "bottomleft4"               => $bottoml4,
                    "bottomleft5"               => $bottoml5,
                    "bottomleft6"               => $bottoml6,
                    "bottomleft7"               => $bottoml7,
                    "bottomleft8"               => $bottoml8
                );
                //echo "<pre>";print_r($fill_data);exit;
                $update = $this->register_model->updateTeeth('teeth',$urn,$fill_data,1000001,"UPDATE"); 
            } 
            /****************************fill teeth ends*/
        }
    }

    /**
    * @desc get date dropdown data
    */
    function getDateDetails($var = "")
    {
        $range = 0;
        $content = "";
        if($var == "days"){
            $range = 31;
            for($i = 1; $i<=$range; $i++){
                $content .= "<option value='$i'>$i</option>";
            }
        }else if($var == "months"){
            $range = 12;
            for($i = 1; $i<=$range; $i++){
                $content .= "<option value='$i'>".$this->lang->line('month'.$i)."</option>";
            }
        }else if($var == "years"){ 
            $year = date("Y");
            //$year = date("Y")-621;
            $i = $year+1;
            $range = $year-12;
            for($i; $i>=$range; $i--){
                $content .= "<option value='$i'>$i</option>";
            }
        }
        return $content;     
    }
    
    //get price
    function getPrice()
    {
        //echo "<pre>";print_r($_POST);exit;
        if(0){
            echo "You are not loged in.";exit;
        }else{
            $p_id       = $this->input->post('pid');
            $dr_urn     = $this->input->post('dr_urn');
            $records    = $this->register_model->getPrice($p_id,$dr_urn); 
            if($records){
                echo $records[0]->price;
            }else{
                echo "";
            }
        }    
    }

    //manage financial
    function bill_list()
    {
        /*******************************************************
        * @desc ************AJAX PAGINATION*********************
        ********************************************************/
        $str_post_str  = '&ajax=1';  
        $recpage  = $this->config->item('recordperpage')/2;//number of records per page
        $starting = $this->input->post('starting');         //get counter which page record
        //if its the first page than show starting from 0
        if(!$starting)
        {
            $starting =0;
        }
        
        $records   = $this->register_model->getPaidrecords($starting,$recpage,FALSE);
        $rec_total = $this->register_model->getPaidrecords($starting,$recpage,TRUE);
        if($records)
        {
            //echo "<pre/>"; print_r($records->result()); exit;
            $data['records'] = $records;
        }
        else
        {
            $data['records'] = '';
        }
        $this->ajax_pagination_new->make_search(
            $rec_total,
            $starting,
            $recpage,
            $this->lang->line('first'),
            $this->lang->line('last'),
            $this->lang->line('prev'),
            $this->lang->line('next'),
            $this->lang->line('page'),
            $this->lang->line('of'),
            $this->lang->line('total'),
            base_url()."index.php/register/home/bill_list",
            'list_div1',
            $str_post_str
        );
         
        $data["search"] = FALSE;
        $data['page']   = $starting;
        $data['total']  = $this->ajax_pagination_new->total;
        $data['links']  = $this->ajax_pagination_new->anchors; 

        //date and time dropdown data
        $data['days']           = $this->getDateDetails('days');
        $data['months']         = $this->getDateDetails('months');
        $data['years']          = $this->getDateDetails('years');
        $data['filter']  = $this->load->view("filter/bill_filter",$data,true); 
        if($this->input->post('ajax')==1)
        {
            $data["search"] = TRUE;
            $this->load->view('filter/bill_filter_list',$data);
        }else{                                                   
            banner();
            sidebar();
            $modal = modal_popup();
            $content = $this->load->view('register/bill/list',$data,true);
            content($content);
            footer();
        }
    }

    /**
    * @desc add to the register
    */
    function pay_bill()
    {
        if(0){
            echo "You are not loged in";exit;
        }else{
            $this->form_validation->set_rules('amount', 'amount', 'trim');
            if($this->form_validation->run() == FALSE){
                //doctors
                $doctors            = $this->register_model->doctors();
                $data['doctors']    = $doctors;               
                //load views and templates
                banner();
                sidebar();
                $modal = modal_popup();
                $content = $this->load->view("register/bill/add",$data,true);
                content($content);
                footer();
            }
            else{
                $dr_name        = $this->input->post('dr_name');    
                $dr_code        = $this->input->post('dr_code');       
                $amount         = $this->input->post('amount');      
                $urn        = $this->urn_model->getURN('financial','urn');
                $data = array(
                    "dr_urn"                => $dr_name,
                    "dr_code"               => $dr_code,
                    "paid_amount"           => $amount,
                    "registerdate"          => date("Y-m-d")
                );
                //echo "<pre>";print_r($data);exit;
                $update = $this->register_model->update('financial',$urn,$data,1000001,"INSERT");
                if($update == true){
                    redirect("register/home/bill_list");
                }

            }
        }
    }

    /**
    * @desc filter copied function
    */
    function filter()
    {
        // Check if user is supervisor, or has view role, or all view role, or dep all view role
        if(1)
        {         
            //echo "<pre>";print_r($_POST);exit;  
            $search_keys="";
            //integrate ajax pagination
            $str_post_str  = '&ajax=1';
            //integrate ajax pagination
            // name
            if($this->input->post('dr_code') != "")
            {
                $str_post_str .= '&dr_code='.$this->input->post('dr_code');
            }
            if($this->input->post('material') != "")
            {
                $str_post_str .= '&material='.$this->input->post('material');
            }
            if($this->input->post('amount') != "")
            {
                $str_post_str .= '&amount='.$this->input->post('amount');
            }
            if($this->input->post('shade') != "")
            {
                $str_post_str .= '&shade='.$this->input->post('shade');
            }
            if($this->input->post('job_code') != "")
            {
                $str_post_str .= '&job_code='.$this->input->post('job_code');
            }
            // start day
            $str_post_str .= '&fday='.$this->input->post('fday');
            //echo $str_post_str; exit;
            // start month
            $str_post_str .= '&fmonth='.$this->input->post('fmonth');
            // start year
            $str_post_str .= '&fyear='.$this->input->post('fyear');
            //------------Register end date --------------------
            $str_post_str .= '&tday='.$this->input->post('tday');
            // start month
            $str_post_str .= '&tmonth='.$this->input->post('tmonth');
            // start year
            $str_post_str .= '&tyear='.$this->input->post('tyear');

            $recpage  = $this->config->item('recordperpage')/2;//number of records per page
            $starting = $this->input->post('starting');         //get counter which page record
            //if its the first page than show starting from 0
            if(!$starting)
            {
                $starting =0;
            }
            
            
            $records   = $this->register_model->search_records($starting,$recpage,FALSE);
            $rec_total = $this->register_model->search_records($starting,$recpage,TRUE);
            if($records)
            {
                /*$doc_rec   = $this->register_model->doc_rec();
                $doc_calc = array();
                foreach($doc_rec->result() as $gen_res){
                    @$doc_calc[$gen_res->dr_name."#".$gen_res->dr_code] += $gen_res->total_price;
                }
                $data['doc_calc']   = $doc_calc;*/
                $data['records']    = $records;
            }
            else
            {
                $data['records']    = '';
                $data['doc_calc']   = '';
            }
            $this->ajax_pagination_new->make_search(
                $rec_total,
                $starting,
                $recpage,
                $this->lang->line('first'),
                $this->lang->line('last'),
                $this->lang->line('prev'),
                $this->lang->line('next'),
                $this->lang->line('page'),
                $this->lang->line('of'),
                $this->lang->line('total'),
                base_url()."index.php/register/home/filter",
                'list_div1',
                $str_post_str
            );
             
            $data["search"] = TRUE;
            $data['page']   = $starting;
            $data['total']  = $this->ajax_pagination_new->total;
            //$data['page']   = $starting;
            $data['links']  = $this->ajax_pagination_new->anchors;
            //$data['total']  = $this->ajax_pagination->total;
            $this->load->view("filter/reg_filter_list",$data);
        }
        else
        {
            echo $this->load->view('unauthorized');
        }
    }

    /**
    * @desc filter copied function
    */
    function filter_bill()
    {
        // Check if user is supervisor, or has view role, or all view role, or dep all view role
        if(1)
        {         
            //echo "<pre>";print_r($_POST);exit;  
            $search_keys="";
            //integrate ajax pagination
            $str_post_str  = '&ajax=1';
            //integrate ajax pagination
            // name
            if($this->input->post('dr_code') != "")
            {
                $str_post_str .= '&dr_code='.$this->input->post('dr_code');
            }
            if($this->input->post('pay_amount') != "")
            {
                $str_post_str .= '&pay_amount='.$this->input->post('pay_amount');
            }
            // start day
            $str_post_str .= '&fday='.$this->input->post('fday');
            //echo $str_post_str; exit;
            // start month
            $str_post_str .= '&fmonth='.$this->input->post('fmonth');
            // start year
            $str_post_str .= '&fyear='.$this->input->post('fyear');
            //------------Register end date --------------------
            $str_post_str .= '&tday='.$this->input->post('tday');
            // start month
            $str_post_str .= '&tmonth='.$this->input->post('tmonth');
            // start year
            $str_post_str .= '&tyear='.$this->input->post('tyear');

            $recpage  = $this->config->item('recordperpage')/2;//number of records per page
            $starting = $this->input->post('starting');         //get counter which page record
            //if its the first page than show starting from 0
            if(!$starting)
            {
                $starting =0;
            }
            
            
            $records   = $this->register_model->search_bill($starting,$recpage,FALSE);
            $rec_total = $this->register_model->search_bill($starting,$recpage,TRUE);
            if($records)
            {
                $data['records']    = $records;
            }
            else
            {
                $data['records']    = '';
                $data['doc_calc']   = '';
            }
            $this->ajax_pagination_new->make_search(
                $rec_total,
                $starting,
                $recpage,
                $this->lang->line('first'),
                $this->lang->line('last'),
                $this->lang->line('prev'),
                $this->lang->line('next'),
                $this->lang->line('page'),
                $this->lang->line('of'),
                $this->lang->line('total'),
                base_url()."index.php/register/home/filter_bill",
                'list_div1',
                $str_post_str
            );
             
            $data["search"] = TRUE;
            $data['page']   = $starting;
            $data['total']  = $this->ajax_pagination_new->total;
            //$data['page']   = $starting;
            $data['links']  = $this->ajax_pagination_new->anchors;
            //$data['total']  = $this->ajax_pagination->total;
            $this->load->view("filter/bill_filter_list",$data);
        }
        else
        {
            echo $this->load->view('unauthorized');
        }
    }
}