<?php 
    $core->userChkRole('PRODUCTS-VIEW');
    echo $theme->getHeader();

$url_link_p="products";
$url_link_p_add_now='products-add-now';
$url_link_p_upload_now='products-upload-now';

$id="";
if(isset($_GET['id']))
    if($_GET['id'] != "")
        $id = $_GET['id'];

$edit_values = array('', '', '', '', '', '', '', '', '', '', '', '', '', '');
$importers_options = null;

if($id != ""){
    $rows = $core->dbFetch('products', array('id' => $id));
    foreach($rows as $r){
        $edit_values[0]   = $core->aes($r['name'], 1);
        $edit_values[1]   = $core->aes($r['price_retail'], 1);
        $edit_values[2]   = $core->aes($r['price_wholesale'], 1);
        $edit_values[3]   = $core->aes($r['price_distribution'], 1);
        $edit_values[4]   = $core->aes($r['price_china'], 1);
        $edit_values[5]   = $core->aes($r['description'], 1);
        $edit_values[6]   = $core->aes($r['price_retail_iqd'], 1);
        $edit_values[7]   = $core->aes($r['price_wholesale_iqd'], 1);
        $edit_values[9]   = $core->aes($r['item_no'], 1);
        $edit_values[10]  = $core->aes($r['price_distribution_iqd'], 1);
        $edit_values[11]  = $core->aes($r['price_arrival'], 1);
        $edit_values[12]  = $core->aes($r['imported_from_company'], 1);
        $edit_values[13]  = $r['importer_id'];
    }
    $rows = $core->dbFetch('importers', null, 'ORDER BY created_at DESC');
    foreach($rows as $r){
        $importers_options.= "<option value='".$r['id']."'";
        if($r['id'] == $edit_values[13]){
            $importers_options.= "selected";
        }
        $importers_options.= ">".$core->aes($r['name'], 1)."</option>";
    }
    $rows = $core->dbFetch('products_img', array('product_id' => $id), 'ORDER BY created_at DESC LIMIT 1');
    foreach($rows as $r)
        if($core->aes($r['url'], 1) != null)
            $edit_values[8] = $core->aes($r['url'], 1);
    
}else{
    $rows = $core->dbFetch('importers', null, 'ORDER BY created_at DESC');
    foreach($rows as $r){
        $importers_options.= "<option selected>".$core->txt('0068')."</option>";
        $importers_options.= "<option value='".$r['id']."'>".$core->aes($r['name'], 1)."</option>";
    }
}

?>

    <div class="row">
        <div class="col-lg-6 grid-margin stretch-card rtl">
              <div class="card">
                <div class="card-body">
                  <h4 class="hb title-size center"><?php echo $core->txt('0052'); ?><br><br></h4>
                  <form class="forms-sample" <?php if($core->userHaveRole('PRODUCTS-EDIT'))echo "method=\"post\" action=\"".V_URLP.$url_link_p_add_now."\""; ?>>
                      
                    <input name="product_id" id="product_id" type="hidden" value="<?php echo $id; ?>">
                      
                      
                    <?php //if($id!=""){ ?>
                        <!--<div class="form-group center">
                          <img src="<?php echo $edit_values[8]; ?>" class="img">
                        </div>-->
                    <?php //} ?>
                      
                      
                    <div class="form-group">
                      <label for="x1"><?php echo $core->txt('0057'); ?> *</label>
                      <input name="name" value="<?php echo $edit_values[0]; ?>" type="text" class="form-control form-control-sm" id="x1">
                    </div>
                      
                      <!-- Item No -->
                    <div class="form-group">
                      <label for="x1item"><?php echo $core->txt('0113'); ?> *</label>
                      <input name="item_no" value="<?php echo $edit_values[9]; ?>" type="text" class="form-control form-control-sm" id="x1ite,">
                    </div>
                      
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="x7"><?php echo $core->txt('0110').' ('.$core->txt('0048').')'; ?> *</label>
                                <input name="price_retail" value="<?php echo $edit_values[1]; ?>" type="text" data-inputmask="'alias': 'currency'" class="form-control form-control-sm" id="x7">
                            </div>
                            <div class="col-sm-6">
                                <label for="x71"><?php echo $core->txt('0110').' ('.$core->txt('0047').')'; ?></label>
                                <input type="number" name="price_retail_iqd" value="<?php echo $edit_values[6]; ?>" class="form-control form-control-sm" id="x71">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="x7_1"><?php echo $core->txt('0111').' ('.$core->txt('0048').')'; ?> *</label>
                                <input name="price_wholesale" value="<?php echo $edit_values[2]; ?>" type="text" data-inputmask="'alias': 'currency'" class="form-control form-control-sm" id="x7_1">
                            </div>
                            <div class="col-sm-6">
                                <label for="x7_11"><?php echo $core->txt('0111').' ('.$core->txt('0047').')'; ?></label>
                                <input type="number" name="price_wholesale_iqd" value="<?php echo $edit_values[7]; ?>" class="form-control form-control-sm" id="x7_11">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="x7_2"><?php echo $core->txt('0112').' ('.$core->txt('0048').')'; ?> *</label>
                                <input name="price_distribution" value="<?php echo $edit_values[3]; ?>" type="text" data-inputmask="'alias': 'currency'" class="form-control form-control-sm" id="x7_2">
                            </div>
                            <div class="col-sm-6">
                                <label for="x7_2_2"><?php echo $core->txt('0112').' ('.$core->txt('0047').')'; ?></label>
                                <input type="number" name="price_distribution_iqd" value="<?php echo $edit_values[10]; ?>" class="form-control form-control-sm" id="x7_2_2">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                      <label for="x8"><?php echo $core->txt('0055').' ('.$core->txt('0121').')'; ?></label>
                      <input name="price_china" value="<?php echo $edit_values[4]; ?>" type="text" class="form-control form-control-sm" id="x8">
                    </div>
                    <div class="form-group">
                      <label for="price_arrival"><?php echo $core->txt('0201').' ('.$core->txt('0048').')'; ?></label>
                      <input name="price_arrival" value="<?php echo $edit_values[11]; ?>" type="text" data-inputmask="'alias': 'currency'" class="form-control form-control-sm" id="price_arrival">
                    </div>
                    <div class="form-group">
                      <label for="imported_from_company"><?php echo $core->txt('0202'); ?></label>
                      <input name="imported_from_company" value="<?php echo $edit_values[12]; ?>" type="text" class="form-control form-control-sm" id="imported_from_company">
                    </div>
                    <div class="form-group">
                      <label for="importer_id"><?php echo $core->txt('0085'); ?> *</label>
                      <select name="importer_id" id="importer_id" class="form-control"><?php echo $importers_options; ?></select>
                    </div>
                    <div class="form-group">
                      <label for="x2"><?php echo $core->txt('0053'); ?></label>
                      <input name="description" value="<?php echo $edit_values[5]; ?>" type="text" class="form-control form-control-sm" id="x2">
                    </div>
                    
                    <?php if($id != ""){ ?>
                        <br>
                        <div class="form-group">
                            <a href="<?php echo V_URLP.'packing&id='.$id; ?>" target="_blank"><?php echo $core->txt('0127'); ?></a>
                            &nbsp;-&nbsp;
                            <a href="<?php echo V_URLP.'products-quantity-edit&id='.$id; ?>" target="_blank"><?php echo $core->txt('0066'); ?></a>
                            <?php
                            if($core->userHaveRole('PRODUCTS-EDIT')){
                                echo "&nbsp;-&nbsp;<a href=\"javascript:void(0);\" onclick=\"doAlr('".V_URLP."products-delete-now&id=".$id."', '".$core->txt('0030')."')\">".$core->txt('0026')."</a>";
                            }
                            ?>
                        </div>
                    <?php } ?>
                    
                    <br>
                    <?php if($core->userHaveRole('PRODUCTS-EDIT'))echo "<button type=\"submit\" class=\"btn btn-primary\">".$core->txt('0023')."</button>"; ?>
                    <a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP.$url_link_p; ?>', '<?php echo $core->txt('0030'); ?>')"><button type="button" class="btn btn-secondary btn-md mr-2"><?php echo $core->txt('0064'); ?></button></a>
                  </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                    <div class="card-body rtl">
                      <h4 class="hb title-size center"><?php echo $core->txt('0118'); ?><br><br></h4>
        
                      <form class="forms-sample" method="post" enctype="multipart/form-data" action="<?php echo V_URLP.$url_link_p_upload_now.'&id='.$id; ?>">

                        <?php if($id == ""){ 
                            echo "<div class='form-group center'>".$core->txt('0119')."</div>";
                        }else{ ?>
                        
                        <?php if($core->userHaveRole('PRODUCTS-UPLOAD-PIC')){
                            echo "<div class=\"form-group\"><label for=\"x1u\">".$core->txt('0117')."</label><input name=\"pic\" type=\"file\" class=\"form-control form-control-sm ltr\" id=\"x1u\"></div><button type=\"submit\" class=\"btn btn-primary\">".$core->txt('0122')."</button><br><br><hr>";
                        } ?>

                        <br>
                                                
                         <?php if($edit_values[8]!=""){ ?>
                            <div class="form-group center">
                              <img src="<?php echo $edit_values[8]; ?>" class="img">
                            </div>
                        <?php } ?>
                    <?php } ?>
                    </form> 
                </div>
            </div>
        </div>
    </div>

<?php echo $theme->getFooter(); ?>