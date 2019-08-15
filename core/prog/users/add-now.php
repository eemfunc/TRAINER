<?php
    $core->userChkRole('USERS-EDIT');
    $e = false;

    $id = null;
    if(isset($_GET['id']))
        if($_GET['id'] != null)
            $id = $_GET['id'];
        
    if(!$core->chk_POST(array('name', 'email', 'roles_id', 'branch_id')))
        $e = true;
    elseif(strlen($_POST['name']) < 1)
        $e = true;
    elseif(strlen($_POST['email']) < 5)
        $e = true;
    elseif(!strpos($_POST['email'], '@') || !strpos($_POST['email'], '.'))
        $e = true;
    elseif($id != null && $core->dbNumRows('users', array('id<>' => $_GET['id'], 'email' => $core->aes($_POST['email']))))
        $e = true;
    elseif($id == null && $core->dbNumRows('users', array('email' => $core->aes($_POST['email']))))
        $e = true;
    elseif(strlen($_POST['roles_id']) < 8)
        $e = true;
    elseif($_POST['roles_id'] == null || !$core->dbNumRows('roles', array('id' => $_POST['roles_id'])))
        $e = true;
    elseif(strlen($_POST['branch_id']) < 8)
        $e = true;
    elseif($_POST['branch_id'] == null || !$core->dbNumRows('branches', array('id' => $_POST['branch_id'])))
        $e = true;
    elseif($id != null && $_POST['password'] != null && strlen($_POST['password']) < 3)
        $e = true;
    elseif($id == null && ($_POST['password'] == null || strlen($_POST['password']) < 3))
        $e = true;

    $url_id = ($id != null) ? '&id='.$_GET['id'] : '';

    if($e)
        $core->err(V_URLP.'users-add'.$url_id, false);

    if(isset($_GET['id'])){
        if(!$core->dbNumRows('users', array('id' => $_GET['id'])))
            $core->err(404);
        $data_arr = array(
            'name'      => $core->aes($_POST['name']),
            'email'     => $core->aes(strtolower($_POST['email'])),
            'roles_id'  => $_POST['roles_id'],
            'branch_id' => $_POST['branch_id']
        );
        if($_POST['password'] != null)
            $data_arr['password'] = $core->aes($_POST['password']);
        if($core->dbU('users', $data_arr, array('id' => $_GET['id'])))
            $core->err(V_URLP.'users-add&id='.$_GET['id'], true);
        else 
            $core->err(V_URLP.'users-add&id='.$_GET['id'], false);
    }else{
        $res = $core->dbI('users', array(
            'name'      => $core->aes($_POST['name']),
            'email'     => $core->aes(strtolower($_POST['email'])),
            'roles_id'  => $_POST['roles_id'],
            'branch_id' => $_POST['branch_id'],
            'password'  => $core->aes($_POST['password'])
        ));
        if($res)
            $core->err(V_URLP.'users', true);
        else
            $core->err(V_URLP.'users', false);
    }
    
?>