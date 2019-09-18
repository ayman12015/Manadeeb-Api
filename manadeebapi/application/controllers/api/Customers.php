<?php defined('BASEPATH') OR exit('No direct script access allowed');

use manadeebapi\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
 
class Customers extends \manadeebapi\Libraries\REST_Controller
{
    public function __construct() {
        parent::__construct();
        // Load User Model
        $this->load->model('Customer_Model', 'customerModel');

    }

     /**
     * Add new Customers with API
     * -------------------------
     * @method: POST
     */
    public function addCustomer_post()
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
            # Create a User customer

            # XSS Filtering (https://www.codeigniter.com/user_guide/libraries/security.html)
            $_POST = $this->security->xss_clean($_POST);
            
            # Form Validation
            $this->form_validation->set_rules('cust_name', 'cust_name', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('cust_mobile', 'cust_mobile', 'trim|required|max_length[14]');
            $this->form_validation->set_rules('cust_shop_name', 'cust_shop_name', 'trim|required|max_length[50]');
            
            $this->form_validation->set_rules('LX', 'LX', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('LY', 'LY', 'trim|required|max_length[50]');

            if ($this->form_validation->run() == FALSE)
            {
                // Form Validation Errors
                $message = array(
                    'status' => false,
                    'error' => $this->form_validation->error_array(),
                    'message' => validation_errors()
                );

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);
            }
            else
            {
                // Load Article Model
               
                $this->load->model('Customer_Model', 'customerModel');

                $insert_data = [
                    'LX' => $this->input->post('LX', TRUE),
                    'LY' => $this->input->post('LY', TRUE)                    
                ];


                // Insert Article
                $output = $this->customerModel->create_customer($insert_data,"locations");

                if ($output > 0 AND !empty($output))
                {
                  
        $daysArr = ['Saturday'=>'0' ,'Sunday' => '1','Monday' => '2','Tuesday' => '3','Wednesday' => '4','Thursday' => '5','Friday' => '6'];
        
        $dayOfWeek = date("l" );


                  $Token_data = $is_valid_token['data'] ;

                  $insert_data = [
                    'cust_name' => $this->input->post('cust_name', TRUE),
                    'cust_mobile' => $this->input->post('cust_mobile', TRUE),
                    'cust_shop_name' => $this->input->post('cust_shop_name', TRUE),
                    'user_id' => $Token_data->id,
                    'weekId' =>  $daysArr[$dayOfWeek],
                    'company_id' => $this->input->post('UserCompanyId', TRUE),
                    'entered_by' => $Token_data->id,
                    'location_id' =>  $output
                ];

                  $output = $this->customerModel->create_customer($insert_data,"AddCust");

                   if ($output > 0 AND !empty($output))
                {
                  $this->response(['status' => TRUE, 'message' => $insert_data], REST_Controller::HTTP_NOT_FOUND);
                }
                 

                } else
                {
                    // Error
                    $message = [
                        'status' => FALSE,
                        'message' => "customer not create"
                    ];
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }
            } 

        } else {
            $this->response(['status' => FALSE, 'message' => $is_valid_token['message'] ], REST_Controller::HTTP_NOT_FOUND);
        }
    }


    /**
     * Add new payment with API
     * -------------------------
     * @method: POST
     */
    public function Payments_post()
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
            # Create a User customer

            # XSS Filtering (https://www.codeigniter.com/user_guide/libraries/security.html)
            $_POST = $this->security->xss_clean($_POST);
            
            # Form Validation
            $this->form_validation->set_rules('pay_amt', 'pay_amt', 'trim|required');
            $this->form_validation->set_rules('pay_type', 'pay_type', 'trim|required');
            
            $this->form_validation->set_rules('checks_amt', 'checks_amt', 'trim|required');
            $this->form_validation->set_rules('checks_no', 'checks_no', 'trim|required');
           
            $this->form_validation->set_rules('check_dt', 'check_dt', 'trim|required');
            $payType= $this->input->post('pay_type');
        

            if ($this->form_validation->run() == FALSE)
            {
                // Form Validation Errors
                $message = array(
                    'status' => false,
                    'error' => $this->form_validation->error_array(),
                    'message' => validation_errors()
                );

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);
            }else if($payType != 1 && $payType !=2 && $payType !=3){
        
                    $message = [
                        'status' => FALSE,
                        'message' => "Unkwon payment type"
                    ];
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                    

                } else  {
                // Load Article Model
               
                $this->load->model('Customer_Model', 'customerModel');

                $insert_data = [
                     'pay_amt' => $this->input->post('pay_amt', TRUE),
                     'BillId' => $this->input->post('BillId', TRUE),
                     'pay_type' => $this->input->post('pay_type', TRUE) 
                    

                ];


                // Insert Article
                $output = $this->customerModel->createpayments($insert_data,"payments");


                if ($output > 0 AND !empty($output))
                {
                
                if($payType==3){
                   $checkDate =$this->input->post('check_dt', TRUE);
                   $formatedDate = date('YYYY-mm-dd',$checkDate);

                  $Token_data = $is_valid_token['data'] ;
                  $insert_data = [
                    'checks_amt' => $this->input->post('pay_amt', TRUE),
                    'checks_no' => $this->input->post('checks_no', TRUE),
                    'bank_id' => $this->input->post('bank_id', TRUE),
                    'check_dt' => $formatedDate,
                    'pay_id' =>  $output
                ];
                  $output = $this->customerModel->createpayments($insert_data,"PaymentCheck");
                }

                   if ($output > 0 AND !empty($output))
                {
                  $this->response(['status' => TRUE, 'message' => $insert_data], REST_Controller::HTTP_NOT_FOUND);
                }
                 

                } else
                {
                    // Error
                    $message = [
                        'status' => FALSE,
                        'message' => "customer not create"
                    ];
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }
            } 

        } else {
            $this->response(['status' => FALSE, 'message' => $is_valid_token['message'] ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

 

  


    
}