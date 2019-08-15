<?php
    $core->userChkRole('DEBTS-VIEW');

if(isset($_GET['id']))
    if(!$core->dbNumRows('transactions', array('id' => $_GET['id'])))
        $core->err(404);
    else
        define('ID', $_GET['id']);
else
    $core->err(404);

$trans_arr = $core->dbFetch('transactions', array('id' => ID));
define('TRANS_DETAILS',         ($core->aes($trans_arr[0]['details'], 1) == null) ? '--' : $core->aes($trans_arr[0]['details'], 1));
define('TRANS_INVOICE_ID',      ($core->aes($trans_arr[0]['invoice_id'], 1) == null) ? '--' : $core->aes($trans_arr[0]['invoice_id'], 1));
define('TRANS_BRANCH_ID',       $trans_arr[0]['branch_id']);
define('TRANS_DEBIT_USD',       $core->aes($trans_arr[0]['debit_usd'], 1));
define('TRANS_DEBIT_IQD',       $core->aes($trans_arr[0]['debit_iqd'], 1));

if(TRANS_DEBIT_USD == null){
    if(TRANS_DEBIT_IQD == null){
        define('TRANS_DEBIT', 0);
    }else{
        define('TRANS_DEBIT', $core->nf(TRANS_DEBIT_IQD));
    }
}else{
    define('TRANS_DEBIT', $core->nf(TRANS_DEBIT_USD));
}

define('TRANS_CREDIT_USD',      $core->aes($trans_arr[0]['credit_usd'], 1));
define('TRANS_CREDIT_IQD',      $core->aes($trans_arr[0]['credit_iqd'], 1));

if(TRANS_CREDIT_USD == null){
    if(TRANS_CREDIT_IQD == null){
        define('TRANS_CREDIT', 0);
    }else{
        define('TRANS_CREDIT', $core->nf(TRANS_CREDIT_IQD));
    }
}else{
    define('TRANS_CREDIT', $core->nf(TRANS_CREDIT_USD));
}

define('TRANS_CURRENCY',        ($core->aes($trans_arr[0]['currency'], 1) == 'USD') ? $core->txt('0048') : $core->txt('0047'));
define('TRANS_DATE',            explode(' ', $trans_arr[0]['created_at'])[0]);
define('TRANS_TIME',            $core->timeConv(explode(' ', $trans_arr[0]['created_at'])[1]));
define('TRANS_CUSTOMER_ID',     $trans_arr[0]['customer_id']);
define('TRANS_CUSTOMER_NAME',   $core->aes($core->dbFetch('customers', array('id' => TRANS_CUSTOMER_ID))[0]['name'], 1));

$branch_arr = $core->dbFetch('branches', array('id' => TRANS_BRANCH_ID));
define('TRANS_NAME',            $core->aes($branch_arr[0]['name'], 1));
define('TRANS_LOCATION',        $core->aes($branch_arr[0]['location'], 1));
define('TRANS_MOBILE',          $core->aes($branch_arr[0]['mobile'], 1));

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
                                اسم الشركة: <?php echo V_COMPANY_NAME; ?><br>
                                الفرع: <?php echo TRANS_NAME; ?><br>
                                العنوان: <?php echo TRANS_LOCATION; ?><br>
                                رقم الموبايل: <?php echo TRANS_MOBILE; ?>
                            </td>
                            <td class="title">
                                <img src="<?php echo V_UPLOAD_FOLDER_PATH; ?>logo/logo.png" style="width:100%; max-width:150px;">
                            </td>
                            <td>
                                <br><br>
                                رقم الايصال: <?php echo ID; ?><br>
                                التأريخ: <?php echo TRANS_DATE; ?><br>
                                الوقت: <?php echo TRANS_TIME; ?><br>
                                الزبون: <?php echo TRANS_CUSTOMER_NAME; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        
        <table cellpadding="0" cellspacing="0">
            
            <tr class="heading">
                <td>الاسم</td>
                <td>التفاصيل</td>
            </tr>
            <tr class="item">
                <td>مبلغ الايداع</td>
                <td><?php echo TRANS_DEBIT; ?></td>
            </tr>
            <tr class="item">
                <td>مبلغ السحب</td>
                <td><?php echo TRANS_CREDIT; ?></td>
            </tr>
            <tr class="item">
                <td>العملة</td>
                <td><?php echo TRANS_CURRENCY; ?></td>
            </tr>
            <tr class="item">
                <td>تابع لفاتورة مبيع</td>
                <td><?php echo TRANS_INVOICE_ID; ?></td>
            </tr>
            <tr class="item">
                <td>التفاصيل</td>
                <td><?php echo TRANS_DETAILS; ?></td>
            </tr>
            <tr class="total">
                <td>الديون المتبقية بتاريخ (<?php echo date('d-m-Y'); ?>)</td>
                <td><?php 
                    $core->requireClass('payments');
                    $pay = new payments();
                    echo $pay->getDebts(TRANS_CUSTOMER_ID);
                    ?></td>
            </tr>
            
        </table>
    </div>
</body>
</html>
