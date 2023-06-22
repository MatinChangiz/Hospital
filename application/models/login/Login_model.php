<?php
/**
*@author: Aziz Matin
*@created Date: 20-Feb-2019
**/
defined('BASEPATH') OR exit('No direct script access allowed');
class Login_model extends CI_Model {
    
    //construct
    function __construct()
    {
        parent::__construct();
    }

    //get urn
    function getURN($table = '',$field = '')
    {
        $result = $this->db->query("SELECT $field FROM $table ORDER BY id DESC LIMIT 1");
        //echo $this->db->last_query();exit;
        if($result->num_rows()>0){
            return $result->row()->$field+1;
        }else{
            return 1000001;
        }
    }
    
    //get teeth records
    function getAllrecords($per_page = 0, $ofset = 0)
    {
        $this->db->select('*');
        $this->db->from('users');
        if($per_page != 0){
            $this->db->limit($per_page,$ofset);
        }
        $this->db->order_by('id','DESC');
        $query = $this->db->get();  
        if($query && $query->num_rows()>0){
            return $query->result();
        }  
        else{
            return false;
        }
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
                    'user_id' => $user_id,
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
        $this->db->from('users');
        $this->db->where ('urn', $urn);
        $query = $this->db->get();  
        if($query && $query->num_rows()>0){
            return $query->result();
        }  
        else{
            return false;
        }
    }
    
    //authenticate function for login
    function authenticate($username='',$password=0)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where ('username', $username);
        $this->db->where ('password', $password);
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        //echo "<pre>";print_r($query);exit;  
        if($query && $query->num_rows() == 1){
            return $query->result();
        }  
        else{
            return false;
        }   
    }
    
    //checkIfTaken function
    function checkIfTaken($username = "")
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where ("username",$username);
        $q = $this->db->get();
        if($q && $q->num_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
    //get pass by urn
    function getPassByUrn($urn = 0)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where ('urn', $urn);
        $query = $this->db->get();  
        if($query && $query->num_rows()>0){
            return $query->result();
        }  
        else{
            return false;
        }
    }
}