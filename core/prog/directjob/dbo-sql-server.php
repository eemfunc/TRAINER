<?php
                      
    echo "<table>";
    $db->connect();
    $sql = "SELECT * FROM products WHERE removed='0' AND price_distribution='' ORDER BY created_at DESC";
    $query = mysqli_query($db->conn, $sql);
    while($r = mysqli_fetch_assoc($query)){
        echo "<tr>";
            echo "<td>".$r['id']."</td>";
            echo "<td>".$core->aes($r['item_no'], 1)."</td>";
            echo "<td>".$core->aes($r['name'], 1)."</td>";
        echo "</tr>";
    }
    $db->disconnect();
    echo "</table>";

die();

/*
*
* 1- Download and install SQL Server 2017 Express (or later version):
*    https://www.microsoft.com/en-us/sql-server/sql-server-downloads
*
* 2- Download and install SSMS (SQL Server Management Studio) 18.0 (or later version):
*    https://docs.microsoft.com/en-us/sql/ssms/download-sql-server-management-studio-ssms
*
* 3- Download and install Microsoft Driver 5.6 for PHP for SQL Server (or later version):
*    https://www.microsoft.com/en-us/download/details.aspx?id=57916
*
* 4- In php.ini file add these two lines to load the driver:
*    extension=php_sqlsrv_73_ts_x64
*    extension=php_pdo_sqlsrv_73_ts_x64
*
* 5- Restart Apache server.
*
* 6- Open SSMS and attach the mdf file of your database (if an error appeared, close
*    the SSMS and run it again as administrator so you can attach the DB without any
*    error).
*
*/

define('MSSQL_SERVER_NAME', 'DESKTOP-DE1KMIA\\SQLEXPRESS');
define('MSSQL_DATABASE', 'StockDB');
define('MSSQL_UID', '');
define('MSSQL_PWD', '');

/* Connecting using sqlsrv_connect() function */
/*
* $conn_options = array('Database' => MSSQL_DATABASE, 'UID' => MSSQL_UID, 'PWD' => MSSQL_PWD);
* $conn = sqlsrv_connect(MSSQL_SERVER_NAME, $conn_options);
*/


/* Connecting using PDO class */
try {  
   $conn = new PDO( "sqlsrv:Server=".MSSQL_SERVER_NAME.";Database=".MSSQL_DATABASE, MSSQL_UID, MSSQL_PWD);
   $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
}catch(PDOException $e){die( "Error connecting to SQL Server" );}  

echo "<table>";
$sql = $conn->query("SELECT * FROM Customers WHERE IS_Deleted='0'");
while($r = $sql->fetch(PDO::FETCH_ASSOC)){   
    echo "<tr>"
        ."<td>".$r['name']."</td>";
    
        $city = "";
        $sql1 = $conn->query("SELECT * FROM Cities WHERE id='".$r['city']."'");
        while($r1 = $sql1->fetch(PDO::FETCH_ASSOC)){
            $city = correct_city($r1['name']);
        }
        echo "<td>".$city."</td>";
    
        $area = "";
        $sql1 = $conn->query("SELECT * FROM Areas WHERE id='".$r['area']."'");
        while($r1 = $sql1->fetch(PDO::FETCH_ASSOC)){
            $area = $r1['name'];
        }
        echo "<td>".$area."</td>";
    
    
        
        /*
        $id=$core->newRandomID('products');$db->query("INSERT INTO products (id, user_id, name, item_no) VALUES ('".$id."','".$core->userData('id')."','".$core->aes(" --- ")."','".$core->aes(" --- ")."')");$db->query("INSERT INTO products_quantities (id, user_id, store_id, product_id, quantity) VALUES ('".$core->newRandomID('products_quantities')."','".$core->userData('id')."','Gj3RJ3sH','".$id."','".$core->aes(" --- ")."')");
        */
    
    
    echo "</tr>";
}
echo "</table>";


function correct_city($area){
    if($area == "البصره")return "البصرة";
    elseif($area == "الديوانيه")return "القادسية";
    elseif($area == "العماره")return "ميسان";
    elseif($area == "الحله")return "بابل";
    elseif($area == "الفلوجه")return "الأنبار";
    elseif($area == "الرمادي")return "الأنبار";
    elseif($area == "الموصل")return "نينوى";
    elseif($area == "سليمانيه")return "السليمانية";
    elseif($area == "بعقوبه")return "ديالى";
    elseif($area == "بلد")return "صلاح الدين";
    elseif($area == "خالص")return "ديالى";
    elseif($area == "خانقين")return "ديالى";
    elseif($area == "رميثه")return "المثنى";
    elseif($area == "سامراء")return "صلاح الدين";
    elseif($area == "سماوه")return "المثنى";
    elseif($area == "مسيب")return "بابل";
    elseif($area == "كوت")return "واسط";
    elseif($area == "حديثه")return "الأنبار";
    elseif($area == "ناصريه")return "ذي قار";
    else return $area;
}

?>