<?php defined('BASEPATH') OR exit('No direct script access allowed');

use manadeebapi\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
 
class Users extends \manadeebapi\Libraries\REST_Controller
{
    public function __construct() {
        parent::__construct();
        // Load User Model
        $this->load->model('user_model', 'UserModel');
    }

  /**
     * User Register
     * --------------------------
     * @param: username
     * @param: email
     * @param: password
     * --------------------------
     * @method : POST
     * @link : api/user/register
     */
    public function register_post()
    {
        header("Access-Control-Allow-Origin: *");

        # XSS Filtering (https://www.codeigniter.com/user_guide/libraries/security.html)
        $_POST = $this->security->xss_clean($_POST);
        
        # Form Validation
    
        $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|max_length[20]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[80]');
        $this->form_validation->set_rules('phone', 'phone', 'trim|required|max_length[80]');

        $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[100]');
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
            
            $insert_data = [

                'username' => $this->input->post('username', TRUE),
                'email' => $this->input->post('email', TRUE),
                'password' => md5($this->input->post('password', TRUE)),
                'phone' => $this->input->post('phone', TRUE),
                'company_id' => $this->input->post('company_id', TRUE),
                
            ];

            // Insert User in Database
            $output = $this->UserModel->insert_user($insert_data);
            if ($output > 0 AND !empty($output))
            {
                // Success 200 Code Send
                $message = [
                    'status' => true,
                    'message' => "User registration successful"
                ];
                $this->response($message, REST_Controller::HTTP_OK);
            } else
            {
                // Error
                $message = [
                    'status' => FALSE,
                    'message' => "Not Register Your Account."
                ];
                $this->response($message, REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }
   


    /**
     * User Login API
     * --------------------
     * @param: username or email
     * @param: password
     * --------------------------
     * @method : POST
     * @link: api/user/login
     */
     public function login_post()
    {
        header("Access-Control-Allow-Origin: *");

        # XSS Filtering (https://www.codeigniter.com/user_guide/libraries/security.html)
        $_POST = $this->security->xss_clean($_POST);
        
        # Form Validation
        $this->form_validation->set_rules('phone', 'phone', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[100]');
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
            // Load Login Function
            $output = $this->UserModel->user_login($this->input->post('phone'), $this->input->post('password'));
            if (!empty($output) AND $output != FALSE)
            {
                // Load Authorization Token Library
                $this->load->library('Authorization_Token');

                // Generate Token
                
                $token_data['id'] = $output->id;
                $token_data['username'] = $output->username;
                $token_data['email'] = $output->email;
                $token_data['phone'] = $output->phone;
                $token_data['company_id'] = $output->company_id;
                $token_data['time'] = time();


                $user_token = $this->authorization_token->generateToken($token_data);

                $return_data = [
                    'user_id' => $output->id,
                    'username' => $output->username,
                    'email' => $output->email,
                    'phone' => $output->phone,
                    'company_id' => $output->company_id,
                    'token' => $user_token,
                ];

                // Login Success
                $message = [
                    'status' => true,
                    'data' => $return_data,
                    'message' => "User login successful"
                ];
                $this->response($message, REST_Controller::HTTP_OK);
            } else
            {
                // Login Error
                $message = [
                    'status' => FALSE,
                    'message' => "Invalid Username or Password"
                ];
                $this->response($message, REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }
}