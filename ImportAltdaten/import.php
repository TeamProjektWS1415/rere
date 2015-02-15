<?php
// ** <CONFIGURATION> **
//Database 
$DB_URL="localhost";
$DB_USERNAME="root";
$DB_PASSWORD="";	
$DB_NAME="typo3";

//CSV Files Path
$PATH_CSV_ADMINISTRATIONS="./Administrations.csv";
$PATH_CSV_SUBJECTS="./Subjects.csv";
$PATH_CSV_GRADES="./Grades.csv";
$PATH_CSV_MODULES="./Modules.csv";

//General Configuration
$CSV_DELIMITER = ",";
$PID = 1; //PID of rere Extension

//ModulImport Configuration
$MODULNUMMER = 0; //Modulnummer for every imported Modul
$FACH = 1; //Value for Fach
$GUELTIGKEITSZEITRAUM = "WS14/15";
// ** </CONFIGURATION> **


// ** Init Database and CSV-Files **
$configOkay = true;
$db = mysqli_connect($DB_URL, $DB_USERNAME, $DB_PASSWORD,$DB_NAME);
if(!$db){
  echo("<br>Connection Error: ".mysqli_connect_error());
  $configOkay = false;
}
if(!file_exists($PATH_CSV_ADMINISTRATIONS)){
	echo("<br>Administrations.csv not found");
	$configOkay = false;
}
if(!file_exists($PATH_CSV_SUBJECTS)){
	echo("<br>Subjects.csv not found");
	$configOkay = false;
}
if(!file_exists($PATH_CSV_GRADES)){
	echo("<br>Grades.csv not found");
	$configOkay = false;
}
if(!file_exists($PATH_CSV_MODULES)){
	echo("<br>Modules.csv not found");
	$configOkay = false;
}
if(!$configOkay == true){
	exit();
}
//CSV data to StringArray
$STRING_CSV_ADMINISTRATIONS = file_get_contents($PATH_CSV_ADMINISTRATIONS);
$STRING_CSV_SUBJECTS = file_get_contents($PATH_CSV_SUBJECTS);
$STRING_CSV_GRADES = file_get_contents($PATH_CSV_GRADES);
$STRING_CSV_MODULES = file_get_contents($PATH_CSV_MODULES);
$administrations_Array = str_getcsv($STRING_CSV_ADMINISTRATIONS,$CSV_DELIMITER);
$subjects_Array = str_getcsv($STRING_CSV_SUBJECTS,$CSV_DELIMITER);
$grades_Array = str_getcsv($STRING_CSV_GRADES,$CSV_DELIMITER);
$modules_Array = str_getcsv($STRING_CSV_MODULES,$CSV_DELIMITER);

//Trim whole Data
$administrations_Array=array_map('trim', $administrations_Array);
$subjects_Array=array_map('trim', $subjects_Array);
$grades_Array=array_map('trim', $grades_Array);
$modules_Array=array_map('trim', $modules_Array);


// ** Import Modules ** 
for ($i = 0; $i < count($modules_Array); $i=$i+8){
	$sql = "INSERT INTO tx_rere_domain_model_modul (pid, modulnr, modulname, gueltigkeitszeitraum, fach, tstamp, crdate, cruser_id, deleted, hidden) VALUES (".$PID.",".$MODULNUMMER.",".$modules_Array[$i+7].",'".$GUELTIGKEITSZEITRAUM."',".$FACH.",".$modules_Array[$i+2]. ",".$modules_Array[$i+3].",".$modules_Array[$i+4].",".$modules_Array[$i+5].",".$modules_Array[$i+6]." )";		
	if (!mysqli_query($db, $sql)) {
		echo "<br>Error: " . $sql . "<br>" . mysqli_error($db);   
	}	
}
echo "done";
?>