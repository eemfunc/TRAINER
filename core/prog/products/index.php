<?php 
    $core->userChkRole('PRODUCTS-VIEW');
    echo $theme->getHeader('select2'); 

$db_table="products";
$url_link_p="products";
$url_link_p_delete="products-delete-now";
$url_link_p_add="products-add";
$url_link_p_edit_quantity="products-quantity-edit";
$url_link_p_packing="packing";

?>
    
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div>
                    <div class="col-lg-12 row">
                        <div class="col-lg-2" style="top:5px;padding-left:25px;">
                            <h4 class="hb title-size"><?php echo $core->txt('0049'); ?></h4>
                        </div>
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4 rtl" style="margin-bottom:0;padding:0;">
                            <div class="select2-div"><select name="search_id" id="search_id" class="form-control js-example-rtl" style="width:400px;"></select></div>
                        </div>
                        <div class="col-lg-2 rtl" style="margin-bottom:0;padding:0;">
                            <button class="btn btn-primary btn-sm hr button-size rtl" style="margin-left:25px;" type="button" onclick="javascript:goto('<?php echo V_URLP.$url_link_p_add; ?>')"><?php echo $core->txt('0006'); ?></button>
                        </div>
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
                                  <th><?php echo $core->txt('0113'); ?></th>
                                  <th><?php echo $core->txt('0050'); ?></th>
                                  <th><?php echo $core->txt('0110'); ?></th>
                                  <th><?php echo $core->txt('0111'); ?></th>
                                  <th><?php echo $core->txt('0112'); ?></th>
                                  <th><?php echo $core->txt('0019'); ?></th>
                                </tr>
                            </thead>
                            <tbody>

    <?php
        $rows = $core->dbFetch('products', null, 'ORDER BY created_at DESC', true, true);
        foreach($rows as $r){
            if($core->chkFilterLimits()){
                echo "<tr>";
                    echo "<td>".$core->aes($r['item_no'], 1)."</td>";
                    echo "<td>".$core->aes($r['name'], 1)."</td>";
                    
                    if($r['price_retail_iqd'] == "" || $core->aes($r['price_retail_iqd'], 1) == ""){
                        
                        if($r['price_retail'] == "" || $core->aes($r['price_retail'], 1) == "")
                            $x = '';
                        else
                            $x = $core->numCur($r['price_retail'], 'USD', true);
                        
                    }else
                        $x = $core->numCur($r['price_retail_iqd'], 'IQD', true);
                        
                    echo "<td>".$x."</td>";
                
                
                    if($r['price_wholesale_iqd'] == ""||$core->aes($r['price_wholesale_iqd'], 1) == ""){
                        
                        if($r['price_wholesale'] == ""||$core->aes($r['price_wholesale'], 1) == "")
                            $x='';
                        else
                            $x=$core->numCur($r['price_wholesale'], 'USD', true);
                        
                    }else
                        $x=$core->numCur($r['price_wholesale_iqd'], 'IQD', true);
                        
                    echo "<td>".$x."</td>";
                
                    echo "<td>".$core->numCur($r['price_distribution'], 'USD', true)."</td>";
                
                    echo "<td>";
                    if($core->userHaveRole('PRODUCTS-QUANTITY-VIEW')){
                    echo "<a href='".V_URLP.$url_link_p_edit_quantity."&id=".$r['id']."'  target='_blank'>".$core->txt('0066')."</a>";
                    }
                    if($core->userHaveRole('PACKING-VIEW')){
                    if($core->userHaveRole('PRODUCTS-QUANTITY-VIEW')){echo ' - ';}
                    echo "<a href='".V_URLP.$url_link_p_packing."&id=".$r['id']."'  target='_blank'>".$core->txt('0127')."</a>";
                    }
                    if($core->userHaveRole('PRODUCTS-EDIT')){
                    echo ' - ';
                    echo "<a href='".V_URLP.$url_link_p_add."&id=".$r['id']."'>".$core->txt('0027')."</a>";
                    if($core->userHaveRole('PACKING-VIEW') || $core->userHaveRole('PRODUCTS-QUANTITY-VIEW')){echo ' - ';}
                    ?><a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP.$url_link_p_delete; ?>&id=<?php echo $r['id']; ?>', '<?php echo $core->txt('0030'); ?>')"><?php echo $core->txt('0026')."</a>";
                    }
                    echo "</td>";
                echo "</tr>";
            }
        }
        echo $theme->fetchFooter('products', $core->FETCH_LIMITS['TOTAL_ROWS_COUNTER']);
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
                        <?php echo V_PROG_QUERY; ?>: 'ajax-search-products-edit',
                        <?php echo V_SEARCH_QUERY; ?>: params.term,
                        <?php echo V_PAGE_QUERY; ?>: params.page
                    };},processResults: function (data, params) {params.page = params.page || 1;return {results: data.matches,pagination: {
                more: (params.page * 30) < data.total_count
        }};},cache: true}});
        
    })(jQuery);
</script>