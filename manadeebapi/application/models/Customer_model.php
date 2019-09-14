<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_Model extends CI_Model
{
    protected $customer_table = 'customers';
     protected $shops_locations_table = 'shops_locations';

    /**
     * Add a new customer
     * @param: {array} customer Data
     */
    public function create_customer(array $data,$tableName) {

        if($tableName === 'locations'){
             $this->db->insert($this->shops_locations_table, $data);
        return $this->db->insert_id();
    }else if ($tableName === 'AddCust'){
             $this->db->insert($this->customer_table, $data);
        return $this->db->insert_id();
    }
   

    }
}




   
