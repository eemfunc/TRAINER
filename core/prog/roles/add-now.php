<?php

    $core->requireClass('roles-class', 'roles');
    $roles = new roles();

    if(isset($_GET['id'])){
        if(!$core->dbNumRows('roles', array('id' => $_GET['id'])))
            $core->err(404);
        else
            define('ID', $_GET['id']);
        
        $e = false;
        
        $post_chk = array('name', 'roles');
        if(!$core->chk_POST($post_chk))
            $e = true;
        elseif(!strlen($_POST['name']))
            $e = true;
            
        if($e)
            $core->err(V_URLP.'roles-add&id='.ID, false);
        
        if($core->dbU("roles", array(
            'name'  => $core->aes($_POST['name']), 
            'roles' => $core->aes($roles->rolesVbars($_POST['roles']))
        ), array("id" => ID)))
            $core->err(V_URLP.'roles', true);
        else 
            $core->err(V_URLP.'roles-add&id='.ID, false);
    }else
        if($core->dbI('roles', array(
            'name'  => $core->aes($_POST['name']),
            'roles' => $core->aes($roles->rolesVbars($_POST['roles']))
        )))
            $core->err(V_URLP.'roles', true);
        else
            $core->err(V_URLP.'roles-add', false);

?>