<?php
require "../function.php";

$airport_to_find = "";
if (isset($_GET["debug"])) {
    $api_file = !filter_var($_GET["debug"], 258);
} else {
    $api_file = true;
}
$json = load_json_file($api_file, 300);
if (isset($_POST["airport_name"])) {
    
    $airport_code = $_POST["airport_name"];
    $airport_index = find_airport($airport_code, $json);
    $airport_status = status($airport_index);
    $oneline = isonline($airport_index);
    $update_hour_airport = get_update_hour_airport($json, $airport_index, $oneline);

    $info = display_info($airport_index, $oneline, $json, $update_hour_airport);
}
$update_hour = getUpdateHour($json);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live airport flightsim</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <form method="post" action="">
        <table class="formulaire">
            <tr>
                <td>
                    <input type="text" id="airport_name" name="airport_name" placeholder="Rechercher un aéroport" value="<?php echo $airport_to_find; ?>">
                </td>
                <td>
                    <button type="submit" class="send"><img src="./image/send.png" class="send" alt="Envoyer"></button>
                </td>
                <td>
                    <img src="./image/info.png" alt="bouton d'information" class="img_information" title="Taper le code ICAO de l'aéroport">
                </td>
                <td>
                    <?php echo isset($airport_status) ? $airport_status : ""; ?>
                </td>
                <td class="update">
                    Heure de M.A.J des donnée : <?php echo $api_file === false ? "    <a href='localhost/live_airport_flightsim/app/public/index.php?debug=false' title='désactiver le mode debug'><span class='debug'>DEBUG</span></a>" : $update_hour ?>
                </td>
            </tr>
        </table>
    </form>
    <?php echo isset($info) ? $info : ""; ?>
    <a href="localhost/live_airport_flightsim/app/public/index.php?debug=false" title="désactiver le mode debug"></a><span class='debug'>DEBUG</span>
</body>

</html>