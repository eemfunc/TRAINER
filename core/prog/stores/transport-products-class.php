<?php

class tp{
    
    public $ID = null;
    public $DRAFT_ARR = array();
    public $TABLE_ARR = array();
    public $PAGE = 1;
    public $TOTAL_PAGES = 1;
    public $TOTAL_ROWS = 1;
    public $START_FROM = 1;
    public $START_TO = 1;
    public $EDIT = true;
    public $EDIT_DISABLED = 'disabled';
    public $NEW_DISABLED = null;
    public $VIEW_ONLY_TP = false;
    public $STORE_ID_FROM;
    public $STORE_NAME_FROM;
    public $STORE_ID_TO;
    public $STORE_NAME_TO;
    public $TRANSPORT_PRODUCTS_ARR = array();
    public $STORE_EDIT_DISABLED = null;

    private $CLOSE_DB = true;
    private $DB_TABLE = 'stores_transport';
    
    function __construct($id = null, $oc = true){
        
        $this->CLOSE_DB = $oc;
        
        if($id != null){
            $this->ID = $id;
            $this->chkId();
            $this->initTransportProducts();
        }
        
    }
    
    public function initDraftArr(){
        global $core;

        $rows = $core->dbFetch('stores_transport_products', array('draft' => '1'), null, $this->CLOSE_DB);
        foreach($rows as $r){
            if(!$core->in_array_v1($r['stores_transport_id'], $this->DRAFT_ARR)){
                
                $d_arr = $core->dbFetch('stores_transport_products', array('stores_transport_id' => $r['stores_transport_id']), 'ORDER BY created_at DESC LIMIT 1', $this->CLOSE_DB);
                
                $user_name = $core->aes($core->dbFetch('users',array('id' => $d_arr[0]['user_id']), null, $this->CLOSE_DB)[0]['name'], 1);
                
                $store_from_arr = $core->dbFetch('stores', array('id' => $d_arr[0]['store_id_from']), null, $this->CLOSE_DB);
                
                $store_name_from = $core->aes($store_from_arr[0]['name'], 1);
                
                if($d_arr[0]['user_id'] == $core->userData('id') || $core->userHaveRole('STORES-TRANSPORT-PRODUCTS-ALL-ACCESS')){
                    $store_name_to = $core->aes($core->dbFetch('stores', array('id' => $d_arr[0]['store_id_to']), null, $this->CLOSE_DB)[0]['name'], 1);

                    $date_arr = $core->dbFetch('stores_transport_products', array('stores_transport_id' => $r['stores_transport_id']), 'ORDER BY created_at ASC LIMIT 1', $this->CLOSE_DB);

                    $da = explode(' ', $date_arr[0]['created_at'])[0];

                    $output_arr = array(
                        'id' => $r['stores_transport_id'],
                        'sf' => $store_name_from,
                        'st' => $store_name_to,
                        'da' => $da,
                        'un' => $user_name
                    );

                    array_push($this->DRAFT_ARR, $output_arr);
                }
            }
        }
        return true;
    }
    
    public function initTableArr(){
        global $core;
        
        $rows = $core->dbFetch($this->DB_TABLE, null, 'ORDER BY created_at DESC', $this->CLOSE_DB, true);
        foreach($rows as $r){
            if($core->chkFilterLimits()){
                
                $done_by_user_name = ($r['done_by_user_id']) ? $core->aes($core->dbFetch('users', array('id' => $r['done_by_user_id']), null, $this->CLOSE_DB)[0]['name'], 1) : '';
                
                $d_arr = $core->dbFetch('stores_transport_products', array('stores_transport_id' => $r['id']), 'ORDER BY created_at DESC LIMIT 1', $this->CLOSE_DB);
                
                $store_from_arr = $core->dbFetch('stores', array('id' => $d_arr[0]['store_id_from']), null, $this->CLOSE_DB);
                
                $store_name_from = $core->aes($store_from_arr[0]['name'], 1);
                
                $store_branch_id_from = $store_from_arr[0]['branch_id'];
                
                $store_to_arr = $core->dbFetch('stores', array('id' => $d_arr[0]['store_id_to']), null, $this->CLOSE_DB);
                
                $store_name_to = $core->aes($store_to_arr[0]['name'], 1);

                $store_branch_id_to = $store_to_arr[0]['branch_id'];
                
                if($store_branch_id_from == $core->userData('branch_id') || $store_branch_id_to == $core->userData('branch_id') || $core->userHaveRole('STORES-TRANSPORT-PRODUCTS-ALL-ACCESS')){
                    $u_name = $core->aes($core->dbFetch('users', array('id' => $r['user_id']), null, $this->CLOSE_DB)[0]["name"], 1);

                    $output_arr = array(
                        'id' => $r['id'],
                        'sf' => $store_name_from,
                        'st' => $store_name_to,
                        'st_b_to' => $store_branch_id_to,
                        'dbun' => $done_by_user_name,
                        'u_name' => $u_name,
                        'status' => $r['status'],
                        'created_date' => explode(' ', $r['created_at'])[0],
                        'arrival_date' => $core->aes($r['arrival_date'], 1)
                    );

                    array_push($this->TABLE_ARR, $output_arr);
                }
            }
        }
        return true;
    }
    
    public function chkId(){
        global $core;
        
        if(!$core->dbNumRows('stores_transport_products', array('stores_transport_id' => $_GET['id']), null, $this->CLOSE_DB))
            $core->err(404);
        else{
            $this->ID = $_GET['id'];
            $this->STORE_EDIT_DISABLED = 'disabled';
        }
        
        if($core->dbNumRows('stores_transport', array('id' => $this->ID), null, $this->CLOSE_DB)){
            $this->EDIT = false;
            $this->NEW_DISABLED = 'disabled';
            $this->VIEW_ONLY_TP = true;
        }else
            $this->EDIT_DISABLED = '';
        
        $store_id_arr = $core->dbFetch('stores_transport_products', array('stores_transport_id' => $this->ID), 'ORDER BY created_at DESC LIMIT 1', $this->CLOSE_DB);
        $this->STORE_ID_FROM    = $store_id_arr[0]['store_id_from'];
        $this->STORE_ID_TO      = $store_id_arr[0]['store_id_to'];
        $this->STORE_NAME_FROM  = $core->aes($core->dbFetch('stores', array('id'=> $this->STORE_ID_FROM), null, $this->CLOSE_DB)[0]['name'], 1);
        $this->STORE_NAME_TO    = $core->aes($core->dbFetch('stores', array('id'=> $this->STORE_ID_TO), null, $this->CLOSE_DB)[0]['name'], 1);
        
        return true;
    }
    
    private function fromStores($selected_id = ''){
        global $core;
        
        if($selected_id == '')
            $txt = '<option value="" selected>'.$core->txt('0068').'</option>';
        else
            $txt = '';
        
        $rows = $core->dbFetch('stores', null, 'ORDER BY created_at ASC', $this->CLOSE_DB);
        foreach($rows as $r){
            if($core->userHaveRole('STORES-TRANSPORT-PRODUCTS-ALL-ACCESS') || ($r['branch_id'] == $core->userData('branch_id') && $core->userData('branch_type') != 'REPRESENTATIVES-BRANCH') || ($r['id'] == $core->userData('user-access-store-id') && $core->userData('branch_type') == 'REPRESENTATIVES-BRANCH') || $this->ID != null){
                $txt.= "<option value='".$r['id']."'";
                if($r['id'] == $selected_id)
                    $txt.= 'selected';
                $txt.= ">".$core->aes($r['name'], 1)."</option>";
            }
        }
        return $txt;
    }
    
    private function toStores($selected_id_from = ''){
        global $core;
        $txt = '';
        $rows = $core->dbFetch('stores', null, 'ORDER BY created_at ASC', $this->CLOSE_DB);
        foreach($rows as $r){
            if($selected_id_from != '' && $r['id'] != $selected_id_from){
                $txt.= "<option value='".$r['id']."'";
                if($r['id'] == $this->STORE_ID_TO)
                    $txt.= 'selected';
                $txt.= ">".$core->aes($r['name'], 1)."</option>";
            }
        }
        return $txt;
    }
    
    public function storeIdFromOptions(){
        if($this->NEW_DISABLED == '' || $this->VIEW_ONLY_TP)
            $txt = $this->fromStores($this->STORE_ID_FROM);
        else
            $txt = $this->fromStores();
        
        return $txt;
    }
    
    public function storeIdtoOptions(){
        $txt = '';
        if($this->NEW_DISABLED == '' || $this->VIEW_ONLY_TP)
            $txt = $this->toStores($this->STORE_ID_FROM);
        
        return $txt;
    }
    
    public function initTransportProducts(){
        global $core;
        
        if($this->ID != ''){
            $rows = $core->dbFetch('stores_transport_products', array('stores_transport_id' => $this->ID), 'ORDER BY created_at ASC', $this->CLOSE_DB);
            foreach($rows as $r){
                $output_arr['id'] = $r['id'];
                $product_arr = $core->dbFetch('products', array('id' => $r['product_id']), null, $this->CLOSE_DB);
                $output_arr['product_name'] = $core->aes($product_arr[0]['name'], 1);
                $output_arr['product_item_no'] = $core->aes($product_arr[0]['item_no'], 1);
                $output_arr['quantity'] = $core->aes($r['quantity'], 1);
                if($r['packing_id'] == 1)
                    $output_arr['packing'] = $core->txt('0129').' (1)';
                else{
                    $packing_arr = $core->dbFetch('packing', array('id' => $r['packing_id']), null, $this->CLOSE_DB);
                    $output_arr['packing'] = $core->aes($packing_arr[0]['name'], 1).' ('.$core->aes($packing_arr[0]['quantity'], 1).')';
                }
                array_push($this->TRANSPORT_PRODUCTS_ARR, $output_arr);
            }
        }
        return true;
    }
    
    public function chkMainTableId($id = null){
        global $core;
        if($id == null)
            $core->err(404);
        elseif(!$core->dbNumRows('stores_transport', array('id' => $id), null, $this->CLOSE_DB))
            $core->err(404);
    }
    
    public function acceptTp($id){
        global $core;
        if($core->dbU("stores_transport", array(
            'status'            => '1', 
            'done_by_user_id'   => $core->userData('id'), 
            'arrival_date'      => $core->aes(date('Y-m-d'))
        ), array("id" => $_GET['id']), $this->CLOSE_DB))
            if($core->dbU("stores_transport_products", array('draft' => '0'), array("stores_transport_id" => $_GET['id']), $this->CLOSE_DB)){
                $store_id_to = $core->dbFetch('stores_transport_products', array('stores_transport_id' => $_GET['id']), ' LIMIT 1', $this->CLOSE_DB)[0]['store_id_to'];
                $rows = $core->dbFetch('products_quantities', array('stores_transport_id' => $_GET['id']), null, $this->CLOSE_DB);
                foreach($rows as $r){
                    if(!$core->dbI('products_quantities', array(
                        'product_id'    => $r['product_id'],
                        'store_id'      => $store_id_to,
                        'quantity'      => $core->aes($core->aes($r['quantity'], 1) * -1),
                        'details'       => $core->aes("TRANSPORT-PRODUCTS: ".$_GET['id'])
                    ), $this->CLOSE_DB))
                        return false;
                }
                return true;
            }else return false;
        else return false;
    }
    
    public function rejectTp($id){
        global $core;
        if($core->dbU("stores_transport", array(
            'status'            =>  '2', 
            'done_by_user_id'   => $core->userData('id'), 
            'arrival_date'      => $core->aes(date('Y-m-d'))
        ), array("id" => $_GET['id']), $this->CLOSE_DB))
            if($core->dbU("stores_transport_products", array('draft' => '0'), array("stores_transport_id" => $_GET['id']), $this->CLOSE_DB))
                if($core->dbD("products_quantities", array("stores_transport_id" => $_GET["id"]), $this->CLOSE_DB))
                    return true;
                else
					return false;
            else
				return false;
        else
			return false;
    }
    
    public function chkSubTableId($id = null){
        global $core;
        if($id == null)
            $core->err(404);
        elseif(!$core->dbNumRows('stores_transport_products', array('stores_transport_id' => $id), null, $this->CLOSE_DB))
            $core->err(404);
    }
    
    public function deleteTp($id){
        global $core;
        if($core->dbD('stores_transport_products', array('stores_transport_id' => $id), $this->CLOSE_DB))
            if($core->dbD('products_quantities', array('stores_transport_id' => $id), $this->CLOSE_DB))
                return true;
            else return false;
        else return false;
    }
    
    public function deleteProductFromTp($id, $tpId){
        global $core;
        if($core->dbD('stores_transport_products', array('id' => $id), $this->CLOSE_DB))
            if($core->dbD('products_quantities', array(
                'stores_transport_id'           => $tpId,
                'stores_transport_product_id'   => $id
            ), $this->CLOSE_DB))
                return true;
            else return false;
        else return false;
    }
           
    public function chkSTPI($id = null){
        global $core;
        if($id == null)
            $core->err(404);
        elseif(!$core->dbNumRows('stores_transport_products', array('id' => $id), null, $this->CLOSE_DB))
            $core->err(404);
    }
	
	public function tpAddNow($id){
        global $core;
        if($core->dbI('stores_transport', array('id' => $id), $this->CLOSE_DB))
            if($core->dbU("stores_transport_products", array('draft' => '0'), array("stores_transport_id" => $id), $this->CLOSE_DB))
                return true;
            else return false;
        else return false;
    }
}

?>