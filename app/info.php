<?php
extract($airport_station_index);
$information = $json["clients"]["atcs"][$airport_index]["atis"]["revision"];
$airport_name = $json["clients"]["atcs"][$airport_index]["atis"]["lines"][1];
$airport_code = $json["clients"]["atcs"][$airport_index]["callsign"];
$atis = $json["clients"]["atcs"][$airport_index]["atis"]["lines"];

if ($TWR_index !== null) {
    $airport_name_TWR = $json["clients"]["atcs"][$TWR_index]["atis"]["lines"][1];
    $airport_connection_time_TWR = gmdate("h:i:s", $json["clients"]["atcs"][$TWR_index]["time"]);
}
if ($APP_index !== null) {
    $airport_name_APP = $json["clients"]["atcs"][$APP_index]["atis"]["lines"][1];
    $airport_connection_time_APP = gmdate("h:i:s", $json["clients"]["atcs"][$APP_index]["time"]);
}
if ($GND_index !== null) {
    $airport_name_GND = $json["clients"]["atcs"][$GND_index]["atis"]["lines"][1];
    $airport_connection_time_GND = gmdate("h:i:s", $json["clients"]["atcs"][$GND_index]["time"]);
}
?>
<p>
<table class="info ">
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

</p>
<table class="info atis big_screan">
    <tr>
        <td class="atis info">A<br>T<br>I<br>S</td>
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
<<table class="info atis small_screan">
    <tr>
        <td class="atis info">A<br>T<br>I<br>S</td>
        <td>
            <ul>
                <?php foreach ($atis as $atis_index) : ?>

                    <?php if (strpos($atis_index, "worldserver.ts.ivao.aero/") === false) : ?>
                        <li><?= $atis_index ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </td>
    </tr>
    <tr>
        <td class="revision"><?php echo $information ?></td>
    </tr>
    </table>