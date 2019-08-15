<?php
    $core->userChkRole('PRODUCTS-EDIT');
    
    if(!empty($_POST)){
        if($core->chk_POST(array('name', 'price_retail', 'price_wholesale', 'price_distribution', 'item_no', 'importer_id'))){
            
            if(isset($_POST['product_id']) && $_POST['product_id'] != null)
                $id = $_POST['product_id'];
            else
                $id = $core->newRandomID('products');

            $x0 = $core->aes($_POST['name']);
            $x1 = $core->aes($core->removeDollarSign($_POST['price_retail']));
            $x2 = $core->aes($core->removeDollarSign($_POST['price_wholesale']));
            $x3 = $core->aes($core->removeDollarSign($_POST['price_distribution']));
            $x4 = $core->aes($_POST['description']);
            $x5 = $core->aes($core->removeDollarSign($_POST['price_china']));
            $x6 = $core->aes($core->removeDollarSign($_POST['price_retail_iqd']));
            $x7 = $core->aes($core->removeDollarSign($_POST['price_wholesale_iqd']));
            $x8 = $core->aes($_POST['item_no']);
            $x9 = $core->aes($core->removeDollarSign($_POST['price_distribution_iqd']));
            $x10 = $core->aes($core->removeDollarSign($_POST['price_arrival']));
            $x11 = $core->aes($_POST['imported_from_company']);
            $x12 = $_POST['importer_id'];
            
            if(!$core->dbNumRows('products', array('id' => $id))){
                $res = $core->dbI('products', array(
                    'id'                        => $id,
                    'name'                      => $x0,
                    'price_retail'              => $x1,
                    'price_wholesale'           => $x2,
                    'price_distribution'        => $x3,
                    'description'               => $x4,
                    'price_china'               => $x5,
                    'price_retail_iqd'          => $x6,
                    'price_wholesale_iqd'       => $x7,
                    'price_distribution_iqd'    => $x9,
                    'item_no'                   => $x8,
                    'price_arrival'             => $x10,
                    'imported_from_company'     => $x11,
                    'importer_id'               => $x12
                ));
                if($res){
                    $core->err(V_URLP.'products-add'.'&id='.$id, true);
                }else{
                    $core->err(V_URLP.'products-add'.'&id='.$id, false);
                }
            }else{
                if($core->dbU('products', array(
                    'name'                      => $x0,
                    'price_retail'              => $x1,
                    'price_wholesale'           => $x2, 
                    'price_distribution'        => $x3, 
                    'description'               => $x4,
                    'price_china'               => $x5,
                    'price_retail_iqd'          => $x6,
                    'price_wholesale_iqd'       => $x7,
                    'price_distribution_iqd'    => $x9,
                    'item_no'                   => $x8,
                    'price_arrival'             => $x10,
                    'imported_from_company'     => $x11,
                    'importer_id'               => $x12
                ), array("id" => $id))){
                    $core->err(V_URLP.'products-add'.'&id='.$id, true);
                }else{
                    $core->err(V_URLP.'products-add'.'&id='.$id, false);
                }
            }
        }else{
            $core->err(V_URLP.'products', false);
        }
    }else{
        $core->err(404);
    }

?>