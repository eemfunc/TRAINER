<?php

class database{
    
    public $conn = null;
    public $lastInsertedID;
    
    public function connect(){
        if(!$this->conn){
            $this->conn = mysqli_connect(V_DB_HOSTNAME, V_DB_USERNAME, V_DB_PASSWORD, V_DB_NAME);
            mysqli_set_charset($this->conn, V_DB_CHARSET);
        }
        return true;
    }
    
    public function disconnect(){
        if($this->conn){
            mysqli_close($this->conn);
            $this->conn = null;
        }
        return true;
    }
    
    public function query($x, $y = true){
        if($y)
            $this->connect();
        $r = mysqli_query($this->conn, $x);
        if($y)
            $this->disconnect();
        return $r;
    }
    
    public function num_rows($x, $y = true){
        if($y)
            $this->connect();
        $r = mysqli_num_rows(mysqli_query($this->conn, $x));
        if($y)
            $this->disconnect();
        return $r;
    }
    
    public function define_columns($table, $x){
        $this->connect();
        $r = array();
        $s = mysqli_query($this->conn, $table);
        while($w = mysqli_fetch_assoc($s)){
            foreach ($x as $k) {
                $r[$k] = $w[$k];
            }
        }
        $this->disconnect();
        return $r;
    }
    
    public function update_row($table, $k){
        global $core;
        $x = "";
        for($i = 1; $i < count($k); $i++){
            if($i > 1)
                $x .= ", ";
            $x .= $k[$i] . "='" . $core->aes($_GET[$k[$i]]) . "'";
        }
        $id = $_GET[$k[0]];
        return ($this->query("UPDATE $table SET $x, synced='0' WHERE id='$id'")) ? true : false;
    }
    
    public function define_columns_v1($query, $columns_arr, $oc = true){
        if($oc)
            $this->connect();
        $output = array();
        $sql = mysqli_query($this->conn, $query);
        while($r = mysqli_fetch_assoc($sql)){
            foreach($columns_arr as $column){
                $output[$column] = $r[$column];
            }
        }
        if($oc)
            $this->disconnect();
        return $output;
    }
    
    public function remove_row($table, $id){
        return ($this->query("UPDATE $table SET removed='1', synced='0' WHERE id='$id'")) ? true : false;
    }
    
    public function delete_row($table, $id){
        return $this->query("DELETE FROM $table WHERE id='$id'") ? true : false;
    }
}

?>