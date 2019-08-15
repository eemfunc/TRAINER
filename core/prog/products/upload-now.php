<?php
    $core->userChkRole('PRODUCTS-UPLOAD-PIC');
if(isset($_GET['id'])){
    if(isset($_FILES['pic'])){
        
        $core->requireClass('files');
        $file = new files($_FILES['pic'], V_ALLOWED_PIC_EXTENSIONS, V_PRODUCTS_PIC_FOLDER);
        
        if($file->EXT_ERR || $file->SIZ_ERR)
            $core->err(V_URLP.'products-add&id='.$_GET['id'], false);

        if($file->uploadNow()){
            if($core->dbI('products_img', array(
                'url'           => $core->aes($file->FILE_URL),
                'product_id'    => $_GET['id']
            )))
                $core->err(V_URLP.'products-add&id='.$_GET['id'], true);
            else $core->err(V_URLP.'products-add&id='.$_GET['id'], false);
        }else $core->err(V_URLP.'products-add&id='.$_GET['id'], false);
        
    }else $core->err(V_URLP.'products-add&id='.$_GET['id'], false);
}else $core->err(V_URLP.'products', false);


?>