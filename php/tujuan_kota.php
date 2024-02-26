<?php
$term = $_GET["term"];
$asal = json_decode(file_get_contents("tujuan_kota.json"), true);
$result = array();
foreach ($asal as $company) {
    $companyLabel = $company["label"];
    if (strpos(strtoupper($companyLabel), strtoupper($term)) !== false) {
        array_push($result, $company);
    }
}
echo json_encode($result);
