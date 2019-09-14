<?php
    $core->userChkRole('LECTURERS-EDIT');
    echo $theme->getHeader();
    $id             = (isset($_GET['id'])) ? $_GET['id'] : null;
    $data_arr       = $core->dbFetch('staff', array('id' => $id));
    $name           = (!isset($_GET['id'])) ? null : $core->aes($data_arr[0]['name'], 1);
    $country        = (!isset($_GET['id'])) ? null : $core->aes($data_arr[0]['country'], 1);
    $city           = (!isset($_GET['id'])) ? null : $core->aes($data_arr[0]['city'], 1);
    $address        = (!isset($_GET['id'])) ? null : $core->aes($data_arr[0]['address'], 1);
    $gender         = (!isset($_GET['id'])) ? null : $core->aes($data_arr[0]['gender'], 1);
    $mobile         = (!isset($_GET['id'])) ? null : $core->aes($data_arr[0]['mobile'], 1);
    $organization   = (!isset($_GET['id'])) ? null : $core->aes($data_arr[0]['organization'], 1);
    $nationality    = (!isset($_GET['id'])) ? null : $core->aes($data_arr[0]['nationality'], 1);
    $job_title      = (!isset($_GET['id'])) ? null : $core->aes($data_arr[0]['job_title'], 1);
    $religion       = (!isset($_GET['id'])) ? null : $core->aes($data_arr[0]['religion'], 1);
    $details        = (!isset($_GET['id'])) ? null : $core->aes($data_arr[0]['details'], 1);
    $email          = (!isset($_GET['id'])) ? null : $core->aes($data_arr[0]['email'], 1);
    $birthdate      = (!isset($_GET['id'])) ? null : $core->aes($data_arr[0]['birthdate'], 1);
?>

    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 grid-margin stretch-card rtl">
              <div class="card">
                <div class="card-body">
                    <h4 class="hb title-size center"><?php echo ($id == null) ? $core->txt('0281') : $core->txt('0282'); ?><br><br></h4>
                    <form class="forms-sample" method="post" action="<?php echo V_URLP.'lecturers-add-now'; ?>">
                        <input name="id" type="hidden" value="<?php echo $id; ?>">
                        <div class="form-group">
                            <label for="name"><?php echo $core->txt('0057'); ?> *</label>
                            <input name="name" id="name" value="<?php echo $name; ?>" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="form-group">
                            <label for="country"><?php echo $core->txt('0272'); ?></label>
                            <input name="country" id="country" value="<?php echo $country; ?>" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="form-group">
                            <label for="city"><?php echo $core->txt('0044'); ?></label>
                            <input name="city" id="city" value="<?php echo $city; ?>" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="form-group">
                            <label for="address"><?php echo $core->txt('0041'); ?></label>
                            <input name="address" id="address" value="<?php echo $address; ?>" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="form-group">
                            <label for="gender"><?php echo $core->txt('0273'); ?></label>
                            <select name="gender" id="gender" class="form-control form-control-sm">
                                <?php if($gender != "male" && $gender != "female")echo "<option value='' selected></option>"; ?>
                                <option value="male"<?php if($gender == "male")echo "selected"; ?>><?php echo $core->txt('0278'); ?></option>
                                <option value="female"<?php if($gender == "female")echo "selected"; ?>><?php echo $core->txt('0279'); ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mobile"><?php echo $core->txt('0040'); ?> *</label>
                            <input name="mobile" id="mobile" value="<?php echo $mobile; ?>" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="form-group">
                            <label for="email"><?php echo $core->txt('0016'); ?></label>
                            <input name="email" id="email" value="<?php echo $email; ?>" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="form-group">
                            <label for="organization"><?php echo $core->txt('0274'); ?></label>
                            <input name="organization" id="organization" value="<?php echo $organization; ?>" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="form-group">
                            <label for="nationality"><?php echo $core->txt('0275'); ?></label>
                            <input name="nationality" id="nationality" value="<?php echo $nationality; ?>" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="form-group">
                            <label for="job_title"><?php echo $core->txt('0269'); ?></label>
                            <input name="job_title" id="job_title" value="<?php echo $job_title; ?>" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="form-group">
                            <label for="religion"><?php echo $core->txt('0276'); ?></label>
                            <input name="religion" id="religion" value="<?php echo $religion; ?>" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="form-group">
                            <label for="details"><?php echo $core->txt('0053'); ?></label>
                            <input name="details" id="details" value="<?php echo $details; ?>" class="form-control form-control-sm" type="text">
                        </div>
                        <div class="form-group">
                            <label for="birthdate"><?php echo $core->txt('0277'); ?></label>
                            <input name="birthdate" id="birthdate" value="<?php echo $birthdate; ?>" class="form-control form-control-sm" type="date">
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary"><?php echo $core->txt('0023'); ?></button>
                        <a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP.'lecturers'; ?>', '<?php echo $core->txt('0030'); ?>')"><button type="button" class="btn btn-secondary btn-md mr-2"><?php echo $core->txt('0064'); ?></button></a>
                    </form>
                </div>
            </div>
            </div>
        <div class="col-lg-3"></div>
    </div>

<?php echo $theme->getFooter(); ?>