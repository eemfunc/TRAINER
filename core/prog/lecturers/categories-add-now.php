<?php
    $core->userChkRole('EXPENSES-CATEGORIES-EDIT');
    if(!$core->chk_POST('name')){
        $core->err(404);
    }
    if($core->chk_POST('id')){
        if($core->dbNumRows('expenses_categories', array('id' => $_POST['id']))){
            if($core->dbU('expenses_categories', array('name' => $core->aes($_POST['name'])), array('id' => $_POST['id']))){
                $core->err(V_URLP.'expenses-categories', true);
            }else{
                $core->err(V_URLP.'expenses-categories-add&id='.$_POST['id'], false);
            }
        }else{
            $core->err(404);
        }
    }else{
        if($core->dbI('expenses_categories', array('name' => $core->aes($_POST['name'])))){
            $core->err(V_URLP.'expenses-categories', true);
        }else{
            $core->err(V_URLP.'expenses-categories-add', false);
        }
    }
?>