<?php echo $theme->getHeader('select2'); ?>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card rtl">
        <div class="card">
            <div class="card-body" style="padding:0px;">
                <?php if($core->userHaveRole('USERS-VIEW')){ ?>
                    <button class="btn btn-primary btn-sm hr button-size rtl" type="button" onclick="javascript:goto('<?php echo V_URLP; ?>users')"><?php echo $core->txt('0005'); ?></button>
                <?php } ?>
                <?php if($core->userHaveRole('STUDENTS-VIEW')){ ?>
                    <button class="btn btn-primary btn-sm hr button-size rtl" type="button" onclick="javascript:goto('<?php echo V_URLP; ?>students')"><?php echo $core->txt('0268'); ?></button>
                <?php } ?>
                

            </div>
        </div>
    </div>
</div>


<div class="row">

    <!-- DOLLAR PRICE -->
    <?php if($core->userHaveRole('DOLLARPRICE-VIEW')){ ?>
    <div class="col-lg-4 grid-margin stretch-card rtl">
          <div class="card">
            <div class="card-body">
              
              

            </div>
        </div>
    </div>
    <?php } ?>

    <!-- PRODUCTS' PRICES -->
    <div class="col-lg-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                
                
            </div>
        </div>
    </div>

</div>

<?php echo $theme->getFooter('select2'); ?>