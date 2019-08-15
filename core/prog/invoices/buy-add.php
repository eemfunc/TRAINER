<?php echo $theme->getHeader('select2'); 

$url_link_p="invoices-buy";
$url_link_p_add_now='invoices-buy-add-now';

$id="";
if(isset($_GET['id']))
    if($_GET['id'] != "")
        $id = $_GET['id'];

?>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card rtl">
              <div class="card">
                <div class="card-body">
                  <h4 class="hb title-size center"><?php echo $core->txt('0086'); ?><br><br></h4>
                  <form class="forms-sample" method="post" action="<?php echo V_URLP.$url_link_p_add_now; ?>">
           
<div class="col-lg-12 row">
    <div class="col-sm-1">
        <input name="invoice_buy_id" id="invoice_buy_id" type="hidden" value="<?php echo $id; ?>">
    </div>
    <div class="col-sm-5">
        <div class="form-group">
            <label class="col-form-label"><?php echo $core->txt('0050'); ?></label>
            <select name="product_id" id="product_id" class="title-size form-control js-example-rtl"></select>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
          <label class="col-form-label"><?php echo $core->txt('0089'); ?></label>
          <input name="quantity" id="quantity" type="number" class="form-control form-control-sm" style="margin-top: 0px;" value="0">
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
          <label class="col-form-label"><?php echo $core->txt('0087'); ?></label>
          <input name="price" id="price" data-inputmask="'alias': 'currency'" class="form-control form-control-sm" style="margin-top: 0px;">
        </div>
    </div>
    <div class="col-sm-1" style="padding-top:35px;">
        <div class="form-group">
          <button id="addProduct" type="button" class="btn btn-primary btn-sm hr button-size rtl" style="vertical-align: bottom;"><?php echo $core->txt('0088'); ?></button>
        </div>
    </div>
    <div class="col-sm-1" id="statIcon" style="padding-top:40px;text-align:right;"></div>
</div>
                      
<div class="row">
    <div class="table-responsive">
        <table id="invoice_buy_products" class="table table-bordered">
            <thead>
                <tr>
                  <th><?php echo $core->txt('0050'); ?></th>
                  <th><?php echo $core->txt('0089'); ?></th>
                  <th><?php echo $core->txt('0087'); ?></th>
                  <th><?php echo $core->txt('0090'); ?></th>
                </tr>
            </thead>
            <tbody>
            <?php
                
                $x0 = '';
                $x0id = '';
                $x1 = '';
                $x2 = '';
                $x3 = '';
                $x4 = '';
                
                if($id != ""){
                    $rows = $core->dbFetch('invoices_buy_products', array('invoice_id' => $id));
                    foreach($rows as $r){
                        echo "<tr>";
                            $p_n_e = $core->aes($core->dbFetch('products', array('id' => $r['product_id']))[0]["name"], 1);
                            $d_quantity = $core->aes($r['quantity'], 1);
                            $d_price = $core->aes($r['price'], 1);
                            echo "<td>".$p_n_e." (".$r['product_id'].")</td>";
                            echo "<td>".$d_quantity."</td>";
                            echo "<td>".$d_price."</td>";
                            echo "<td>".round(($d_quantity * $d_price), 2)."</td>";
                        echo "</tr>";
                    }
                    
                    $rows = $core->dbFetch('invoices_buy', array('id' => $id));
                    foreach($rows as $r){
                        $x0 = $core->aes($core->dbFetch('importers', array('id' => $r['importer_id']))[0]["name"], 1);
                        $x0id = $r['importer_id'];
                        $x1 = $core->aes($r['title'], 1);
                        $x2 = $core->aes($r['invoice_no'], 1);
                        $x3 = $core->aes($r['company'], 1);
                        $x4 = $core->aes($r['description'], 1);
                    }

                }
            ?>
            </tbody>
        </table>
    </div>
</div>

<br><br><br>
                      
                    <div class="form-group">
                      <label for="importer_id"><?php echo $core->txt('0085'); ?> *</label>
                      <select name="importer_id" value="<?php echo $x0; ?>" id="importer_id" class="title-size form-control form-control-sm js-example-rtl-2"></select>
                    </div>
                    <div class="form-group">
                      <label for="x1"><?php echo $core->txt('0057'); ?> *</label>
                      <input name="title" value="<?php echo $x1; ?>" type="text" class="form-control form-control-sm" id="x1">
                    </div>
                    <div class="form-group">
                      <label for="x8"><?php echo $core->txt('0083'); ?></label>
                      <input name="invoice_no" value="<?php echo $x2; ?>" type="text" class="form-control form-control-sm" id="x8">
                    </div>
                    <div class="form-group">
                      <label for="x7_1"><?php echo $core->txt('0091'); ?></label>
                      <input name="company" value="<?php echo $x3; ?>" type="text" class="form-control form-control-sm" id="x7_1">
                    </div>
                    <div class="form-group">
                      <label for="x2"><?php echo $core->txt('0053'); ?></label>
                      <input name="description" value="<?php echo $x4; ?>" type="text" class="form-control form-control-sm" id="x2">
                    </div>
                    
                    
                    <br><br>
                    <button type="submit" class="btn btn-primary"><?php echo $core->txt('0023'); ?></button>
                    <a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP.$url_link_p; ?>', '<?php echo $core->txt('0030'); ?>')"><button type="button" class="btn btn-secondary btn-md mr-2"><?php echo $core->txt('0064'); ?></button></a>
                  </form>
                </div>
            </div>
        </div>
    </div>

<?php echo $theme->getFooter('select2'); ?>

<script type="text/javascript">
    (function ($) {
        
        $("#addProduct").click(function(){
            var addNow = 0;
            $("#statIcon").empty();
            if($('#product_id').val() != '' && $('#product_id').val() != null &&
              $('#quantity').val() != '' && $('#quantity').val() > 0 &&
              $('#price').val() != '' && $('#price').val().replace('$', '') > 0 &&
              Math.floor($('#quantity').val()) == $('#quantity').val())
                addNow = 1;
            if(addNow == 0){
                $("#statIcon").append("<i class='fa fa-times' style='color:red;'></i>");
            }else{
                $("#addProduct").attr("disabled", true);
                var ajaxStat = 0;
                $.ajax({
                    url: "<?php echo V_MAIN_FOLDER_PATH; ?>",
                    method: "GET",
                    data: {
                        <?php echo V_PROG_QUERY; ?> : "ajax-invoice-buy-add-product",
                        "invoice_buy_id" : $('#invoice_buy_id').val(),
                        "product_id" : $('#product_id').val(),
                        "quantity" : $('#quantity').val(),
                        "price" : $('#price').val().replace('$', '')
                    },
                    success: function(data){
                        var out = JSON.parse(data);
                        if(out.status == "success")ajaxStat = 1;
                        if(addNow == 0 || ajaxStat == 0){
                            $("#statIcon").append("<i class='fa fa-times' style='color:red;'></i>");
                        }else{
                            $('#invoice_buy_id').val(out.data.invoice_buy_id);
                            $('#invoice_buy_products').append(
                                '<tr>' +
                                    '<td>' + $('#product_id').val() + '</td>' +
                                    '<td>' + $('#quantity').val() + '</td>' +
                                    '<td>' + $('#price').val().replace('$', '') + '</td>' +
                                    '<td>' + ($('#price').val().replace('$', '') * $('#quantity').val()).toFixed(2) + '</td>' +
                                '</tr>'
                            );
                            $("#statIcon").append("<i class='fa fa-check' style='color:green;'></i>");
                            $('#product_id').val('');
                            $('#select2-product_id-container').attr('title', '');
                            $('#select2-product_id-container').empty();
                            $('#select2-product_id-container').append('<?php echo $core->txt('0068'); ?>');
                            $('#quantity').val('0');
                            $('#price').val('');
                        }
                        $("#addProduct").attr("disabled", false);
                    },
                    fail: function(xhr, textStatus, errorThrown){
                        $("#statIcon").append("<i class='fa fa-times' style='color:red;'></i>");
                        $("#addProduct").attr("disabled", false);
                    }
                }); 
            }
        });
        
        $('.js-example-rtl').select2({
            placeholder: "<?php echo $core->txt('0068'); ?>",language:{errorLoading:function(){return"<?php echo $core->txt('0069'); ?>";},inputTooLong:function(e){var t=e.input.length-e.maximum;return"<?php echo $core->txt('0070'); ?>"+t+"<?php echo $core->txt('0071'); ?>";},inputTooShort:function(e){var t=e.minimum-e.input.length;return"<?php echo $core->txt('0072'); ?>"+t+"<?php echo $core->txt('0076'); ?>";},loadingMore:function(){return"<?php echo $core->txt('0073'); ?>";},maximumSelected:function(e){return"<?php echo $core->txt('0074'); ?>"+e.maximum+"<?php echo $core->txt('0075'); ?>";},noResults:function(){return"<?php echo $core->txt('0077'); ?>";},searching:function(){return"<?php echo $core->txt('0078'); ?>";}},dir: '<?php echo V_SELECT2_DIR; ?>',minimumInputLength: <?php echo V_SELECT2_MINIMUM_INPUT_LENGTH; ?>,ajax: {url: "<?php echo V_MAIN_FOLDER_PATH; ?>",dataType: "json",delay: 250,
                data: function (params) {
                    return {
                        <?php echo V_PROG_QUERY; ?>: 'ajax-search-products-v1',
                        <?php echo V_SEARCH_QUERY; ?>: params.term,
                        <?php echo V_PAGE_QUERY; ?>: params.page
                    };},processResults: function (data, params) {params.page = params.page || 1;return {results: data.matches,pagination: {
                more: (params.page * 30) < data.total_count
        }};},cache: true}});
        
        $('.js-example-rtl-2').select2({
            placeholder: "<?php echo $core->txt('0068'); ?>",language:{errorLoading:function(){return"<?php echo $core->txt('0069'); ?>";},inputTooLong:function(e){var t=e.input.length-e.maximum;return"<?php echo $core->txt('0070'); ?>"+t+"<?php echo $core->txt('0071'); ?>";},inputTooShort:function(e){var t=e.minimum-e.input.length;return"<?php echo $core->txt('0072'); ?>"+t+"<?php echo $core->txt('0076'); ?>";},loadingMore:function(){return"<?php echo $core->txt('0073'); ?>";},maximumSelected:function(e){return"<?php echo $core->txt('0074'); ?>"+e.maximum+"<?php echo $core->txt('0075'); ?>";},noResults:function(){return"<?php echo $core->txt('0077'); ?>";},searching:function(){return"<?php echo $core->txt('0078'); ?>";}},dir: '<?php echo V_SELECT2_DIR; ?>',minimumInputLength: <?php echo V_SELECT2_MINIMUM_INPUT_LENGTH; ?>,ajax: {url: "<?php echo V_MAIN_FOLDER_PATH; ?>",dataType: "json",delay: 250,
                data: function (params) {
                    return {
                        <?php echo V_PROG_QUERY; ?>: 'ajax-search-importers',
                        <?php echo V_SEARCH_QUERY; ?>: params.term,
                        <?php echo V_PAGE_QUERY; ?>: params.page
                    };}
                   ,processResults: function (data, params) {
                       params.page = params.page || 1;
                       return {
                           results: data.matches,
                           pagination: {
                                more: (params.page * 30) < data.total_count
                           }
                       };
                   },cache: true}
        });
        
        <?php if($x0 != '' && $x0id != ''){ ?>
            $('#select2-importer_id-container').empty();
            $('#select2-importer_id-container').append('<?php echo $x0.' ('.$x0id.')'; ?>');
        <?php } ?>
        
    })(jQuery);
</script>