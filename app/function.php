<?php
function load_json_file($loader, $time)
{
    if ($loader) {
        if (file_exists("../direct_airport_status.json")) {
            $json = json_decode(file_get_contents("../direct_airport_status.json"), true);
            $update_time_parts = explode("T", $json["updatedAt"]);
            $update_date = $update_time_parts[0];
            $update_time = substr($update_time_parts[1], 0, 5);
            $update_time = strtotime("$update_date $update_time");
            $current_time = time();

            if ($current_time - $update_time >= $time) {
                unlink("../direct_airport_status.json");
                $file_content = file_get_contents("https://api.ivao.aero/v2/tracker/whazzup");
                file_put_contents("../direct_airport_status.json", $file_content);
            }
        } else {
            $file_content = file_get_contents("https://api.ivao.aero/v2/tracker/whazzup");
            file_put_contents("../direct_airport_status.json", $file_content);
        }

        $file = file_get_contents("../direct_airport_status.json");
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

function status($oneline)
{
    if ($oneline) {
        return "<span class='online'>Connecté</span>";
    } else {
        return "<span class='offline'>Déconnecté</span>";
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

function display_info($airport_index, $oneline, $json, $update_hour_airport)
{
    if ($oneline) {
        ob_start();
        require "../info.php";
        return ob_get_clean();
    } else {
        return;
    }
}

function getUpdateHour($json)
{
    $updatedat = $json["updatedAt"];
    $data = explode("T", $updatedat)[1];
    $hour_minute = explode(":", $data);
    $hour = $hour_minute[0];
    $minute = $hour_minute[1];

    $update_hour = $hour . ":" . $minute." UTC";
    return $update_hour;
}

function get_update_hour_airport($json, $airport_index, $oneline)
{
    if ($oneline) {
        $lines_index = null;

        foreach ($json["clients"]["atcs"][$airport_index]["atis"]["lines"] as $index => $lines) {
            if (is_int(strpos($lines, "recorded at"))) {
                $lines_index = $index;
                break;
            }
        }

        if (!is_null($lines_index)) {
            $update_hour_airport = substr(explode(" at ", $json["clients"]["atcs"][$airport_index]["atis"]["lines"][$lines_index])[1], 0, 2) . ":" . substr(explode(" at ", $json["clients"]["atcs"][$airport_index]["atis"]["lines"][$lines_index])[1], 2, 2);
            return $update_hour_airport;
        }

        return "aucune heure de mise à jour n'a été trouvée";
    } else {
        return "";
    }
}
