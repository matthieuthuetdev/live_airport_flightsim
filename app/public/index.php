<?php
require "../function.php";

$airport_to_find = "";
if (isset($_GET["load"])) {
    $api_file = $_GET["load"];
} else {
    $api_file = true;
}


if (isset($_POST["airport_name"])) {
    $json = load_json_file($api_file, 300);
    $airport_code = $_POST["airport_name"];
    $airport_index = find_airport($airport_code, $json);
    $airport_status = status($airport_index);
    $oneline = isonline($airport_index,);
    $info = display_info($airport_index, $oneline, $json);
    $hupdate_hour = getUpdateHour();
}
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
                <td><label for="airport_name">Code de l'aéroport :</label>
                    <input type="text" id="airport_name" name="airport_name" placeholder="Rechercher un aéroport" value="<?php echo $airport_to_find; ?>">
                </td>
                <td>
                    <button type="submit" class="icone"><img src="./image/send.png" class="icone" alt="Envoyer"></button>
                </td>
                <td>
                    <img src="./image/info.png" alt="bouton d'information" class="icone" title="Taper le code ICAO de l'aéroport">
                </td>
                <td>
                    <?php echo isset($airport_status) ? $airport_status : ""; ?>
                </td>
                <td>
                <?php echo isset($update_hour) ? $update_hour : ""; ?>

                </td>
            </tr>
        </table>
    </form>
    <?php echo isset($info) ? $info : ""; ?>
</body>

</html>