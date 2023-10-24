<?php

$information = $json["clients"]["atcs"][$airport_index]["atis"]["revision"];

$update_hour = substr(explode(" at ", $json["clients"]["atcs"][$airport_index]["atis"]["lines"][2])[1], 0, 2) . ":" . substr(explode(" at ", $json["clients"]["atcs"][$airport_index]["atis"]["lines"][2])[1], 2, 2);

$airport_name = $json["clients"]["atcs"][$airport_index]["atis"]["lines"][1];
$airport_code = $json["clients"]["atcs"][$airport_index]["callsign"];
$atis = $json["clients"]["atcs"][$airport_index]["atis"]["lines"]
?>
<p>
<table class="info">
    <tr>
        <th class="info">Code ICAO</th>
        <th class="info">Nom</th>
        <th class="info">Information</th>
        <th class="info">Heure de mise à jour</th>
    </tr>
    <tr>
        <td class="info"><?php echo $airport_code; ?></td>
        <td class="info"><?php echo $airport_name; ?></td>
        <td class="info"><?php echo $information; ?></td>
        <td class="info"><?php echo $update_hour; ?></td>
    </tr>
</table>
</p>
<p></p>
<table class="info">
    <tr>
        <td class="atis"  >A<br>T<br>I<br>S</td>
        <td>
        <ul>
    <li><?php echo $json["clients"]["atcs"][$airport_index]["atis"]["lines"][2]; ?></li>
    <li><?php echo $json["clients"]["atcs"][$airport_index]["atis"]["lines"][3]; ?></li>
    <li><?php echo $json["clients"]["atcs"][$airport_index]["atis"]["lines"][4]; ?></li>
    <li><?php echo $json["clients"]["atcs"][$airport_index]["atis"]["lines"][5]; ?></li>
    <li><?php echo $json["clients"]["atcs"][$airport_index]["atis"]["lines"][6]; ?></li>
</ul>

        </td>
    </tr>
</table>
</p>