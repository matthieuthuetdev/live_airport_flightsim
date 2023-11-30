<?php
extract($airport_station_index);
$information = $json["clients"]["atcs"][$airport_index]["atis"]["revision"];
$airport_name = $json["clients"]["atcs"][$airport_index]["atis"]["lines"][1];
$airport_code = $json["clients"]["atcs"][$airport_index]["callsign"];
$atis = $json["clients"]["atcs"][$airport_index]["atis"]["lines"];

if ($TWR_index !== null) {
    $airport_name_TWR = $json["clients"]["atcs"][$TWR_index]["atis"]["lines"][1];
    $airport_connection_time_TWR = gmdate("h:i:s",$json["clients"]["atcs"][$TWR_index]["time"]);
}
if ($APP_index !== null) {
    $airport_name_APP = $json["clients"]["atcs"][$APP_index]["atis"]["lines"][1];
    $airport_connection_time_APP = gmdate("h:i:s",$json["clients"]["atcs"][$APP_index]["time"]);
}
if ($GND_index !== null) {
    $airport_name_GND = $json["clients"]["atcs"][$GND_index]["atis"]["lines"][1];
    $airport_connection_time_GND = gmdate("h:i:s",$json["clients"]["atcs"][$GND_index]["time"]);
}
?>
<p>
<table class="info big_screan">
    <tr>
        <th class="info">Code ICAO</th>
        <th class="info">Nom</th>
        <th class="info">Statut</th>
        <th class="info">Temps de connexion</th>
    </tr>
    <tr>
        <td class="info"><?php echo $airport_station_index["airport_to_find_TWR"] ?></td>
        <td class="info"><?php echo isset($airport_name_TWR) ? $airport_name_TWR : "" ?></td>
        <td class="info"><?php echo ($oneline_TWR == true) ? "<span class='online_station'>Connecté</span>" : "<span class='offline_station'>Déconnecté</span>" ?></td>
        <td class="info"><?php echo isset($airport_connection_time_TWR) ? $airport_connection_time_TWR : "" ?></td>
    </tr>
    <tr>
        <td class="info"><?php echo $airport_station_index["airport_to_find_APP"] ?></td>
        <td class="info"><?php echo isset($airport_name_APP) ? $airport_name_APP : "" ?></td>
        <td class="info"><?php echo ($oneline_APP == true) ? "<span class='online_station'>Connecté</span>" : "<span class='offline_station'>Déconnecté</span>" ?></td>
        <td class="info"><?php echo isset($airport_connection_time_APP) ? $airport_connection_time_APP : "" ?></td>
    </tr>
    <tr>
        <td class="info"><?php echo $airport_station_index["airport_to_find_GND"] ?></td>
        <td class="info"><?php echo isset($airport_name_GND) ? $airport_name_GND : "" ?></td>
        <td class="info"><?php echo ($oneline_GND == true) ? "<span class='online_station'>Connecté</span>" : "<span class='offline_station'>Déconnecté</span>" ?></td>
        <td class="info"><?php echo isset($airport_connection_time_GND) ? $airport_connection_time_GND : "" ?></td>
    </tr>
</table>
</p>
<p>
<table class="info small_screan">
    <tr>
        <th class="info">Code ICAO</td>
        <td class="info"><?php echo $airport_code; ?></td>
    </tr>
    <tr>
        <th class="info">Nom</td>
        <td class="info"><?php echo $airport_name; ?></td>
    </tr>
    <tr>
        <th class="info">Information</td>
        <td class="info"><?php echo $information; ?></td>
    </tr>
    <tr>
        <th class="info">Heure de mise à jour de l'ATIS</td>
        <td class="info"><?php echo $update_hour_airport . " UTC"; ?></td>
    </tr>
</table>

</p>
<table class="info atis">
    <tr>
        <td class="atis">A<br>T<br>I<br>S</td>
        <td>
            <ul>
                <?php foreach ($atis as $atis_index) : ?>

                    <?php if (strpos($atis_index, "worldserver.ts.ivao.aero/") === false) : ?>
                        <li><?= $atis_index ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </td>
        <td class="revision"><?php echo $information ?></td>
    </tr>
</table>
</p>