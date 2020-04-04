<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('form','html');
		$this->load->helper('url');
		//$this->load->library('form_validation');
		$this->load->model('UserModel');
	   $this->load->library('form_validation');
        
        // Load file helper
        $this->load->helper('file');


	}

	public function index()
	{
		$this->load->view('user');
	}

	public function user_fields(){
			// $config['upload_path']          = './uploads/';
   //              $config['allowed_types']        = 'xlsx|csv';
   //              $config['max_size']             = 100;
   //              $config['max_width']            = 1024;
   //              $config['max_height']           = 768;

   //              //$this->load->library('upload', $config);
   //              $this->upload->initialize($config);
   //              if ( ! $this->upload->do_upload('userfile'))
   //              {
   //                      $error = array('error' => $this->upload->display_errors());

   //                      $this->load->view('user', $error);
   //              }
   //              else
   //              {
   //                      $data = array('upload_data' => $this->upload->data());

   //                      $this->load->view('user', $data);
   //              }
	         //die();
		$url = "http://localhost/ci_test/userapi/user_domain";
		$postData = array(
			'name'=>$this->input->post('name'),
			'email'=>$this->input->post('email'),
			'phone'=>$this->input->post('phone'),
			'watsapp_no'=>$this->input->post('watsapp_no'),
			'domain_name'=>$this->input->post('domain_name'),
			'domain_date'=>$this->input->post('domain_date'),
			'hosting_package'=>$this->input->post('hosting_package'),
			'hosting_date'=>$this->input->post('hosting_date'),
			'uploads'=>$this->upload->data('file_name')
		);
		//print_r($this->UserModel->save_user($data));die();
		$ch = curl_init();  
 
	    curl_setopt($ch,CURLOPT_URL,$url);
	    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	    curl_setopt($ch,CURLOPT_HEADER, false); 
	    curl_setopt($ch, CURLOPT_POST, count($postData));
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    
	 
	    $output=curl_exec($ch);
	 
	    curl_close($ch);
	    //echo $output;

		//die();
		if($output){
			//$this->load->view('view_all_users');
			//echo "success";
			 redirect(base_url().'user/view_all_users', 'refresh');
		}
		else{
			//echo "failed";
			redirect('user');
		}
	}

	public function view_all_users(){
		// $data['user_info'] = $this->UserModel->getUsers();
		// print_r($data);
		$url = "http://localhost/ci_test/userapi/user_domain";
		$ch = curl_init();  
 
	    curl_setopt($ch,CURLOPT_URL,$url);
	    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	//  curl_setopt($ch,CURLOPT_HEADER, false); 
	 
	    $data = curl_exec($ch);
	 	$transaction = json_decode($data, TRUE);
	    $data = curl_exec($ch);
		$data3['user_info'] = $transaction['data'];
		
		$this->load->view('view_users',$data3);
	}

	public function user_fields_search(){
		//echo "Hello";
	   $name = $this->input->post('uname');
	   $phone = $this->input->post('phone');
	   $domain_name = $this->input->post('domain_name');
	   $start_date = $this->input->post('start_date');
	   $end_date = $this->input->post('end_date');
	   $data['user_info_search'] = $this->UserModel->user_filter($name, $phone, $domain_name, $start_date, $end_date);
	   //print_r($data);
	   $this->load->view('view_users',$data);
	}

	public function edit_user($id){
		$url = "http://localhost/ci_test/userapi/user_domain/".$id;
		$ch = curl_init();  
 
	    curl_setopt($ch,CURLOPT_URL,$url);
	    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	//  curl_setopt($ch,CURLOPT_HEADER, false); 
	 
	    $data = curl_exec($ch);
	 	$transaction = json_decode($data, TRUE);
	    $data = curl_exec($ch);
	    //print_r($transaction);
		$data3['user_info'] = $transaction['data'];
		
		$this->load->view('edit_user',$data3);
	}

	public function edit_user_details($id){
		$url = "http://localhost/ci_test/userapi/user_update_domain/".$id;
		$updateData = array(
			'name'=>$this->input->post('name'),
			'email'=>$this->input->post('email'),
			'phone'=>$this->input->post('phone'),
			'watsapp_no'=>$this->input->post('watsapp_no'),
			'domain_name'=>$this->input->post('domain_name'),
			'domain_date'=>$this->input->post('domain_date'),
			'hosting_package'=>$this->input->post('hosting_package'),
			'hosting_date'=>$this->input->post('hosting_date')
		);
		$ch = curl_init();  
 
	    curl_setopt($ch,CURLOPT_URL,$url);
	    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	    curl_setopt($ch,CURLOPT_HEADER, false); 
	    curl_setopt($ch, CURLOPT_POST, count($updateData));
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $updateData);    
	 
	    $output=curl_exec($ch);
	 
	    curl_close($ch);
	    //echo $output;
	    if($output){
			//$this->load->view('view_all_users');
			//echo "success";
			 redirect(base_url().'user/view_all_users', 'refresh');
		}
		else{
			//echo "failed";
			redirect('user/view_all_users', 'refresh');
		}
	}

	// public function delete_user($id){
	// 	if($this->UserModel->delete_user($id)){
	// 		 redirect(base_url().'user/view_all_users', 'refresh');
	// 	}
	// 	else{
	// 		redirect(base_url().'user/view_all_users?err=error', 'refresh');
	// 	}
	// }

	public function user_delete($id){
		 	$url = "http://localhost/ci_test/userapi/user_domain/".$id;
		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, $url);
		    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		    $result = curl_exec($ch);
		    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		    curl_close($ch);
		    if($result){
			//$this->load->view('view_all_users');
			//echo "success";
			 	redirect(base_url().'user/view_all_users');
			}
			else{
				//echo "failed";
				redirect('user/view_all_users');
			}

	}


public function import(){
    // echo "hello";
    // die();
       $data = array();
       $memData = array();
       
       // If import request is submitted
       if($this->input->post('importSubmit')){
           // Form field validation rules
           $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');
           
           // Validate submitted form data
           if($this->form_validation->run() == true){
               $insertCount = $updateCount = $rowCount = $notAddCount = 0;
               
               // If file uploaded
               if(is_uploaded_file($_FILES['file']['tmp_name'])){
                   // Load CSV reader library
                   $this->load->library('CSVReader');
                   
                   // Parse data from CSV file
                   $csvData = $this->csvreader->parse_csv($_FILES['file']['tmp_name']);
                   
               // 

               // print_r($csvData); die;
                   // Insert/update CSV data into database
                   if(!empty($csvData)){
                       foreach($csvData as $row){ $rowCount++;
                           //print_r($row);
                            echo $keys_values = implode($row,';');
                            print_r($keys_values);
                           // Prepare data for DB insertion
                           $memData = array(
                               'name' => $row['name'],
                               'email' => $row['email'],
                               'phone' => $row['phone'],
                               'watsapp_no' => $row['watsapp_no'],
                               'domain_name' => $row['domain_name'],
                               'domain_date' => $row['domain_date'],
                               'hosting_package' => $row['hosting_package'],
                               'hosting_date' => $row['hosting_date'],
                           );
                           
                           //print_r($memData);
                           // Check whether email already exists in the database
                           // $con = array(
                           //     'where' => array(
                           //         'email' => $row['Email']
                           //     ),
                           //     'returnType' => 'count'
                           // );
                           $prevCount = $this->UserModel->getRows($con);
                           
                           if($prevCount > 0){
                               // Update member data
                               $condition = array('email' => $row['Email']);
                               $update = $this->UserModel->update($memData, $condition);
                               
                               if($update){
                                   $updateCount++;
                               }
                           }else{
                               // Insert member data
                               $insert = $this->UserModel->insert($memData);
                               
                               if($insert){
                                   $insertCount++;
                               }
                           }
                       }
                       
                       // Status message with imported data count
                       $notAddCount = ($rowCount - ($insertCount + $updateCount));
                       $successMsg = 'Members imported successfully. Total Rows ('.$rowCount.') | Inserted ('.$insertCount.') | Updated ('.$updateCount.') | Not Inserted ('.$notAddCount.')';
                       $this->session->set_userdata('success_msg', $successMsg);
                   }
               }else{
                   $this->session->set_userdata('error_msg', 'Error on file upload, please try again.');
               }
           }else{
               $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
           }
       }
       redirect('user');
   }

   public function file_check($str){
       $allowed_mime_types = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
       if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != ""){
           $mime = get_mime_by_extension($_FILES['file']['name']);
           $fileAr = explode('.', $_FILES['file']['name']);
           $ext = end($fileAr);
           if(($ext == 'csv') && in_array($mime, $allowed_mime_types)){
               return true;
           }else{
               $this->form_validation->set_message('file_check', 'Please select only CSV file to upload.');
               return false;
           }
       }else{
           $this->form_validation->set_message('file_check', 'Please select a CSV file to upload.');
           return false;
       }
   }
}
