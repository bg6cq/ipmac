<?php

$debug = 0;

$ipv4 = 0;
$ipv6 = 1;
$mac_new = 0;
$mac_old = 0;

function update_mac_port($mac, $jhjip, $port, $vlan) 
{
	global $mysqli;
	global $debug, $mac_new, $mac_old;
	$q = "select MAC from MACPort where MAC=? and JHJIP=? and Port=? and Vlan=? and Lastsee>date_sub(now(),INTERVAL 10 day) limit 1";
	if($debug) echo $q."\n";
	$stmt=$mysqli->prepare($q);
	$stmt->bind_param("ssss",$mac,$jhjip,$port,$vlan);
	$stmt->execute();
	$stmt->bind_result($oldmac);
	$stmt->store_result();
	if($stmt->fetch()) {
		$mac_old ++;
                $q = "update MACPort set Lastsee=now() where MAC=? and JHJIP=? and Port=? and Vlan=? and Lastsee>date_sub(now(),INTERVAL 10 day)";
	} else {
		$mac_new ++;
                $q = "insert into MACPort (MAC,JHJIP,Port,Vlan,FirstSee,LastSee) values(?,?,?,?,now(),now())";
	}
	$stmt->close();
	if($debug) echo $q."\n";
	$stmt=$mysqli->prepare($q);
	$stmt->bind_param("ssss",$mac,$jhjip,$port,$vlan);
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
	$jhjip = $argv[$debug + 1];
 else 
	$jhjip="";

if($debug) {
	echo "debug = $debug\n";
	echo "jhjip = $jhjip\n";
}

$uplinkports = array ();
$q = "select Port from UplinkPort where JHJIP = ?";
if($debug) echo $q."\n";
$stmt=$mysqli->prepare($q);
$stmt->bind_param("s",$jhjip);
$stmt->execute();
$stmt->bind_result($port);
$stmt->store_result();
while($stmt->fetch()) {
	echo $port."\n";
	$uplinkports[] =  $port;
}
$stmt->close();
if($debug) {
	echo "uplinkports: ";
	var_dump($uplinkports);
	echo "\n";
}

$count = 0;
while($f = fgets(STDIN)){
	$delimiter = array(" ","\t","\r","\n");
	$replace = str_replace($delimiter, $delimiter[0], $f);
	$r = explode($delimiter[0], $replace);
	$mac = process_mac($r[0]);
	$vlan = $r[1];
	$port = $r[2];

	if($debug) echo $mac."/".$vlan."/".$port;
	if(in_array($port, $uplinkports)) {
		if($debug) echo ", ".$port." is uplinkport, skip\n";
		continue;
	} else 
		if($debug) echo "\n";
	update_mac_port($mac, $jhjip, $port, $vlan);
	$count = $count + 1;
}

echo "update $count mac, ";
echo "new $mac_new, old $mac_old\n";
?>
