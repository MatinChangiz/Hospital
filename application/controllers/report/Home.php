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
        $this->load->model(array('report/report_model','urn_model','register/register_model'));
        
        $this->amc_auth->is_logged_in();

    }

    function index()
    {
        // First take all the stored emergency reports and load emergency calls (119) police list
        $this->search();
        // If user is logged in
    }

    /**
    * @desc this function show list of all available records.
    */
    /**
    * @desc register list function
    */
    function search()
    {   
        //date and time dropdown data
        $data['days']           = $this->getDateDetails('days');
        $data['months']         = $this->getDateDetails('months');
        $data['years']          = $this->getDateDetails('years');                                               
        banner();
        sidebar();
        $modal = modal_popup();
        $content = $this->load->view('filter/report',$data,true);
        content($content);
        footer();
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
    function do_filter()
    {
        // Check if user is supervisor, or has view role, or all view role, or dep all view role
        if(1)
        {           
            $search_keys="";
            //integrate ajax pagination
            $str_post_str  = '&ajax=1';
            //integrate ajax pagination
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
            
            
            $records   = $this->report_model->search_records($starting,$recpage,FALSE);
            $rec_total = $this->report_model->search_records($starting,$recpage,TRUE);
            if($records)
            {
                //doctors total price between date
                $doc_rec   = $this->report_model->doc_rec();
                $doc_calc = array();
                foreach($doc_rec->result() as $gen_res){
                    @$doc_calc[$gen_res->dr_name."#".$gen_res->dr_code] += $gen_res->total_price;
                }
                //doctors total price till date
                $pr_calc = array();
                $dr_tPrice   = $this->report_model->datePrice();
                if($dr_tPrice){
                    foreach($dr_tPrice->result() as $pr_res){
                        @$pr_calc[$pr_res->dr_name] += $pr_res->total_price;
                    }
                }
                //echo "<pre>";print_r($pr_calc);exit;
                $data['records']    = $records;
                $data['doc_calc']   = $doc_calc;
                $data['pr_calc']    = $pr_calc;
            }
            else
            {
                $data['records']    = '';
                $data['doc_calc']   = '';
                $data['pr_calc']    = '';
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
                base_url()."index.php/report/home/do_filter",
                'list_div1',
                $str_post_str
            );
             
            $data["search"] = TRUE;
            $data['page']   = $starting;
            $data['total']  = $this->ajax_pagination_new->total;
            //$data['page']       = $page;
            $data['title']      = $this->lang->line("register_list");
            //$data['page']   = $starting;
            $data['links']  = $this->ajax_pagination_new->anchors;
            //$data['total']  = $this->ajax_pagination->total;
            $this->load->view("filter/report_filter_list",$data);
        }
        else
        {
            echo $this->load->view('unauthorized');
        }
    }

    /**
    * @desc print report
    */
    function genDBexelprint()
    {
        $allsql = $this->input->post('allsql');
        $allsql = $this->clean_encrypt->decode($allsql);
        //echo "<pre>".$allsql;exit;
        //Get data from the database (model)
        $reportObj = $this->report_model->doc_rec($allsql);
        $pr_calc = array();
        $dr_tPrice   = $this->report_model->datePrice();
        if($dr_tPrice){
            foreach($dr_tPrice->result() as $pr_res){
                @$pr_calc[$pr_res->dr_name] += $pr_res->total_price;
            }
        }
        //echo "<pre>";print_r($pr_calc);exit;
        if($reportObj !=false)
        {
            $this->load->helper('phpexcel');
            //$excel = new PHPExcel();
            $file = "templates/excel_temp.xlsx";
            $inputFileType = PHPExcel_IOFactory::identify($file);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $excel = $objReader->load("templates/excel_temp.xlsx");
            $excel->getProperties()
                ->setCreator("WEOPREG")
                ->setLastModifiedBy("WEOPREG")
                ->setTitle("WEOPREG")
                ->setSubject("WEOPREG")
                ->setDescription("WEOPREG")
                ->setKeywords("WEOPREG")
                ->setCategory("WEOPREG");
            $excel->setActiveSheetIndex(0);
    
            $excel->getActiveSheet()->getSheetView()->setZoomScale(100);
            $rotation = 0;
            ini_set('memory_limit','4026M');
            $excel->getActiveSheet()->setShowGridlines(FALSE);
            $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
            $excel->getActiveSheet()->getPageSetup()->setFitToPage(true);
            $excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
            $excel->getActiveSheet()->getPageMargins()->setTop(0.8);
            $excel->getActiveSheet()->getPageMargins()->setRight(0.8);
            $excel->getActiveSheet()->getPageMargins()->setLeft(0.8);
            $excel->getActiveSheet()->getPageMargins()->setBottom('0.3');
            $excel->getActiveSheet()->getPageMargins()->setFooter('0.3');
            $excel->getActiveSheet()->getPageMargins()->setHeader('0.3');

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

            $styleArray = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('argb' => 'ffffff'),
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'rotation' =>$rotation,
                ),
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => 'ffffff'),
                    ),
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
                        'rotation' => $rotation,
                        'startcolor' => array(
                            'argb' => '223962',
                        ),
                        'endcolor' => array(
                            'argb' => '223962',
                    ),
                ),
            );

            $signature = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('argb' => '223962'),
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'rotation' =>$rotation,
                ),
            );
                  
            //Start title
            $excel->getActiveSheet()->setShowGridlines(FALSE);
            
            $i              =1;
            $counter        = 3;
            $remain         = 0;
            $remains        = 0;
            $totalall       = 0;
            $dr_dup_arr     = "";
            $iTotalPrice    = "0";
            $iTotalPaid     = "0";
            $iTotalRemain   = "0";
            $iTotalPayable  = "0";
            $the_remian     = "0";
            //$totalRecords = $reportObj->num_rows();
            foreach($reportObj->result() AS $item)
            {
                $iTotalPrice += $item->total_price;
                @$dr_dup_arr[$item->dr_name] .= "#".$item->total_price;
                $excel->getActiveSheet()->getStyle('A'.$counter.':M'.$counter)->applyFromArray($border);
                $excel->getActiveSheet()->getStyle('A'.$counter.':M'.$counter)->getAlignment()->setWrapText(true);
                //sest text direction right to left
                $excel->getActiveSheet()->setCellValue('A'.$counter,$i);
                $excel->getActiveSheet()->setCellValue('B'.$counter,$this->register_model->nameByUrn('doctors',$item->dr_name,'dr_name'));
                $excel->getActiveSheet()->setCellValue('C'.$counter,$item->dr_code);
                
                $excel->getActiveSheet()->setCellValue('D'.$counter,$item->shade);
                $excel->getActiveSheet()->setCellValue('E'.$counter,$item->job_code);
                $excel->getActiveSheet()->setCellValue('F'.$counter,$this->register_model->nameByUrn('materials',$item->material,'name'));
                $excel->getActiveSheet()->setCellValue('G'.$counter,$item->amount);
                $excel->getActiveSheet()->setCellValue('H'.$counter,$item->price);
                $excel->getActiveSheet()->setCellValue('I'.$counter,$item->total_price);
                $date_arr = explode(" ",$item->registerdate);
                $excel->getActiveSheet()->setCellValue('M'.$counter,@$date_arr[0]);
                $counter++;
                $i++;
            }
            $merge_counter = 3;
            if($dr_dup_arr !=""){
                foreach($dr_dup_arr as $dup=>$val){
                    $paid           = $this->paid($dup);
                    $tot            = $this->totalPrice($dup);
                    //$remain         = $tot-$paid;
                    //calculation
                    if(!empty($pr_calc)){
                        $toDateTotal = $pr_calc[$dup];
                        if(intval($toDateTotal) > intval($paid)){
                            $remain = intval($toDateTotal)-intval($paid);
                            //calculate paid price
                            if(intval($tot)>intval($remain)){
                                $paid   = intval($tot)-intval($remain);
                            }else{
                                $paid   = "0";
                            }
                            //calculatee remain price
                            if($remain > $tot){
                                $the_remian = intval($remain)-intval($tot);
                            }else{
                                $the_remian = $remain;
                            }
                        }else{
                            $paid = $tot;
                        }
                    }
                    $iTotalPaid     += $paid;
                    $iTotalRemain   += $the_remian;
                    $iTotalPayable  += $remain;
                    //calc merge
                    $merge_count = count(explode("#",$val))-2;
                    $to = $merge_counter+$merge_count;
                    $excel->getActiveSheet()->mergeCells('J'.$merge_counter.':J'.$to);
                    $excel->getActiveSheet()->mergeCells('K'.$merge_counter.':K'.$to);
                    $excel->getActiveSheet()->mergeCells('L'.$merge_counter.':L'.$to);
                    $excel->getActiveSheet()->setCellValue('J'.$merge_counter,$paid);
                    $excel->getActiveSheet()->setCellValue('K'.$merge_counter,$the_remian);
                    $excel->getActiveSheet()->setCellValue('L'.$merge_counter,$remain);
                    $merge_counter = $merge_counter+$merge_count+1;
                }
            }
            $icount = $counter;
            $scount = $counter+1;
            $excel->getActiveSheet()->mergeCells('A'.$icount.':H'.($icount));
            $excel->getActiveSheet()->getStyle('A'.$icount.':M'.$icount)->applyFromArray($styleArray);
            $excel->getActiveSheet()->setCellValue('A'.$icount,"Total");
            $excel->getActiveSheet()->setCellValue('I'.$icount,$iTotalPrice);
            $excel->getActiveSheet()->setCellValue('J'.$icount,$iTotalPaid);
            $excel->getActiveSheet()->setCellValue('K'.$icount,$iTotalRemain);
            $excel->getActiveSheet()->setCellValue('L'.$icount,$iTotalPayable);
            $excel->getActiveSheet()->getRowDimension($icount)->setRowHeight(24);
            //signature
            $excel->getActiveSheet()->getStyle('A'.$scount.':M'.($scount+1))->applyFromArray($signature);
            $excel->getActiveSheet()->mergeCells('A'.$scount.':M'.($scount+1));
            $excel->getActiveSheet()->setCellValue('A'.$scount,"Signature");
            
            ob_end_clean();
            $name = "report";
            // redirect to cleint browser
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment;filename=$name.xlsx");
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $objWriter->save('php://output');

        }
    }

    //paid amount
    function paid($dr_urn){
        $details_rec   = $this->report_model->getDetailsRec($dr_urn);
        //echo "<pre>";print_r($details_rec);exit;
        $paid = "0";
        if($details_rec){
            foreach($details_rec as $drc){
                $paid += $drc->paid_amount;
            }
        }
        return $paid;
    }

    //total price
    function totalPrice($dr_urn){
        $details_rec   = $this->report_model->getTotalPrice($dr_urn);
        //echo "<pre>";print_r($details_rec);exit;
        $paid = "0";
        if($details_rec){
            foreach($details_rec as $drc){
                $paid += $drc->total_price;
            }
        }
        return $paid;
    }
}