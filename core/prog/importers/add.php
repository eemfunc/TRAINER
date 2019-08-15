<?php
    $core->userChkRole('IMPORTERS-EDIT');
    echo $theme->getHeader();
    $id     = (isset($_GET['id'])) ? $_GET['id'] : null;
    $name   = (isset($_GET['id'])) ? $core->aes($core->dbFetch('importers', array('id' => $_GET['id']))[0]['name'], 1) : null;
?>

    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 grid-margin stretch-card rtl">
              <div class="card">
                <div class="card-body">
                    <h4 class="hb title-size center"><?php echo $core->txt('0093'); ?><br><br></h4>
                    <form class="forms-sample" method="post" action="<?php echo V_URLP.'importers-add-now'; ?>">
                        <div class="form-group">
                            <label for="name"><?php echo $core->txt('0057'); ?> *</label>
                            <input name="name" value="<?php echo $name; ?>" type="text" class="form-control form-control-sm" id="name">
                            <input name="id" value="<?php echo $id; ?>" type="hidden">
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary"><?php echo $core->txt('0023'); ?></button>
                        <a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP.'importers'; ?>', '<?php echo $core->txt('0030'); ?>')"><button type="button" class="btn btn-secondary btn-md mr-2"><?php echo $core->txt('0064'); ?></button></a>
                    </form>
                </div>
            </div>
            </div>
        <div class="col-lg-3"></div>
    </div>

<?php echo $theme->getFooter(); ?>