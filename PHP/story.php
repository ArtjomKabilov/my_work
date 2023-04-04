<?php
// Вбиваем ip и данные snmpv3
$ip_address = "10.181.2.210";
$username = "snmpuser";
$auth_password = "snmpauthcred";
$auth_protocol = "MD5";
$priv_password = "snmpprivcred";
$priv_protocol = "DES";
$timeout = 300000;
$retries = 5;





// OID constants
define('SYS_DESCR_OID', '1.3.6.1.2.1.1.1.0');
define('IFACE_OID', '1.3.6.1.2.1.2.2');
define('CPU_OID', '1.3.6.1.4.1.1916.1.1.1.6');
define('MEM_OID', '1.3.6.1.4.1.1916.1.1.1.5');
define('POWER_OID', '1.3.6.1.4.1.1916.1.1.1.9');
define('TEMP_OID', '1.3.6.1.4.1.1916.1.1.1.13');
define('FAN_OID', '1.3.6.1.4.1.1916.1.1.1.8');

// Function to query SNMPv3 and return the value of a specified OID
function get_snmp_value($oid) {
    global $ip_address, $username, $auth_password, $auth_protocol, $priv_password, $priv_protocol, $timeout, $retries;
    $session = new SNMP(SNMP::VERSION_3, $ip_address, $username, $timeout, $retries);
    $session->setSecurity('authPriv', $auth_protocol, $auth_password, $priv_protocol, $priv_password, 'aeeeff');
    $value = $session->get($oid);
    $session->close();
    return $value;
}

// Retrieve system description
$sys_descr = get_snmp_value(SYS_DESCR_OID);

// Retrieve interface information
$ifaces = [];
$iface_rows = get_snmp_value(IFACE_OID . '.1');
$num_ifaces = count($iface_rows);
for ($i = 1; $i <= $num_ifaces; $i++) {
    $iface_index = get_snmp_value(IFACE_OID . '.1.' . $i);
    $iface_name = get_snmp_value(IFACE_OID . '.2.' . $i);
    $iface_status = get_snmp_value(IFACE_OID . '.8.' . $i);
    $iface_speed = get_snmp_value(IFACE_OID . '.5.' . $i);
    $ifaces[] = [
        'index' => $iface_index,
        'name' => $iface_name,
        'status' => $iface_status,
        'speed' => $iface_speed
    ];
}

// Retrieve CPU usage
$mem_usage = get_snmp_value(MEM_OID . '.1');

// Retrieve power supply status
$power_status = get_snmp_value(POWER_OID . '.0');

// Retrieve temperature
$temp = get_snmp_value(TEMP_OID . '.0');

// Retrieve fan status
$fan_status = get_snmp_value(FAN_OID . '.0');

// HTML/CSS code for displaying information
?>

<!DOCTYPE html>
<html>
   
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Switch X440 G2</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link href="style.css" rel="stylesheet">
        
  </head>

    <body>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="data.php">Vlan teave</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="story.php">Story</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    <title>Extreme x440 G2 Switch Information</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        tr:hover {background-color:#f5f5f5;}
    </style>
</head>
<body>
<h1>Extreme x440 G2 Switch Information</h1>
<h2>System Description</h2>
<p><?php echo $sys_descr; ?></p>
<h2>Interface Information</h2>
<table>
    <tr>
        <th>Index</th>
        <th>Name</th>
        <th>Status</th>
        <th>Speed</th>
    </tr>
    <?php foreach ($ifaces as $iface): ?>
        <tr>
            <td><?php echo $iface['index']; ?></td>
            <td><?php echo $iface['name']; ?></td>
            <td><?php echo $iface['status']; ?></td>
            <td><?php echo $iface['speed']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<h2>CPU Usage</h2>
<p><?php echo $cpu_usage; ?></p>
<h2>Memory Usage</h2>
<p><?php echo $mem_usage; ?></p>
<h2>Power Supply Status</h2>
<p><?php echo $power_status; ?></p>
<h2>Temperature</h2>
<p><?php echo $temp; ?></p>
<h2>Fan Status</h2>
<p><?php echo $fan_status; ?></p>
</body>
</html>


<?php



// Закрываем snmpv3 сессию
$session->close();

?>
