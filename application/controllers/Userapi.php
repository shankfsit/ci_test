<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'third_party/REST_Controller.php';
require APPPATH . 'third_party/Format.php';
require APPPATH . 'third_party/Shortener.class.php';
use Restserver\Libraries\REST_Controller;
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Userapi extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('form','html','file');
        $this->load->helper('url');
        $this->load->model('UserModel');
        
        // Load these helper to create JWT tokens
        $this->load->helper(['jwt', 'authorization']); 
    }

    public function hello_get()
    {
        //echo "Hello";die();
        $tokenData = 'domain@gmail.com';
        
        // Create a token
        $token = AUTHORIZATION::generateToken($tokenData);
        // Set HTTP status code
        $status = parent::HTTP_OK;
        // Prepare the response
        $response = ['status' => $status, 'token' => $token];
        // REST_Controller provide this method to send responses
        $this->response($response, $status);
    }

 private function verify_request()
{
    // Get all the headers
    $headers = $this->input->request_headers();
    // Extract the token
    $token = $headers['Authorization'];
    // Use try-catch
    // JWT library throws exception if the token is not valid
    try {
        // Validate the token
        // Successfull validation will return the decoded user data else returns false
        $data = AUTHORIZATION::validateToken($token);
        if ($data === false) {
            $status = parent::HTTP_UNAUTHORIZED;
            $response = ['status' => $status, 'msg' => 'Unauthorized Access!'];
            $this->response($response, $status);
            exit();
        } else {
            return $data;
        }
    } catch (Exception $e) {
        // Token is invalid
        // Send the unathorized access message
        $status = parent::HTTP_UNAUTHORIZED;
        $response = ['status' => $status, 'msg' => 'Unauthorized Access! '];
        $this->response($response, $status);
    }
}


    /***********************************************************************/
    /************Offers Api Start Here*****************************/
    /***********************************************************************/

    public function user_domain_get($id = 0)
    {
        //$this->verify_request();   
        if(!empty($id)){
            //$data = $this->db->get_where("offers", ['id' => $id])->row_array();
            $data = $this->UserModel->getUserById($id);
        }else{
            //$data = $this->db->get("offers")->result();
            $data = $this->UserModel->getUsers();
        }
        $status = parent::HTTP_OK;
        $response = ['status' => $status, 'data' => $data];
        $this->response($response, $status);
    }

    public function user_domain_post()
    {
        //echo "hello post";
        //$this->verify_request(); 
        // $headers = $this->input->request_headers();

        // Extract the token
        //$token = $headers['Authorization'];
        if(empty($this->input->post('name'))){
           // echo "The field is Required";
            $this->response(['The field is Required']);
        }
        else if (empty($this->input->post('email'))) {
            $this->response(['The field is Required']);
        }
        else if (empty($this->input->post('phone'))) {
            $this->response(['The field is Required']);
        }
        else if (empty($this->input->post('watsapp_no'))) {
            $this->response(['The field is Required']);
        }
        else if (empty($this->input->post('domain_name'))) {
            $this->response(['The field is Required']);
        }
        else if (empty($this->input->post('domain_date'))) {
            $this->response(['The field is Required']);
        }
        else if (empty($this->input->post('hosting_package'))) {
            $this->response(['The field is Required']);
        }
        else if (empty($this->input->post('hosting_date'))) {
            $this->response(['The field is Required']);
        }
        else{
            //echo "Success";
            $data = array(
            'name'=>$this->input->post('name'),
            'email'=>$this->input->post('email'),
            'phone'=>$this->input->post('phone'),
            'watsapp_no'=>$this->input->post('watsapp_no'),
            'domain_name'=>$this->input->post('domain_name'),
            'domain_date'=>$this->input->post('domain_date'),
            'hosting_package'=>$this->input->post('hosting_package'),
            'hosting_date'=>$this->input->post('hosting_date')
        );
        //print_r($data);die();
        $result = $this->UserModel->save_user($data);
        //print_r($result);die();
        $status = parent::HTTP_OK;
     
        $this->response(['Item created successfully.'], $status);
        }
    }

    

    public function user_update_domain_post($id)
    {
        // $data = array(
        //     'name'=>$this->put('name'),
        //     'email'=>$this->put('email'),
        //     'phone'=>$this->put('phone'),
        //     'watsapp_no'=>$this->put('watsapp_no'),
        //     'domain_name'=>$this->put('domain_name'),
        //     'domain_date'=>$this->put('domain_date'),
        //     'hosting_package'=>$this->put('hosting_package'),
        //     'hosting_date'=>$this->put('hosting_date')
        // );
        $data = array(
            'name'=>$this->input->post('name'),
            'email'=>$this->input->post('email'),
            'phone'=>$this->input->post('phone'),
            'watsapp_no'=>$this->input->post('watsapp_no'),
            'domain_name'=>$this->input->post('domain_name'),
            'domain_date'=>$this->input->post('domain_date'),
            'hosting_package'=>$this->input->post('hosting_package'),
            'hosting_date'=>$this->input->post('hosting_date')
        );
        //print_r($data);
        //die();
        //$this->verify_request();
    //     $headers = $this->input->request_headers();
    // // Extract the token
    //     echo $token = $headers['Authorization'];die;
        //$data=$this->put(); 
        //$this->db->update('user_domain',$data,array('id' => $id));
        $result = $this->UserModel->update_user($data,$id);
        $status = parent::HTTP_OK;
        $this->response(['Item updated successfully.'], $status);
    }

    public function user_domain_delete($id)
    {
        //$this->verify_request(); 
        //echo $id;
        $this->UserModel->delete_user($id);
        $status = parent::HTTP_OK;
        $this->response(['Item deleted successfully.'], $status);
    }

    public function user_domain_filter_post()
    {
        $name = $this->input->post('name');
        $phone = $this->input->post('phone');
        $domain_name = $this->input->post('domain_name');
        //$domain_date = $this->input->post('domain_date');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        //$delete_status = 0;
        //print_r($data[name]);
        //echo $data['name'];
        //die();
        //$this->verify_request(); 
        // $data = array(
        // 'name' => $this->input->post('name'),
        // 'url' => $this->input->post('url'),
        // 'country_code' => $this->input->post('country_code'),
        // 'group_id' => $this->input->post('group_id'),
        // 'aff_network_id' => $this->input->post('aff_network_id')
        // );
        //print_r($data);die();
        $data = $this->UserModel->user_filter($name, $phone, $domain_name, $start_date, $end_date);
        $status = parent::HTTP_OK;
        // $data= array(
        //  'title'=>$this->input->post('title'),

        //  'description'=>$this->input->post('description')

        // );
        //echo $input = $this->input->post("title");die();
        //print_r($data);
        //$this->db->set($input);
        //$this->db->insert('items',$data);
        $response = ['status' => $status, 'data' => $data];
        $this->response($response, $status);
    }

    public function other_url_get($id){
        $this->verify_request();   
        $data = $this->Offer_model->get_other_urls($id);
        $status = parent::HTTP_OK;
        $response = ['status' => $status, 'data' => $data];
        $this->response($response, $status);
    }

    //Update other Urls
    public function update_other_urls_put($id)
    {
        $this->verify_request();
    
        $data = $this->put();
        $this->db->update('rotational_urls', $data, array('id' => $id));
        $status = parent::HTTP_OK;
        $this->response(['Other Urls updated successfully.'], $status);
    }

    /***********************************************************************/
    /************Offers Api Ends Here*****************************/
    /***********************************************************************/

    /***********************************************************************/
    /************Offers Category Api Start Here*****************************/
    /***********************************************************************/

    public function offers_category_get($id = 0)
    {
        $this->verify_request();   
        if(!empty($id)){
            $data = $this->Offer_model->get_offer_cat_by_id($id)->row_array();
        }else{
            $data = $this->Offer_model->get_all_offers_cat();
        }
        $status = parent::HTTP_OK;
        $response = ['status' => $status, 'data' => $data];
        $this->response($response, $status);
    }

    public function offers_category_post()
    {
        $this->verify_request(); 
        $data = array(
        'category_title' => $this->input->post('category_title'),
        'off_cat_status' => $this->input->post('off_cat_status')
        );
        //print_r($data);die;
        $result = $this->Offer_model->insert_new_offer_cat($data);
        $status = parent::HTTP_OK;
        $this->response(['offer category created successfully.'], $status);
    }

    public function offers_category_put($id)
    {
        $this->verify_request(); 
        $data=$this->put(); 
        $this->db->update('offers_category',$data,array('off_cat_id' => $id));
        // $data=array(
        //    'category_title'=>$this->put('category_title')
        // );
        // $this->Offer_model->update_offer_cat($data,$id);
        $status = parent::HTTP_OK;
        $this->response(['Offers Category updated successfully.'], $status);
    }

    

    /***********************************************************************/
    /************Offers Category Api Ends Here*****************************/
    /***********************************************************************/

    /***********************************************************************/
    /************Offers Group Api Starts Here*****************************/
    /***********************************************************************/

    public function offers_group_post()
    {
        $this->verify_request(); 
        $data = array(
        'group_name' => $this->input->post('group_name'),
        'group_status' => $this->input->post('group_status')
        );
        $result = $this->Offer_model->insert_new_offer_group($data);
        $status = parent::HTTP_OK;
        $this->response(['offer group created successfully.'], $status);
    }

    public function offers_group_get($id = 0)
    {
        $this->verify_request();   
        if(!empty($id)){
            $data = $this->Offer_model->get_offer_group_by_id($id)->row_array();
        }else{
            $data = $this->Offer_model->get_all_offers_group();
        }
        $status = parent::HTTP_OK;
        $response = ['status' => $status, 'data' => $data];
        $this->response($response, $status);
    }

    public function offers_group_put($id)
    {
        $this->verify_request(); 
        $data=$this->put(); 
        $this->db->update('offers_group',$data,array('grp_id' => $id));
        // $data=array(
        //    'group_name'=>$this->put('group_name'),
        //    'updated_by'=>$this->put('updated_by')
        // );
        // $this->Offer_model->update_offer_group($data,$id);
        $status = parent::HTTP_OK;
        $this->response(['Offers Group updated successfully.'], $status);
    }

    // public function offers_group_delete($id)
    // {
    //     $this->verify_request(); 
    //     //$deleted_by => $this->put('deleted_by');
    //     $this->Offer_model->delete_offer_group($id);
    //     $status = parent::HTTP_OK;
    //     $this->response(['Offers Group deleted successfully.'], $status);
    // }

    /***********************************************************************/
    /************Offers Group Api Ends Here*****************************/
    /***********************************************************************/

    /***********************************************************************/
    /************Offers Applications Api Starts Here*****************************/
    /***********************************************************************/
    public function offers_applications_post()
    {
        $this->verify_request(); 
        $data = array(
        'offer_id' => $this->input->post('offer_id'),
        'publisher_id' => $this->input->post('publisher_id')
        );
        $result = $this->Offer_model->insert_offers_applications($data);
        $status = parent::HTTP_OK;
        $this->response(['offer Applicationsp created successfully.'], $status);
    }

    public function offers_applications_get($id = 0)
    {
        $this->verify_request();   
        if(!empty($id)){
            $data = $this->Offer_model->get_offer_applications_by_id($id);
        }else{
            $data = $this->Offer_model->get_all_offers_applications();
        }
        $status = parent::HTTP_OK;
        $response = ['status' => $status, 'data' => $data];
        $this->response($response, $status);
    }

    public function offers_applications_approve_post()
    {
        $this->verify_request(); 
        $headers = $this->input->request_headers();
        // Extract the token
        $token = $headers['Authorization'];
        //echo $token; die();
        $user = $this->Offer_model->get_user_by_token($token);
        //print_r($user[0]['user_id']);die();
        $user_id = $user[0]['user_id'];
        //$data=array("1","2");
        $id = $this->input->post();
        // foreach($data as $x)
        //   {
        //   echo "id=" . $x;
        //   echo "<br>";
        //   }
        $d = implode(',', $id);
        //echo $d;die;
        $data = explode(',', $d);
        //echo count($data);
        //print_r($data);
        //die();
        //$data = explode(',', $id);

        foreach ($data as $x) {
           //echo $x;
            $result = $this->Offer_model->offer_application_approve($x,$user_id);
        }
        //die();
        //$result = $this->Offer_model->offer_application_approve($data);
        $status = parent::HTTP_OK;
        $this->response(['offer applications updated successfully.'], $status);
    }

    public function offers_applications_deny_post()
    {
        $this->verify_request(); 
        $id = $this->input->post();
        $d = implode(',', $id);
        $data = explode(',', $d);
        foreach ($data as $x) {
           //echo $x;
            $result = $this->Offer_model->offer_application_deny($x);
        }
        $status = parent::HTTP_OK;
        $this->response(['offer applications Denied successfully.'], $status);
    }
    /***********************************************************************/
    /************Offers Applications Api Ends Here**************************/
    /***********************************************************************/

    /***********************************************************************/
    /************Offers Suppression List Api Starts Here********************/
    /***********************************************************************/

    public function offers_suppression_list_post()
    {
        $this->verify_request(); 
        $data = array(
        'name' => $this->input->post('name'),
        'download_url' => $this->input->post('download_url'),
        'unsubscribe_url' => $this->input->post('unsubscribe_url')
        );
        $result = $this->Offer_model->insert_offers_sup_list($data);
        $status = parent::HTTP_OK;
        $this->response(['offer Suppression List created successfully.'], $status);
    }

    public function offers_suppression_list_get($id = 0)
    {
        //echo "Hello";die;
        $this->verify_request();   
        if(!empty($id)){
            $data = $this->Offer_model->get_offer_sup_list_id($id)->row_array();;
        }else{
            $data = $this->Offer_model->get_all_offers_sup_list()->result();;
        }
        $status = parent::HTTP_OK;
        $response = ['status' => $status, 'data' => $data];
        $this->response($response, $status);
    }

    public function offers_suppression_list_put($id)
    {
        // echo $data = $this->put('title');
        //print_r($data);
        // die();
        $this->verify_request();
    //     $headers = $this->input->request_headers();
    // // Extract the token
    //     echo $token = $headers['Authorization'];die;
        $data=$this->put(); 
        $this->db->update('suppression_list',$data,array('sup_list_id' => $id));
        $status = parent::HTTP_OK;
        $this->response(['Item updated successfully.'], $status);
    }

    /***********************************************************************/
    /************Offers Suppression List Api Ends Here********************/
    /***********************************************************************/

    /***********************************************************************/
    /************Offers group Add Api Start Here*****************************/
    /***********************************************************************/

    public function offers_group_add_get($id = 0)
    {
        $this->verify_request();   
        if(!empty($id)){
            $data = $this->Offer_model->get_offer_grp_add_by_id($id);
        }else{
            $data = $this->Offer_model->get_all_offers_grp_add();
        }
        $status = parent::HTTP_OK;
        $response = ['status' => $status, 'data' => $data];
        $this->response($response, $status);
    }

    public function get_offerslist_by_group_post()
    {
        $this->verify_request();   
        $grp_id = $this->input->post('grp_id');
        $data = $this->Offer_model->get_offer_grp_add_by_id($grp_id);
        $status = parent::HTTP_OK;
        $response = ['status' => $status, 'data' => $data];
        $this->response($response, $status);
    }

    public function offers_group_add_post()
    {
        $this->verify_request(); 
        $data = array(
        'grp_id' => $this->input->post('grp_id'),
        'offer_id' => $this->input->post('offer_id')
        );
        $result = $this->Offer_model->insert_offer_grp_add($data);
        $status = parent::HTTP_OK;
        $this->response(['offer category created successfully.'], $status);
    }

    public function offers_group_add_delete($id)
    {
        $this->verify_request(); 
        $this->Offer_model->delete_group_offer($id);
        $status = parent::HTTP_OK;
        $this->response(['Offer is deleted successfully.'], $status);
    }

    // public function offers_group_add_put($id)
    // {
    //     $this->verify_request(); 
    //     $data=$this->put(); 
    //     $this->db->update('grp_offers',$data,array('id' => $id));
    //     $status = parent::HTTP_OK;
    //     $this->response(['Group Offers updated successfully.'], $status);
    // }

    /***********************************************************************/
    /************Offers Category Api Ends Here*****************************/
    /***********************************************************************/

    /***********************************************************************/
    /************Offers cat Add Api Start Here*****************************/
    /***********************************************************************/

    public function get_offerslist_by_cat_get($cat_id)
    {
        $this->verify_request();   
        //$grp_id = $this->input->post('grp_id');
        $data = $this->Offer_model->get_offer_cat_add_by_catid($cat_id);
        $status = parent::HTTP_OK;
        $response = ['status' => $status, 'data' => $data];
        $this->response($response, $status);
    }

    public function offers_cat_add_post()
    {
        $this->verify_request(); 
        $data = array(
        'cat_id' => $this->input->post('cat_id'),
        'offer_id' => $this->input->post('offer_id')
        );
        $result = $this->Offer_model->insert_offer_cat_add($data);
        $status = parent::HTTP_OK;
        $this->response(['offer category created successfully.'], $status);
    }

    public function offers_cat_add_delete($id)
    {
        $this->verify_request(); 
        $this->Offer_model->delete_cat_offer($id);
        $status = parent::HTTP_OK;
        $this->response(['Offer is deleted successfully.'], $status);
    }


    /***********************************************************************/
    /************Offers Cat add Api Ends Here*****************************/
    /***********************************************************************/

    /***********************************************************************/
    /************Offers Reports Api Starts Here*****************************/
    /***********************************************************************/

    public function offer_reports_get()
    {
        $this->verify_request();   
        $data = $this->Offer_model->offer_reports();
        $status = parent::HTTP_OK;
        $response = ['status' => $status, 'data' => $data];
        $this->response($response, $status);
    }

    // public function offer_reports_filter_get()
    // {
    //     $this->verify_request();   
    //     $data_range = $this->input->post('data_range');
    //     $start_date = $this->input->post('start_date');
    //     $end_date = $this->input->post('end_date');
    //     $data = $this->Offer_model->offer_reports_filter($data_range,$start_date,$end_date);
    //     $status = parent::HTTP_OK;
    //     $response = ['status' => $status, 'data' => $data];
    //     $this->response($response, $status);
    // }

    public function offer_reports_filter_post()
    {
        $this->verify_request();   
        
        $data = $this->Offer_model->offer_reports_filter();
        //array_push($data,"blue","yellow");
        //print_r($data);die();
        $start_date = $this->input->post('start_date');
        //echo "<br/>";
        $end_date = $this->input->post('end_date');
        //die();
       //  $array2 = array();
       $count = count($data);
       //  for ($a = 0; $a < $count; $a++) {
       //      $adv_id = $data[$a]['advertiser_id'];
       //      $adv_name = $this->Offer_model->get_adv_name_by_id($adv_id);
       //      //print_r($adv_name);
       //      //$result = call_user_func_array('array_merge', $adv_name);
       //      //$array2[] = $adv_name[0]['company'];
       //      //print_r($result);
       //      $array2[] = $adv_name;
       //  }
       // //  print_r($array2);
       // $result = call_user_func_array('array_merge', $array2);
         //print_r($result);
        $array1 = array();
        
        for ($x = 0; $x < $count; $x++) {
            $offer_id = $data[$x]['off_id'];
            $adv_id = $data[$x]['advertiser_id'];
            /**************Advertiser Name *************/
            $adv_name = $this->Offer_model->get_adv_name_by_id($adv_id);
            //print_r($adv_name['company']);
            //$result = call_user_func_array('array_merge', $adv_name);
         //print_r($result);
            $data[$x]['company'] = $adv_name['company'];
            //Clicks
            $clicks = $this->Offer_model->get_clicks_by_id($offer_id,$start_date,$end_date);
            
            $no_of_clicks = count($clicks);
            $data[$x]['Clicks'] = $no_of_clicks;
            //Conversions
            $conversions = $this->Offer_model->get_conversions_by_id($offer_id,$start_date,$end_date);
            $no_of_conversions = count($conversions);
            $data[$x]['Conversions'] = $no_of_conversions;
            //CR
            if($data[$x]['Clicks'] == 0){
                $data[$x]['CR'] = 0;
            }
            else{
                $data[$x]['CR'] = ($data[$x]['Conversions']/$data[$x]['Clicks'])*100;
            }

            //Payout

            $data[$x]['Payout'] = ($data[$x]['Conversions']*$data[$x]['cost_per_conversion']);


            //Revenue
            $data[$x]['Revenue'] = ($data[$x]['Conversions']*$data[$x]['revenue_per_conversion']);

            //CPC
            if($data[$x]['Clicks'] == 0){
                $data[$x]['CPC'] = 0;
            }
            else{
                $data[$x]['CPC'] = ($data[$x]['Conversions']*$data[$x]['cost_per_conversion'])/$data[$x]['Clicks'];
            }
            


            //RPC
            if($data[$x]['Clicks'] == 0){
                $data[$x]['RPC'] = 0;
            }
            else{
                $data[$x]['RPC'] = ($data[$x]['Conversions']*$data[$x]['revenue_per_conversion'])/$data[$x]['Clicks'];
            }


            //Profit
            $data[$x]['Profit'] = ($data[$x]['Conversions']*$data[$x]['revenue_per_conversion'])-($data[$x]['Conversions']*$data[$x]['cost_per_conversion']);
            
            //print_r($clicks);
        }


        
        $status = parent::HTTP_OK;
        $response = ['status' => $status, 'data' => $data];
        $this->response($response, $status);
    }



    /***********************************************************************/
    /************Offers Reports Api Ends Here*****************************/
    /***********************************************************************/
}
