<?php
    $core->userChkRole('REGISTRANTS-EDIT');
    if(!$core->chk_GET('id')){
        $core->err(404);
    }elseif(!$core->dbNumRows('courses', array('id' => $_GET['id']))){
        $core->err(404);
    }
    echo $theme->getHeader();
?>

    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 grid-margin stretch-card rtl">
              <div class="card">
                <div class="card-body">
                    <h4 class="hb title-size center"><?php echo $core->txt('0299'); ?><br><br></h4>
                    <form class="forms-sample" method="post" action="<?php echo V_URLP.'registrants-add-now'; ?>">
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
                                echo "<option value='COURSE01'";
                                if($type == 'COURSE01'){
                                    echo "selected";
                                }
                                echo ">".$core->txt("0288")."</option>";
                                echo "<option value='COURSE02'";
                                if($type == 'COURSE02'){
                                    echo "selected";
                                }
                                echo ">".$core->txt("0289")."</option>";
                                echo "<option value='COURSE03'";
                                if($type == 'COURSE03'){
                                    echo "selected";
                                }
                                echo ">".$core->txt("0290")."</option>";
                                echo "<option value='COURSE04'";
                                if($type == 'COURSE04'){
                                    echo "selected";
                                }
                                echo ">".$core->txt("0291")."</option>";
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
                            <input name="rewards" id="rewards" value="<?php echo $rewards; ?>" class="form-control form-control-sm" type="number">
                        </div>
                        <div class="form-group">
                            <label for="details"><?php echo $core->txt('0053'); ?></label>
                            <input name="details" id="details" value="<?php echo $details; ?>" class="form-control form-control-sm" type="text">
                        </div>
                        
                        <br>
                        <button type="submit" class="btn btn-primary"><?php echo $core->txt('0023'); ?></button>
                        <a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP.'registrants'; ?>', '<?php echo $core->txt('0030'); ?>')"><button type="button" class="btn btn-secondary btn-md mr-2"><?php echo $core->txt('0064'); ?></button></a>
                    </form>
                </div>
            </div>
            </div>
        <div class="col-lg-3"></div>
    </div>

<?php echo $theme->getFooter(); ?>