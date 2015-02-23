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

//SubjectImport Configuration
$NOTENSYSTEM_BEI_KLAUSUR = "hochschulsystem"; //Alternatives: "15pktsystem" or "schulsystem"
$PRÜFER = "Johner";
//Prüfling Configuration
$FEUserIDforMatrikelnummer = "true";
$MATRIKELNUMMER = 101010;//Value for every created Prüfling, only if $FEUserIDforMatrikelnummer != "true"
// ** </CONFIGURATION> **


// ** Init Database and CSV-Files **
$configOkay = true;
$db = new mysqli($DB_URL, $DB_USERNAME, $DB_PASSWORD,$DB_NAME);
if(!$db){
  echo("<br>Connection Error: ".mysqli_connect_error());
  $configOkay = false;
}
$db->set_charset("utf8");
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

//compute Semester
function timestampToSemester ($unixTimestamp){
	$SS08 = 1204326000; 
	$SS09 = 1235862000;
	$SS10 = 1267398000;
	$SS11 = 1298934000;
	$SS12 = 1330556400;
	$SS13 = 1362092400;
	$SS14 = 1393628400;
	$SS15 = 1425164400;
	$WS0809 = 1220223600;
	$WS0910 = 1251759600;
	$WS1011 = 1283295600;
	$WS1112 = 1314831600;
	$WS1213 = 1346454000;
	$WS1314 = 1377990000;			
	$WS1415 = 1409526000;
	$GUELTIGKEITSZEITRAUM="WS07/08";
	if($unixTimestamp > $SS08){
		$GUELTIGKEITSZEITRAUM = "SS8";
	}
	if($unixTimestamp >$WS0809){
		$GUELTIGKEITSZEITRAUM="WS08/09";
	}
	if($unixTimestamp >$SS09){
		$GUELTIGKEITSZEITRAUM="SS9";
	}
	if($unixTimestamp >$WS0910){
		$GUELTIGKEITSZEITRAUM="WS09/10";
	}
	if($unixTimestamp >$SS10){
		$GUELTIGKEITSZEITRAUM="SS10";
	}
	if($unixTimestamp >$WS1011){
		$GUELTIGKEITSZEITRAUM="WS10/11";
	}
	if($unixTimestamp >$SS11){
		$GUELTIGKEITSZEITRAUM="SS11";
	}
	if($unixTimestamp >$WS1112){
		$GUELTIGKEITSZEITRAUM="WS11/12";
	}
	if($unixTimestamp >$SS12){
		$GUELTIGKEITSZEITRAUM="SS12";
	}
	if($unixTimestamp >$WS1213){
		$GUELTIGKEITSZEITRAUM="WS12/13";
	}
	if($unixTimestamp >$SS13){
		$GUELTIGKEITSZEITRAUM="SS13";
	}
	if($unixTimestamp >$WS1314){
		$GUELTIGKEITSZEITRAUM="WS13/14";
	}
	if($unixTimestamp >$SS14){
		$GUELTIGKEITSZEITRAUM="SS14";
	}
	if($unixTimestamp >$WS1415){
		$GUELTIGKEITSZEITRAUM="WS14/15";
	}
	if($unixTimestamp >$SS15){
		$GUELTIGKEITSZEITRAUM="SS15";
	}
	return $GUELTIGKEITSZEITRAUM;
}

// ** Import Subjects **
for ($i = 0; $i < count($subjects_Array); $i=$i+9){
	$subjectUID = $subjects_Array[$i];
	$fachname = $subjects_Array[$i+7];
	$fachcode = $subjects_Array[$i+8];
	//search related entry in addministration table 	
	$subjectUID_FK = 0;
	$linePointer = 0;
	$examsForSubjectRowLine_array = array();
	for ( ;$linePointer < count($administrations_Array); $linePointer=$linePointer+15){
		$subjectUID_FK = $administrations_Array[$linePointer+8];
		if($subjectUID_FK == $subjectUID){
			$examsForSubjectRowLine_array[] =  $linePointer;
		}
	}
	foreach($examsForSubjectRowLine_array as $examLinePointer){
		$gueltigeitszeitraumUnixTime = 	$administrations_Array[$examLinePointer +14];
		if($gueltigeitszeitraumUnixTime == 0){
			$gueltigeitszeitraumUnixTime = $administrations_Array[$examLinePointer +3];
		}	
		$GUELTIGKEITSZEITRAUM = timestampToSemester($gueltigeitszeitraumUnixTime); 
	 	//search ModulUID in new db for reference 
	 	$modulUIDforSubject_old = $administrations_Array[$examLinePointer+7];
		$modulNameforSubject = -1;
		for($k = 0; $k < count($modules_Array); $k=$k+8){
			if($modules_Array[$k]== $modulUIDforSubject_old){
				$modulNameforSubject = $modules_Array[$k+7];
			}
		}	
		if($modulNameforSubject == -1){
			echo "Error: no modul with UID: " . $modulUIDforSubject_old . "in CSV";
		}
		$sqlQuery = "SELECT uid FROM tx_rere_domain_model_modul where modulname=".$modulNameforSubject." AND gueltigkeitszeitraum='".$GUELTIGKEITSZEITRAUM."'";
		$result  = mysqli_query($db, $sqlQuery);
		if($result->num_rows > 1){
			echo "Error: Same modul UID twice for subject: ". $modulNameforSubject;
			exit();	
		}
		if($result->num_rows == 0){
			for ($j = 0; $j < count($modules_Array); $j=$j+8){
				if($modulUIDforSubject_old == $modules_Array[$j]){
					$sql = "INSERT INTO tx_rere_domain_model_modul (pid, modulnr, modulname, gueltigkeitszeitraum, fach, tstamp, crdate, cruser_id, deleted, hidden) VALUES (".$PID.",".$MODULNUMMER.",".$modules_Array[$j+7].",'".$GUELTIGKEITSZEITRAUM."',".$FACH.",".$modules_Array[$j+2]. ",".$modules_Array[$j+3].",".$modules_Array[$j+4].",".$modules_Array[$j+5].",".$modules_Array[$j+6]." )";	
					if(!mysqli_query($db, $sql)) {
						echo "<br>Error: " . $sql . "<br>" . mysqli_error($db);   
						exit();
					}
					$sqlQuery = "SELECT uid FROM tx_rere_domain_model_modul where modulname=".$modulNameforSubject." AND gueltigkeitszeitraum='".$GUELTIGKEITSZEITRAUM."'";
					$result  = mysqli_query($db, $sqlQuery);
					break;				
				}
			}
		}	
		$row = $result->fetch_assoc();
		$modulUIDforSubject_new=$row["uid"];
		//Look for Notenschema for Subject
		$gradeType_old = $administrations_Array[$examLinePointer+13];
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
			if($configID == "'".$administrations_Array[$examLinePointer]."'"){
				$counterNote++;
			}
		}
		$sql = "INSERT INTO tx_rere_domain_model_fach (pid, fachnr, fachname, pruefer, notenschema, modulnr, note, tstamp, crdate, cruser_id, deleted, hidden, matrikelnr, datum, creditpoints, modul) VALUES (".$PID.",".$fachcode.",".$fachname.",'".$PRÜFER."','".$gradeType_new."',".$modulUIDforSubject_new.",".$counterNote.",".$subjects_Array[$i+2].",".$subjects_Array[$i+3].",".$subjects_Array[$i+4].",".$subjects_Array[$i+5].",".$subjects_Array[$i+6].",".$counterNote.",'".	$administrations_Array[$examLinePointer +14]."',".$administrations_Array[$examLinePointer+9].",".$administrations_Array[$examLinePointer].")";
		if (!mysqli_query($db, $sql)) {
				echo "<br>Error: " . $sql . "<br>" . mysqli_error($db); 
				exit();  
			} 
	
	}	
}
echo "Modules and Subjects completed<br>";

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
	//look for Pruefling
	$feUserUID = $grades_Array[$i+7];
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
	//look for fach
	$subject_configUid = $grades_Array[$i+10];
	$sqlQuery = "SELECT uid FROM tx_rere_domain_model_fach where modul=".$subject_configUid."";
	$result  = mysqli_query($db, $sqlQuery);
	if($result->num_rows > 1){
		echo "Error: double entry with subjectConfigUID: " .$subject_configUid;
		exit();	
	}
	if($result->num_rows == 0){
			echo "No Entry with SubjectConfigUID: ".$subjectUID."</br>";
			echo "Grade with UID ". $grades_Array[$i]." by FE-USER ".$feUserUID." cannot be assigned </br>";
			continue;
	}
	$row = $result->fetch_assoc();
	$fachUID = $row['uid'];
	$KOMMENTAR = $grades_Array[$i+9];
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