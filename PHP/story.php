<?php
require_once('start.php');
$oid = ".1.3.6.1.4.1.1916.1.24.1.1.5";



$switchStatusOID = '1.3.6.1.2.1.1.1.0';
$status = $session->get($switchStatusOID,  );
if ($session->getError()) {
    ;
    echo '<marquee direction="left" bgcolor="red" scrollamount="17"><div class="helpme"><h1>Kahjuks pole lüliti võrguga ühendatud, te ei näe teavet</h1></div></marquee>';
  } else {
    // Process switch status
    if ($status == 'Down') {
        
        echo 'Kahjuks pole lüliti võrguga ühendatud, te ei näe teavet';
    } else {
      

    }
}
$events = $session->walk($oid);

// display the events in an HTML table
echo "<table>";
echo "<tr><th>Event ID</th><th>Event Name</th><th>Event Description</th></tr>";
foreach ($events as $event) {
    // extract the event ID and description from the OID and value
    $event_id = substr($event, strrpos($event, ".") + 1);
    $event_name = snmpget($ip_address, $username, ".1.3.6.1.4.1.1916.1.33.1.4.1.2.$event_id");
    $event_desc = snmpget($ip_address, $username, ".1.3.6.1.4.1.1916.1.33.1.4.1.3.$event_id");

    // display the event information in the HTML table
    echo "<tr><td>$event_id</td><td>$event_name</td><td>$event_desc</td></tr>";
}
echo "</table>";


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

    </body>

</html>
<?php



// Закрываем snmpv3 сессию
$session->close();

?>
