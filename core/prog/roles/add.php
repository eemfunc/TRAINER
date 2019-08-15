<?php 
    $core->requireClass('roles-class', 'roles');
    $roles = (isset($_GET['id'])) ? new roles($_GET['id']) : new roles();
    echo $theme->getHeader();
?>

    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 grid-margin stretch-card rtl">
              <div class="card">
                <div class="card-body">
                  <h4 class="hb title-size center"><?php if($roles->ID != null)echo $core->txt('0246');else echo $core->txt('0245'); ?><br><br></h4>
                  <form class="forms-sample" method="post" action="<?php echo V_URLP.'roles-add-now';if($roles->ID != null)echo '&id='.$roles->ID; ?>">
                    <div class="form-group">
                      <label for="name"><?php echo $core->txt('0057'); ?> *</label>
                      <input name="name" type="text" class="form-control form-control-sm" id="name" value="<?php echo $roles->NAME; ?>">
                    </div>
                    <div class="form-group">
                      <label for="roles"><?php echo $core->txt('0244'); ?> <?php echo $core->txt('0247'); ?> *</label>
                      <textarea name="roles" class="form-control ltrTextArea" id="roles"><?php echo $roles->ROLES; ?></textarea>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary btn-md mr-2"><?php echo $core->txt('0023'); ?></button>
                    <a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP; ?>roles', '<?php echo $core->txt('0030'); ?>')"><button type="button" class="btn btn-secondary btn-md mr-2"><?php echo $core->txt('0064'); ?></button></a>
                  </form>
                </div>
            </div>
            </div>
        <div class="col-lg-3"></div>
    </div>

<?php echo $theme->getFooter(); ?>