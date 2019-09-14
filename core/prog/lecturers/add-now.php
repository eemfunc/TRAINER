<?php
    $core->userChkRole('LECTURERS-EDIT');
    if(isset($_POST['id']) && !empty($_POST['id'])){
        if(!$core->chk_POST(array('name', 'mobile'))){
            $core->err(V_URLP.'lecturers-add&id='.$_POST['id'], false);
        }elseif(strlen($_POST['name']) < 3 || strlen($_POST['mobile']) < 10){
            $core->err(V_URLP.'lecturers-add&id='.$_POST['id'], false);
        }
        if($core->dbNumRows('staff', array('id' => $_POST['id']))){
            if($core->dbU('staff', array(
                'name'          => $core->aes($_POST['name']),
                'country'       => $core->aes($_POST['country']),
                'city'          => $core->aes($_POST['city']),
                'address'       => $core->aes($_POST['address']),
                'gender'        => $core->aes($_POST['gender']),
                'mobile'        => $core->aes($_POST['mobile']),
                'organization'  => $core->aes($_POST['organization']),
                'nationality'   => $core->aes($_POST['nationality']),
                'job_title'     => $core->aes($_POST['job_title']),
                'religion'      => $core->aes($_POST['religion']),
                'details'       => $core->aes($_POST['details']),
                'email'         => $core->aes($_POST['email']),
                'birthdate'     => $core->aes($_POST['birthdate'])
            ), array('id' => $_POST['id']))){
                $core->err(V_URLP.'lecturers', true);
            }else{
                $core->err(V_URLP.'lecturers-add&id='.$_POST['id'], false);
            }
        }else{
            $core->err(404);
        }
    }else{
        if(!$core->chk_POST(array('name', 'mobile'))){
            $core->err(V_URLP.'lecturers-add', false);
        }elseif(strlen($_POST['name']) < 3 || strlen($_POST['mobile']) < 10){
            $core->err(V_URLP.'lecturers-add', false);
        }
        if($core->dbI('staff', array(
            'name'          => $core->aes($_POST['name']),
            'country'       => $core->aes($_POST['country']),
            'city'          => $core->aes($_POST['city']),
            'address'       => $core->aes($_POST['address']),
            'gender'        => $core->aes($_POST['gender']),
            'mobile'        => $core->aes($_POST['mobile']),
            'organization'  => $core->aes($_POST['organization']),
            'nationality'   => $core->aes($_POST['nationality']),
            'job_title'     => $core->aes($_POST['job_title']),
            'religion'      => $core->aes($_POST['religion']),
            'details'       => $core->aes($_POST['details']),
            'email'         => $core->aes($_POST['email']),
            'birthdate'     => $core->aes($_POST['birthdate']),
            'type'          => $core->aes('LECTURER')
        ))){
            $core->err(V_URLP.'lecturers', true);
        }else{
            $core->err(V_URLP.'lecturers-add', false);
        }
    }
?>