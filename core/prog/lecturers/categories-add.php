<?php
    $core->userChkRole('EXPENSES-CATEGORIES-EDIT');
    echo $theme->getHeader();
    $id     = (isset($_GET['id'])) ? $_GET['id'] : null;
    $name   = (isset($_GET['id'])) ? $core->aes($core->dbFetch('expenses_categories', array('id' => $_GET['id']))[0]['name'], 1) : null;
?>

    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 grid-margin stretch-card rtl">
              <div class="card">
                <div class="card-body">
                    <h4 class="hb title-size center"><?php echo ($id == null) ? $core->txt('0262') : $core->txt('0263'); ?><br><br></h4>
                    <form class="forms-sample" method="post" action="<?php echo V_URLP.'expenses-categories-add-now'; ?>">
                        <div class="form-group">
                            <label for="name"><?php echo $core->txt('0057'); ?> *</label>
                            <input name="id" value="<?php echo $id; ?>" type="hidden">
                            <input name="name" value="<?php echo $name; ?>" type="text" class="form-control form-control-sm" id="name">
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary"><?php echo $core->txt('0023'); ?></button>
                        <a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP.'expenses-categories'; ?>', '<?php echo $core->txt('0030'); ?>')"><button type="button" class="btn btn-secondary btn-md mr-2"><?php echo $core->txt('0064'); ?></button></a>
                    </form>
                </div>
            </div>
            </div>
        <div class="col-lg-3"></div>
    </div>

<?php echo $theme->getFooter(); ?>