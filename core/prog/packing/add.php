<?php 
    $core->userChkRole('PACKING-EDIT');
    echo $theme->getHeader(); 

$url_link_p="packing&id=".$_GET['id'];
$url_link_p_add_now='packing-add-now&id='.$_GET['id'];

if(!isset($_GET['id']))
    $core->err(404);
if(!$core->dbNumRows('products', array('id' => $_GET['id'])))
    $core->err(404);

?>

    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 grid-margin stretch-card rtl">
              <div class="card">
                <div class="card-body">
                    <?php
                        $p_data = $core->dbFetch('products', array('id' => $_GET['id']));
                        $p_txt = $core->aes($p_data[0]['name'], 1);
                        $p_txt .= '&nbsp;'.$core->aes($p_data[0]['item_no'], 1);
                    ?>
                  <h4 class="hb title-size center"><?php echo $core->txt('0130').'<br><br>'.$p_txt; ?><br><br></h4>
                  <form class="forms-sample" method="post" action="<?php echo V_URLP.$url_link_p_add_now; ?>">
                    <div class="form-group">
                      <label for="x1"><?php echo $core->txt('0057'); ?> *</label>
                      <input name="product_id" type="hidden" value="<?php echo $_GET['id']; ?>">
                      <input name="name" type="text" class="form-control form-control-sm" id="x1">
                    </div>
                    <div class="form-group">
                      <label for="x3"><?php echo $core->txt('0066'); ?> *</label>
                      <input name="quantity" type="text" class="form-control form-control-sm" id="x3">
                    </div>
                    <br><br>
                    <button type="submit" class="btn btn-primary btn-md mr-2"><?php echo $core->txt('0023'); ?></button>
                    <a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP.$url_link_p; ?>', '<?php echo $core->txt('0030'); ?>')"><button type="button" class="btn btn-secondary btn-md mr-2"><?php echo $core->txt('0064'); ?></button></a>
                  </form>
                </div>
            </div>
            </div>
        <div class="col-lg-3"></div>
    </div>

<?php echo $theme->getFooter(); ?>