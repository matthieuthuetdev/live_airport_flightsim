<?php

function load_json_file($loader, $time)
{
    if ($loader) {
        $logContent = file_get_contents("../log.txt"); // Lire le contenu du fichier de log
        $update_time_unix = strtotime($logContent);
        $current_time = time();

        if ($current_time - $update_time_unix >= $time) {
            if (file_exists("../directe_airport_status.json")) {
                unlink("../directe_airport_status.json");
            }
            $file_content = file_get_contents("https://api.ivao.aero/v2/tracker/whazzup");
            file_put_contents("../directe_airport_status.json", $file_content);
            file_put_contents("../log.txt", date('Y-m-d H:i:s')); // Mettre à jour le fichier de log
            $file = $file_content; // Assigner le contenu du fichier téléchargé
        } else {
            $file = file_get_contents("../airport_status.json");
        }
    } else {
        $file = file_get_contents("../airport_status.json");
    }
    $json = json_decode($file, true);
    return $json;

}

function find_airport($airport_code, $json)
{
    $airport_to_find = strtoupper($airport_code) . "_TWR";
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

