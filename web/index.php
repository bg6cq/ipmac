<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<link href="table.css" type="text/css" rel="stylesheet" /> 
<title>IP/MAC管理</title>
</head>
<body>


<a href=index.php>查IP</a>  <a href=mac.php>查接口</a><hr>

<?php

require("db.php");

@$str = $_REQUEST["str"];
echo "<form action=index.php method=get>";
echo "<p>IPMAC查询 ";
echo "查询字符串: <input name=str value=\"";
echo $str;
echo "\">";
echo "<input type=submit value=IPMAC查询>";
echo "</form><p>";
if($str!="") {
// work
	echo "<table><tr><th>IP</th><th>MAC</th><th>FisrtSee</th><th>LastSee</th><th>命令</th></tr>\n";
	$q = "select IP,MAC,Firstsee,LastSee from IPMAC_cur where IP=? or MAC=? order by IP";
	$stmt=$mysqli->prepare($q);
	$stmt->bind_param("ss",$str,$str);
	$stmt->execute();
	$stmt->bind_result($ip,$mac,$firstsee,$lastsee);
	$stmt->store_result();
	while($stmt->fetch()) {
		echo "<tr><td>";
		echo "<a href=index.php?str=$ip>$ip</a>"; echo "</td><td>";
		echo "<a href=index.php?str=$mac>$mac</a>"; echo "</td><td>";
		echo $firstsee; echo "</td><td>";
		echo $lastsee; echo "</td>";
		echo "<td><a href=mac.php?mac=$mac>查端口</a></tr>";
	}
	$q = "select IP,MAC,Firstsee,LastSee from IPMAC where IP=? or MAC=? order by Lastsee desc";
	$stmt=$mysqli->prepare($q);
	$stmt->bind_param("ss",$str,$str);
	$stmt->execute();
	$stmt->bind_result($ip,$mac,$firstsee,$lastsee);
	$stmt->store_result();
	while($stmt->fetch()) {
		echo "<tr><td>";
		echo "<a href=index.php?str=$ip>$ip</a>"; echo "</td><td>";
		echo "<a href=index.php?str=$mac>$mac</a>"; echo "</td><td>";
		$firstsee; echo "</td><td>";
		echo $lastsee; echo "</td>";
		echo "<td><a href=mac.php?mac=$mac>查端口</a></tr>";
	}
	echo "</table>";
} else {
  	echo "<table><tr><th>IP</th><th>MAC</th><th>FisrtSee</th><th>LastSee</th><th>命令</th></tr>\n";
        $q = "select IP,MAC,Firstsee,LastSee from IPMAC_cur order by LastSee desc, inet_aton(IP) limit 500";
        $stmt=$mysqli->prepare($q);
        $stmt->execute();
        $stmt->bind_result($ip,$mac,$firstsee,$lastsee);
        $stmt->store_result();
        while($stmt->fetch()) {
                echo "<tr><td>";
		echo "<a href=index.php?str=$ip>$ip</a>"; echo "</td><td>";
		echo "<a href=index.php?str=$mac>$mac</a>"; echo "</td><td>";
                echo $firstsee; echo "</td><td>";
		echo $lastsee; echo "</td>";
		echo "<td><a href=mac.php?mac=$mac>查端口</a></tr>";
        }
	echo "</table>";
}
