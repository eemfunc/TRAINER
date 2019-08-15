<?php
$core->userChkRole('DEBTS-SUBTRACT');
echo $theme->getHeader('select2');
?>
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 grid-margin stretch-card rtl">
            <div class="card">
                <div class="card-body">
                <form autocomplete="off" target="_blank" class="forms-sample" method="post" action="<?php echo V_URLP.'debts-subtract-now'; ?>">
                  <input autocomplete="false" name="hidden" type="text" style="display:none;">
                  
                  <h4 class="hb title-size center"><?php echo $core->txt('0260'); ?></h4>
                  <br>
                  <div class="form-group">
                    <label class="col-form-label"><?php echo $core->txt('0096'); ?> *</label>
                    <select name="customer_id" id="customer_id" class="title-size form-control js-example-rtl"></select>
                  </div>
                  <div class="row">
                    <div class="col-lg-4 form-group">
                        <label class="col-form-label"><?php echo $core->txt('0102'); ?> *</label>
                        <select name="currency" id="currency" class="form-control" style="margin-top: 0px;">
                            <option value="IQD" selected><?php echo $core->txt('0047'); ?></option>
                            <option value="USD"><?php echo $core->txt('0048'); ?></option>
                        </select>
                    </div>
                    <div class="col-lg-8 form-group"  style="top:10px;">
                        <label for="amount"><?php echo $core->txt('0175'); ?> *</label>
                        <input name="amount" type="text" class="form-control form-control-sm" id="amount">
                    </div>
                  </div>
                  <br>
                  <button type="submit" class="btn btn-primary"><?php echo $core->txt('0023'); ?></button>
                </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3"></div>
    </div>

<?php echo $theme->getFooter(); ?>
<script type="text/javascript">
    $('.js-example-rtl').select2({
        placeholder: "<?php echo $core->txt('0068'); ?>",language:{errorLoading:function(){return"<?php echo $core->txt('0069'); ?>";},inputTooLong:function(e){var t=e.input.length-e.maximum;return"<?php echo $core->txt('0070'); ?>"+t+"<?php echo $core->txt('0071'); ?>";},inputTooShort:function(e){var t=e.minimum-e.input.length;return"<?php echo $core->txt('0072'); ?>"+t+"<?php echo $core->txt('0076'); ?>";},loadingMore:function(){return"<?php echo $core->txt('0073'); ?>";},maximumSelected:function(e){return"<?php echo $core->txt('0074'); ?>"+e.maximum+"<?php echo $core->txt('0075'); ?>";},noResults:function(){return"<?php echo $core->txt('0077'); ?>";},searching:function(){return"<?php echo $core->txt('0078'); ?>";}},dir: '<?php echo V_SELECT2_DIR; ?>',minimumInputLength: <?php echo V_SELECT2_MINIMUM_INPUT_LENGTH; ?>, ajax: {url: "<?php echo V_MAIN_FOLDER_PATH; ?>",dataType: "json",delay: 250,data: function (params) {return {
            <?php echo V_PROG_QUERY; ?>: 'ajax-search-customers-v1',
            <?php echo V_SEARCH_QUERY; ?>: params.term,
            <?php echo V_PAGE_QUERY; ?>: params.page
        };},processResults: function (data, params) {params.page = params.page || 1;return {results: data.matches,pagination: {more: (params.page * <?php echo V_ROWS_PER_PAGE_SELECT2; ?>) < data.total_count}};},cache: true}
    });
</script>