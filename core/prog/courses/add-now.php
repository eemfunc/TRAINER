<?php
    $core->userChkRole('COURSES-EDIT');
    if(isset($_POST['id']) && !empty($_POST['id'])){
        if(!$core->chk_POST(array('name', 'type', 'lecturer_id', 'course_var_id', 'start_date', 'end_date', 'lectures_no', 'price', 'rewards'))){
            $core->err(V_URLP.'courses-add&id='.$_POST['id'], false);
        }elseif(strlen($_POST['name']) < 3){
            $core->err(V_URLP.'courses-add&id='.$_POST['id'], false);
        }
        
        // Here to update some error conditions!

        if($core->dbNumRows('courses', array('id' => $_POST['id']))){
            if($core->dbU('courses', array(
                'name'          => $core->aes($_POST['name']),
                'type'          => $core->aes($_POST['type']),
                'lecturer_id'   => $_POST['lecturer_id'],
                'course_var_id' => $core->aes($_POST['course_var_id']),
                'start_date'    => $core->aes($_POST['start_date']),
                'end_date'      => $core->aes($_POST['end_date']),
                'lectures_no'   => $core->aes($_POST['lectures_no']),
                'price'         => $core->aes($_POST['price']),
                'rewards'       => $core->aes($_POST['rewards']),
                'details'       => $core->aes($_POST['details'])
            ), array('id' => $_POST['id']))){
                $core->err(V_URLP.'courses', true);
            }else{
                $core->err(V_URLP.'courses-add&id='.$_POST['id'], false);
            }
        }else{
            $core->err(404);
        }
    }else{
        if(!$core->chk_POST(array('name', 'type', 'lecturer_id', 'course_var_id', 'start_date', 'end_date', 'lectures_no', 'price', 'rewards'))){
            $core->err(V_URLP.'courses-add', false);
        }elseif(strlen($_POST['name']) < 3){
            $core->err(V_URLP.'courses-add', false);
        }

        // Here to update some error conditions!

        if($core->dbI('courses', array(
            'name'          => $core->aes($_POST['name']),
            'type'          => $core->aes($_POST['type']),
            'lecturer_id'   => $_POST['lecturer_id'],
            'course_var_id' => $core->aes($_POST['course_var_id']),
            'start_date'    => $core->aes($_POST['start_date']),
            'end_date'      => $core->aes($_POST['end_date']),
            'lectures_no'   => $core->aes($_POST['lectures_no']),
            'price'         => $core->aes($_POST['price']),
            'rewards'       => $core->aes($_POST['rewards']),
            'details'       => $core->aes($_POST['details'])
        ))){
            $core->err(V_URLP.'courses', true);
        }else{
            $core->err(V_URLP.'courses-add', false);
        }
    }
?>