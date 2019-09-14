<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Addbill_model extends CI_Model
{
   

    /**
     * get bills
     * @param: {array} Bills Data
     */
    
public function get_custbill($CustId)
{
 
 
 $this->db->select('*');
        $this->db->from('customers_bills');
        $this->db->where('cust_id', $CustId); 
        $this->db->order_by('BillId', 'DESC');
       
        $query = $this->db->get();
       
        return $query->result();
    }

    // cancel bill

    public function cancel_bill($Bill_id){

     $this->db->set('payment_status', 2);
     $this->db->where('BillId',$Bill_id);
    $this->db->update('customers_bills');
    }
   
   //get valiable product

public function get_avaliableProduct($CustCompanyId,$uer_id)
{
 
  
       $this->db->select('*');
       $this->db->from('prod_avalable');
       $this->db->where('company_id', $CustCompanyId); 
      // $this->db->where('user_id', $uer_id); 

    
         
        $query = $this->db->get();
       
        return $query->result();
    }


   
// get unpaid customer list
 public function get_requestproducts( $CustCompanyId)
{
   
 $this->db->select("CONCAT(p.prod_name, ' - ', pg.package_name) AS 'ProdNamePackage'  , pg.package_abbreviation, pp.ProductPrice");
       $this->db->from('products p');
       $this->db->join('ProductPrice pp', 'pp.prod_id=p.prod_id');
       $this->db->join('packages pg ', 'pp.package_id=pg.package_id');
       $this->db->where('pp.company_id', $CustCompanyId); 
       $this->db->where('pp.CurrentPrice', 1); 
       //$this->db->where('user_id', $uer_id); 

    
         
        $query = $this->db->get();
       
        return $query->result();
    }

    // get customers

 public function get_customers( $CustCompanyId,$weekId,$uer_id)
{
 
 
      $this->db->select('*');
       $this->db->from('customers');
       $this->db->where('company_id', $CustCompanyId); 
       $this->db->where('weekId', $weekId); 
       $this->db->where('user_id', $uer_id); 

    
         
        $query = $this->db->get();
       
        return $query->result();
    }

    //get product
    
     public function get_product($uer_id)
       {
 
 
       $this->db->select('*');
       $this->db->from('and_shipped_prod');
     //  $this->db->where('company_id', $CustCompanyId); 
      
       $this->db->where('owner_id', $uer_id); 

    
         
        $query = $this->db->get();
       
        return $query->result();
    }

 //get unpaid customer list


    public function get_unpaidcustomerlist( $CustCompanyId,$weekId,$uer_id)
{
 
 
  
       $this->db->select('*');
       $this->db->from('customers c');
       $this->db->join('shops_locations cl', 'c.location_id=cl.location_id');
       $this->db->where('c.company_id', $CustCompanyId); 
       $this->db->where('c.del', 0); 
       $this->db->where('c.user_id', $uer_id); 

    
         
        $query = $this->db->get();
       
        return $query->result();
    }
    


    // get banks information
 public function get_banks()
{
 
 
 $this->db->select('*');
        $this->db->from('customer_banks');
       // $this->db->where('cust_id', $cust_id); 
        $this->db->order_by('bank_id', 'DESC');
       
        $query = $this->db->get();
       
        return $query->result();
    }

    //get customer information


}



       


