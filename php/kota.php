<?php
$term = $_GET["term"];
$asal = json_decode(file_get_contents("kota.json"), true);
$result = array();
foreach ($asal as $company) {
    $companyLabel = $company["label"];
    if (strpos(strtoupper($companyLabel), strtoupper($term)) !== false) {
        array_push($result, $company);
    }
}
echo json_encode($result);
