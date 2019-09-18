<?php defined('BASEPATH') OR exit('No direct script access allowed');

use manadeebapi\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
 
class Getdata extends \manadeebapi\Libraries\REST_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('Addbill_Model', 'AddbillModel');
    }

    /**
     * Aget bills with API
     * -------------------------
     * @method: POST
     */
   

 function getBills_post()
 { 

      header("Access-Control-Allow-Origin: *");
    
        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE)
        {
              
              $CustId =  $this->input->post('CustId'); 

               $data = $this->AddbillModel->get_custbill($CustId);

               if ($data > 0 AND !empty($data))
                {
                    // Success
                    $message = [
                        'status' => true,
                        'message' => "Data Found Successfull",
                        'data' => $data,
                    ];
                    $this->response($message, REST_Controller::HTTP_OK);
                } else
                {
                    // Error
                    $message = [
                        'status' => FALSE,
                        'message' => "Data Not Found"
                    ];
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }
                

        } else {


            $this->response(['status' => FALSE, 'message' => $is_valid_token['message'] ], REST_Controller::HTTP_NOT_FOUND);

        }
    }

    // cancel bilss
    function CancelBills_post(){

      header("Access-Control-Allow-Origin: *");
    
        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();

        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE)
        {

              $data =  $is_valid_token['data'];
              $uer_id =  $data->id;
              $Bill_id =  $this->input->post('Bill_id');
             

              $data = $this->AddbillModel->cancel_bill($Bill_id);



               if ($data > 0 AND !empty($data))
                {
                    // Success
                    $message = [
                        'status' => true,
                        'message' => "Data saved Successfull",
                        
                    ];
                    $this->response($message, REST_Controller::HTTP_OK);
                } else
                {
                    // Error
                    $message = [
                        'status' => FALSE,
                        'message' => "Data Not saved"
                    ];
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }
                

        } else {


            $this->response(['status' => FALSE, 'message' => $is_valid_token['message'] ], REST_Controller::HTTP_NOT_FOUND);

        }


    }

  // get product

   function GetProducts_post(){ 

     header("Access-Control-Allow-Origin: *");
    
        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();

        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE)
        {

              $data =  $is_valid_token['data'];
              $uer_id =  $data->id;
              


              $data = $this->AddbillModel->get_product($uer_id);



               if ($data > 0 AND !empty($data))
                {
                    // Success
                    $message = [
                        'status' => true,
                        'message' => "Data Found Successfull",
                        'data' => $data,
                    ];
                    $this->response($message, REST_Controller::HTTP_OK);
                } else
                {
                    // Error
                    $message = [
                        'status' => FALSE,
                        'message' => "Data Not Found"
                    ];
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }
                

        } else {


            $this->response(['status' => FALSE, 'message' => $is_valid_token['message'] ], REST_Controller::HTTP_NOT_FOUND);

        }

   }

  //function for test 

   // function display(){
   //  header("Access-Control-Allow-Origin: *");
   //  $this->load->library('Authorization');
   //  $is_valid_token = $this->->authorization_token->validateToken();
   //  if(!empty($is))

   // }
   


//get unpaid customer bils
   
     function GetUnpaymentcuslists_post(){

       header("Access-Control-Allow-Origin: *");
    
        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();

        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE)
        {

              $data =  $is_valid_token['data'];
              $uer_id =  $data->id;
              $CustCompanyId =  $this->input->post('CustCompanyId');
              $weekId =  $this->input->post('weekId');



              $data = $this->AddbillModel->get_unpaidcustomerlist($CustCompanyId, $weekId, $uer_id);



               if ($data > 0 AND !empty($data))
                {
                    // Success
                    $message = [
                        'status' => true,
                        'message' => "Data Found Successfull",
                        'data' => $data,
                    ];
                    $this->response($message, REST_Controller::HTTP_OK);
                } else
                {
                    // Error
                    $message = [
                        'status' => FALSE,
                        'message' => "Data Not Found"
                    ];
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }
                

        } else {


            $this->response(['status' => FALSE, 'message' => $is_valid_token['message'] ], REST_Controller::HTTP_NOT_FOUND);

        }



     }

   //get avaliable product
   
   function getvaliableProducts_post()
 { 
  
  header("Access-Control-Allow-Origin: *");
    
        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();

        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE)
        {

              $data =  $is_valid_token['data'];
              $uer_id =  $data->id;
              $CustCompanyId =  $this->input->post('CustCompanyId');
             



              $data = $this->AddbillModel->get_avaliableProduct($CustCompanyId, $uer_id);



               if ($data > 0 AND !empty($data))
                {
                    // Success
                    $message = [
                        'status' => true,
                        'message' => "Data Found Successfull",
                        'data' => $data,
                    ];
                    $this->response($message, REST_Controller::HTTP_OK);
                } else
                {
                    // Error
                    $message = [
                        'status' => FALSE,
                        'message' => "Data Not Found"
                    ];
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }
                

        } else {


            $this->response(['status' => FALSE, 'message' => $is_valid_token['message'] ], REST_Controller::HTTP_NOT_FOUND);

        }
    }
    
   

    //get request product
     function GetRequestProducts_post()
 { 

     header("Access-Control-Allow-Origin: *");
    
        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();

        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE)
        {

              $data =  $is_valid_token['data'];
              $uer_id =  $data->id;
              $CustCompanyId =  $this->input->post('CustCompanyId');
            
             

              $data = $this->AddbillModel->get_requestproducts($CustCompanyId);

               if ($data > 0 AND !empty($data))
                {
                    // Success
                    $message = [
                        'status' => true,
                        'message' => "Data Found Successfull",
                        'data' => $data,
                    ];
                    $this->response($message, REST_Controller::HTTP_OK);
                } else
                {
                    // Error
                    $message = [
                        'status' => FALSE,
                        'message' => "Data Not Found"
                    ];
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }
                

        } else {


            $this->response(['status' => FALSE, 'message' => $is_valid_token['message'] ], REST_Controller::HTTP_NOT_FOUND);

        }
    } 
    


  function getBanks_get()
 { 

      header("Access-Control-Allow-Origin: *");
    
        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE)
        {
              
               $data = $this->AddbillModel->get_banks();

               if ($data > 0 AND !empty($data))
                {
                    // Success
                    $message = [
                        'status' => true,
                        'message' => "Data Found Successfull",
                        'data' => $data,
                    ];
                    $this->response($message, REST_Controller::HTTP_OK);
                } else
                {
                    // Error
                    $message = [
                        'status' => FALSE,
                        'message' => "Data Not Found"
                    ];
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }
                

        } else {


            $this->response(['status' => FALSE, 'message' => $is_valid_token['message'] ], REST_Controller::HTTP_NOT_FOUND);

        }
    } 

 function getSelectedCustomers_post(){

  header("Access-Control-Allow-Origin: *");
    
        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();

        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE)
        {

              $data =  $is_valid_token['data'];
              $uer_id =  $data->id;
              $CustCompanyId =  $this->input->post('CustCompanyId');
              



              $data = $this->AddbillModel->get_selectedcustomers($CustCompanyId, $uer_id);



               if ($data > 0 AND !empty($data))
                {
                    // Success
                    $message = [
                        'status' => true,
                        'message' => "Data Found Successfull",
                        'data' => $data,
                    ];
                    $this->response($message, REST_Controller::HTTP_OK);
                } else
                {
                    // Error
                    $message = [
                        'status' => FALSE,
                        'message' => "Data Not Found"
                    ];
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }
                

        } else {


            $this->response(['status' => FALSE, 'message' => $is_valid_token['message'] ], REST_Controller::HTTP_NOT_FOUND);

        }

    
 }

  // get customer infromation

  function getCustomers_post()
 { 

       header("Access-Control-Allow-Origin: *");
    
        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        /**
         * User Token Validation
         */
        $is_valid_token = $this->authorization_token->validateToken();

        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE)
        {

              $data =  $is_valid_token['data'];
              $uer_id =  $data->id;
              $CustCompanyId =  $this->input->post('CustCompanyId');
              $weekId =  $this->input->post('weekId');



              $data = $this->AddbillModel->get_customers($CustCompanyId, $weekId, $uer_id);



               if ($data > 0 AND !empty($data))
                {
                    // Success
                    $message = [
                        'status' => true,
                        'message' => "Data Found Successfull",
                        'data' => $data,
                    ];
                    $this->response($message, REST_Controller::HTTP_OK);
                } else
                {
                    // Error
                    $message = [
                        'status' => FALSE,
                        'message' => "Data Not Found"
                    ];
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }
                

        } else {


            $this->response(['status' => FALSE, 'message' => $is_valid_token['message'] ], REST_Controller::HTTP_NOT_FOUND);

        }
    }
  

    //get avalibale product
 //      function getValiableproduct_get()
 // { 

 //      header("Access-Control-Allow-Origin: *");
    
 //        // Load Authorization Token Library
 //        $this->load->library('Authorization_Token');

 //        /**
 //         * User Token Validation
 //         */
 //        $is_valid_token = $this->authorization_token->validateToken();
 //        if (!empty($is_valid_token) AND $is_valid_token['status'] === TRUE)
 //        {
              
 //               $data = $this->AddbillModel->get_customers();

 //               if ($data > 0 AND !empty($data))
 //                {
 //                    // Success
 //                    $message = [
 //                        'status' => true,
 //                        'message' => "Data Found Successfull",
 //                        'data' => $data,
 //                    ];
 //                    $this->response($message, REST_Controller::HTTP_OK);
 //                } else
 //                {
 //                    // Error
 //                    $message = [
 //                        'status' => FALSE,
 //                        'message' => "Data Not Found"
 //                    ];
 //                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
 //                }
                

 //        } else {


 //            $this->response(['status' => FALSE, 'message' => $is_valid_token['message'] ], REST_Controller::HTTP_NOT_FOUND);

 //        }
 //    }
    
    
       


  }





 
       