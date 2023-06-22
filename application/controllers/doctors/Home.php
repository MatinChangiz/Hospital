<?php
/**
*@author: Aziz Matin
*@created Date: 225-OCT-2021
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
        $this->load->library('Ajax_pagination_new');
        $this->load->library('Clean_encrypt');
        $this->load->library('Amc_auth');
        $this->amc_auth->is_logged_in();  
        //helper
        $this->load->helper('datecheck');
        //load libraries
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('user_agent');
        //load language file
        $this->lang->load("home");
        $this->lang->load("global");
        //load models
        $this->load->model(array('doctors/doctor_model','urn_model','document/document_model'));
    }

    /**
    * @desc index function
    */
    public function index()
    {
        $this->listRecords();
    }
    
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
        $records   = $this->doctor_model->getAllrecords($starting,$recpage,FALSE);
        $rec_total = $this->doctor_model->getAllrecords($starting,$recpage,TRUE);
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
            base_url()."index.php/doctors/home/listRecords",
            'list_div1',
            $str_post_str
        );
         
        $data["search"] = FALSE;
        $data['page']   = $starting;
        $data['total']  = $this->ajax_pagination_new->total;
        $data['links']  = $this->ajax_pagination_new->anchors;  

        $data['days']           = $this->getDateDetails('days');
        $data['months']         = $this->getDateDetails('months');
        $data['years']          = $this->getDateDetails('years');
           
        //date and time dropdown data 
        $data['filter']         = $this->load->view("filter/doctor_filter",$data,true); 
        if($this->input->post('ajax')==1)
        {
            $data["search"] = TRUE;
            $this->load->view('filter/doctor_filter_list',$data);
        }else{                                                   
            banner();
            sidebar();
            $modal = modal_popup();
            $content = $this->load->view('doctors/list',$data,true);
            content($content);
            footer();
        }
    }
    
    /**
    * @desc add to the register
    */
    function add($queue_urn = 0)
    {
        if(0){
            echo "You are not loged in";exit;
        }else{
            $this->form_validation->set_rules('dr_name[]', 'dr_name[]', 'trim');
            $this->form_validation->set_rules('dr_code[]', 'dr_code[]', 'trim');
            if($this->form_validation->run() == FALSE){
                //load views and templates
                $data = array();
                banner();
                sidebar();
                $modal = modal_popup();
                $content = $this->load->view("doctors/add",$data,true);
                content($content);
                footer();
            }
            else{
                $updateDrug = "";
                $dr_name        = $this->input->post('dr_name');  
                //print_r($_POST);exit; 
                $dr_code        = $this->input->post('dr_code');       
                $contact        = $this->input->post('contact');       
                $drug_data = array();
                foreach($dr_name AS $key=>$value){
                    if($dr_name[$key] != ''){
                        $drug_data = array(
                            "dr_name"                   => $dr_name[$key],
                            "dr_code"                   => $dr_code[$key],
                            "contact"                   => $contact[$key],
                            "registerdate"              => date("Y-m-d")
                        );
                        $drug_urn = $this->urn_model->getURN('doctors','urn');
                        $updateDrug = $this->doctor_model->update('doctors',$drug_urn,$drug_data,1000001,"INSERT");
                    }
                }
                if($updateDrug){
                    redirect("doctors/home/listRecords",'refresh');
                }     
            }
        }
    }
    
    /**
    * @desc edit registered data
    */
    function edit($urn = 0)
    {
        if(0){
            echo "You are not loged in";exit;
        }else{
            $dec_urn = $this->clean_encrypt->decode($urn);
            $this->form_validation->set_rules('dr_name', 'dr_name', 'trim');
            $this->form_validation->set_rules('dr_code', 'dr_code', 'trim');
            if($this->form_validation->run() == FALSE){
                $data = "";
                $records = false;
                //top title
                $data['title'] = $this->lang->line("register_edit");
                $records = $this->doctor_model->getViewRecords($dec_urn);
                
                $data["record"]             = $records[0];
                $data["enc_urn"]            = $urn;
                
                //load views and templates
                banner();
                sidebar();
                $modal = modal_popup();
                //the views if the record is exist
                $content = $this->load->view("doctors/edit",$data,true);
                content($content);
                footer(); 
            }
            else{
                $updateDrug = "";
                $dr_name        = $this->input->post('dr_name');  
                $dr_code        = $this->input->post('dr_code');       
                $contact        = $this->input->post('contact');       
                $drug_data = array(
                    "dr_name"                   => $dr_name,
                    "dr_code"                   => $dr_code,
                    "contact"                   => $contact,
                    "is_updated"               => 1
                );
                $updateDrug = $this->doctor_model->update('doctors',$dec_urn,$drug_data,1000001,"UPDATE");
                if($updateDrug){
                    redirect("doctors/home/listRecords/$urn",'refresh');
                }     
            }
        }
    }
    
    /**
    * @desc multiple function
    */
    function multiple()
    {
        //echo "<pre>";print_r($_POST);exit;
        $counter = $this->input->post('no');
        $dr_name = $this->lang->line('dr_name');
        $dr_code = $this->lang->line('dr_code');
        $contact = $this->lang->line('contact');
        $base_url = base_url();
        $content = "";
        if($counter >0){
            $content .= "<table class=\"table\" id=\"imRemovable$counter\">
                            <tr>
                                <td scope=\"col\" width=\"33%\" class=\"iEntry\" colspan=\"3\">
                                    <span class=\"btn btn-danger ino\">$counter</span><input type=\"button\" id=\"rm\" class=\"btn btn-danger\" value=\"-\" onclick=\"javascript:removeElement('imRemovable$counter','$counter');\" >
                                </td>
                            </tr>
                            <tr> 
                                <td scope=\"col\" width=\"33%\" class=\"iEntry\">
                                    <div class=\"inputfield\">
                                        <div class=\"rLabel\">
                                            <label class=\"\" for=\"textinput\">$dr_name : </label>                
                                        </div>
                                        <div class=\"textfield btm20padding\">
                                            <input id=\"dr_name[]\" name=\"dr_name[]\" type=\"text\" placeholder=\"$dr_name\" class=\"form-control iInput\" >     
                                        </div>
                                    </div>
                                </td>
                                <td scope=\"col\" width=\"33%\" class=\"iEntry\">
                                    <div class=\"inputfield\">
                                        <div class=\"rLabel\">
                                            <label class=\"\" for=\"textinput\">$dr_code : </label>                
                                        </div>
                                        <div class=\"textfield btm20padding\">
                                            <input id=\"dr_code[]\" name=\"dr_code[]\" type=\"text\" placeholder=\"$dr_code\" class=\"form-control iInput\">     
                                        </div>
                                    </div>    
                                </td>
                                <td scope=\"col\" width=\"34%\" class=\"iEntry\">
                                    <div class=\"inputfield\">
                                        <div class=\"rLabel\">
                                            <label class=\"\" for=\"textinput\">$contact : </label> 
                                        </div>
                                        <div class=\"textfield btm20padding\">
                                            <input id=\"contact[]\" name=\"contact[]\" type=\"text\" placeholder=\"$contact\" class=\"form-control iInput\">     
                                        </div>
                                    </div>    
                                </td> 
                            </tr>
                         </table>";
        }
        echo $content;
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
    
    /**
    * @desc filter copied function
    */
    function filter()
    {
        // Check if user is supervisor, or has view role, or all view role, or dep all view role
        if(1)
        {           
            $search_keys="";
            //integrate ajax pagination
            $str_post_str  = '&ajax=1';
            //integrate ajax pagination
            // name
            if($this->input->post('dr_name') != "")
            {
                $str_post_str .= '&dr_name='.$this->input->post('dr_name');
            }
            // name
            if($this->input->post('dr_code') != "")
            {
                $str_post_str .= '&dr_code='.$this->input->post('dr_code');
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
            
            
            $records   = $this->doctor_model->search_records($starting,$recpage,FALSE);
            $rec_total = $this->doctor_model->search_records($starting,$recpage,TRUE);
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
                base_url()."index.php/doctors/home/filter",
                'list_div1',
                $str_post_str
            );
             
            $data["search"] = TRUE;
            $data['page']   = $starting;
            $data['total']  = $this->ajax_pagination_new->total;
            $data['links']  = $this->ajax_pagination_new->anchors;
            //$data['total']  = $this->ajax_pagination->total;
            $this->load->view("filter/doctor_filter_list",$data);
        }
        else
        {
            echo $this->load->view('unauthorized');
        }
    }
    
    function genDBexelprint()
    {
        $allsql = $this->input->post('allsql');
        $allsql = $this->clean_encrypt->decode($allsql);
        //echo "<pre>".$allsql;exit;
        //Get data from the database (model)
        $reportObj = $this->drug_model->search_records($allsql);

        //echo "<pre>";print_r($reportObj);exit;

        if($reportObj !=false)
        {
            $this->load->helper('phpexcel');
            $excel = new PHPExcel();
            $excel->getProperties()
                ->setCreator("WEOPREG")
                ->setLastModifiedBy("WEOPREG")
                ->setTitle("WEOPREG")
                ->setSubject("WEOPREG")
                ->setDescription("WEOPREG")
                ->setKeywords("WEOPREG")
                ->setCategory("WEOPREG");
            $excel->setActiveSheetIndex(0);
            // we are selecting a worksheet
            $excel->getActiveSheet()->setTitle($this->lang->line('drug_reports'));
            $excel->getActiveSheet()->getSheetView()->setZoomScale(100);
            //$lang = $this->mng_auth->get_language();
            $excel->getActiveSheet()->setRightToLeft(true);
            $rotation = -90;
            ini_set('memory_limit','4026M');
            $excel->getActiveSheet()->setShowGridlines(true);
            $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
            $excel->getActiveSheet()->getPageMargins()->setTop(0.8);
            $excel->getActiveSheet()->getPageMargins()->setRight(0.3);
            $excel->getActiveSheet()->getPageMargins()->setLeft(0.3);
            $excel->getActiveSheet()->getPageMargins()->setBottom('0.3');
            $excel->getActiveSheet()->getPageMargins()->setFooter('0.3');
            $excel->getActiveSheet()->getPageMargins()->setHeader('0.3');
            $styleArrayTitles = array
            (
                'font' => array(
                    'bold' => TRUE,
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    ),
            );

            //NO style
            $styleArray = array(
                'font' => array(
                    'bold' => true,
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'rotation' =>$rotation,
                ),
                'borders' => array(
                                    'allborders' => array(
                                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                                            'color' => array('argb' => '#DBDBB7'),
                                        ),
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
                        'rotation' => $rotation,
                        'startcolor' => array(
                            'argb' => 'CCCCCC',
                        ),
                        'endcolor' => array(
                            'argb' => 'CCCCCC',
                    ),
                ),
            );
            //NO style
            $styleTitles = array(
                'font' => array(
                    'bold' => true,
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ),
                'borders' => array(
                                    'allborders' => array(
                                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                                            'color' => array('argb' => '#FFFFFF'),
                                        ),
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
                        'startcolor' => array(
                            'argb' => '00bcd4',
                        ),
                        'endcolor' => array(
                            'argb' => '00bcd4',
                    ),
                ),
            );


            $border = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => '00000000'),
                    ),
                ),
                'alignment' => array
                (
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ),
            );
            //Start title
            $countrow = 1;
            $excel->getActiveSheet()->getStyle('A'.$countrow.':H'.$countrow)->applyFromArray($border);
            $excel->getActiveSheet()->mergeCells('A'.$countrow.':H'.$countrow);
            $excel->getActiveSheet()->getRowDimension($countrow)->setRowHeight(30);
            $excel->getActiveSheet()->getRowDimension(2)->setRowHeight(30);

            $excel->getActiveSheet()->getStyle('A'.$countrow)->getFont()->setSize(14);
            //No
            $countrow++;
        
            ////number
            $excel->getActiveSheet()->setCellValue('A1',$this->lang->line('drug_reports'));
            $excel->getActiveSheet()->setCellValue('A'.$countrow,$this->lang->line('id'));
            $excel->getActiveSheet()->setCellValue('B'.$countrow,$this->lang->line('drugs'));
            $excel->getActiveSheet()->setCellValue('C'.$countrow,$this->lang->line('drug_type'));
            $excel->getActiveSheet()->setCellValue('D'.$countrow,$this->lang->line('amount'));
            $excel->getActiveSheet()->setCellValue('E'.$countrow,$this->lang->line('buy_price'));
            $excel->getActiveSheet()->setCellValue('F'.$countrow,$this->lang->line('sale_price'));
            $excel->getActiveSheet()->setCellValue('G'.$countrow,$this->lang->line('total_buy'));
            $excel->getActiveSheet()->setCellValue('H'.$countrow,$this->lang->line('total_sale'));

            $excel->getActiveSheet()->getStyle('A'.$countrow.':H'.($countrow))->applyFromArray($styleTitles);
            $countrow++;


            $excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
            $excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $excel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
            $excel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
            $excel->getActiveSheet()->getColumnDimension('E')->setWidth(18);
            $excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);


            $totalcal=0;
            $counter = 1;
            $countrow = 3;
            $fee = 0;
            $remains = 0;
            $totalRecords = $reportObj->num_rows();
            foreach($reportObj->result() AS $item)
            {
                $total_buy = $item->amout*$item->buy_price;
                $total_sale = $item->amout*$item->sale_price;
                $excel->getActiveSheet()->setCellValue('A'.$countrow,$counter);
                $excel->getActiveSheet()->setCellValue('B'.$countrow,$item->name);
                $excel->getActiveSheet()->setCellValue('C'.$countrow,$item->type);
                $excel->getActiveSheet()->setCellValue('D'.$countrow,$item->amout);
                $excel->getActiveSheet()->setCellValue('E'.$countrow,$item->buy_price);
                $excel->getActiveSheet()->setCellValue('F'.$countrow,$item->sale_price);
                $excel->getActiveSheet()->setCellValue('G'.$countrow,$total_buy);
                $excel->getActiveSheet()->setCellValue('H'.$countrow,$total_sale);
                
                $amount +=  $item->amout;
                $buy +=  $item->buy_price;
                $buy_total +=  $total_buy;
                $sale +=  $item->sale_price;
                $sale_total +=  $total_sale;
                
                $counter++;
                $countrow++;
            }


            $excel->getActiveSheet()->mergeCells('A'.$countrow.':C'.($countrow));
            $excel->getActiveSheet()->setCellValue('A'.$countrow,$this->lang->line('total'));
            $excel->getActiveSheet()->getStyle('A'.$countrow)->getFont()->setSize(14);
            $excel->getActiveSheet()->getRowDimension($countrow)->setRowHeight(24);
            
            $excel->getActiveSheet()->setCellValue('D'.$countrow,$amount);
            $excel->getActiveSheet()->setCellValue('E'.$countrow,$buy);
            $excel->getActiveSheet()->setCellValue('F'.$countrow,$sale);
            $excel->getActiveSheet()->setCellValue('G'.$countrow,$buy_total);
            $excel->getActiveSheet()->setCellValue('H'.$countrow,$sale_total);
            $excel->getActiveSheet()->getStyle('A3:H'.($countrow))->applyFromArray($border);
            $excel->getActiveSheet()->getStyle('A3:H'.($countrow-1))->getAlignment()->setWrapText(true);
            ob_end_clean();
            $name = $this->lang->line('drug_reports');
            // redirect to cleint browser
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment;filename=$name.xlsx");
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $objWriter->save('php://output');

        }
    }

    function delete($urn = 0)
    {
        $dec_urn = $this->clean_encrypt->decode($urn);
        $delete = $this->doctor_model->delete('doctors',$dec_urn);
        if($delete){
            redirect("doctors/home/listRecords/$urn",'refresh');
        }
    }
}
?>