<?php
require_once('start.php');

// OID for VLAN names
$vlan_names_oid = '1.3.6.1.2.1.17.7.1.4.3.1.1';

// OID for VLAN IDs
$vlan_ids_oid = '1.3.6.1.2.1.17.7.1.4.2.1.3';

// OID for VLAN IP addresses
/// Get VLAN names, IDs, and IP addresses
$vlan_names = $session->walk($vlan_names_oid);
$vlan_ids = $session->walk($vlan_ids_oid);

// Display VLAN table

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
        <button class="btn btn-primary" id="myBtn">Loo vlan</button>

        <!-- Модальном окно -->
        <div id="myModal" class="modal">
        <!-- Модальное содержание -->
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h2>Vlani kiire loomine ja seadistamine</h2>
                </div>
                <div class="modal-body">
                    <form action="data.php" method="POST">
                        <div class="mb-3">
                            <label for="vlan" class="form-label">Vlan-nimi</label>
                            <input type="text" name="vlan"  class="form-control" id="vlan1">
                        </div>
                        <div class="mb-3">
                            <label for="tag" class="form-label">Tag</label>
                            <input type="number" name="tag" class="form-control" id="tag1">
                        </div>
                        <div class="mb-3">
                            <label for="ip" class="form-label">IP-aadress ja mask</label>
                            <input type="text" name="ip" class="form-control" id="ip1">
                            <input type="number" name="mask" class="form-control" id="mask1">
                        </div>
                        <div class="mb-3">
                            <label for="ip" class="form-label">pordi number</label>
                            <input type="text" name="port" class="form-control" id="port1">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>

        <script>
            var modal = document.getElementById("myModal");

            var btn = document.getElementById("myBtn");

            var span = document.getElementsByClassName("close")[0];

            btn.onclick = function() {
            modal.style.display = "block";
            }

            span.onclick = function() {
            modal.style.display = "none";
            }

            window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
                }
            }
        </script>
        <?php
            echo '<table><tr><th>VLAN ID</th><th>Name</th></tr>';
            foreach ($vlan_names as $oid => $name) {
                $vlan_id = substr($oid, strrpos($oid, '.') + 1);
                if (isset($vlan_ids['1.3.6.1.2.1.17.7.1.4.2.1.3.' . $vlan_id])) {
                   
                }
                echo '<tr><td>' . $vlan_id . '</td><td>' . $name . '</tr>';
            }
            echo '</table>';        
        ?>
        <form method="POST" action="data.php">
            <input type="text" id="vlan_id2" name="vlan_id2">
            <button  class="btn btn-primary" type="submit">Remove VLAN</button>
        </form>

    </body>

</html>
<?php

if (isset($_POST['vlan_id2'])){
    
    json2($vlan_id2 = $_POST['vlan_id2']);
}

function json2($vlan_id2){
    //JSON
    $contents2 = file_get_contents("C:\Users\POPOV\Desktop\This_is_for_my_practice-main\python\deletevlan.json");


    //Decode the JSON data into a PHP array.
    $contentsDecoded2 = json_decode($contents2, true);

    //Modify the counter variable.
    $contentsDecoded2 = array(
        'id' => $vlan_id2,

    );

    $jsonData2 = json_encode($contentsDecoded2);


    file_put_contents("C:\Users\POPOV\Desktop\This_is_for_my_practice-main\python\deletevlan.json", $jsonData2);
    
    $output2 = shell_exec("python DeleteVlan.py");
    echo 'VLAN '.$vlan_id2.' removed successfully';
    
    

}



// Display success message



if (isset($_POST['vlan']) && isset($_POST['tag']) && isset($_POST['ip'])  && isset($_POST['mask']) && isset($_POST['port'])){
    
    json($vlan = $_POST['vlan'],$tag = $_POST['tag'], $ip = $_POST['ip'], $mask = $_POST['mask'], $port = $_POST['port']);
}
function json($vlan, $tag, $ip, $mask, $port){
    //JSON
    $contents = file_get_contents("C:\Users\POPOV\Desktop\This_is_for_my_practice-main\python\data.json");


    //Decode the JSON data into a PHP array.
    $contentsDecoded = json_decode($contents, true);

    //Modify the counter variable.
    $contentsDecoded = array(
        'vlan' => $vlan,
        'tag' => $tag,
        'ip' => $ip,   
        'mask' => $mask,
        'port' => $port
    );

    $jsonData = json_encode($contentsDecoded);


    file_put_contents("C:\Users\POPOV\Desktop\This_is_for_my_practice-main\python\data.json", $jsonData);
    
    $output = shell_exec("python VlanCreate.py ");
    
    
    
    echo 'Data added successfully!';
}
// Закрываем snmpv3 сессию
$session->close();

?>