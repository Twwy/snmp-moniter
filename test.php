<?php

//61.175.163.196 windows
//61.175.132.172 windows
//110.76.43.117 linux
$ip = '110.76.43.117';
$ip2 = '61.175.132.172';
//$ip = '61.175.163.196';

//$info = '1.3.6.1.4.1.2021.4';
//$info = '1.3.6.1.2.1.25.2';
//$info = '1.3.6.1.2.1.25.2.1.2';
//$info = '1.3.6.1.2.1.25.3.3.1.2';
$info = '1.3.6.1.4.1.2021.11';

//$info = 'HOST-RESOURCES-MIB::hrSystemDate.0';

$a = snmprealwalk($ip, "public", $info); 
//$a = snmpget($ip, 'public', '1.3.6.1.2.1.1.1.0');
$b = snmprealwalk($ip2, "public", $info);


/*
require('snmp-moniter.php');
$snmp = new snmp_moniter;
$snmp->ip = $ip2;
$a = $b = $snmp->device();
*/

var_dump($a);
echo '<br/><br/>';
var_dump($b);

?>
