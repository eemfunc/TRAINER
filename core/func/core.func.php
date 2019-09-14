<?php

class CoreFunc{

    public $FETCH_LIMITS    = array();

    private $DB_TYPE        = "mysql";
    private $DB_HOSTNAME    = V_DB_HOSTNAME;
    private $DB_NAME        = V_DB_NAME;
    private $DB_USERNAME    = V_DB_USERNAME;
    private $DB_PASSWORD    = V_DB_PASSWORD;
    private $DB_CONN        = null;
    private $LANG_JSON_DATA = null;
    private $AES_METHOD     = 'AES-256-CBC';
    private $AES_IV         = 'I6d^s9A&x0o/W2!T';
    private $AES_KEY        = V_ENCRYPTION_KEY;
    private $AES_KEY_LENGTH = 32;
    private $AES_HASH_ALGO  = 'SHA256';
    private $USER_DATA      = array();
    
    function __construct(){
        require_once('config.php');
        $this->requireClass('theme');
    }
    
    public function requireClass($classNames, $progSubFolder = null){
        if(!is_array($classNames))
            $classNames = (array) $classNames;
        foreach($classNames as $className){
            try{
                if(!$progSubFolder)
                    require_once(V_CLASS_ROOT.$className.'.php');
                else
                    require_once(V_PROG_ROOT.$progSubFolder.'/'.$className.'.php');
            }catch(exception $e) {
                die('Error requiring '.$className.' with error message: '.$e->getMessage());
                return false;
            }
        }
        return true;
    }
    
    /* Search in multidimensional array */
    public function in_array_v1($value, $array, $strict = false) {
        foreach($array as $item){
            if(($strict ? $item === $value : $item == $value) || (is_array($item) && $this->in_array_v1($value, $item, $strict)))
                return true;
        }
        return false;
    }
    
    public function minStr($str, $length = V_MINIMIZE_STRING_LENGTH){
        if(!is_string($str))
            return false;
        return (strlen($str) <= $length) ? $str : substr($str, 0, $length - 4).' ...';
    }
    
    public function dbConnect(){
        if(!$this->DB_CONN){
            try{
                $dsn = "$this->DB_TYPE:Server=$this->DB_HOSTNAME;Database=$this->DB_NAME";
                $this->DB_CONN = new PDO($dsn, $this->DB_USERNAME, $this->DB_PASSWORD);
                $this->DB_CONN->query("USE $this->DB_NAME");
                $this->DB_CONN->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return true;
            }catch(PDOException $e){
                echo "Error connecting to database! <br>Error message: ".$e->getMessage();
                return false;
            }
        }else
            return true;
    }

    public function dbDisconnect(){
        $this->DB_CONN = null;
    }

    public function dbGetAll($what = "TABLES", $table_name = null, $disconnect = true){
        $what = strtoupper($what);
        if($what == "TABLES"){
            $c = "TABLE_NAME";
            $sql_query_str = "SELECT $c FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='$this->DB_NAME'";
        }elseif($what == "COLUMNS"){
            $c = "COLUMN_NAME";
            $sql_query_str = "SELECT $c FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='$this->DB_NAME' AND TABLE_NAME='$table_name'";
        }
        $output = array();
        $this->dbConnect();
        $query = $this->DB_CONN->query($sql_query_str);
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            array_push($output, $row[$c]);
        }
        if($disconnect)
            $this->dbDisconnect();
        return (!count($output)) ? null : $output;
    }

    public function dbFetch($table, $conditions = null, $orderBy = null, $disconnect = true, $prepareFetchLimits = false){
        if($prepareFetchLimits)
            $this->prepareFetchLimits();
        $sql_query_str = "SELECT * FROM ".$table." WHERE removed='0'";
        if($conditions !== null && is_array($conditions)){
            if(array_key_exists('removed', $conditions))
                unset($conditions['removed']);
            if(count($conditions))
                foreach($conditions as $key => $value)
                    $sql_query_str.= " AND ".$this->getColumnCondition($key)."'".$value."'";
        }
        if($orderBy !== null)
            $sql_query_str.= $orderBy;
        $data = array();
        $columns_arr = $this->dbGetAll('COLUMNS', $table);
        $this->dbConnect();
        $query = $this->DB_CONN->query($sql_query_str);
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $new_row_data = array();
            foreach($columns_arr as $column){
                $new_row_data[$column] = $row[$column];
            }
            array_push($data, $new_row_data);
        }
        if($disconnect)
            $this->dbDisconnect();
        return (!count($data)) ? array() : $data;
    }

    public function prepareFetchLimits($total_rows = null){
        $this->FETCH_LIMITS['ROWS_NUM']     = (!empty($_GET[V_ROWS_PER_PAGE_QUERY])) ? $_GET[V_ROWS_PER_PAGE_QUERY] : V_ROWS_PER_PAGE_TABLES;
        $this->FETCH_LIMITS['PAGE_NO']      = (!empty($_GET[V_PAGE_QUERY])) ?  $_GET[V_PAGE_QUERY] : 1;
        $this->FETCH_LIMITS['START_FROM']   = ($this->FETCH_LIMITS['PAGE_NO'] - 1) * $this->FETCH_LIMITS['ROWS_NUM'];
        if($total_rows === null){
            $this->FETCH_LIMITS['TOTAL_ROWS_COUNTER']   = 0;
            $this->FETCH_LIMITS['CURRENT_ROWS_COUNTER'] = 0;
        }else{
            $this->FETCH_LIMITS['TOTAL_ROWS']   = $total_rows;
            $this->FETCH_LIMITS['TOTAL_PAGES']  = ceil($this->FETCH_LIMITS['TOTAL_ROWS'] / $this->FETCH_LIMITS['ROWS_NUM']);
            $this->FETCH_LIMITS['START_TO']     = ($this->FETCH_LIMITS['TOTAL_ROWS'] < $this->FETCH_LIMITS['START_FROM'] + $this->FETCH_LIMITS['ROWS_NUM']) ? $this->FETCH_LIMITS['TOTAL_ROWS'] : $this->FETCH_LIMITS['START_FROM'] + $this->FETCH_LIMITS['ROWS_NUM'];
        }
        return true;
    }

    public function chkDef($constant){
        if(defined($constant))
            if(constant($constant) == true)
                return true;
        return false;
    }

    public function chkFilterLimits($filter_conditions = true){
        if($filter_conditions)
            if($this->chkFetchLimit())
                return true;
        return false;
    }

    public function chkFetchLimit(){
        $condition = (($this->FETCH_LIMITS['TOTAL_ROWS_COUNTER'] >= $this->FETCH_LIMITS['START_FROM']) && ($this->FETCH_LIMITS['TOTAL_ROWS_COUNTER'] < ($this->FETCH_LIMITS['START_FROM'] + $this->FETCH_LIMITS['ROWS_NUM'])));
        if($condition){
            $this->FETCH_LIMITS['CURRENT_ROWS_COUNTER']++;
            $this->FETCH_LIMITS['TOTAL_ROWS_COUNTER']++;
        }else
            $this->FETCH_LIMITS['TOTAL_ROWS_COUNTER']++;
        return $condition;
    }

    private function getColumnCondition($key){
        $c      = substr($key, -1);
        $c_arr  = array('<', '>', '=');
        return (in_array($c, $c_arr)) ? $key : $key.'=';
    }

    public function dbQ($sql_query_str, $disconnect = true){
        $this->dbConnect();
        $query = $this->DB_CONN->query($sql_query_str);
        if($disconnect)
            $this->dbDisconnect();
        return $query;
    }

    public function dbNumRows($table, $conditions = null, $orderBy = null, $disconnect = true){
        $sql_query_str = "SELECT * FROM ".$table." WHERE removed='0'";
        if($conditions !== null){
            if(array_key_exists('removed', $conditions))
                unset($conditions['removed']);
            foreach($conditions as $key => $value)
                $sql_query_str.= " AND ".$this->getColumnCondition($key)."'".$value."'";
        }
        if($orderBy !== null)
            $sql_query_str.= $orderBy;
        $this->dbConnect();
        $num_rows = 0;
        $query = $this->DB_CONN->query($sql_query_str);
        while($row = $query->fetch()){
            $num_rows++;
        }
        if($disconnect)
            $this->dbDisconnect();
        return $num_rows;
    }

    public function dbU($table = null, $data = array(), $conditions = array(), $disconnect = true){
        if(!$this->dbChkTable($table) || !count($data) || !count($conditions))
            return false;
        $sql = "UPDATE ".$table." SET synced='0'";
        unset($data['synced']);
        foreach($data as $column => $value)
            $sql.= ", ".$column."='".$value."'";
        $sql.=" WHERE removed='0'";
        foreach($conditions as $key => $value)
            $sql.= " AND ".$this->getColumnCondition($key)."'".$value."'";
        return $this->dbQ($sql, $disconnect);
    }

    public function dbChkTable($table = null, $disconnect = true){
        if(!$table)
            return false;
        try{
            $result = $this->dbQ("SELECT 1 FROM ".$table." LIMIT 1", $disconnect);
        }catch(Exception $e){
            return false;
        }
        return true;
    }

    public function dbI($table = null, $data = array(), $disconnect = true){
        if(!$this->dbChkTable($table) || !count($data))
            return false;
        $sql = "INSERT INTO ".$table." (user_id";
        unset($data['user_id']);
        if(!array_key_exists('id', $data))
            $sql.= ", id";
        foreach($data as $column => $value){
            $sql.= ", ".$column;
        }
        $sql.= ") VALUES ('".$this->userData('id')."'";
        if(!array_key_exists('id', $data))
            $sql.= ", '".$this->newRandomID($table)."'";
        foreach($data as $column => $value)
            $sql.= ", '".$value."'";
        $sql.=")";
        return $this->dbQ($sql, $disconnect);
    }

    public function dbD($table = null, $conditions = array(), $disconnect = true){
        if(!$this->dbChkTable($table) || !count($conditions))
            return false;
        $sql = "UPDATE ".$table." SET synced='0', removed='1' WHERE ";
        $firstCondition = true;
        foreach($conditions as $key => $value){
            if(!$firstCondition)
                $sql.= " AND ";
            $sql.= $this->getColumnCondition($key)."'".$value."'";
            $firstCondition = false;
        }
        return $this->dbQ($sql, $disconnect);
    }

    public function txt($i){
        $this->chkLangJsonData();
        $txt_key = $this->chkTxtKey($i);
        return $this->LANG_JSON_DATA->$txt_key;
    }
    
    private function chkLangJsonData(){
        if($this->LANG_JSON_DATA == null){
            $lang_path = $_SERVER['DOCUMENT_ROOT'].'/'.V_MAIN_FOLDER.V_LANG_FOLDER_PATH;
            $lang_path.='/'.V_DEFAULT_LANG.'.json';
            $this->LANG_JSON_DATA = json_decode(file_get_contents($lang_path));
            return false;
        }else
            return true;
    }
    
    private function chkTxtKey($i){
        return (array_key_exists($i, $this->LANG_JSON_DATA)) ? $i : '0001';
    }

    public function aes($x, $y = null){
        return (!$y) ? $this->aesEncrypt($x) : $this->aesDecrypt($x);
    }
    
    private function aesGetKey(){
        return substr(hash($this->AES_HASH_ALGO, $this->AES_KEY, true), 0, $this->AES_KEY_LENGTH);
    }
    
    private function aesEncrypt($x){
        return base64_encode(openssl_encrypt($x, $this->AES_METHOD, $this->aesGetKey(), OPENSSL_RAW_DATA, $this->AES_IV));
    }
    
    private function aesDecrypt($x){
        return openssl_decrypt(base64_decode($x), $this->AES_METHOD, $this->aesGetKey(), OPENSSL_RAW_DATA, $this->AES_IV);
    }

    public function err($url = null, $msg = null){
        switch($url){
            case 404:
            case '404':
                $url = V_URLP.V_404PAGE;
                break;
            case null:
                $url = V_MAIN_FOLDER_PATH;
        }
        if($msg === true)
            $url.= '&'.V_MSG_QUERY.'=s';
        elseif($msg === false)
            $url.= '&'.V_MSG_QUERY.'=f';
        elseif($msg != null)
            $url.= '&'.V_MSG_QUERY.'='.$msg;
        header("location: ".$url);
        die();
        return true;
    }
    
    public function chk_GET($param, $notNull = true){
        if(!is_array($param)){
            $value = isset($_GET[$param]) ? $_GET[$param] : null;
            return ($notNull && $_GET[$param] == null) ? false : true;
        }else{
            for($i = 0; $i < count($param); $i++)
                if(!isset($_GET[$param[$i]]))
                    return false;
                elseif($notNull && $_GET[$param[$i]] == null)
                    return false;
            return true;
        }
    }
    
    public function chk_POST($param, $notNull = true){
        if(!is_array($param)){
            $value = isset($_POST[$param]) ? $_POST[$param] : null;
            if($notNull && $_POST[$param] == null)
                return false;
            else
                return true;
        }else{
            for($i = 0; $i < count($param); $i++)
                if(!isset($_POST[$param[$i]]))
                    return false;
                elseif($notNull && $_POST[$param[$i]] == null)
                    return false;
            return true;
        }
    }
    
    public function mkJson($status = true, $message = null, $data = array(), $jsonHeader = false){
        if($jsonHeader)
            header('Content-Type: application/json');
        return json_encode(array(
            "status"    => ($status) ? 'success' : 'failed',
            "message"   => $message,
            "data"      => $data
        ));
    }

    public function removeParamFromUrl($full_url, $param){
        $l_question_arr = explode('?', $full_url);
        $l_and_arr = explode('&', $l_question_arr[1]);
        $output = $l_question_arr[0].'?';
        $done_first_one = false;
        for($i = 0; $i < count($l_and_arr); $i++){
            if(explode('=', $l_and_arr[$i])[0] != $param){
                if($done_first_one)
                    $output.= '&';
                $output.= $l_and_arr[$i];
                $done_first_one = true;
            }
        }
        return $output;
    }

    public function randStr($length = 8, $type = "A-a-0"){
        $chars = array(
            'A' => "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
            'a' => "abcdefghijklmnopqrstuvwxyz",
            '0' => "0123456789",
            '&' => "!@#%&"
        );
        $str = '';
        $j = explode('-', $type);
        for($i = 0; $i < count($j); $i++){
            if(strpos($chars['A'], $j[$i]) !== false)
                $str .= $chars['A'];
            if(strpos($chars['a'], $j[$i]) !== false)
                $str .= $chars['a'];
            if(strpos($chars['0'], $j[$i]) !== false)
                $str .= $chars['0'];
            if(strpos($chars['&'], $j[$i]) !== false)
            $str .= $chars['&'];
        }
        $output = '';
        for($i = 0; $i < $length; $i++)
            $output .= substr($str, mt_rand(0, strlen($str) - 1), 1);
        return $output;
    }
    
    public function newRandomID($dbTable, $length = 8, $type = 'A-a-0', $disconnect = true){
        $this->dbConnect();
        do{
            $id = $this->randStr($length, $type);
            $num_rows = 0;
            $query = $this->DB_CONN->query("SELECT * FROM ".$dbTable." WHERE id='".$id."'");
            while($row = $query->fetch())
                $num_rows++;
        }while($num_rows > 0);
        if($disconnect)
            $this->dbDisconnect();
        return $id;
    }

    public function numCur($num = 0, $cur = 'USD', $decrypt = false){
        if($decrypt)
            $num = $this->aes($num, 1);
        if($num != null && is_numeric($num))
            if(strtolower($cur) == 'iqd')
                return number_format($num).' '.$this->txt('0114');
            else
                return number_format($num, 2, '.', ',').' $';
        else
            return $num;
    }

    /* Numbers beautifier. Puts commas and dot. */
    public function nf($num, $thousands = true){
        $output_float = round($num, 3);
        $output_int = round($num, 0);
        if($output_float - $output_int == 0){
            if($thousands)
                $output = number_format($output_int);
            else
                $output = $output_int;
        }else{
            $output_float_arr = explode('.', $output_float);
            if(strlen($output_float_arr[1]) > 2)
                $output_float = substr($output_float, 0, -1);
            if($thousands)
                $output = number_format((float)$output_float, 2, '.', ',');
            else
                $output = $output_float;
        }
        return $output;
    }
    
    
    public function removeDollarSign($x){
        return (strpos($x, '$') !== false) ? trim(str_replace('$', '', $x)) : trim($x);
    }
    
    public function timeConv($time, $type = "h:i A"){
        $t = explode(':', $time);
        if($t[0] > 12){
            $o = $t[0] - 12;
            $a = 'PM';
        }else{
            $o = $t[0];
            $a = 'AM';
        }
        return $o.':'.$t[1].' '.$a;
    }

    public function copyright(){
        $output = '&copy;&nbsp;';
        if(V_PROJECT_STARTING_DATE == date('Y'))
            $output.= date('Y');
        else
            $output.= V_PROJECT_STARTING_DATE.'&nbsp;-&nbsp;'.date('Y');
        $output.= '&nbsp;by&nbsp;'.V_COMPANY.'&nbsp;'.V_COPYRIGHT_TXT;
        return $output;
    }

    public function age($fromDate, $toDate = 'now', $type = 'y'){
        if(strtolower($toDate) == 'now')
            $toDate = date('Y-m-d');
        $m = (((date('Y', strtotime($toDate)) - date('Y', strtotime($fromDate))) * 12) + (date('m', strtotime($toDate)) - date('m', strtotime($fromDate))));
        $y = floor($m / 12).'|'.((($m / 12) - floor($m / 12)) * 12);
        return ($type == 'm') ? $m : $y;
    }

    public function userData($key, $value = "__|JUST|GET|DATA|__"){
        if(!$key)
            return null;
        elseif($value != "__|JUST|GET|DATA|__")
            return $this->USER_DATA[$key] = $value;
        elseif(!array_key_exists($key, $this->USER_DATA))
            return null;
        else
            return $this->USER_DATA[$key];
    }

    public function userChkSign(){
        $userIsSigned = false;
        if(isset($_COOKIE[V_COOKIES_NAME])){
            $this->userData('email', strtolower($this->aes(base64_decode($_COOKIE[V_COOKIES_NAME]), 1)));
            if($this->dbNumRows('users', array('email' => $this->aes($this->userData('email')), 'activated' => '1')))
                $userIsSigned = true;
        }
        if(!$userIsSigned)
            $this->userSignOut();
        else{
            $data_arr = $this->dbFetch('users', array('email' => $this->aes($this->userData('email'))));
            $this->userData('id', $data_arr[0]['id']);
            $this->userData('name', $this->aes($data_arr[0]['name'], 1));
            if($data_arr[0]['roles_id'] != null){
                $this->userData('roles', explode('|', $this->aes($this->dbFetch('roles', array('id' => $data_arr[0]['roles_id']))[0]['roles'], 1)));
                foreach($this->userData('roles') as $role){
                    $exp = explode('-', $role);
                    if(count($exp) > 2)
                        if($exp[0].'-'.$exp[1] == 'STORE-ACCESS')
                            $this->userData('user-access-store-id', $exp[2]);
                }
            }
            $this->userData('branch_id', $data_arr[0]['branch_id']);
            if($this->userData('branch_id') != null){
                $branch_arr = $this->dbFetch('branches', array('id' => $this->userData('branch_id')));
                $this->userData('branch_name', $this->aes($branch_arr[0]['name'], 1));
                $this->userData('branch_type', $this->aes($branch_arr[0]['type'], 1));
            }
        }
        return $userIsSigned;
    }

    public function userSignIn($email){
        if(setcookie(V_COOKIES_NAME, base64_encode($this->aes($email)), 0, '/'))
            return true;
        else
            return false;
    }
    
    public function userSignOut(){
        return setcookie(V_COOKIES_NAME, '', time() - 604800, '/');
    }

    public function userHaveRole($role){
        if(array_search('ADMIN', (array)$this->userData('roles')) !== false)
            return true;
        else
            return (array_search($role, (array)$this->userData('roles')) !== false) ? true : false;
    }
    
    public function userChkRole($role){
        if(!$this->userHaveRole($role)){
            $this->err(404);
            return false;
        }else
            return true;
    }

}

?>