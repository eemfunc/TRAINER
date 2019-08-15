<?php 
    $core->userChkRole('CUSTOMERS-VIEW');
    echo $theme->getHeader('select2'); 

$url_link_p="customers";
$url_link_p_delete="customers-delete-now";
$url_link_p_add="customers-add";

?>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div>
                    <div class="col-lg-12 row">
                        <div class="col-lg-3" style="top:5px;padding-left:25px;">
                            <h4 class="hb title-size"><?php echo $core->txt('0255'); ?></h4>
                        </div>
                        
                        <?php if($core->userHaveRole('CUSTOMERS-EDIT')){ ?>
                        <div class="col-lg-3"></div>
                        <?php }else{ ?>
                        <div class="col-lg-5"></div>
                        <?php } ?>
                        <div class="col-lg-4 rtl" style="margin-bottom:0;padding:0;">
                            <div class="select2-div"><select name="search_id" id="search_id" class="form-control js-example-rtl" style="width:400px;"></select></div>
                        </div>
                        <?php if($core->userHaveRole('CUSTOMERS-EDIT')){ ?>
                        <div class="col-lg-2 rtl" style="margin-bottom:0;padding:0;">
                            <button class="btn btn-primary btn-sm hr button-size rtl" type="button" style="margin-left:25px;" onclick="javascript:goto('<?php echo V_URLP.$url_link_p_add; ?>')"><?php echo $core->txt('0006'); ?></button>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                  <th><?php echo $core->txt('0015'); ?></th>
                                  <th><?php echo $core->txt('0039'); ?></th>
                                  <th><?php echo $core->txt('0040'); ?></th>
                                  <th><?php echo $core->txt('0041'); ?></th>
                                  <th><?php echo $core->txt('0019'); ?></th>
                                </tr>
                            </thead>
                            <tbody>

    <?php
        $rows = $core->dbFetch('customers', null, 'ORDER BY created_at DESC', true, true);
        foreach($rows as $r){
            if($core->chkFilterLimits()){
                echo "<tr>";
                    echo "<td>".$core->aes($r['name'], 1)."</td>";
                    echo "<td>".$core->aes($r['company'], 1)."</td>";
                    echo "<td>";
                        echo $core->aes($r['mobile_1'], 1);
                        if(strlen($core->aes($r['mobile_2'], 1)) > 0){
                            if(strlen($core->aes($r['mobile_1'], 1)) > 0)
                                echo " - ";
                            echo $core->aes($r['mobile_2'], 1);
                        }
                    echo "</td>";
                    echo "<td>";
                        echo $core->aes($r['city'], 1);
                        if($core->aes($r['region'], 1)!="")
                            echo " / ".$core->aes($r['region'], 1);
                        if($core->aes($r['address'], 1)!="")
                            echo " / ".$core->aes($r['address'], 1);
                    echo "</td>";
                    echo "<td>";
                        echo "<a href=\"javascript:void(0);\" onclick=\"goto('".V_URLP.$url_link_p_add.'&id='.$r['id']."')\">";
                        if($core->userHaveRole('CUSTOMERS-EDIT')){
                            echo $core->txt('0027');
                        }else{
                            echo $core->txt('0147');
                        }
                        echo "</a>";
                        if($core->userHaveRole('DEBTS-SUBTRACT')){
                        echo ' - ';
                        echo "<a href=\"javascript:void(0);\" onclick=\"goto('".V_URLP."debts-subtract&id=".$r['id']."')\">".$core->txt('0170')."</a>";
                        }
                        if($core->userHaveRole('CUSTOMERS-DELETE')){
                        echo ' - ';
                        echo "<a href=\"javascript:void(0);\" onclick=\"doAlr('".V_URLP.$url_link_p_delete."&id=".$r['id']."', '".$core->txt('0199')."')\">".$core->txt('0026')."</a>";
                        }
                    echo "</td>";
                echo "</tr>";
            }
        }
        echo $theme->fetchFooter('customers', $core->FETCH_LIMITS['TOTAL_ROWS_COUNTER']);
        ?>
    </div></div></div></div></div>

<?php echo $theme->getFooter('select2'); ?>
                                
<script type="text/javascript">
    (function ($) {
    
    $('#search_id').on('change',function(){
        goto('<?php echo V_URLP.$url_link_p_add.'&id='; ?>' + $('#search_id').select2('data')[0].id);
    });

    $('.js-example-rtl').select2({
        placeholder: "<?php echo $core->txt('0115'); ?>",language:{errorLoading:function(){return"<?php echo $core->txt('0069'); ?>";},inputTooLong:function(e){var t=e.input.length-e.maximum;return"<?php echo $core->txt('0070'); ?>"+t+"<?php echo $core->txt('0071'); ?>";},inputTooShort:function(e){var t=e.minimum-e.input.length;return"<?php echo $core->txt('0072'); ?>"+t+"<?php echo $core->txt('0076'); ?>";},loadingMore:function(){return"<?php echo $core->txt('0073'); ?>";},maximumSelected:function(e){return"<?php echo $core->txt('0074'); ?>"+e.maximum+"<?php echo $core->txt('0075'); ?>";},noResults:function(){return"<?php echo $core->txt('0077'); ?>";},searching:function(){return"<?php echo $core->txt('0078'); ?>";}},dir: '<?php echo V_SELECT2_DIR; ?>',minimumInputLength: <?php echo V_SELECT2_MINIMUM_INPUT_LENGTH; ?>,ajax: {url: "<?php echo V_MAIN_FOLDER_PATH; ?>",dataType: "json",delay: 250,
            data: function (params) {
                return {
                    <?php echo V_PROG_QUERY; ?>: 'ajax-search-customers-edit',
                    <?php echo V_SEARCH_QUERY; ?>: params.term,
                    <?php echo V_PAGE_QUERY; ?>: params.page
                };},processResults: function (data, params) {params.page = params.page || 1;return {results: data.matches,pagination: {
            more: (params.page * 30) < data.total_count
    }};},cache: true}});
    
})(jQuery);
</script>