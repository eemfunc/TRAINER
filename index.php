<?php

require('config.php');
require('core/func/core.func.php');
require('core/func/func.database.php');
require('core/func/func.theme.php');

$core       = new CoreFunc();
$db         = new database();
$theme      = new theme();

if(!isset($_GET[V_PROG_QUERY]))
    if(!$core->userChkSign())
        $core->err(V_URLP.V_SIGNPAGE);
    else
        $core->err(V_URLP.V_HOMEPAGE);
elseif(!$core->userChkSign()){
    if($_GET[V_PROG_QUERY] != V_SIGNPAGE)
        $core->err(V_URLP.V_SIGNPAGE);
}elseif($_GET[V_PROG_QUERY] == V_SIGNPAGE)
    $core->err(V_URLP.V_HOMEPAGE);

if(strpos($_GET[V_PROG_QUERY], '-') !== false){
    $dir    = explode('-', $_GET[V_PROG_QUERY])[0];
    $file   = substr($_GET[V_PROG_QUERY], strlen($dir) + 1);
}else{
    $dir    = $_GET[V_PROG_QUERY];
    $file   = 'index';
}

if(!file_exists(V_PROG_ROOT.$dir.'/'.$file.'.php'))
    $core->err(404);

require(V_PROG_ROOT.$dir.'/'.$file.'.php');

?>