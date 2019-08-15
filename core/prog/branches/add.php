<?php
    $core->userChkRole('BRANCHES-EDIT');
    $core->requireClass('branches-class', 'branches');
    $branches = (isset($_GET['id'])) ? new branches($_GET['id']) : new branches();
    echo $theme->getHeader();
?>

    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 grid-margin stretch-card rtl">
              <div class="card">
                <div class="card-body">
                  <h4 class="hb title-size center"><?php if($branches->ID != '')echo $core->txt('0222');else echo $core->txt('0056'); ?><br><br></h4>
                  <form class="forms-sample" method="post" action="<?php echo V_URLP.'branches-add-now';if($branches->ID)echo '&id='.$branches->ID; ?>">
                    <div class="form-group">
                      <label for="name"><?php echo $core->txt('0057'); ?> *</label>
                      <input name="name" type="text" class="form-control form-control-sm" id="name" value="<?php echo $branches->NAME; ?>">
                    </div>
                    <div class="form-group">
                      <label for="location"><?php echo $core->txt('0062'); ?> *</label>
                      <input name="location" type="text" class="form-control form-control-sm" id="location" value="<?php echo $branches->LOCATION; ?>">
                    </div>
                    <div class="form-group">
                      <label for="mobile"><?php echo $core->txt('0040'); ?> *</label>
                      <input name="mobile" type="text" class="form-control form-control-sm" id="mobile" value="<?php echo $branches->MOBILE; ?>">
                    </div>
                    <div class="form-group">
                      <label for="type"><?php echo $core->txt('0253'); ?> *</label>
                      <select name="type" type="text" class="form-control" id="type">
                        <?php echo $branches->branchTypeOptions(); ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="admin_user_id"><?php echo $core->txt('0243'); ?> *</label>
                        <select name="admin_user_id" type="text" class="form-control" id="admin_user_id">
                            <?php echo $branches->adminUserOptions(); ?>
                        </select>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary btn-md mr-2"><?php echo $core->txt('0023'); ?></button>
                    <a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP; ?>branches', '<?php echo $core->txt('0030'); ?>')"><button type="button" class="btn btn-secondary btn-md mr-2"><?php echo $core->txt('0064'); ?></button></a>
                  </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3"></div>
    </div>

<?php echo $theme->getFooter(); ?>