<?php 
    $core->userChkRole('DISCOUNTS-EDIT');  
    echo $theme->getHeader();

$url_link_p="discounts";
$url_link_p_add_now='discounts-add-now';

?>

    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 grid-margin stretch-card rtl">
              <div class="card">
                <div class="card-body">
                  <h4 class="hb title-size center"><?php echo $core->txt('0108'); ?><br><br></h4>
                  <form class="forms-sample" method="post" action="<?php echo V_URLP.$url_link_p_add_now; ?>">
                    <div class="form-group">
                      <label for="percentage"><?php echo $core->txt('0107'); ?> *</label>
                      <input name="percentage" type="text" class="form-control form-control-sm" id="percentage">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary"><?php echo $core->txt('0023'); ?></button>
                    <a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP.$url_link_p; ?>', '<?php echo $core->txt('0030'); ?>')"><button type="button" class="btn btn-secondary btn-md mr-2"><?php echo $core->txt('0064'); ?></button></a>
                  </form>
                </div>
            </div>
            </div>
        <div class="col-lg-3"></div>
    </div>

<?php echo $theme->getFooter(); ?>