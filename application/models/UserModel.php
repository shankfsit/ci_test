<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {

	function __construct() {
        // Set table name
        $this->table = 'user_domain';
    }

	public function save_user($data)
	{
		return $this->db->insert('user_domain', $data);
	}

	public function getUsers(){
		$sql = "SELECT * FROM user_domain";
		return $this->db->query($sql)->result_array();
	}

	public function getUserById($id){
		$sql = "SELECT * FROM user_domain WHERE id = $id";
		return $this->db->query($sql)->result_array();
	}

	public function update_user($data,$id){
		return $this->db->update('user_domain', $data, array('id' => $id));
	}

	public function user_filter($name, $phone, $domain_name,  $start_date, $end_date)
	{
		$sql = "SELECT * FROM user_domain WHERE 1 ";
		if($name !=""){
			$sql .= " AND name LIKE '%$name%'";
		}
		if($phone !=""){
			$sql .= " AND phone LIKE '%$phone%'";
		}
		if($domain_name !=""){
			$sql .= " AND domain_name LIKE '%$domain_name%'";
		}
		// if($domain_date !=""){
		// 	$sql .= " AND domain_date LIKE '%$domain_date%'";
		// }
		if($start_date !="" && $end_date ==""){
			$sql .= " AND domain_date LIKE '%$start_date%'";
		}
		if($start_date !="" && $end_date !=""){
			$sql .= " AND domain_date between '$start_date' AND '$end_date'";
		}
		
		$sql .= " ORDER BY id DESC";
		return $this->db->query($sql)->result_array();
	}

	public function delete_user($id){
		$sql = "DELETE FROM user_domain WHERE id=$id";
		return $this->db->query($sql);
	}

	function getRows($params = array()){

        $this->db->select('*');
        $this->db->from($this->table);
        
        if(array_key_exists("where", $params)){
            foreach($params['where'] as $key => $val){
                $this->db->where($key, $val);
            }
        }
        
        if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
            $result = $this->db->count_all_results();
        }else{
            if(array_key_exists("id", $params)){
                $this->db->where('id', $params['id']);
                $query = $this->db->get();
                $result = $query->row_array();
            }else{
                $this->db->order_by('id', 'desc');
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                    $this->db->limit($params['limit'],$params['start']);
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                    $this->db->limit($params['limit']);
                }
                
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        
        // Return fetched data
        return $result;
    }
    
    /*
     * Insert members data into the database
     * @param $data data to be insert based on the passed parameters
     */
    public function insert($data = array()) {
        if(!empty($data)){
            // Add created and modified date if not included
            
            // Insert member data
            $insert = $this->db->insert($this->table, $data);
            
            // Return the status
            return $insert?$this->db->insert_id():false;
        }
        return false;
    }
    
    /*
     * Update member data into the database
     * @param $data array to be update based on the passed parameters
     * @param $condition array filter data
     */
    public function update($data, $condition = array()) {
        if(!empty($data)){
            
            // Update member data
            $update = $this->db->update($this->table, $data, $condition);
            
            // Return the status
            return $update?true:false;
        }
        return false;
    }
}
