<?php

class xlsxvars{
    
    public $STATUS = false;
    public $INV_NAME;
    public $ARR = array();
    public $NEW_PRODUCTS = 0;
    public $REPEATED_PRODUCTS = 0;
    private $ID;
    private $JSON_CONTENT;
    private $JSON_FINAL;
    private $ROW_ERR = 0;
    private $CLOSE_DB;
    
    function __construct($id, $oc = true){
        
        $this->CLOSE_DB = $oc;
        
        $this->checkID($id);
        
        if($this->STATUS)
            $this->prepareData();
        
    }
    
    private function checkID($id){
        global $core;
        if($core->dbNumRows('invoices_xlsx', array('id' => $id), null, $this->CLOSE_DB)){
            $this->STATUS = true;
            $this->ID = $id;
        }
    }
    
    private function prepareData(){
        global $core;
        $db_data = $core->dbFetch('invoices_xlsx', array('id' => $this->ID), null, $this->CLOSE_DB);
        $this->INV_NAME = $core->aes($db_data[0]["name"], 1);
        $this->JSON_CONTENT = $core->aes($db_data[0]["json_content"], 1);
        $this->JSON_FINAL = $core->aes($db_data[0]["json_final"], 1);
        $core->requireClass('json');
        $json = new json();
        if($this->JSON_FINAL == null || !$json->chkJson($this->JSON_FINAL))
            $this->prepareJsonFinal();
        else
            $this->ARR = json_decode($this->JSON_FINAL);
        $this->prepareCounters();
    }
    
    private function prepareJsonFinal(){
        global $core;
        $sheet = explode("\"", $this->JSON_CONTENT)[1];
        $json_arr = json_decode($this->JSON_CONTENT);
        $total_rows = count($json_arr->$sheet);
        for($i = 0; $i < $total_rows; $i++){
            if(!isset($json_arr->$sheet[$i][0]))
                unset($json_arr->$sheet[$i]);
            else{
                $item_no = $json_arr->$sheet[$i][0];
                if($i < 3 || !$item_no || $item_no == 'total')
                    unset($json_arr->$sheet[$i]);
                else{
                    
                    $err = false;
                    
                    // item_no
                    $this->ARR[$i][0] = $this->removeNewLines($json_arr->$sheet[$i][0]);
                    
                    // importer
                    if(!isset($json_arr->$sheet[$i][1]) || $json_arr->$sheet[$i][1] == null || ($json_arr->$sheet[$i][1] !== 1 && $json_arr->$sheet[$i][1] !== 2))
                        $this->ARR[$i][1] = 1;
                    else
                        $this->ARR[$i][1] = $this->removeNewLines($json_arr->$sheet[$i][1]);
                    
                    // product_name
                    if(!isset($json_arr->$sheet[$i][2]) || $json_arr->$sheet[$i][2] == null){
                        $err = true;
                        $this->ARR[$i][2] = $core->txt('0207');
                    }else
                        $this->ARR[$i][2] = $this->removeNewLines($json_arr->$sheet[$i][2]);
                    
                    // cartons
                    if(!isset($json_arr->$sheet[$i][4]) || $json_arr->$sheet[$i][4] == null){
                        $err = true;
                        $this->ARR[$i][3] = 0;
                    }else
                        $this->ARR[$i][3] = $this->removeNewLines($json_arr->$sheet[$i][4]);
                    
                    // pieces_per_cartons
                    if(!isset($json_arr->$sheet[$i][5]) || $json_arr->$sheet[$i][5] == null){
                        $err = true;
                        $this->ARR[$i][4] = 0;
                    }else
                        $this->ARR[$i][4] = $this->removeNewLines($json_arr->$sheet[$i][5]);
                    
                    // quantity
                    if(!isset($json_arr->$sheet[$i][6]) || $json_arr->$sheet[$i][6] == null){
                        $err = true;
                        $this->ARR[$i][5] = 0;
                    }else
                        $this->ARR[$i][5] = $this->removeNewLines($json_arr->$sheet[$i][6]);
                    
                    // price_china
                    if(!isset($json_arr->$sheet[$i][7]) || $json_arr->$sheet[$i][7] == null){
                        $err = true;
                        $this->ARR[$i][6] = 0;
                    }else{
                        $x = $this->removeNewLines($json_arr->$sheet[$i][7]);
                        if(!is_numeric($x))
                            $this->ARR[$i][6] = 0;
                        else
                            $this->ARR[$i][6] = $x;
                    }
                    
                    // price_arrived
                    if(!isset($json_arr->$sheet[$i][10]) || $json_arr->$sheet[$i][10] == null){
                        $err = true;
                        $this->ARR[$i][7] = 0;
                    }else
                        $this->ARR[$i][7] = $core->nf($this->removeNewLines($json_arr->$sheet[$i][10]));
                    
                    // price_distribution
                    if(!isset($json_arr->$sheet[$i][14]) || $json_arr->$sheet[$i][14] == null){
                        $err = true;
                        $this->ARR[$i][8] = 0;
                    }else
                        $this->ARR[$i][8] = $this->removeNewLines($json_arr->$sheet[$i][14]);
                    
                    // price_wholesale
                    if(!isset($json_arr->$sheet[$i][15]) || $json_arr->$sheet[$i][15] == null){
                        $err = true;
                        $this->ARR[$i][9] = 0;
                    }else
                        $this->ARR[$i][9] = $this->removeNewLines($json_arr->$sheet[$i][15]);
                    
                    // price_retail
                    if(!isset($json_arr->$sheet[$i][16]) || $json_arr->$sheet[$i][16] == null){
                        $err = true;
                        $this->ARR[$i][10] = 0;
                    }else
                        $this->ARR[$i][10] = $this->removeNewLines($json_arr->$sheet[$i][16]);
                    
                    // error?
                    if($err){
                        $this->ARR[$i][11] = 1;
                        $this->ROW_ERR = 1;
                    }else
                        $this->ARR[$i][11] = 0;
                    
                }
            }
        }
        $this->ARR = array_values($this->ARR);
        $this->JSON_FINAL = json_encode($this->ARR);
        $this->updateJsonFinal();
    }
    
    private function updateJsonFinal(){
        global $core;
        return ($core->dbU('invoices_xlsx', array(
            'json_final'    => $core->aes($this->JSON_FINAL),
            'errors'        => $core->aes($this->ROW_ERR)
        ), array('id' => $this->ID), $this->CLOSE_DB)) ? true : false;
    }
     
    private function removeNewLines($str, $separator = ' - '){
        if(strstr($str, "\n")){
            $str_arr = explode("\n", $str);
            $output = '';
            for($i = 0; $i < count($str_arr); $i++){
                if($i != 0)
                    $output.= $separator;
                $output.= trim($str_arr[$i]);
            }
            return trim($output);
        }else
            return trim($str);
    }
    
    public function getImporterName($sector){
        global $core;
        return $core->aes($core->dbFetch('importers', array('sectorXlsxInvoice' => $sector), null, $this->CLOSE_DB)[0]['name'], 1);
    }
    
    public function prepareCounters(){
        global $core;
        $n = 0;
        for($i = 0; $i < count($this->ARR); $i++)
            if($core->dbNumRows('products', array('item_no' => $core->aes($this->ARR[$i][0]), null, $this->CLOSE_DB)))
                $n++;
        $this->REPEATED_PRODUCTS    = $n;
        $this->NEW_PRODUCTS         = (count($this->ARR) - $this->REPEATED_PRODUCTS);
    }
    
    public function getUserName($id){
        global $core;
        return $core->aes($core->dbFetch('users', array('id' => $id), null, $this->CLOSE_DB)[0]['name'], 1);
    }
    
    public function finishProducts(){
        global $core;
        
        $updateDB = false;
        
        for($i = 0; $i < count($this->ARR); $i++){
            if($core->dbNumRows('products', array('item_no' => $core->aes($this->ARR[$i][0]), null, $this->CLOSE_DB))){
                
                $data_arr = array(
                    'importer_id' => $this->getImporterId($this->ARR[$i][1])
                );
                
                if($this->ARR[$i][6] > 0)
                    $data_arr['price_china'] = $core->aes($this->ARR[$i][6]);
                
                if($this->ARR[$i][7] > 0)
                    $data_arr['price_arrival'] = $core->aes($this->ARR[$i][7]);
                
                if($this->ARR[$i][8] > 0)
                    $data_arr['price_distribution'] = $core->aes($this->ARR[$i][8]);
                
                if($this->ARR[$i][9] > 0)
                    $data_arr['price_wholesale_iqd'] = $core->aes($this->ARR[$i][9]);
                
                if($this->ARR[$i][10] > 0)
                    $data_arr['price_retail_iqd'] = $core->aes($this->ARR[$i][10]);
                
                $updateDB = $core->dbU('products', $data_arr, array('item_no' => $core->aes($this->ARR[$i][0])), $this->CLOSE_DB);

            }else
                $updateDB = $core->dbI('products', array(
                    'item_no'               => $core->aes($this->ARR[$i][0]),
                    'importer_id'           => $this->getImporterId($this->ARR[$i][1]),
                    'name'                  => $core->aes($this->ARR[$i][2]),
                    'price_china'           => $core->aes($this->ARR[$i][6]),
                    'price_arrival'         => $core->aes($this->ARR[$i][7]),
                    'price_distribution'    => $core->aes($this->ARR[$i][8]),
                    'price_wholesale_iqd'   => $core->aes($this->ARR[$i][9]),
                    'price_retail_iqd'      => $core->aes($this->ARR[$i][10])
                ), $this->CLOSE_DB);
        }
        
        if($updateDB){
            if($this->updateArrivalDate(1))
                return true;
            else
                return false;
        }else
            return false;
    }
    
    private function getImporterId($sector){
        global $core;
        return $core->dbFetch('importers', array('sectorXlsxInvoice' => $sector), null, $this->CLOSE_DB)[0]['id'];
    }
    
    public function finishQuantities(){
        global $core;
        $this->finishProducts();
        $updateDB           = false;
        $defaultStoreSector = 1;
        for($i = 0; $i < count($this->ARR); $i++){
            $updateDB = $core->dbI('products_quantities', array(
                'product_id'    => $this->getProductId($this->ARR[$i][0]),
                'store_id'      => $this->getStoreId($defaultStoreSector),
                'quantity'      => $core->aes($this->ARR[$i][5]),
                'details'       => $core->aes('XLSX INVOICE ('.$this->ID.')')
            ), $this->CLOSE_DB);
        }
        if($updateDB){
            if($this->updateArrivalDate(2))
                return true;
            else
                return false;
        }else
            return false;
    }
    
    private function getStoreId($sector){
        global $core;
        return $core->dbFetch('stores', array('sectorXlsxInvoice' => $sector), null, $this->CLOSE_DB)[0]['id'];
    }
    
    private function getProductId($item_no){
        global $core;
        return $core->dbFetch('products', array('item_no' => $core->aes($item_no)), null, $this->CLOSE_DB)[0]['id'];
    }
    
    private function updateArrivalDate($done){
        global $core;
        if($core->dbU('invoices_xlsx', array(
            'arrival_date'  => $core->aes(date('Y-m-d')),
            'done'          => $done
        ), array('id' => $this->ID), $this->CLOSE_DB))
            return true;
        else
            return false;
        
    }
}

?>