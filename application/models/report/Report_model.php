<?php
/**
*@author: Aziz Matin
*@created Date: 25-OCT-2021
**/
defined('BASEPATH') OR exit('No direct script access allowed');
class Report_model extends CI_Model {
    //construct function
    function __construct()
    {
        parent::__construct();
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
          doctors       AS t1
        ');
        if(!$isTotal)
        {
            $this->db->limit($limit, $offset);

            //order the records
            $this->db->order_by("t1.urn","DESC");

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
    
    //get view records
    function getViewRecords($urn = 0)
    {
        $this->db->select('*');
        $this->db->from('doctors');
        $this->db->where ('urn', $urn);
        $query = $this->db->get();  
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
        $dateSql             = "1";
        //check for register date
        $dateSql .= " AND ".searchdate
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
          registeration   AS  t1
        ');
        if(($this->input->post('fday') != "00" && $this->input->post('fmonth') != "00" && $this->input->post('fyear') != "0000") OR ($this->input->post('tday') != "00" && $this->input->post('tmonth') != "00" && $this->input->post('tyear') != "0000")){
            $this->db->where($dateSql,null,false);
        }
        
        // name
        if($this->input->post('dr_code') != '' && $this->input->post('dr_code') != 0)
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

    /**
    * @desc This function's usage is to search emergency call report
    */
    function doc_rec()
    {
        $dateSql             = "1";
        //check for register date
        $dateSql .= " AND ".searchdate
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
        $this->db->from('
          registeration   AS  t1
        ');
        if(($this->input->post('fday') != "00" && $this->input->post('fmonth') != "00" && $this->input->post('fyear') != "0000") OR ($this->input->post('tday') != "00" && $this->input->post('tmonth') != "00" && $this->input->post('tyear') != "0000")){
            $this->db->where($dateSql,null,false);
        }
        // name
        if($this->input->post('dr_code') != '' && $this->input->post('dr_code') != 0)
        {
            $this->db->where('t1.dr_code',$this->input->post('dr_code'));
        }
        //order the records
        $this->db->order_by("t1.dr_name","ASC");
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

    /**
    * @desc This function's usage is to search emergency call report
    */
    function datePrice()
    {
        $dateSql             = "1";
        //check for register date
        $dateSql .= " AND ".searchDatePrice
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
        $this->db->select('sum(t1.total_price) as total_price, t1.dr_name');
        $this->db->from('
          registeration   AS  t1
        ');
        if($dateSql != "1"){
            $this->db->where($dateSql,null,false);
        }
        // name
        if($this->input->post('dr_code') != '' && $this->input->post('dr_code') != 0)
        {
            $this->db->where('t1.dr_code',$this->input->post('dr_code'));
        }
        //order the records
        $this->db->order_by("t1.dr_name","ASC");
        $this->db->group_by("t1.dr_name");

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

    //get details of records
    function getDetailsRec($urn = 0)
    {
        $this->db->select('dr_urn,dr_code,paid_amount');
        $this->db->from('financial');
        $this->db->where ('dr_urn', $urn);
        $query = $this->db->get();  
        //echo "<pre/>".$this->db->last_query(); exit;
        if($query && $query->num_rows()>0){
            return $query->result();
        }  
        else{
            return false;
        }
    }

    //get total price
    function getTotalPrice($urn = 0)
    {
        $dateSql             = "1";
        //check for register date
        $dateSql .= " AND ".searchdate
        (
            $this->input->post('fday'),
            $this->input->post('fmonth'),
            $this->input->post('fyear'),
            $this->input->post('tday'),
            $this->input->post('tmonth'),
            $this->input->post('tyear'),
            'date_format(registerdate,"%Y-%m-%d")',
            'en'
        );
        $this->db->select('sum(total_price) as total_price');
        $this->db->from('registeration');
        if($dateSql != "1"){
            $this->db->where($dateSql,null,false);
        }
        $this->db->where ('dr_name', $urn);
        $query = $this->db->get();  
        //echo "<pre/>".$this->db->last_query(); exit;
        if($query && $query->num_rows()>0){
            return $query->result();
        }  
        else{
            return false;
        }
    }
}
?>