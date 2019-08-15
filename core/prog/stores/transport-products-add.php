<?php
    $core->userChkRole('STORES-TRANSPORT-PRODUCTS-EDIT');
    $core->requireClass('transport-products-class', 'stores');
    $tp = (isset($_GET['id'])) ? new tp($_GET['id']) : new tp();
    echo $theme->getHeader('select2');
?>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card rtl">
              <div class="card">
                <div class="card-body">
                  <form class="forms-sample" method="post" action="<?php echo V_URLP; ?>stores-transport-products-add-now">
                <div class="col-lg-12 row" style="padding:0;margin:0;">
                    <div class="col-sm-2 invoiceBG" style="padding-top:35px;">
                        <input name="stores_transport_id" id="stores_transport_id" type="hidden" value="<?php echo $tp->ID; ?>">
                        <h4 class="hb title-size center"><?php echo $core->txt('0223'); ?></h4>
                    </div>
                    <div class="col-sm-5 invoiceBG">
                        <div class="form-group">
                            <label class="col-form-label"><?php echo $core->txt('0225'); ?></label>
                            <select name="store_id_from" id="store_id_from" class="form-control" style="margin-top:1px;" <?php echo $tp->STORE_EDIT_DISABLED; ?>><?php echo $tp->storeIdFromOptions(); ?></select>
                        </div>
                    </div>
                    <div class="col-sm-5 invoiceBG">
                        <div class="form-group">
                            <label class="col-form-label"><?php echo $core->txt('0226'); ?></label>
                            <select name="store_id_to" id="store_id_to" class="form-control" style="margin-top:1px;" <?php echo $tp->STORE_EDIT_DISABLED; ?>><?php echo $tp->storeIdToOptions(); ?></select>
                        </div>
                    </div>
                </div>
                <br>
                <?php if($tp->EDIT && $tp->NEW_DISABLED == ''){ ?>
                <div class="col-lg-12 row">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label class="col-form-label"><?php echo $core->txt('0050'); ?></label>
                            <div class="select2-div"><select name="product_id" id="product_id" class="title-size form-control js-example-rtl" <?php echo $tp->EDIT_DISABLED; ?>></select></div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="col-form-label"><?php echo $core->txt('0127'); ?></label>
                            <select name="packing_id" id="packing_id" class="form-control" style="margin-top: 1px;" <?php echo $tp->EDIT_DISABLED; ?>></select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                          <label class="col-form-label"><?php echo $core->txt('0066'); ?></label>
                          <input name="quantity" id="quantity" type="number" class="form-control form-control-sm" style="margin-top: 0px;" value="0" <?php echo $tp->EDIT_DISABLED; ?>>
                        </div>
                    </div>
                    <div class="col-sm-3" style="padding-top:35px;">
                        <div class="form-group">
                          <button id="addProduct" type="button" class="btn btn-primary btn-sm hr button-size rtl" style="vertical-align: bottom;" <?php echo $tp->EDIT_DISABLED; ?>><?php echo $core->txt('0088'); ?></button>
                        </div>
                    </div>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="table-responsive">
                        <table id="stores_transport_products" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><?php echo $core->txt('0050'); ?></th>
                                    <th><?php echo $core->txt('0179'); ?></th>
                                    <?php if($tp->EDIT && $tp->NEW_DISABLED == ''){ ?>
                                        <th><?php echo $core->txt('0026'); ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php for($i = 0; $i < count($tp->TRANSPORT_PRODUCTS_ARR); $i++){ ?>
                                <tr>
                                    <td><?php echo $tp->TRANSPORT_PRODUCTS_ARR[$i]['product_name']; ?> (<span>&#x200F;<?php echo $tp->TRANSPORT_PRODUCTS_ARR[$i]['product_item_no']; ?></span>)</td>
                                    <td><?php echo $core->nf($tp->TRANSPORT_PRODUCTS_ARR[$i]['quantity']); ?> <?php echo $tp->TRANSPORT_PRODUCTS_ARR[$i]['packing']; ?></td>
                                    <?php if($tp->EDIT && $tp->NEW_DISABLED == ''){ ?>
                                        <td><a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP; ?>stores-transport-product-delete-now&id=<?php echo $tp->TRANSPORT_PRODUCTS_ARR[$i]['id']; ?>&stores_transport_id=' + document.getElementById('stores_transport_id').value, '<?php echo $core->txt('0030'); ?>')"><?php echo $core->txt('0026'); ?></a></td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <br>    
                <?php if($tp->EDIT && $tp->NEW_DISABLED == ''){ ?>
                    <button type="submit" id="submitButton" class="btn btn-primary" <?php echo $tp->EDIT_DISABLED; ?>><?php echo $core->txt('0138'); ?></button>
                    <a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP; ?>stores-transport-products', '<?php echo $core->txt('0030'); ?>')"><button type="button" class="btn btn-secondary btn-md mr-2"><?php echo $core->txt('0064'); ?></button></a>
                <?php }else{ ?>     
                    <a href="javascript:void(0);" onclick="window.close()"><button type="button" class="btn btn-secondary btn-md mr-2"><?php echo $core->txt('0150'); ?></button></a>
                <?php } ?>
                  </form>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">var v_arr={V_URLP:'<?php echo V_URLP; ?>',s1:'<?php echo $core->txt('0068'); ?>',s2:'<?php echo $core->txt('0069'); ?>',s3:'<?php echo $core->txt('0070'); ?>',s4:'<?php echo $core->txt('0071'); ?>',s5:'<?php echo $core->txt('0072'); ?>',s6:'<?php echo $core->txt('0076'); ?>',s7:'<?php echo $core->txt('0073'); ?>',s8:'<?php echo $core->txt('0074'); ?>',s9:'<?php echo $core->txt('0075'); ?>',s10:'<?php echo $core->txt('0077'); ?>',s11:'<?php echo $core->txt('0078'); ?>',s12:'<?php echo V_SELECT2_DIR; ?>',s13:'<?php echo V_SELECT2_MINIMUM_INPUT_LENGTH; ?>',s14:'<?php echo V_MAIN_FOLDER_PATH; ?>',s15:'<?php echo V_ROWS_PER_PAGE_SELECT2; ?>',l1:'<?php echo $core->txt("0030"); ?>',l2:'<?php echo $core->txt("0026"); ?>',l3:'<?php echo $core->txt('0001'); ?>'};function ajaxRet1(params){return{<?php echo V_PROG_QUERY; ?>:"ajax-search-products-v1",<?php echo V_SEARCH_QUERY; ?>:params.term,<?php echo V_PAGE_QUERY; ?>:params.page};}</script>

<?php //echo $theme->getFooter('transport-products-add', 'select2'); ?>
<?php echo $theme->getFooter(); ?>

<script type="text/javascript">
(function ($) {
        
        $('#store_id_from').on('change',function(){
            if(document.getElementById("store_id_from").value == ''){
                document.getElementById("store_id_to").innerHTML = '';
                $("#store_id_to").prop("disabled", true);
                $("#product_id").prop("disabled", true);
                $("#packing_id").prop("disabled", true);
                $("#quantity").prop("disabled", true);
                $("#addProduct").prop("disabled", true);
                $("#submitButton").prop("disabled", true);
            }else{
                var v = document.getElementById("store_id_from").value;
                $.ajax({
                    type: 'POST',
                    url: v_arr['V_URLP'] + 'ajax-stores-in',
                    data: {
                        store_id_from: v
                    },
                    success: function (response){
                        if(response == null){
                            document.getElementById("store_id_to").innerHTML = '';
                            $("#store_id_to").prop("disabled", true);
                            $("#product_id").prop("disabled", true);
                            $("#packing_id").prop("disabled", true);
                            $("#quantity").prop("disabled", true);
                            $("#addProduct").prop("disabled", true);
                            $("#submitButton").prop("disabled", true);
                        }else{
                            $("#store_id_to").attr("disabled", false);
                            document.getElementById("store_id_to").innerHTML = response;
                        }
                    }
                });
            }
        });
        
        $('#store_id_to').on('change',function(){
            if(document.getElementById("store_id_to").value == ''){
                $("#product_id").prop("disabled", true);
                $("#packing_id").prop("disabled", true);
                $("#quantity").prop("disabled", true);
                $("#addProduct").prop("disabled", true);
                $("#submitButton").prop("disabled", true);
            }else{
                $("#product_id").attr("disabled", false);
                $("#packing_id").attr("disabled", false);
                $("#quantity").attr("disabled", false);
                $("#addProduct").attr("disabled", false);
                $("#submitButton").attr("disabled", false);
            }
        });
        
        $('#product_id').on('change',function(){
            var v = document.getElementById("product_id").value;
            if(v != null && v != ''){
                $.ajax({
                    type: 'POST',
                    url: v_arr['V_URLP'] + 'ajax-invoice-products-packing',
                    data: {
                        product_id: v
                    },
                    success: function (response){
                        document.getElementById("packing_id").innerHTML = response;
                    }
                });
            }else{
                document.getElementById("packing_id").innerHTML = '';
            }
        });
        
        $("#addProduct").click(function(){
            $.ajax({
                url: v_arr['V_URLP'] + "stores-transport-products-add-ajax",
                method: "POST",
                data: {
                    "stores_transport_id"   : $('#stores_transport_id').val(),
                    "store_id_from"         : $('#store_id_from').val(),
                    "store_id_to"           : $('#store_id_to').val(),
                    "product_id"            : $('#product_id').val(),
                    "packing_id"            : $('#packing_id').val(),
                    "quantity"              : $('#quantity').val()
                },
                success: function(data){
                    var out = JSON.parse(data);
                    if(out.status != "success"){
                        alert(out.message);
                    }else{
                        $("#store_id_from").prop("disabled", true);
                        $("#store_id_to").prop("disabled", true);
                        
                        var url = new URL(window.location.href);
                        var idParam = url.searchParams.get('id');
                        if(idParam == null)
                            window.history.pushState(null, null, window.location.href + '&id=' + out.data.stores_transport_id);                        
                        $('#stores_transport_id').val(out.data.stores_transport_id);
                        $('#stores_transport_products').append(
                            '<tr>' +
                                '<td>' + out.data.product_name + '</td>' +
                                '<td>' + out.data.quantity + '</td>' +
                                '<td><a href="javascript:void(0);" onclick="doAlr(\'' + v_arr['V_URLP'] + 'stores-transport-product-delete-now&id=' + out.data.stores_transport_product_id + '&stores_transport_id=' + document.getElementById('stores_transport_id').value + '\', \'' + v_arr['l1'] + '\')">' + v_arr['l2'] + '</a></td>' +
                            '</tr>'
                        );
                        $('#product_id').val('');
                        $('#select2-product_id-container').attr('title', '');
                        $('#select2-product_id-container').empty();
                        $('#select2-product_id-container').append(v_arr['s1']);
                        document.getElementById("packing_id").innerHTML='';
                        $('#quantity').val('0');
                    }
                },
                fail: function(xhr, textStatus, errorThrown){
                    alert(v_arr['l3']);
                }
            });
            $("#addProduct").attr('disabled', false);
        });
        
        $('.js-example-rtl').select2({placeholder:v_arr['s1'],language:{errorLoading:function(){return v_arr['s2'];},inputTooLong:function(e){var t=e.input.length-e.maximum;return v_arr['s3']+t+v_arr['s4'];},inputTooShort:function(e){var t=e.minimum-e.input.length;return v_arr['s5']+t+v_arr['s6'];},loadingMore:function(){return v_arr['s7'];},maximumSelected:function(e){return v_arr['s8']+e.maximum+v_arr['s9'];},noResults:function(){return v_arr['s10'];},searching:function(){return v_arr['s11'];}},dir:v_arr['s12'],minimumInputLength:v_arr['s13'],ajax:{url:v_arr['s14'],dataType:"json",delay:250,data:function(params){return ajaxRet1(params);},processResults:function(data, params){params.page = params.page || 1;return {results: data.matches,pagination: {more: (params.page * v_arr['s15']) < data.total_count}};},cache: true}});
        
    })(jQuery);
</script>