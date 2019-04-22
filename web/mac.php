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

@$mac = $_REQUEST["mac"];
@$jhjip = $_REQUEST["jhjip"];
@$port = $_REQUEST["port"];
echo "<form action=mac.php method=get>";
echo "<p>MAC/交换机查询 ";
echo "查询字符串: <input name=mac value=\"";
echo $str;
echo "\">";
echo "<input type=submit value=MAC/交换机查询>";
echo "</form><p>";
if( ($mac=="") && ($jhjip=="")) {
	echo "<table><tr><th>交换机</ht><th>MAC数</th></tr>\n";
	$q = "select JHJIP, count(*) from MACPort group by JHJIP";
	$stmt=$mysqli->prepare($q);
	$stmt->execute();
	$stmt->bind_result($jhjip,$count);
	$stmt->store_result();
	while($stmt->fetch()) {
        	echo "<tr><td>";
        	echo "<a href=mac.php?jhjip=$jhjip>$jhjip</a>"; echo "</td><td>";
        	echo $count; echo "</td></tr>";
	}
	echo "</table>";
	exit;
}

if( ($mac=="") && ($jhjip!="") && ($port=="")) {
        echo "<table><tr><th>交换机</ht><th>接口</th><th>MAC数</th></tr>\n";
        $q = "select JHJIP, Port, count(*) from MACPort where JHJIP=? group by JHJIP, Port order by Port";
        $stmt=$mysqli->prepare($q);
	$stmt->bind_param("s",$jhjip);
        $stmt->execute();
        $stmt->bind_result($jhjip,$port,$count);
        $stmt->store_result();
        while($stmt->fetch()) {
                echo "<tr><td>";
                echo "<a href=mac.php?jhjip=$jhjip>$jhjip</a>"; echo "</td><td>";
                echo "<a href=mac.php?jhjip=$jhjip&port=$port>$port</a>"; echo "</td><td>";
                echo $count; echo "</td></tr>";
        }
        echo "</table>";
        exit;
}

echo "<table><tr><th>MAC</th><th>交换机</ht><th>接口</th><th>VLAN</th><th>FisrtSee</th><th>LastSee</th><th>命令</th></tr>\n";
if($mac!="") {
	$q = "select MAC,JHJIP, Port, Vlan, Firstsee,LastSee from MACPort where MAC=?";
	$stmt=$mysqli->prepare($q);
	$stmt->bind_param("s",$mac);
} else {
	$q = "select MAC,JHJIP, Port, Vlan, Firstsee,LastSee from MACPort where JHJIP=? and Port=? order by MAC";
	$stmt=$mysqli->prepare($q);
	$stmt->bind_param("ss",$jhjip, $port);
}
$stmt->execute();
$stmt->bind_result($mac,$jhjip,$port,$vlan,$firstsee,$lastsee);
$stmt->store_result();
while($stmt->fetch()) {
	echo "<tr><td>";
	echo "<a href=mac.php?mac=$mac>$mac</a>"; echo "</td><td>";
	echo "<a href=mac.php?jhjip=$jhjip>$jhjip</a>"; echo "</td><td>";
	echo "<a href=mac.php?jhjip=$jhjip&port=$port>$port</a>"; echo "</td><td>";
	echo $vlan; echo "</td><td>";
	echo $firstsee; echo "</td><td>";
	echo $lastsee; echo "</td>";
	echo "<td><a href=index.php?str=$mac>查IP</a></tr>";
}
echo "</table>";
?>
