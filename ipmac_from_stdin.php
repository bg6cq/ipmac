<?php

$debug = 0;

$ip_new = 0;
$ip_old = 0;

function update_ip_mac($router, $ip, $mac) 
{
	global $mysqli;
	global $debug, $ip_new, $ip_old;

	$q = "replace into IPMAC_IP_last (IP,LastSee) values(?,now())";
	if($debug) echo $q."\n";
	$stmt=$mysqli->prepare($q);
	$stmt->bind_param("s",$ip);
	$stmt->execute();

	$q = "replace into IPMAC_MAC_last (MAC,LastSee) values(?,now())";
	if($debug) echo $q."\n";
	$stmt=$mysqli->prepare($q);
	$stmt->bind_param("s",$mac);
	$stmt->execute();

   	$q = "select MAC, FirstSee, LastSee, RouterIP from IPMAC_cur where IP=?";
	if($debug) echo $q."\n";
	$stmt=$mysqli->prepare($q);
	$stmt->bind_param("s",$ip);
	$stmt->execute();
	$stmt->bind_result($oldmac,$firstsee,$lastsee,$oldrouter);
	$stmt->store_result();
	if($stmt->fetch()) {
		if($oldmac == $mac) { // 同样的MAC已经存在
			$ip_old ++;
			$stmt->close();
			$q = "update IPMAC_cur set Lastsee=now(),RouterIP=? where IP=?";
			if($debug) echo $q."\n";
			$stmt=$mysqli->prepare($q);
			$stmt->bind_param("ss",$router,$ip);
			$stmt->execute();
			$stmt->close();
			return;
		} else {  // MAC地址不同，保存之前的MAC地址
			$stmt->close();
			$q = "insert into IPMAC (IP,MAC,FirstSee,LastSee,RouterIP) values(?,?,?,?,?)";
			if($debug) echo $q."\n";
			$stmt=$mysqli->prepare($q);
			$stmt->bind_param("sssss",$ip,$oldmac,$firstsee,$lastsee,$oldrouter);
			$stmt->execute();
		}
	}
	$stmt->close();
	$ip_new ++;
	$q = "replace into IPMAC_cur (IP,MAC,FirstSee,LastSee,RouterIP) values(?,?,now(),now(),?)";
	if($debug) echo $q."\n";
	$stmt=$mysqli->prepare($q);
	$stmt->bind_param("sss",$ip,$mac,$router);
	$stmt->execute();
	$stmt->close();
}

if (PHP_SAPI != "cli") {
	echo "must run in cli";
	exit;
}

require("web/db.php");

if($argc > 1) 
	if($argv[1]=="-d") 
		$debug = 1;
if($argc > 1 + $debug)
	$router = $argv[$debug + 1];
 else 
	$router="";

if($debug) {
	echo "debug = $debug\n";
	echo "router = $router\n";
}

$count = 0;
while($f = fgets(STDIN)){
	$delimiter = array(" ","\t","\r","\n");
	$replace = str_replace($delimiter, $delimiter[0], $f);
	$r = explode($delimiter[0], $replace);
	$ip = $r[0];
	$mac = process_mac($r[1]);
	if($debug) echo $ip."/".$mac."\n";
	update_ip_mac($router, $ip, $mac);
	$count = $count +1;
}

echo "updated $count ip, new ip $ip_new, old ip $ip_old\n";
?>
