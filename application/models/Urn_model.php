<?php
/**
*@author: Aziz Matin
*@created Date: 20-Feb-2019
**/
defined('BASEPATH') OR exit('No direct script access allowed');
class Urn_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	/*function getURN($table = '',$field = ''){
		//echo "ddddddddddddddddddd";exit;
		$this->db->query("CALL GenerateURN('".$table."','".$field."',@urn)");
		$result = $this->db->query("SELECT @urn AS urn");
		if($result){
			return $result->row()->urn;
		}else{
			return 0;
		}
	}*/

	function getURN($table = '',$field = ''){
		$result = $this->db->query("SELECT $field FROM $table ORDER BY id DESC LIMIT 1");
		//echo $this->db->last_query();exit;
		if($result->num_rows()>0){
			return $result->row()->$field+1;
		}else{
			return 10001;
		}
	}
    
    function getPatientId($table = '',$field = ''){
        $result = $this->db->query("SELECT $field FROM $table ORDER BY id DESC LIMIT 1");
        //echo $this->db->last_query();exit;
        if($result->num_rows()>0){
            $g_id = explode("_",$result->row()->$field);
            $starter = $g_id[1]+1;
            $u_id = "NDC".$starter;
            return $u_id;
        }else{
            $starter = 10001;
            $u_id = "NDC".$starter;
            return $u_id;
        }
    }
}