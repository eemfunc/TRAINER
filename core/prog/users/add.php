<?php 
    $core->userChkRole('USERS-EDIT');
$url_link_p="users";
$url_link_p_add_now='users-add-now';

if(isset($_GET['id'])){
    if(!$core->dbNumRows('users', array('id' => $_GET['id'])))
        $core->err();
    else define('ID', $_GET['id']);
}

$v = array('', '', '', '');
if(defined('ID')){
    $rows = $core->dbFetch('users', array('id' => ID));
    foreach($rows as $r){
        $v[0] = $core->aes($r['name'], 1);
        $v[1] = $core->aes($r['email'], 1);
        $v[2] = $r['roles_id'];
        $v[3] = $r['branch_id'];
    }
}

echo $theme->getHeader();

?>

    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 grid-margin stretch-card rtl">
              <div class="card">
                <div class="card-body">
                  <h4 class="hb title-size center"><?php if(defined('ID'))echo $core->txt('0198');else echo $core->txt('0020'); ?><br><br></h4>
                  <form class="forms-sample" method="post" action="<?php echo V_URLP.$url_link_p_add_now;if(defined('ID'))echo '&id='.ID; ?>">
                    <div class="form-group">
                      <label for="name"><?php echo $core->txt('0015'); ?> *</label>
                      <input name="name" type="text" class="form-control form-control-sm" id="name" value="<?php echo $v[0]; ?>">
                    </div>
                    <div class="form-group">
                      <label for="email"><?php echo $core->txt('0016'); ?> *</label>
                      <input name="email" type="email" class="form-control form-control-sm" id="email" value="<?php echo $v[1]; ?>">
                    </div>
                    <div class="form-group">
                      <label for="branch_id"><?php echo $core->txt('0061'); ?> *</label>
                      <select name="branch_id" id="branch_id" class="form-control">
                      <?php
                        $txt = ($v[3] != null) ? '' : '<option value="" selected>'.$core->txt('0068').'</option>';
                        $rows = $core->dbFetch('branches', null, 'ORDER BY created_at ASC');
                        foreach($rows as $r){
                            $txt.= "<option value='".$r['id']."'";
                            if($v[3] != null && $r['id'] == $v[3])
                                $txt.= ' selected';
                            $txt.= ">".$core->aes($r['name'], 1)."</option>";
                        }
                        echo $txt;
                      ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="roles_id"><?php echo $core->txt('0244'); ?> *</label>
                      <select name="roles_id" id="roles_id" class="form-control">
                      <?php
                        $txt = ($v[2] != null) ? '' : '<option value="" selected>'.$core->txt('0068').'</option>';
                        $rows = $core->dbFetch('roles', null, 'ORDER BY created_at ASC');
                        foreach($rows as $r){
                            $txt.= "<option value='".$r['id']."'";
                            if($v[2] != null && $r['id'] == $v[2])
                                $txt.= ' selected';
                            $txt.= ">".$core->aes($r['name'], 1)."</option>";
                        }
                        echo $txt;
                      ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="password"><?php echo $core->txt('0021'); ?> <?php echo (defined('ID')) ? '('.$core->txt('0248').')' : '*'; ?></label>
                      <input name="password" type="password" class="form-control form-control-sm" id="password">
                    </div>
                      <br>
                    <!--<div class="form-check form-check-flat form-check-default">
                      <label class="form-check-label blc title-size">
                        <input name="activate" type="checkbox" class="form-check-input">&nbsp;&nbsp;<?php echo $core->txt('0022'); ?>
                      </label>
                    </div>-->
                    <button type="submit" class="btn btn-primary"><?php echo $core->txt('0023'); ?></button>
                    <a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP.$url_link_p; ?>', '<?php echo $core->txt('0030'); ?>')"><button type="button" class="btn btn-secondary btn-md mr-2"><?php echo $core->txt('0064'); ?></button></a>
                  </form>
                </div>
            </div>
            </div>
        <div class="col-lg-3"></div>
    </div>

<?php echo $theme->getFooter(); ?>