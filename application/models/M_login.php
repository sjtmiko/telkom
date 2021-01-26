<?php 
 
class M_login extends CI_Model{	
    function auth($where){
       $query =  $this->db->get_where('login',$where);
        return $query;
    }
}