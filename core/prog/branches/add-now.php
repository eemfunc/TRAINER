<?php
    $core->userChkRole('BRANCHES-EDIT');
    $chk_arr = array('name', 'admin_user_id', 'mobile', 'location', 'type');

    if(isset($_GET['id'])){
        if(!$core->dbNumRows('branches', array('id' => $_GET['id'])))
            $core->err(404);
        else
            define('ID', $_GET['id']);
        
        $e = false;
        
        if(!$core->chk_POST($chk_arr))
            $e = true;
        elseif(!strlen($_POST['name']))
            $e = true;
        elseif($core->dbNumRows('branches', array(
            'admin_user_id' => $_POST['admin_user_id'],
            'id<>' => $_GET['id']
        )))
            $e = true;
            
        $core->requireClass('branches-class', 'branches');
        $branches = new branches();
        if(!in_array($_POST['type'], $branches->TYPE_ARR))
            $e = true;
        
        if($e)
            $core->err(V_URLP.'branches-add&id='.ID, false);
        
        if($core->dbU("branches", array(
            'name'          => $core->aes($_POST['name']), 
            'location'      => $core->aes($_POST['location']), 
            'mobile'        => $core->aes($_POST['mobile']), 
            'admin_user_id' => $_POST['admin_user_id'], 
            'type'          => $core->aes($_POST['type'])
        ), array("id" => ID))){
            $core->err(V_URLP.'branches', true);
        }else{
            $core->err(V_URLP.'branches-add&id='.ID, false);
        }
    }else{
        if(!$core->chk_POST($chk_arr)){
            $core->err(V_URLP.'branches-add', false);
        }
        if($core->dbI('branches', array(
            'name'          => $core->aes($_POST['name']),
            'location'      => $core->aes($_POST['location']),
            'mobile'        => $core->aes($_POST['mobile']),
            'admin_user_id' => $_POST['admin_user_id'],
            'type'          => $core->aes($_POST['type'])
        ))){
            $core->err(V_URLP.'branches', true);
        }else{
            $core->err(V_URLP.'branches-add', false);
        }
    }

?>