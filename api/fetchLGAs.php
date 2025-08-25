<?php


header("Content-Type: application/json");

// Load JSON file
$data = json_decode(file_get_contents("nigeria-states-lgas.json"), true);

if (isset($_GET['state'])) {
    $state = strtolower($_GET['state']); // normalize
    if (isset($data[$state])) {
        echo json_encode($data[$state]["lgas"]);
    } else {
        echo json_encode(["error" => "State not found"]);
    }
} else {
    // return list of states
    $states = [];
    foreach ($data as $key => $value) {
        $states[] = ["id" => $key, "name" => $value["name"]];
    }
    echo json_encode($states);
}

