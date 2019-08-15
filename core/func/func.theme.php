<?php

class theme{
    
    public function noTableData(){
        global $core;
        
        $txt = "</tbody></table><table class='table table-bordered'><tbody><tr><td class='center'>".$core->txt('0018')."</td></tr></tbody></table>";
        return $txt;
    }
    
    public function tablePagination($page, $total_pages, $urlp){
        global $core;
        
        $txt = "<div class='col-sm-12 col-md-7'><div class='dataTables_paginate paging_simple_numbers'><ul class='pagination'><li class='paginate_button page-item previous ";
        if($page == 1)
            $txt.= "disabled";
        $txt.= "'><a href='javascript:void(0);' onclick=\"javascript:goto('".V_URLP.$urlp."&".V_PAGE_QUERY."=".($page - 1)."')\" aria-controls='order-listing' data-dt-idx='0' tabindex='0' class='page-link'>".$core->txt('0036')."</a></li>";
        for($i = 1; $i <= $total_pages; $i++){
            $x=0;
            if($page < 4){
                if($i < 6)
                    $x = 1;
                elseif($i == 6)
                    $x = 3;
                else
                    $x = 0;
            }elseif($page > ($total_pages - 3)){
                if($i > ($total_pages - 5))
                    $x = 1;
                elseif($i == ($total_pages - 5))
                    $x = 2;
                else
                    $x = 0;
            }else{
                if($i == ($page - 3))
                    $x = 2;
                elseif($i == ($page + 3))
                    $x = 3;
                elseif($i > ($page - 3) && $i < ($page + 3))
                    $x = 1;
                else $x = 0;
            }
            if($x == 1){
                $txt.= "<li class='paginate_button page-item ";
                if($i == $page)
                    $txt.= "active disabled";
                $txt.= "'><a href='javascript:void(0);' onclick=\"javascript:goto('".V_URLP.$urlp."&".V_PAGE_QUERY."=".$i."')\" aria-controls='order-listing' data-dt-idx='1' tabindex='0' class='page-link'>".$core->nf($i)."</a></li>";
            }elseif($x == 2){
                $txt.= "<li class='paginate_button page-item'><a href='javascript:void(0);' onclick=\"javascript:goto('".V_URLP.$urlp."&".V_PAGE_QUERY."=1')\" aria-controls='order-listing' data-dt-idx='1' tabindex='0' class='page-link'>...</a></li>";
            }elseif($x == 3){
                $txt.= "<li class='paginate_button page-item'><a href='javascript:void(0);' onclick=\"javascript:goto('".V_URLP.$urlp."&".V_PAGE_QUERY."=".$total_pages."')\" aria-controls='order-listing' data-dt-idx='1' tabindex='0' class='page-link'>...</a></li>";
            }
        }
        $txt.= "<li class='paginate_button page-item next ";
        if($page == $total_pages)
            $txt.= "disabled";
        $txt.= "' id='order-listing_next'><a href='javascript:void(0);' onclick=\"javascript:goto('".V_URLP.$urlp."&".V_PAGE_QUERY."=".($page + 1)."')\" aria-controls='order-listing' data-dt-idx='2' tabindex='0' class='page-link'>".$core->txt('0037')."</a></li></ul></div></div>";
        return $txt;
    }
    
    public function tableCountersInfo($start_from, $start_to, $total_rows){
        global $core;
        
        $txt = "<div class='col-sm-12 col-md-5 rtl' style='padding-right:0;'><div class='dataTables_info button-size-1'>".$core->txt('0032')."&nbsp;(&nbsp;".$core->nf($start_from + 1)."&nbsp;".$core->txt('0034')."&nbsp;".$core->nf($start_to)."&nbsp;)&nbsp;".$core->txt('0033')."&nbsp;".$core->nf($total_rows)."&nbsp;".$core->txt('0035')."</div></div>";
        
        return $txt;
    }
    
    public function getHeader($includes = array()){
        global $core;
        
        $txt = "<!DOCTYPE html><html lang='en'><head><meta charset='utf-8'><title>".V_WEB_TITLE."</title><meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'><link rel='icon' href='".V_THEME_FOLDER_PATH."assets/images/favicon.png' type='image/png'><link rel='stylesheet' href='".V_THEME_FOLDER_PATH."assets/vendors/iconfonts/MaterialDesign-Webfont-master/css/materialdesignicons.min.css'><link rel='stylesheet' href='".V_THEME_FOLDER_PATH."assets/vendors/css/vendor.bundle.base.css'><link rel='stylesheet' href='".V_THEME_FOLDER_PATH."assets/vendors/css/vendor.bundle.addons.css'><link rel='stylesheet' href='".V_THEME_FOLDER_PATH."assets/css/style.css'><link rel='stylesheet' href='".V_THEME_FOLDER_PATH."assets/css/style.custom.css'>";
        
        if(!is_array($includes))
            $includes = (array)$includes;
        if(in_array('select2', $includes))
            $txt.= "<link rel='stylesheet' href='".V_THEME_FOLDER_PATH."assets/vendors/select2-4.0.6-rc.1/select2.min.css'><link rel='stylesheet' href='".V_THEME_FOLDER_PATH."assets/css/select2.custom.css'>";
        
        $txt.= "</head><body class='sidebar-icon-only'><div class='container-scroller'><nav class='navbar col-lg-12 col-12 p-0 d-flex flex-row'><div class='navbar-menu-wrapper d-flex align-items-stretch justify-content-between'><ul class='navbar-nav mr-lg-2 d-none d-lg-flex'><li class='nav-item nav-toggler-item'><button class='navbar-toggler align-self-center' type='button' data-toggle='minimize'><span class='mdi mdi-menu'></span></button></li></ul><ul class='navbar-nav navbar-nav-right'><li class='nav-item nav-profile dropdown'><a class='nav-link dropdown-toggle' href='#' data-toggle='dropdown' id='profileDropdown'><span class='nav-profile-name'>".$core->userData('name')."</span></a><div class='dropdown-menu dropdown-menu-right navbar-dropdown' aria-labelledby='profileDropdown'><a class='dropdown-item' href='".V_URLP."dashboard'><i class='mdi mdi-view-dashboard text-primary'></i>".$core->txt('0236')."</a><a class='dropdown-item' href='".V_URLP."sign-out'><i class='mdi mdi-logout text-primary'></i>".$core->txt('0104')."</a></div></li></ul></div></nav><div class='container-fluid page-body-wrapper'><nav class='sidebar sidebar-offcanvas' id='sidebar'><ul class='nav'><li class='nav-item'><a class='nav-link' href='".V_URLP."dashboard'><i class='mdi mdi-view-dashboard menu-icon'></i><span class='menu-title'>".$core->txt('0236')."</span></a></li>";
        if($core->userHaveRole('INVOICES-EDIT')){
        $txt.= "<li class='nav-item'><a class='nav-link' href='".V_URLP."invoices-add' target='_blank'><i class='mdi mdi-file-document-box-multiple menu-icon'></i><span class='menu-title'>".$core->txt('0190')."</span></a></li>";
        }
        if($core->userHaveRole('CUSTOMERS-EDIT')){
        $txt.= "<li class='nav-item'><a class='nav-link' href='".V_URLP."customers-add' target='_blank'><i class='mdi mdi-account-card-details menu-icon'></i><span class='menu-title'>".$core->txt('0256')."</span></a></li>";
        }
        
        $txt.= "</ul></nav><div class='main-panel'><div class='content-wrapper'><div id='preloader'><div class='canvas'><div class='spinner'></div></div></div>";
        
        if(isset($_GET[V_MSG_QUERY])){
            if($_GET[V_MSG_QUERY] == 's')
                $txt.= "<div class='card card-inverse-success rtl'>".$core->txt('0024')."</div><br>";
            elseif($_GET[V_MSG_QUERY] == 'f')
                $txt.= "<div class='card card-inverse-danger rtl'>".$core->txt('0025')."</div><br>";
            elseif($_GET[V_MSG_QUERY] == 'f_credit_limit')
                $txt.= "<div class='card card-inverse-danger rtl'>".$core->txt('0189')."</div><br>";
        }
        
        return $txt;
    }
    
    public function getFooter($includes = array()){
        global $core;
        $txt = "</div><footer class='footer'><div class='d-sm-flex justify-content-center justify-content-sm-between'><span class='text-muted text-center text-sm-left d-block d-sm-inline-block'>".$core->copyright()."</span></div></footer></div></div></div><script src='".V_THEME_FOLDER_PATH."assets/vendors/js/vendor.bundle.base.js'></script><script src='".V_THEME_FOLDER_PATH."assets/vendors/js/vendor.bundle.addons.js'></script><script src='".V_THEME_FOLDER_PATH."assets/js/template_theme.js'></script><script src='".V_THEME_FOLDER_PATH."assets/js/script.custom.js'></script>";
        
        if(!is_array($includes))
            $includes = (array)$includes;
        foreach($includes as $include){
            if($include == 'select2'){
                $txt.= "<script src='".V_THEME_FOLDER_PATH."assets/vendors/select2-4.0.6-rc.1/select2.min.js'></script>";
            }else{
                $dir = explode('-', $_GET[V_PROG_QUERY])[0].'/';
                $txt.= "<script src='".V_CORE_FOLDER_PATH.V_PROG_FOLDER.$dir.$include.".js'></script>";
            }
        }
        $txt.= "</body></html>";
        
        return $txt;
    }

    public function fetchFooter($url_link_p, $total_rows = null){
        global $core;
        if($total_rows !== null)
            $core->prepareFetchLimits($total_rows);
        if($core->FETCH_LIMITS['TOTAL_ROWS'] > 0){
            $output = "</tbody></table><br><div class='row' style='width:100%;margin:0px;'><div class='col-sm-12 col-md-7' style='padding-left:0px;'><div class='dataTables_paginate paging_simple_numbers'><ul class='pagination'><li class='paginate_button page-item previous";
            if($core->FETCH_LIMITS['PAGE_NO'] == 1)
                $output.= ' disabled';
            $output.= "'><a href='javascript:void(0);' onclick=\"javascript:goto('".V_URLP.$url_link_p.'&'.V_PAGE_QUERY.'='.($core->FETCH_LIMITS['PAGE_NO']-1)."')\" aria-controls='order-listing' data-dt-idx='0' tabindex='0' class='page-link'>".$core->txt('0036')."</a></li>";
            for($i = 1; $i <= $core->FETCH_LIMITS['TOTAL_PAGES']; $i++){
                $x = 0;
                if($core->FETCH_LIMITS['PAGE_NO'] < 4){
                    if($i < 6)
                        $x = 1;
                    elseif($i == 6)
                        $x = 3;
                    else
                        $x = 0;
                }elseif($core->FETCH_LIMITS['PAGE_NO'] > ($core->FETCH_LIMITS['TOTAL_PAGES'] - 3)){
                    if($i > ($core->FETCH_LIMITS['TOTAL_PAGES']-5))
                        $x = 1;
                    elseif($i == ($core->FETCH_LIMITS['TOTAL_PAGES'] - 5))
                        $x = 2;
                    else
                        $x = 0;
                }else{
                    if($i == ($core->FETCH_LIMITS['PAGE_NO'] - 3))
                        $x = 2;
                    elseif($i == ($core->FETCH_LIMITS['PAGE_NO'] + 3))
                        $x = 3;
                    elseif($i > ($core->FETCH_LIMITS['PAGE_NO'] - 3) && $i < ($core->FETCH_LIMITS['PAGE_NO'] + 3))
                        $x = 1;
                    else
                        $x = 0;
                }
                if($x == 1){
                    $output.= "<li class='paginate_button page-item";
                    if($i == $core->FETCH_LIMITS['PAGE_NO'])
                        $output.= " active disabled";
                    $output.= "'><a href='javascript:void(0);' onclick=\"javascript:goto('".V_URLP.$url_link_p.'&'.V_PAGE_QUERY.'='.$i."')\" aria-controls='order-listing' data-dt-idx='1' tabindex='0' class='page-link'>".$i."</a></li>";
                }elseif($x == 2){
                    $output.= "<li class='paginate_button page-item'><a href='javascript:void(0);' onclick=\"javascript:goto('".V_URLP.$url_link_p.'&'.V_PAGE_QUERY."=1')\" aria-controls='order-listing' data-dt-idx='1' tabindex='0' class='page-link'>...</a></li>";
                }elseif($x == 3){
                    $output.= "<li class='paginate_button page-item'><a href='javascript:void(0);' onclick=\"javascript:goto('".V_URLP.$url_link_p.'&'.V_PAGE_QUERY.'='.$core->FETCH_LIMITS['TOTAL_PAGES']."')\" aria-controls='order-listing' data-dt-idx='1' tabindex='0' class='page-link'>...</a></li>";
                }
            }
            $output.= "<li class='paginate_button page-item next";
            if($core->FETCH_LIMITS['PAGE_NO'] == $core->FETCH_LIMITS['TOTAL_PAGES'])
                $output.= " disabled";
            $output.= "' id='order-listing_next'><a href='javascript:void(0);' onclick=\"javascript:goto('".V_URLP.$url_link_p.'&'.V_PAGE_QUERY.'='.($core->FETCH_LIMITS['PAGE_NO'] + 1)."')\" aria-controls='order-listing' data-dt-idx='2' tabindex='0' class='page-link'>".$core->txt('0037')."</a></li></ul></div></div><div class='col-sm-12 col-md-5 rtl' style='padding-right:0;'><div class='dataTables_info button-size-1'>".$core->txt('0032').' ( '.$core->nf($core->FETCH_LIMITS['START_FROM'] + 1).' '.$core->txt('0034').' '.$core->nf($core->FETCH_LIMITS['START_TO']).' ) '.$core->txt('0033').' '.$core->nf($core->FETCH_LIMITS['TOTAL_ROWS']).' '.$core->txt('0035')."</div></div></div>";
        }else{
            $output = "</tbody></table>";
            if(!$core->chkDef('HIDE_EMPTY_TABLE_INFO'))
                $output.= "<table class='table table-bordered'><tbody><tr><td class='center'>".$core->txt('0018')."</td></tr></tbody></table>";
        }
        return $output;
    }
}

?>