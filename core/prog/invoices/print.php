<?php
    $core->userChkRole('INVOICES-VIEW');

if(isset($_GET['id']))
    if(!$core->dbNumRows('invoices', array('id' => $_GET['id'])))
        $core->err(404);
    else
        define('ID', $_GET['id']);
else
    $core->err(404);

$invoice_arr = $core->dbFetch('invoices', array('id' => ID));
define('INV_TOTAL',             $core->aes($invoice_arr[0]['invoice_total'], 1));
define('INV_TOTAL_DISCOUNT',    $core->aes($invoice_arr[0]['invoice_total_discount'], 1));
define('INV_FIRST_PAYMENT',     $core->aes($invoice_arr[0]['first_payment'], 1));
define('INV_DELIVERY',          $core->aes($invoice_arr[0]['delivery'], 1));
define('INV_DETAILS',           $core->aes($invoice_arr[0]['details'], 1));
define('INV_BRANCH_ID',         $invoice_arr[0]['branch_id']);
define('INV_DATE',              explode(' ', $invoice_arr[0]['created_at'])[0]);
define('INV_TIME',              $core->timeConv(explode(' ', $invoice_arr[0]['created_at'])[1]));
define('INV_CUSTOMER_ID',       $invoice_arr[0]['customer_id']);
define('INV_CUSTOMER_NAME',     $core->aes($core->dbFetch('customers', array('id' => INV_CUSTOMER_ID))[0]['name'], 1));

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>GStar Invoice</title>
        
        <link rel="shortcut icon" href="<?php echo V_THEME_FOLDER_PATH; ?>assets/images/favicon.png">
        
        <style>
            @font-face{font-family:Helvetica-Bold;src: url('<?php echo V_THEME_FOLDER_PATH; ?>assets/fonts/HelveticaNeue/HelveticaNeueW23-Bd.woff');}
            @font-face{font-family:Helvetica-Reg;src: url('<?php echo V_THEME_FOLDER_PATH; ?>assets/fonts/HelveticaNeue/HelveticaNeueW23-Reg.woff');}
        </style>
    
        <style>
            .invoice-box {
                padding: 30px;
                font-size: 16px;
                line-height: 24px;
                font-family: Helvetica-Reg;
                color: #555;
            }

            .invoice-box table {
                width: 100%;
                line-height: inherit;
                text-align: left;
            }

            .invoice-box table td {
                padding: 5px;
                vertical-align: top;
            }

            .invoice-box table tr td:nth-child(2) {
                text-align: right;
            }

            .invoice-box table tr.top table td {
                padding-bottom: 20px;
            }

            .invoice-box table tr.top table td.title {
                font-size: 45px;
                line-height: 45px;
                color: #333;
            }

            .invoice-box table tr.information table td {
                padding-bottom: 40px;
            }

            .invoice-box table tr.heading td {
                background: #eee;
                border-bottom: 1px solid #ddd;
                font-weight: bold;
            }

            .invoice-box table tr.details td {
                padding-bottom: 20px;
            }

            .invoice-box table tr.item td{
                border-bottom: 1px solid #eee;
            }

            .invoice-box table tr.item.last td {
                border-bottom: none;
            }

            .invoice-box table tr.total td:nth-child(2) {
                border-top: 2px solid #eee;
                font-weight: bold;
            }

            @media only screen and (max-width: 600px) {
                .invoice-box table tr.top table td {
                    width: 100%;
                    display: block;
                    text-align: center;
                }

                .invoice-box table tr.information table td {
                    width: 100%;
                    display: block;
                    text-align: center;
                }
            }

            /** RTL **/
            .rtl {
                direction: rtl;
            }

            .rtl table {
                text-align: right;
            }

            .rtl table tr td:last-child {
                text-align: left;
            }
        </style>
    </head>

<body onload="window.print()">
    <div class="invoice-box rtl">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <br><br>
                                <?php $branch_arr = $core->dbFetch('branches', array('id' => INV_BRANCH_ID)); ?>
                                اسم الشركة: <?php echo V_COMPANY_NAME; ?><br>
                                الفرع: <?php echo $core->aes($branch_arr[0]['name'], 1); ?><br>
                                العنوان: <?php echo $core->aes($branch_arr[0]['location'], 1); ?><br>
                                رقم الموبايل: <?php echo $core->aes($branch_arr[0]['mobile'], 1); ?>
                            </td>
                            <td class="title">
                                <img src="<?php echo V_UPLOAD_FOLDER_PATH; ?>logo/logo.png" style="width:100%; max-width:150px;">
                            </td>
                            <td>
                                <br><br>
                                رقم الفاتورة: <?php echo ID; ?><br>
                                التأريخ: <?php echo INV_DATE; ?><br>
                                الوقت: <?php echo INV_TIME; ?><br>
                                الزبون: <?php echo INV_CUSTOMER_NAME; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
            
            <!--<tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                Sparksuite, Inc.<br>
                                12345 Sunny Road<br>
                                Sunnyville, CA 12345
                            </td>
                            
                            <td>
                                Acme Corp.<br>
                                John Doe<br>
                                john@example.com
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>-->
            
            
            
          <table cellpadding="0" cellspacing="0">
              <tr class="heading">
                <td>اسم المادة</td>
                <td>الكمية (التعبئة)</td>
                <td>سعر القطعة</td>
                <td>المجموع</td>
                </tr>
              
            <?php
            $rows = $core->dbFetch('invoices_products', array('invoice_id' => ID), 'ORDER BY created_at ASC');
            foreach($rows as $r){
                echo "<tr class='details'>";
                        $product_arr        = $core->dbFetch('products', array('id' => $r['product_id']));
                        $product_name       = $core->aes($product_arr[0]['name'], 1);
                        $product_item_no    = $core->aes($product_arr[0]['item_no'], 1);
                    echo "<td>".$product_name." (<span>&#x200F;".$product_item_no."</span>)</td>";
                        $quantity = $core->aes($r['quantity'], 1);
                        if($r['packing_id'] == 1){
                            $packing = $core->txt('0129').' (1)';
                        }else{
                            $packing_arr = $core->dbFetch('packing', array('id' => $r['packing_id']));
                            $packing = $core->aes($packing_arr[0]['name'], 1).' ('.$core->aes($packing_arr[0]['quantity'], 1).')';
                        }
                    echo "<td>".$core->nf($quantity).' '.$packing."</td>";
                        if($core->aes($r['currency'], 1) == 'USD'){
                            $unit_price = $core->aes($r['unit_price_usd'], 1);
                            $total_price = $core->aes($r['total_price_usd'], 1);
                        }else{
                            $unit_price = $core->aes($r['unit_price_iqd'], 1);
                            $total_price = $core->aes($r['total_price_iqd'], 1);
                        }
                        if($core->aes($r['currency'], 1) == 'IQD')
                            $c = ' '.$core->txt('0134');
                        else $c = ' '.$core->txt('0135');
                    echo "<td>".$core->nf($unit_price).$c."</td>";
                    echo "<td>".$core->nf($total_price).$c."</td>";
                echo "</tr>";
            }
            ?>
            
            </table>
        
        
            <table cellpadding="0" cellspacing="0">
            
            <tr class="heading">
                <td>التفاصيل</td>
                <td>المبلغ</td>
            </tr>
            <tr class="item">
                <td>مجموع الفاتورة</td>
                <td><?php echo $core->nf(INV_TOTAL_DISCOUNT).$c; ?></td>
            </tr>
            <tr class="item">
                <td>الواصل</td>
                <td><?php echo $core->nf(INV_FIRST_PAYMENT); ?></td>
            </tr>
            <tr class="total">
                <td>الديون المتبقية</td>
                <td><?php 
                    $core->requireClass('payments');
                    $pay = new payments();
                    echo $pay->getDebts(INV_CUSTOMER_ID);
                    ?></td>
            </tr>
            
            
            <!--<tr class="item last">
                <td>
                    Domain name (1 year)
                </td>
                
                <td>
                    $10.00
                </td>
            </tr>-->
            
            <!--<tr class="total">
                <td></td>
                
                <td>
                   Total: $385.00
                </td>
            </tr>-->
            
        </table>
    </div>
</body>
</html>
