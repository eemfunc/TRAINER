<?php 
    $core->userChkRole('PRODUCTS-QUANTITY-VIEW');
    if(!$core->chk_GET('id'))
        $core->err(404);
    echo
        $theme->getHeader(); 

    $url_link_p="products";
    $url_link_p_add_now='products-quantity-add-now';
?>

    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 grid-margin stretch-card rtl">
              <div class="card">
                <div class="card-body">
                  <h4 class="hb title-size center"><?php if($core->userHaveRole('PRODUCTS-QUANTITY-EDIT'))echo $core->txt('0067');else echo $core->txt('0249'); ?><br><br></h4>
                  <form class="forms-sample" method="post" action="<?php echo V_URLP.$url_link_p_add_now; ?>">
                    <div class="form-group">
                      <label for="x1"><?php echo $core->txt('0050'); ?></label>
                        <div class="rtl">
        <?php
            $product_vars = $core->dbFetch('products', array('id' => $_GET['id']));
            echo $core->aes($product_vars[0]['name'], 1).' (<span>&#x200F;'.$core->aes($product_vars[0]['item_no'], 1).'</span>)';
        ?>
                            <br>
                        </div>
                    </div>
                      
                      <div class="form-group row">
                        <div class="form-group col-lg-8">
                         <input type="hidden" name="product_id" value="<?php echo $_GET['id']; ?>">
                         <label for="x6"><?php echo $core->txt('0065'); ?> *</label>
                            <select name="store_id" class="form-control" id="x6">
                                <option value="" selected><?php echo $core->txt('0068'); ?></option>
                                <?php
                                    $rows = $core->dbFetch('stores', null, 'ORDER BY created_at ASC');
                                    foreach($rows as $r){
                                        if($core->userHaveRole('STORES-ALL-ACCESS') || $r['branch_id'] == $core->userData('branch_id'))
                                            echo "<option value='".$r['id']."'>".$core->aes($r['name'],1)."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                          <label for="x7auto"><?php echo $core->txt('0066'); ?></label>
                          <input name="quantity" type="text" class="form-control h40" id="x7auto" disabled>
                        </div>
                      </div>
                      <?php if($core->userHaveRole('PRODUCTS-QUANTITY-EDIT')){ ?>
                      <div class="form-group row">
                        <div class="form-group col-sm-6">
                          <label for="x7add"><?php echo $core->txt('0125'); ?></label>
                          <input name="add_quantity" type="number" class="form-control h40" id="x7add">
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="x7decrease"><?php echo $core->txt('0126'); ?></label>
                          <input name="decrease_quantity" type="number" class="form-control h40" id="x7decrease">
                        </div>
                      </div>
                    <div class="form-group">
                      <label for="x8"><?php echo $core->txt('0053'); ?> *</label>
                      <input name="details" type="text" class="form-control h40" id="x8">
                    </div>
                    <br><br>
                    <button type="submit" class="btn btn-primary"><?php echo $core->txt('0023'); ?></button>
                      <?php } ?>
                    <a href="javascript:void(0);" onclick="doAlr('<?php echo V_URLP.$url_link_p; ?>', '<?php echo $core->txt('0030'); ?>')"><button type="button" class="btn btn-secondary btn-md mr-2"><?php echo $core->txt('0064'); ?></button></a>
                  </form>
                </div>
            </div>
            </div>
        <div class="col-lg-3"></div>
    </div>



<?php echo $theme->getFooter(); ?>

<script type="text/javascript">
    (function ($) {
        $('#x6').on('change',function(){getQuantity();});
        $('#x7add').on('change',function(){document.getElementById("x7decrease").value='';});
        $('#x7decrease').on('change',function(){document.getElementById("x7add").value='';});
    })(jQuery);
    
    function getQuantity(){
        var v = document.getElementById("x6").value;
        if(v!=null&&v!=''){
            $.ajax({
                type: 'POST',
                url: '<?php echo V_URLP; ?>ajax-stores-quantity',
                data: { 
                    store_id: v,
                    product_id: "<?php echo $_GET['id']; ?>"
                },
                success: function (response){
                    document.getElementById("x7auto").value=response;
                }
            });
        }else{
            document.getElementById("x7auto").innerHTML="";
        }
    }
</script>