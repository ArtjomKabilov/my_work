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


// Создвем сессию snmpv3
$session = new SNMP(SNMP::VERSION_3, $ip_address, $username, $timeout, $retries);
$session->setSecurity('authPriv', $auth_protocol, $auth_password, $priv_protocol, $priv_password, 'aeeeff');

?>