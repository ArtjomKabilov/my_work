
<?php
require_once('start.php');

$switchStatusOID = '1.3.6.1.2.1.1.1.0';
$status = $session->get($switchStatusOID,  error_reporting(0));
if ($session->getError()) {
    error_reporting(0);
    echo '<marquee direction="left" bgcolor="red" scrollamount="17"><div class="helpme"><h1>Kahjuks pole lüliti võrguga ühendatud, te ei näe teavet</h1></div></marquee>';
  } else {
    // Process switch status
    if ($status == 'Down') {
        
        echo 'Kahjuks pole lüliti võrguga ühendatud, te ei näe teavet';
    } else {
      

    }
}
$oid = "1.3.6.1.4.1.1916.1.1.1.34.1.10.3";

$vvv = $session->get($oid);
print_r($vvv);
$list = [];

for ($portcount = 1001; $portcount < 1029; $portcount++){
    $port = "1.3.6.1.4.1.1916.1.4.11.1.1.$portcount";
    array_push($list, $port);
}

$value = $session->get($list);

$numberCount = [];

foreach ($value as $key=>$values) {
    array_push($numberCount, explode(" ", $value[$key]));
}

$numbers = [];
echo "<pre>";
foreach ($numberCount as $key=>$values) {
    array_push($numbers, $values[1]);
}
echo "</pre>";

/*echo "<pre>";
print_r($numbers);
echo "</pre>";*/

$counter = 28;
function showPorts($numberList, $index) {
    if ($numberList[$index] > $index) {
        echo "<th style='background-color: red'>" . $index + 1 . "</th>";
    } else {
        echo "<th style='background-color: green'>" . $index + 1 . "</th>";
    }     
}

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
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled">Disabled</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <h2>Kommunikaatori pordi ühenduse olek</h2>
        <table style="width:100%">
                            <tr>
                                <?php                    
                                    for ($index = 0; $index < 28 ; $index++){
                                        if ($index % 2 == 0) {
                                            showPorts($numbers, $index);
                                        }
                                    }                 
                                ?>
                            </tr>
                            <tr>
                                <?php 
                                    for ($index = 0; $index < 28 ; $index++){ 
                                        if ($index % 2 != 0) { 
                                            showPorts($numbers, $index);
                                        }
                                    }              
                                ?>
                            </tr>
                        </table>
        
        <style>     
            .helpme{
                font-weight: bold;
                padding: 2px;
            }
        </style>
        
        
    </body>

</html>
<?php



// Закрываем snmpv3 сессию
$session->close();

?>
