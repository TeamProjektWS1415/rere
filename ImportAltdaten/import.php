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
$CSV_DELIMITER = "^";
$PID = 1; //PID of rere Extension

//ModulImport Configuration
$MODULNUMMER = 0; //Modulnummer for every imported Modul
$FACH = 1; //Value for Fach
$GUELTIGKEITSZEITRAUM = "WS14/15";

//SubjectImport Configuration
$NOTENSYSTEM_BEI_KLAUSUR = "hochschulsystem"; //Alternatives: "15pktsystem" or "schulsystem"
$PRÜFER = "Johner";
//Prüfling Configuration
$FEUserIDforMatrikelnummer = "true";
$MATRIKELNUMMER = 101010;//Value for every created Prüfling, only if $FEUserIDforMatrikelnummer != "true"
// ** </CONFIGURATION> **


// ** Init Database and CSV-Files **
$configOkay = true;
$db = mysqli_connect($DB_URL, $DB_USERNAME, $DB_PASSWORD,$DB_NAME);
if(!$db){
  echo("<br>Connection Error: ".mysqli_connect_error());
  $configOkay = false;
}
mysql_set_charset('utf8', $db);
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


// ** Import Modules ** /
for ($i = 0; $i < count($modules_Array); $i=$i+8){
	$sql = "INSERT INTO tx_rere_domain_model_modul (pid, modulnr, modulname, gueltigkeitszeitraum, fach, tstamp, crdate, cruser_id, deleted, hidden) VALUES (".$PID.",".$MODULNUMMER.",".$modules_Array[$i+7].",'".$GUELTIGKEITSZEITRAUM."',".$FACH.",".$modules_Array[$i+2]. ",".$modules_Array[$i+3].",".$modules_Array[$i+4].",".$modules_Array[$i+5].",".$modules_Array[$i+6]." )";		
	if (!mysqli_query($db, $sql)) {
		echo "<br>Error: " . $sql . "<br>" . mysqli_error($db);   
		exit();
		}	
}
echo "Module completed</br>";

// ** Import Subjects **
for ($i = 0; $i < count($subjects_Array); $i=$i+9){
	$subjectUID = $subjects_Array[$i];
	$fachname = $subjects_Array[$i+7];
	$fachcode = $subjects_Array[$i+8];
	//search related entry in addministration table 	
	$subjectUID_FK = -1;
	$linePointer = 0;
	for ( ;$linePointer < count($administrations_Array); $linePointer=$linePointer+15){
		$subjectUID_FK = $administrations_Array[$linePointer+8];
		if($subjectUID_FK == $subjectUID){
			break;
		}
	}
	if($subjectUID_FK == -1){
		echo "Error: Subject without ForeignKey in administration table";
		exit();	
	}
	//search ModulUID in new db for reference 
	$modulUIDforSubject_old = $administrations_Array[$linePointer+7];
	$modulNameforSubject = -1;
	for($k = 0; $k < count($modules_Array); $k=$k+8){
		if($modules_Array[$k]== $modulUIDforSubject_old){
			$modulNameforSubject = $modules_Array[$k+7];
		}
	}	
	if($modulNameforSubject == -1){
		echo "Error: no modul with UID: " . $modulUIDforSubject_old . "in CSV";
	}
	$sqlQuery = "SELECT uid FROM tx_rere_domain_model_modul where modulname=".$modulNameforSubject."";
	$result  = mysqli_query($db, $sqlQuery);
	if($result->num_rows > 1){
		echo "Error: Same modul UID twice for subject: ". $modulNameforSubject;
		exit();	
	}
	$row = $result->fetch_assoc();
	$modulUIDforSubject_new=$row["uid"];
	//Look for Notenschema for Subject
	$gradeType_old = $administrations_Array[$linePointer+13];
	if($gradeType_old == "'K'"){
		$gradeType_new = $NOTENSYSTEM_BEI_KLAUSUR;
	}
	elseif($gradeType_old == "'S'"){
		$gradeType_new = "unbenotet";
	}
	else{
		echo"invalid Subject Grade Type " . $gradeType_old; 
		exit();
	}
	
	//Count number of grades for subject for column 'note'
	$counterNote = 0;
	for ($j = 0; $j < count($grades_Array); $j=$j+11){
		$configID = $grades_Array[$j+10];
		for($l = 0; $l < count($administrations_Array); $l=$l+15){
			if($subjectUID == $administrations_Array[$l+8]){
						$counterNote++;
			}
		}
	}
	$klausurZeitpunkt=0;	
	/*$klausurZeitpunktUnixTime = $administrations_Array[$linePointer+14];
		if($klausurZeitpunktUnixTime > 0 ){
			$klausurZeitpunkt = date("d.M.Y",$klausurZeitpunktUnixTime);		
		}*/
	$sql = "INSERT INTO tx_rere_domain_model_fach (pid, fachnr, fachname, pruefer, notenschema, modulnr, note, tstamp, crdate, cruser_id, deleted, hidden, matrikelnr, datum, creditpoints) VALUES (".$PID.",".$fachcode.",".$fachname.",'".$PRÜFER."','".$gradeType_new."',".$modulUIDforSubject_new.",".$counterNote.",".$subjects_Array[$i+2].",".$subjects_Array[$i+3].",".$subjects_Array[$i+4].",".$subjects_Array[$i+5].",".$subjects_Array[$i+6].",".$counterNote.",'".$klausurZeitpunkt."',".$administrations_Array[$linePointer+9].")";
	if (!mysqli_query($db, $sql)) {
			echo "<br>Error: " . $sql . "<br>" . mysqli_error($db); 
			exit();  
		} 
}
echo "Subjects completed</br>";

//** import/create Prueflinge
for ($i = 0; $i < count($grades_Array); $i=$i+11){
	$feUserUID=$grades_Array[$i+7];
	$sqlQuery = "SELECT typo3_f_e_user FROM tx_rere_domain_model_pruefling where typo3_f_e_user=".$feUserUID;
	$result  = mysqli_query($db, $sqlQuery);
	if($result->num_rows > 0){
		continue;
	}
	$sqlQuery = "SELECT first_name, last_name FROM fe_users where uid=".$feUserUID."";
	$result  = mysqli_query($db, $sqlQuery);
	if($result->num_rows > 1){
		echo "Error: Same modul UID twice ";
		exit();	
	}
	if($result->num_rows < 1){
		echo "Error: FE User with UID ".$feUserUID ." is missing.";
		exit();	
	}
	$row = $result->fetch_assoc();
	$firstName = $row['first_name'];
	$lastName = $row['last_name'];
	//Count number of grades for Pruefling for column 'note'
	$counterNote = 0;
	for ($j = 0; $j < count($grades_Array); $j=$j+11){
		if($feUserUID == $grades_Array[$j+7]){
			$counterNote++;
		}
	}	
	if($FEUserIDforMatrikelnummer == "true"){
		$MATRIKELNUMMER = $feUserUID;
	}
	$sql = "INSERT INTO tx_rere_domain_model_pruefling (pid, matrikelnr, vorname, nachname, typo3_f_e_user, note) VALUES (".$PID.",".$MATRIKELNUMMER.",'".$firstName."','".$lastName."',".$feUserUID.",".$counterNote.")";
	
	if (!mysqli_query($db, $sql)) {
				echo "<br>Error: " . $sql . "<br>" . mysqli_error($db); 
				exit();  
	}	
}
echo "Create Prüflinge completed </br>";

//** import Grades
for ($i = 0; $i < count($grades_Array); $i=$i+11){
	$KOMMENTAR = $grades_Array[$i+9];
	$feUserUID = $grades_Array[$i+7];
	//look for Pruefling
	$sqlQuery = "SELECT uid FROM tx_rere_domain_model_pruefling where typo3_f_e_user=".$feUserUID;
	$result  = mysqli_query($db, $sqlQuery);
	if($result->num_rows == 0){
		echo "Error: no FE-User for grade with UID: ".$grades_Array[$i];
		exit();	
	}
	if($result->num_rows > 1){
			echo "More than one pruefling entry for FE-User ".$feUserUID;
			exit();	
	}
	$row = $result->fetch_assoc();
	$prueflingUID = $row['uid'];
	//*look for fach
	//	look for old UID of Subject
	$subject_configUid = $grades_Array[$i+10];
	for($l = 0; $l < count($administrations_Array); $l=$l+15){
		if($subject_configUid == "'".$administrations_Array[$l]."'"){
			$subjectUID = $administrations_Array[$l+8];	
			break;			
		}
	}
	//	look for new UID
	for ($k = 0; $k < count($subjects_Array); $k=$k+9){
		if($subjectUID == $subjects_Array[$k]){
			$fachname= $subjects_Array[$k+7];
		}
	}
	$sqlQuery = "SELECT uid FROM tx_rere_domain_model_fach where fachname=".$fachname."";
	$result  = mysqli_query($db, $sqlQuery);
	if($result->num_rows > 1){
		echo "Error: double entry with fachname: " .$fachname;
		exit();	
	}
	if($result->num_rows == 0){
			echo "No fach with ".$fachname;
			exit();	
	}
	$row = $result->fetch_assoc();
	$fachUID = $row['uid'];
	
	//adjustment note/grade
	$NOTE = $grades_Array[$i+8];
	if($NOTE == "'bestanden'"){
		$NOTE = "'be'";
	}
	if($NOTE == "'nicht bestanden'"){
		$NOTE = "'N'";
	}
	if($NOTE == "'1'"){
		$NOTE = "1.0";
	}
	if($NOTE == "'2'"){
		$NOTE = "2.0";
	}
	if($NOTE == "'3'"){
		$NOTE = "3.0";
	}
	if($NOTE == "'4'"){
		$NOTE = "4.0";
	}
	if($NOTE == "'5'"){
		$NOTE = "5.0";
	}
	
	$sql = "INSERT INTO tx_rere_domain_model_note (pid, fach, pruefling, wert, kommentar, tstamp, crdate, cruser_id, deleted, hidden ) VALUES(".$PID.",".$fachUID.",".$prueflingUID."," .$NOTE.",".$KOMMENTAR.",".$grades_Array[$i+2].",".$grades_Array[$i+3].",".$grades_Array[$i+4].",".$grades_Array[$i+5].",".$grades_Array[$i+6].")";
	if (!mysqli_query($db, $sql)) {
			echo "<br>Error: " . $sql . "<br>" . mysqli_error($db); 
			exit();  
		} 
} 
echo "Grades completed </br>";

?>