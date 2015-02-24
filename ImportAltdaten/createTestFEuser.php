<?php

function crossfoot($digits) {
    // Typcast falls Integer uebergeben
    $strDigits = (string) $digits;

    for ($intCrossfoot = $i = 0; $i < strlen($strDigits); $i++) {
        $intCrossfoot += $strDigits{$i};
    }

    return $intCrossfoot;
}

$DB_URL = "localhost";
$DB_USERNAME = "typo3";
$DB_PASSWORD = "";
$DB_NAME = "typo3";
$db = mysqli_connect($DB_URL, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

for ($i = 1; $i < 2000; $i++) {
    $j = crossfoot($i);
    $sql = "INSERT INTO fe_users (first_name, last_name) VALUES (" . $i . "," . $j . ")";
    if (!mysqli_query($db, $sql)) {
        echo "<br>Error: " . $sql . "<br>" . mysqli_error($db);
        exit();
    }
}
?>