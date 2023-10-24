<?php
function load_json_file($loader)
{
    if ($loader) {
        $file = file_get_contents("https://api.ivao.aero/v2/tracker/whazzup");
    } else {
        $file = file_get_contents("../airport_status.json");
    }
    $json = json_decode($file, true);
    return $json;
}

function find_airport($airport_to_find, $json)
{
    $airport_to_find = $airport_to_find . "_TWR";
    $airport_index = null;

    foreach ($json["clients"]["atcs"] as $index => $current_airport) {
        if (is_int(strpos($current_airport["callsign"], $airport_to_find))) {
            $airport_index = $index;
            break;
        }
    }
    return $airport_index;
}

function status($airport_index)
{
    if ($airport_index !== null) {
        return "<span class='online'>Connecté</span>";
    } else {
        return "<span class='offline'>Déonnecté</span>";
    }
}

function isonline($airport_index)
{
    if ($airport_index !== null) {
        return true;
    } else {
        return false;
    }
}
function display_info($airport_index, $oneline, $json)
{
    if ($oneline === true) {
        ob_start();
        require "../info.php";
        return ob_get_clean();
    } else {
        return;
    }
}
