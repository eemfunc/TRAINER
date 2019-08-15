<?php 
    $core->userChkRole('STORES-EDIT');
    echo $theme->getHeader(); 

if(isset($_GET['id'])){
    if(!$core->dbNumRows('stores', array('id' => $_GET['id'])))
        $core->err();
    else
        define('ID', $_GET['id']);
}

$v = array('', '', '', '');
if(defined('ID')){
    $rows = $core->dbFetch('stores', array('id' => ID));
    foreach($rows as $r){
        $v[0] = $core->aes($r['name'], 1);
        $v[1] = $core->aes($r['location'], 1);
        $v[2] = $r['branch_id'];
    }
}

?>

    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 grid-margin stretch-card rtl">
              <div class="card">
                <div class="card-body">
                  <h4 class="hb title-size center"><?php if(defined('ID'))echo $core->txt('0197');else echo $core->txt('0063'); ?><br><br></h4>
                  <form class="forms-sample" method="post" action="<?php echo V_URLP.'stores-add-now';if(defined('ID'))echo '&id='.ID; ?>">
                    <div class="form-group">
                      <label for="name"><?php echo $core->txt('0057'); ?> *</label>
                      <input name="name" type="text" class="form-control form-control-sm" id="name" value="<?php echo $v[0]; ?>">
                    </div>
                    <div class="form-group">
                      <label for="branch_id"><?php echo $core->txt('0061'); ?> *</label>
                      <select name="branch_id" id="branch_id" class="form-control">
                      <?php
                        $txt = ($v[2] != null) ? '' : '<option value="" selected>'.$core->txt('0068').'</option>';
                        $rows = $core->dbFetch('branches', null, 'ORDER BY created_at ASC');
                        foreach($rows as $r){
                            $txt.= "<option value='".$r['id']."'";
                            if($v[2] != null && $r['id'] == $v[2])
                                $txt.= 'selected';
                            $txt.= ">".$core->aes($r['name'], 1)."</option>";
                        }
                        echo $txt;
                      ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="location"><?php echo $core->txt('0062'); ?></label>
                      <input name="location" type="text" class="form-control form-control-sm" id="location" value="<?php echo $v[1]; ?>">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary btn-md mr-2"><?php echo $core->txt('0023'); ?></button>
                    <a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP; ?>stores', '<?php echo $core->txt('0030'); ?>')"><button type="button" class="btn btn-secondary btn-md mr-2"><?php echo $core->txt('0064'); ?></button></a>
                  </form>
                </div>
            </div>
            </div>
        <div class="col-lg-3"></div>
    </div>

<?php echo $theme->getFooter(); ?>