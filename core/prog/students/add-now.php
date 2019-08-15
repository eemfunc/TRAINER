<?php
    $core->userChkRole('STUDENTS-EDIT');
    if(!$core->chk_POST(array('name', 'country', 'city', 'address', 'gender', 'mobile', 'organization', 'nationality', 'job_title', 'religion', 'details', 'email', 'birthdate'))){
        $core->err(404);
    }elseif(strlen($_POST['name']) < 3 || strlen($_POST['mobile']) < 10){
        $core->err(404);
    }
    if(isset($_POST['id']) && !empty($_POST['id'])){
        if($core->dbNumRows('expenses', array('id' => $_POST['id']))){
            if($core->dbU('expenses', array(
                'expenses_categories_id'    => $_POST['expenses_category'],
                'amount'                    => $core->aes($_POST['amount']),
                'currency'                  => $core->aes($_POST['currency']),
                'details'                   => $core->aes($_POST['details'])
            ), array('id' => $_POST['id']))){
                $core->err(V_URLP.'expenses', true);
            }else{
                $core->err(V_URLP.'expenses-add&id='.$_POST['id'], false);
            }
        }else{
            $core->err(404);
        }
    }else{
        $core->requireClass('payments');
        $pay = new payments();
        if($core->dbI('expenses', array(
            'expenses_categories_id'    => $_POST['expenses_category'],
            'amount'                    => $core->aes($_POST['amount']),
            'currency'                  => $core->aes($_POST['currency']),
            'details'                   => $core->aes($_POST['details']),
            'branch_id'                 => $core->userData('branch_id'),
            'dollar_price'              => $core->aes($pay->USD_PRICE)
        ))){
            $core->err(V_URLP.'expenses', true);
        }else{
            $core->err(V_URLP.'expenses-add', false);
        }
    }
?>