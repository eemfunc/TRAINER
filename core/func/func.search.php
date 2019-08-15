<?php

class search{
    
    public function v1($w, $y){
        $q1 = strtolower(preg_replace('!\s+!', ' ', trim($w)));
        $q1 = str_replace(array('أ','إ','آ'), 'ا', $q1);
        $q1 = str_replace(array('ى'), 'ي', $q1);
        $q1 = str_replace(array('ظ'),'ض', $q1);
        $q1 = str_replace(array('ة'), 'ه', $q1);
        $q = $q1;
        $c1 = strtolower(preg_replace('!\s+!', ' ', trim($y)));
        $c1 = str_replace(array('أ','إ','آ'), 'ا', $c1);
        $c1 = str_replace(array('ى'), 'ي', $c1);
        $c1 = str_replace(array('ظ'),'ض', $c1);
        $c1 = str_replace(array('ة'), 'ه', $c1);
        $c = substr($c1, 0, strlen($q));
        if($c == $q)
            return true;
        else
            return false;
    }
    
    public function v2($w, $y){
        $q1 = strtolower(preg_replace('!\s+!', ' ', trim($w)));
        $q1 = str_replace(array('أ','إ','آ'), 'ا', $q1);
        $q1 = str_replace(array('ى'), 'ي', $q1);
        $q1 = str_replace(array('ظ'),'ض', $q1);
        $q1 = str_replace(array('ة'), 'ه', $q1);
        $q = explode(" ", $q1);
        $c1 = strtolower(preg_replace('!\s+!', ' ', trim($y)));
        $c1 = str_replace(array('أ','إ','آ'), 'ا', $c1);
        $c1 = str_replace(array('ى'), 'ي', $c1);
        $c1 = str_replace(array('ظ'),'ض', $c1);
        $c1 = str_replace(array('ة'), 'ه', $c1);
        $c = explode(" ", $c1);
        $h = 0;
        for($i = 0; $i < count($q); $i++)
            for($j = 0; $j < count($c); $j++)
                if($q[$i] == $c[$j]){
                    $h+= 1;
                    break;
                }
        if($h > 0)
            if(count($q) < 3)
                if(count($q) == $h)
                    return true;
            elseif(count($q)-$h < 2)
                return true;
        return false;
    }
    
}

?>