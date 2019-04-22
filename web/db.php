<?php

$db_host = "localhost";
$db_user = "root";
$db_passwd = "";
$db_dbname = "ipmac";

$mysqli = new mysqli($db_host, $db_user, $db_passwd, $db_dbname);
if(mysqli_connect_error()){
        echo mysqli_connect_error();
}

$mysqli->query("set names utf8");

function process_mac($str){
        $str = str_replace(":","",$str);
        $str = str_replace(".","",$str);
        $str = str_replace("-","",$str);
        $str = strtoupper($str);
        if(strlen($str)==12)
                return $str;
        return $str;
}

?>
