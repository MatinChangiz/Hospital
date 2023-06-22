<?php
/**
*@author: Aziz Matin
*@created Date: 20-Feb-2019
**/
defined('BASEPATH') OR exit('No direct script access allowed');
class Pricing_model extends CI_Model {
    //construct function
    function __construct()
    {
        parent::__construct();
    }

    //insert and update function
    function update($table = "",$urn = 0, $data = array(), $user_id = 0, $action = "INSERT")
    {
        if (is_array($data) AND !empty($data)) {
            $table_urn = array('urn' => $urn);
            $data = array_merge($data,$table_urn);
            //echo "<pre>";print_r($data);exit;
            $this->db->trans_start();
            $log_data = array();
            if($user_id != 0){
                $log = array(
                    'urn' => $urn,
                    'userid' => $user_id,
                    'logid' => $urn,
                    'action' => $action,
                    'logdate' => date('Y-m-d H:i:s'),
                    'logip' => $_SERVER['REMOTE_ADDR']
                );
            }else{
                $log = array();
                //$log = array('urn' => $urn);
            }
            $log_data = array_merge($data,$log);
            if($action == "UPDATE"){
                $this->db->where('urn',$urn);
                $this->db->update($table,$data);
            }elseif($action == "INSERT"){
                $this->db->insert($table,$data);
            }
            $this->db->insert($table.'_log',$log_data);
            $this->db->trans_complete();
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    //get view records
    function getViewRecords($urn = 0)
    {
        $this->db->select('*');
        $this->db->from('pricing');
        $this->db->where ('urn', $urn);
        $query = $this->db->get();  
        if($query && $query->num_rows()>0){
            return $query->result();
        }  
        else{
            return false;
        }
    }
    
    //get teeth records
    function getTeethRecords($urn = 0)
    {
        $this->db->select('*');
        $this->db->from('teeth');
        $this->db->where ('register_urn', $urn);
        $query = $this->db->get();  
        if($query && $query->num_rows()>0){
            return $query->result();
        }  
        else{
            return false;
        }
    }
    
    //get Drug records
    function getDrugRecords($urn = 0)
    {
        $this->db->select('*');
        $this->db->from('spent_drug');
        $this->db->where ('parent_urn', $urn);
        $query = $this->db->get();  
        if($query && $query->num_rows()>0){
            return $query->result();
        }  
        else{
            return false;
        }
    }
    
    //get all records
    function getAllrecords($offset=0,$limit=0,$isTotal=FALSE)
    {
        $allSql             = "1";
        if(!$isTotal)
        {
            $this->db->select
                            ('
                              t1.*
                            ');
        }
        $this->db->from('
          pricing       AS t1
        ');
        if(!$isTotal)
        {
            $this->db->limit($limit, $offset);

            //order the records
            $this->db->order_by("t1.urn","DESC");
            $this->db->group_by("t1.urn");

            $query=$this->db->get();
            //echo "<pre/>".$this->db->last_query(); exit;

            if($query->num_rows() > 0)
            {
                return $query;
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            return $this->db->count_all_results();
        }
    }
            
    //get queue by urn
    function getQueueByURN($urn =0)
    {
        $this->db->select('*');
        $this->db->from('queue');
        $this->db->where ('urn', $urn);
        $query = $this->db->get();  
        if($query && $query->num_rows()>0){
            return $query->result();
        }  
        else{
            return false;
        }
    }
    
    //doctors lsits
    function doctors()
    {
        $this->db->select('*');
        $this->db->from('doctors');
        $query = $this->db->get();  
        if($query && $query->num_rows()>0){
            return $query->result();
        }  
        else{
            return false;
        }    
    }
    
    function material(){
        $this->db->select('*');
        $this->db->from('materials');
        $query = $this->db->get();  
        if($query && $query->num_rows()>0){
            return $query->result();
        }  
        else{
            return false;
        }
    }

    //get doctor name 
    function doctorName($urn = 0)
    {
        $this->db->select('name');
        $this->db->from('doctors');
        if($urn != 0){
            $this->db->where ('urn', $urn);
        }
        $query = $this->db->get();  
        if($query && $query->num_rows()>0){
            $name = $query->result();
            return $name[0]->name;
        }  
        else{
            return false;
        } 
    }
    
    //insert and update function
    function updateTeeth($table = "",$urn = 0, $data = array(), $user_id = 0, $action = "INSERT", $type = 0)
    {
        if (is_array($data) AND !empty($data)) {
            $table_urn = array('urn' => $urn);
            $data = array_merge($data,$table_urn);
            //echo "<pre>";print_r($data);exit;
            $this->db->trans_start();
            $log_data = array();
            if($user_id != 0){
                $log = array(
                    'urn' => $urn,
                    'userid' => $user_id,
                    'logid' => $urn,
                    'action' => $action,
                    'logdate' => date('Y-m-d H:i:s'),
                    'logip' => $_SERVER['REMOTE_ADDR']
                );
            }else{
                $log = array();
                //$log = array('urn' => $urn);
            }
            $log_data = array_merge($data,$log);
            if($action == "UPDATE"){
                $this->db->where('urn',$urn);
                $this->db->update($table,$data);
            }elseif($action == "INSERT"){
                $this->db->insert($table,$data);
            }
            $this->db->insert($table.'_log',$log_data);
            $this->db->trans_complete();
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    //get search records
    function getFilterRecords($per_page = 0, $ofset = 0, $str_post = 1)
    {
        $name = 1;
        $f_name = 1;
        $contact = 1;
        $visit = 1;
        $fee = 1;
        $remain = 1;  
        $where = 1;
        
        if($this->input->post('name') !=''){
            $name = "t1.name =".'"'.$this->input->post('name').'"';
        }
        
        if($this->input->post('f_name') !=''){
            $f_name = "t1.f_name =".'"'.$this->input->post('f_name').'"';
        }
        
        $where = $name." AND ".$f_name;
        $this->db->select('t1.*');
        $this->db->from('register AS t1');
        if($per_page != 0){
            $this->db->limit($per_page,$ofset);
        }
        if($where != 1){
            $this->db->where($where,Null,False);
        }
        $this->db->order_by('t1.id','DESC');
        $query = $this->db->get();  
        //echo "<pre>";print_r($this->db->last_query());exit;
        if($query && $query->num_rows()>0){
            return $query->result();
        }  
        else{
            return false;
        }
    }
    
    /**
    * @desc This function's usage is to search emergency call report
    */
    function search_records($offset=0,$limit=0,$isTotal=FALSE)
    {
        $allSql             = "1";
        //check for register date
        $allSql .= " AND ".searchdate
        (
            $this->input->post('fday'),
            $this->input->post('fmonth'),
            $this->input->post('fyear'),
            $this->input->post('tday'),
            $this->input->post('tmonth'),
            $this->input->post('tyear'),
            'date_format(t1.registerdate,"%Y-%m-%d")',
            'en'
        );
        if(!$isTotal)
        {
            $this->db->select
                            ('
                              t1.*
                            ');
        }
        $this->db->from('
          pricing       AS t1
        ');
        $this->db->where($allSql,null,false);
        
        // name
        if($this->input->post('material') != '0')
        {
            $this->db->where('t1.material_urn',$this->input->post('material'));
        }
        // name
        if($this->input->post('dr_code') != '')
        {
            $this->db->where('t1.dr_code',$this->input->post('dr_code'));
        }
        if(!$isTotal)
        {
            $this->db->limit($limit, $offset);

            //order the records
            $this->db->order_by("t1.urn","DESC");
            $this->db->group_by("t1.urn");

            $query=$this->db->get();
            //echo "<pre/>".$this->db->last_query(); exit;

            if($query->num_rows() > 0)
            {
                return $query;
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            return $this->db->count_all_results();
        }
    }
    
    //get static name by urn
    function getStaticName($urn,$code)
    {
        $this->db->select('*');
        $this->db->from("stable");
        $this->db->where("urn",$urn);  
        $this->db->where("code",$code);  
        $query = $this->db->get();  
        if($query && $query->num_rows()>0){
            return $query->result();
        }  
        else{
            return false;
        }    
    }
    
    //get patient used drug price
    function getDrugPrice($urn = 0)
    {
        $this->db->select_sum('total_price');
        $this->db->from('spent_drug');
        $this->db->where("parent_urn",$urn);
        $query = $this->db->get();  
        if($query && $query->num_rows()>0){
            return $query->result();
            //return $query->result_array();
        }  
        else{
            return false;
        }    
    }

    //get register data
    function getDrCode($urn = 0)
    {
        $this->db->select('*');
        $this->db->from('doctors');
        if($urn){
            $this->db->where ('urn', $urn); 
        } 
        $query = $this->db->get();  
        if($query && $query->num_rows()>0){
            return $query->result();
        }  
        else{
            return false;
        }
    }

    //get register data
    function nameByUrn($table = 'doctors', $urn = 0, $feild = 'id')
    {
        $this->db->select($feild);
        $this->db->from($table);
        $this->db->where ('urn', $urn);  
        $query = $this->db->get();  
        if($query && $query->num_rows()>0){
            return $query->row()->$feild;
        }  
        else{
            return false;
        }
    }

    //check if price set for doctor
    function checkIfExist()
    {
        $this->db->select('dr_urn');
        $this->db->from('pricing');
        $this->db->group_by("dr_urn");
        $query = $this->db->get();  
        //echo "<pre>";print_r($this->db->last_query());exit;
        if($query && $query->num_rows()>0){
            return $query->result();
        }  
        else{
            return false;
        }
    }
}
?>