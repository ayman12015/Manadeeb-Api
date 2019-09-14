<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends CI_Model
{
    protected $user_table = 'members';

    /**
     * Use Registration
     * @param: {array} User Data
     */
    public function insert_user(array $data) {
        $this->db->insert($this->user_table, $data);
        return $this->db->insert_id();
    }
     

    /**
     * User Login
     * ----------------------------------
     * @param: username or email address
     * @param: password


     */


     public function user_login($phone, $password)
    {
        $this->db->where('phone', $phone);
        
        $q = $this->db->get($this->user_table);

        if( $q->num_rows() ) 
        {
            $user_pass = $q->row('password');

            $send_pass= hash('sha512', $password);


            if( password_verify($send_pass, $user_pass)) {
                return $q->row();
            }
            return FALSE; 

        }else{
            return FALSE;
        }
    }

   
}
