<?php

$information = $json["clients"]["atcs"][$airport_index]["atis"]["revision"];


$airport_name = $json["clients"]["atcs"][$airport_index]["atis"]["lines"][1];
$airport_code = $json["clients"]["atcs"][$airport_index]["callsign"];
$atis = $json["clients"]["atcs"][$airport_index]["atis"]["lines"];
var_dump($json["clients"]["atcs"][$airport_index]["atis"]["lines"]);
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
        <td class="info"><?php echo $update_hour_airport; ?></td>
    </tr>
</table>
</p>
<p></p>
<table class="info">
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
    </tr>
</table>
</p>
