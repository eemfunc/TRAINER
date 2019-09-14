<?php
    $core->userChkRole('COURSES-EDIT');
    echo $theme->getHeader();
    $id             = (isset($_GET['id'])) ? $_GET['id'] : null;
    $data_arr       = $core->dbFetch('courses', array('id' => $id));
    $name           = (!isset($_GET['id'])) ? null : $core->aes($data_arr[0]['name'], 1);
    $type           = (!isset($_GET['id'])) ? null : $core->aes($data_arr[0]['type'], 1);
    $lecturer_id    = (!isset($_GET['id'])) ? null : $data_arr[0]['lecturer_id'];
    $course_var_id  = (!isset($_GET['id'])) ? null : $core->aes($data_arr[0]['course_var_id'], 1);
    $start_date     = (!isset($_GET['id'])) ? null : $core->aes($data_arr[0]['start_date'], 1);
    $end_date       = (!isset($_GET['id'])) ? null : $core->aes($data_arr[0]['end_date'], 1);
    $lectures_no     = (!isset($_GET['id'])) ? null : $core->aes($data_arr[0]['lectures_no'], 1);
    $price          = (!isset($_GET['id'])) ? null : $core->aes($data_arr[0]['price'], 1);
    $rewards        = (!isset($_GET['id'])) ? null : $core->aes($data_arr[0]['rewards'], 1);
    $details        = (!isset($_GET['id'])) ? null : $core->aes($data_arr[0]['details'], 1);
?>

    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 grid-margin stretch-card rtl">
              <div class="card">
                <div class="card-body">
                    <h4 class="hb title-size center"><?php echo ($id == null) ? $core->txt('0292') : $core->txt('0293'); ?><br><br></h4>
                    <form class="forms-sample" method="post" action="<?php echo V_URLP.'courses-add-now'; ?>">
                        <input name="id" type="hidden" value="<?php echo $id; ?>">
                        <div class="form-group">
                            <label for="name"><?php echo $core->txt('0057'); ?> *</label>
                            <input name="name" id="name" value="<?php echo $name; ?>" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="form-group">
                            <label for="type"><?php echo $core->txt('0284'); ?> *</label>
                            <select name="type" id="type" class="form-control">
                                <?php
                                if($lecturer_id == null){
                                    echo "<option value='' selected>".$core->txt('0068')."</option>"; 
                                }
                                if($core->userHaveRole('COURSE01')){
                                    echo "<option value='COURSE01'";
                                    if($type == 'COURSE01'){
                                        echo "selected";
                                    }
                                    echo ">".$core->txt("0288")."</option>";
                                }
                                if($core->userHaveRole('COURSE02')){
                                    echo "<option value='COURSE02'";
                                    if($type == 'COURSE02'){
                                        echo "selected";
                                    }
                                    echo ">".$core->txt("0289")."</option>";
                                }
                                if($core->userHaveRole('COURSE03')){
                                    echo "<option value='COURSE03'";
                                    if($type == 'COURSE03'){
                                        echo "selected";
                                    }
                                    echo ">".$core->txt("0290")."</option>";
                                }
                                if($core->userHaveRole('COURSE04')){
                                    echo "<option value='COURSE04'";
                                    if($type == 'COURSE04'){
                                        echo "selected";
                                    }
                                    echo ">".$core->txt("0291")."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="lecturer_id"><?php echo $core->txt('0294'); ?> *</label>
                            <select name="lecturer_id" id="lecturer_id" class="form-control">
                                <?php
                                if($lecturer_id == null){
                                    echo "<option value='' selected>".$core->txt('0068')."</option>"; 
                                }
                                $rows = $core->dbFetch('staff', array('type' => $core->aes('LECTURER')), 'ORDER BY created_at ASC');
                                foreach($rows as $r){
                                    echo "<option value='".$r['id']."'";
                                    if($lecturer_id == $r['id']){
                                        echo "selected";
                                    }
                                    echo ">".$core->aes($r['name'], 1)."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="course_var_id"><?php echo $core->txt('0013'); ?> *</label>
                            <input name="course_var_id" id="course_var_id" value="<?php echo $course_var_id; ?>" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="form-group">
                            <label for="start_date"><?php echo $core->txt('0286'); ?> *</label>
                            <input name="start_date" id="start_date" value="<?php echo $start_date; ?>" class="form-control form-control-sm" type="date">
                        </div>
                        <div class="form-group">
                            <label for="end_date"><?php echo $core->txt('0297'); ?> *</label>
                            <input name="end_date" id="end_date" value="<?php echo $end_date; ?>" class="form-control form-control-sm" type="date">
                        </div>
                        <div class="form-group">
                            <label for="lectures_no"><?php echo $core->txt('0295'); ?> *</label>
                            <input name="lectures_no" id="lectures_no" value="<?php echo $lectures_no; ?>" class="form-control form-control-sm" type="number">
                        </div>
                        <div class="form-group">
                            <label for="price"><?php echo $core->txt('0051'); ?> *</label>
                            <input name="price" id="price" value="<?php echo $price; ?>" class="form-control form-control-sm" type="number">
                        </div>
                        <div class="form-group">
                            <label for="rewards"><?php echo $core->txt('0296'); ?> *</label>
                            <input name="rewards" id="rewards" value="<?php echo $rewards; ?>" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="form-group">
                            <label for="details"><?php echo $core->txt('0053'); ?></label>
                            <input name="details" id="details" value="<?php echo $details; ?>" class="form-control form-control-sm" type="text">
                        </div>
                        
                        <br>
                        <button type="submit" class="btn btn-primary"><?php echo $core->txt('0023'); ?></button>
                        <a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP.'courses'; ?>', '<?php echo $core->txt('0030'); ?>')"><button type="button" class="btn btn-secondary btn-md mr-2"><?php echo $core->txt('0064'); ?></button></a>
                    </form>
                </div>
            </div>
            </div>
        <div class="col-lg-3"></div>
    </div>

<?php echo $theme->getFooter(); ?>