<?php

/**
 * 
 * la fonction load_json_file permet de charger le bon fichier JSON,
 * si la variable load est égale à true le fichier distant sera chargé
 * si la dernière mise à jour est plus vieille que du nombre de seconde contenues dans la variable time,
 * sinon le fichier mis à jour lors de la dernière mise à jour sera chargé
 * 
 * @param bool $loader cette variable définit quel fichier est chargé,
 * @param int $time cette variable initialise le temps entre chaque réactualisation du fichier JSON.
 * @return array $json la fonction retourne un tableau associatif avec les données du fichier json
 */


function load_json_file($loader, $time)
{
    if ($loader) {
        if (file_exists("../direct_airport_status.json")) {
            $json = json_decode(file_get_contents("../direct_airport_status.json"), true);
            if ($json !== null) {
                $update_time_parts = explode("T", $json["updatedAt"]);
                $update_date = $update_time_parts[0];
                $update_time = substr($update_time_parts[1], 0, 5);
                $update_time = strtotime("$update_date $update_time");
            }
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

/**
 * la fonction find_airport parcourt la variable json 
 * à la recherche de l'aéroport que l'utilisateur a saisi.
 * 
 * @param string $airport_code cette variable contient la saisie de l'utilisateur.
 * @param array $json variable renvoyer par la fonction load_son_file.
 * @return array la fonction retourne un tableau contenant les informaton suivantes : l'index de la station retenu pour l'affichage de l'atis, l'index de la toure de l'aéroport, l'index de l'aproche de l'aéroport, l'index du sol de l'aéroport, le code de l'aéroport suivi des sufix "_TWR" "_APP", "_GND"
 */


function find_airport($airport_code, $json)
{
    $airport_to_find_TWR = strtoupper(trim($airport_code)) . "_TWR";
    $airport_to_find_APP = strtoupper(trim($airport_code)) . "_APP";
    $airport_to_find_GND = strtoupper(trim($airport_code)) . "_GND";
    $airport_index_TWR = null;
    $airport_index_APP = null;
    $airport_index_GND = null;

    foreach ($json["clients"]["atcs"] as $index => $current_airport) {
        if (is_int(strpos($current_airport["callsign"], $airport_to_find_TWR))) {
            $airport_index_TWR = $index;
            break;
        }

        if (is_int(strpos($current_airport["callsign"], $airport_to_find_APP)) && $airport_index_TWR === null) {
            $airport_index_APP = $index;
        }
        if (is_int(strpos($current_airport["callsign"], $airport_to_find_GND)) && $airport_index_TWR === null) {
            $airport_index_GND = $index;
        }
    }

    if ($airport_index_TWR !== null) {
        $airport_index = $airport_index_TWR;
    } else if ($airport_index_APP !== null) {
        $airport_index = $airport_index_APP;
    } else if ($airport_index_GND !== null) {
        $airport_index = $airport_index_GND;
    }
    return array("airport_index" => $airport_index ,"TWR_index" => $airport_index_TWR , "APP_index" => $airport_index_APP , "GND_index" => $airport_index_GND , "airport_to_find_TWR" => $airport_to_find_TWR , "airport_to_find_APP" => $airport_to_find_APP , "airport_to_find_GND" => $airport_to_find_GND);
}

/**
 * la fonction status renvoi le texte à afficher à côté du formulaire,
 * si l'aéroport est en ligne le texte connecté doit être afficher et sinon le texte déconnecté doit être afficher.
 * @param bool $isoneline cette variable est renvoyer par la fonction isoneline.
 * @param array $json 
 * @return string elle retourne le texte à afficher à côté du formulaire
 */


function status($oneline, $json)
{
    if ($json !== null) {
        if ($oneline) {
            return "<span class='online'>Connecté</span>";
        } else {
            return "<span class='offline'>Déconnecté</span>";
        }
    } else {
        return "<span class='offline'>Erreur lors du chargement des données  </span>";
    }
}


/**
 * la fonction isonline vérifit si l'index des différantes station de l'aéroport est définit ou si il est à null.
 * @param int @param null airport_index
 * @return array la fonction retourne un tableau avec le statut des station de l'aéroport, true si elle est en ligne et false si la station est hors ligne.
 */


function isonline($airport_station_index)
 {
     $airport_station_status = array();
     foreach ($airport_station_index as $index => $airport_index) {
         if ($airport_index === null || is_int($airport_index)) {
             if ($airport_index !== null) {
                 $status = true;
             } else {
                 $status = false;
             }
             $airport_station_status["status_".substr($index, 0, 3)] = $status;
         } else {
             break;
         }
     }
     return $airport_station_status;
 }


/**
 * la fonction display_info inclut le fichier ou sont contenu les informations de l'aéroport courant.
 * @param int $airport_index
 * @param bool $oneline la fonction ne s'exécute que si $online est égale à true.
 * @param array $json
 * @param string $update_hour_airport L'heure de mise à jour de l'aéroport sera affichée à l'utilisateur.
 * @param array $airport_stations_index la fonction prand en paramaitre le tableau contenant l'index des station de l'aéroport et le nom de l'aéroport avec les sufix des différantes station
 * @param array $airport_stations_status la fonction prand en paramaitre le tableau contenant le status des station de l'aéroport
 * @return string la fonction retourne les informations à afficher sous la forme d'un code html
 */


function display_info($airport_index, $oneline, $json, $update_hour_airport, $airport_station_index, $airport_station_status)
{
    if ($oneline) {
        ob_start();
        require "../info.php";
        return ob_get_clean();
    } else {
        return;
    }
}

/**
 * la fonction getUpdateHour permet de récupérer l'heure de mise à jour du fichier json afin de l'afficher sur la page.
 * @param array $json
 * @return string la fonction retourne l’heure de mise à jour du fichier json.
 */


function getUpdateHour($json)
{
    if ($json !== null) {
        $updatedat = $json["updatedAt"];
        $data = explode("T", $updatedat)[1];
        $hour_minute = explode(":", $data);
        $hour = $hour_minute[0];
        $minute = $hour_minute[1];

        $update_hour = $hour . ":" . $minute . " UTC";
        return $update_hour;
    } else {
        return "Not found.";
    }
}

/**
 * la fonction get_update_hour_airport parcoure la totalité des éléments de l'atis de l'aéroport renseigner dans la variable $airport_index et recherche le paterne "recorded at" dans le tableau.
 * @param array $json
 * @param int $airport_index
 * @param bool $oneline
 * @return string la fonction retourne l’heure de mise à jour de l'atis correspondant à l'aéroport.
 */


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
