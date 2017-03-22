<?php
$url = $_GET['ip'];
$hostname = snmpwalk($url, "public", "1.3.6.1.4.1.674.10892.5.1.3.1"); 
$serialNo = snmpwalk($url, "public", "1.3.6.1.4.1.674.10892.5.1.3.2");
$os = snmpwalk($url, "public", "1.3.6.1.4.1.674.10892.5.1.3.6");
$cpuIndex = snmpwalk($url, "public", "1.3.6.1.4.1.674.10892.5.4.1100.30.1.26");
$cpuName = snmpwalk($url, "public", "1.3.6.1.4.1.674.10892.5.4.1100.30.1.23");
$memoryIndex = snmpwalk($url, "public", "1.3.6.1.4.1.674.10892.5.4.1100.50.1.26");
$memorySize = snmpwalk($url, "public", "1.3.6.1.4.1.674.10892.5.4.1100.50.1.14");
$hddIndex = snmpwalk($url, "public", "1.3.6.1.4.1.674.10892.5.5.1.20.130.4.1.2");
$hddSize = snmpwalk($url, "public", "1.3.6.1.4.1.674.10892.5.5.1.20.130.4.1.11");
$status = snmpwalk($url, "public", "1.3.6.1.4.1.674.10892.5.2.4");



$hostname[0] = trim(substr($hostname[0],9),'"');
$serialNo[0] = trim(substr($serialNo[0],9),'"');
$os[0] = trim(substr($os[0],9),'"');
$status[0] = trim(substr($status[0],9),'"');

if ($status[0] == "4")  $status[0] = "ON"; 
elseif ($status[0] == "3")  $status[0] = "OFF"; 
elseif ($status[0] == "2")  $status[0] = "UNKNOWN";
elseif ($status[0] == "1")  $status[0] = "OTHER"; 
                                                                    
foreach ($cpuIndex as $i => $val) $cpuIndex[$i] = trim(substr($val,9),'"');
foreach ($memoryIndex as $i => $val) $memoryIndex[$i] = trim(substr($val,9),'"');
foreach ($hddIndex as $i => $val) $hddIndex[$i] = trim(substr($val,9),'"'); 

foreach ($cpuName as $i => $val) $cpuName[$i] = trim(substr($val,9),'"');
foreach ($memorySize as $i => $val) $memorySize[$i] = intval(substr($val,8));
foreach ($hddSize as $i => $val) $hddSize[$i] = intval(substr($val,9));                   


echo '
<html>
<head><title>SCAN - '.$url.'</title></head>
<body>
<center><h1>SNMP scan of '.$url.'</h1></center>
<table align="center" cellpadding="5" border="2">
<tr bgcolor=#ddd>
  <td>Hostname</td>
  <td>'.$hostname[0].'</td>
</tr>
<tr>
  <td>Serial no.</td>
  <td>'.$serialNo[0].'</td>
</tr>
<tr>
  <td>Model</td>
  <td>'.$os[0].'</td>
</tr>';

if ($status[0] != "ON") echo '<tr bgcolor=#f00>';
else echo '<tr bgcolor=#0f0>';

echo '
  <td>Status</td>
  <td>'.$status[0].'</td>
</tr>
<tr>';

foreach ($cpuName as $i => $val) {
    echo '<td>'.$cpuIndex[$i].'</td><td>'.$val.'</td>';
    echo '</tr><tr>';
    };
unset($val);
unset($i);

foreach ($memorySize as $val) $memoryTotal += $val;
echo '<td bgcolor=#ddd>Total memory</td><td bgcolor=#ddd>'.round($memoryTotal/1048576, 2).' GB</td>';
echo '</tr><tr>';
unset($val);
unset($i);



foreach ($memorySize as $i => $val) { 
    echo '<td>'.$memoryIndex[$i].'</td><td>'.round($val/1048576, 2).' GB</td>';
    echo '</tr><tr>';
    };
unset($val);
unset($i);

foreach ($hddSize as $i => $val) {
    echo '<td>'.$hddIndex[$i].'</td><td>'.round($val/1024, 2).' GB</td>';
    echo '</tr><tr>';
    };
unset($val);
unset($i);
echo '</tr>';

echo '</body></html>';  
?>