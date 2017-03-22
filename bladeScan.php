<?php
$url = $_GET['ip'];
$hostname = snmpwalk($url, "public", "iso.3.6.1.4.1.232.22.2.4.1.1.1.4"); 
$serialNo = snmpwalk($url, "public", "iso.3.6.1.4.1.232.22.2.4.1.1.1.16");
$type = snmpwalk($url, "public", "iso.3.6.1.4.1.232.22.2.4.1.1.1.17");
$vc_type = snmpwalk($url, "public", "iso.3.6.1.4.1.232.22.2.6.1.1.1.6");
$vc_sn = snmpwalk($url, "public", "iso.3.6.1.4.1.232.22.2.6.1.1.1.7");

for ($i = 0; $i <= 15; $i++) {
  $hostname[$i] = trim(substr($hostname[$i],9),'"');
  if ($hostname[$i] == "Unknown") $hostname[$i] = "-----";
}
for ($i = 0; $i <= 15; $i++) {
  $serialNo[$i] = trim(substr($serialNo[$i],9),'"');
  if ($serialNo[$i] == "Unknown") $serialNo[$i] = "-----";
}
for ($i = 0; $i <= 15; $i++) {
  $type[$i] = trim(substr($type[$i],9),'"');
  if ($type[$i] == "Unknown") $type[$i] = "-----";
}
for ($i = 0; $i <= 7; $i++) {
  $vc_type[$i] = trim(substr($vc_type[$i],9),'"');
  if ($vc_type[$i] == "Unknown") $vc_type[$i] = "-----";
}
for ($i = 0; $i <= 7; $i++) {
  $vc_sn[$i] = trim(substr($vc_sn[$i],9),'"');
  if ($vc_sn[$i] == "Unknown") $vc_sn[$i] = "-----";
}

echo '
<html>
<head><title>SCAN - '.$url.'</title></head>
<body>
<center><h1>SNMP scan of '.$url.'</h1></center>
<table align="center" cellpadding="5" border="2" width="800">
<tr bgcolor="#bbb">
<td width="30">Bay</td><td>Hostname</td><td>Serial no.</td><td>Model</td>
</tr>';
for ($i = 0; $i <= 15; $i++) {
    echo '<td>'.($i+1).'</td><td>'.$hostname[$i].'</td><td>'.$serialNo[$i].'</td><td>'.$type[$i].'</td>';
    if ($i < 16) {
        if ($i % 2 == 0) echo '</tr><tr bgcolor="#ddd">';
        else echo '</tr><tr>'; 
    } else {
        echo '</tr></table>';
    }
}


echo '
<table align="center" cellpadding="5" border="2" width="800">
<tr bgcolor="#bbb">
<td width="30">VC</td><td>Type</td><td>Serial no.</td>
</tr>';
for ($i = 0; $i <= 7; $i++) {
    echo '<td>'.($i+1).'</td><td>'.$vc_type[$i].'</td><td>'.$vc_sn[$i].'</td>';
    if ($i < 8) {
        if ($i % 2 == 0) echo '</tr><tr bgcolor="#ddd">';
        else echo '</tr><tr>'; 
    } else {
        echo '</tr></table>';
    }
}
echo '</br>';
echo '</body></html>'; 
?>