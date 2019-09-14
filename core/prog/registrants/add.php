<?php
    $core->userChkRole('REGISTRANTS-EDIT');
    if(!$core->chk_GET('id')){
        $core->err(404);
    }elseif(!$core->dbNumRows('courses', array('id' => $_GET['id']))){
        $core->err(404);
    }
    echo $theme->getHeader('select2');
?>

    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="col-lg-12" style="text-align: center;padding-top:7px;">
                    <h4 class="hb title-size"><?php echo $core->aes($core->dbFetch('courses', array('id' => $_GET['id']))[0]['name'], 1); ?></h4>
                </div>
            </div>
        </div>
        <div class="col-lg-3"></div>
    </div>

    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 grid-margin stretch-card rtl">
              <div class="card">
                <div class="card-body">
                    <h4 class="hb title-size center"><?php echo $core->txt('0299'); ?><br><br></h4>
                    <form class="forms-sample" method="post" action="<?php echo V_URLP.'registrants-add-now&id='.$_GET['id']; ?>">
                        <div class="form-group">
                            <label for="student"><?php echo $core->txt('0306'); ?> *</label>
                            <select name="student" id="student" class="form-control js-example-rtl-2"></select>
                        </div>
                        
                        <br>
                        <button type="submit" class="btn btn-primary"><?php echo $core->txt('0023'); ?></button>
                        <a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP.'registrants&id='.$_GET['id']; ?>', '<?php echo $core->txt('0030'); ?>')"><button type="button" class="btn btn-secondary btn-md mr-2"><?php echo $core->txt('0064'); ?></button></a>
                    </form>
                </div>
            </div>
            </div>
        <div class="col-lg-3"></div>
    </div>

<?php echo $theme->getFooter(); ?>

<script type="text/javascript">
    (function ($) {
        $('.js-example-rtl-2').select2({
            placeholder: "<?php echo $core->txt('0068'); ?>",language:{errorLoading:function(){return"<?php echo $core->txt('0069'); ?>";},inputTooLong:function(e){var t=e.input.length-e.maximum;return"<?php echo $core->txt('0070'); ?>"+t+"<?php echo $core->txt('0071'); ?>";},inputTooShort:function(e){var t=e.minimum-e.input.length;return"<?php echo $core->txt('0072'); ?>"+t+"<?php echo $core->txt('0076'); ?>";},loadingMore:function(){return"<?php echo $core->txt('0073'); ?>";},maximumSelected:function(e){return"<?php echo $core->txt('0074'); ?>"+e.maximum+"<?php echo $core->txt('0075'); ?>";},noResults:function(){return"<?php echo $core->txt('0077'); ?>";},searching:function(){return"<?php echo $core->txt('0078'); ?>";}},dir: '<?php echo V_SELECT2_DIR; ?>',minimumInputLength: <?php echo V_SELECT2_MINIMUM_INPUT_LENGTH; ?>,
            
            ajax: {url: "<?php echo V_MAIN_FOLDER_PATH; ?>",dataType: "json",delay: 250,data: function (params) {return {
                <?php echo V_PROG_QUERY; ?>: 'registrants-search-students',
                <?php echo V_SEARCH_QUERY; ?>: params.term,
                <?php echo V_PAGE_QUERY; ?>: params.page
            };},processResults: function (data, params) {params.page = params.page || 1;return {results: data.matches,pagination: {more: (params.page * <?php echo V_ROWS_PER_PAGE_SELECT2; ?>) < data.total_count}};},cache: true}});
        
    })(jQuery);
</script>