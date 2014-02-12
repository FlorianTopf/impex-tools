<?php
/********************************************************************************
***********                        IMPExToEPN.php                   *************
***********                                                         *************
*********** Converts XML files consistent with the IMPEx Data Model *************
*********** specification in a SQl table consistent with EPN-TAP    *************
***********                                                         *************
*********** written by: Sebastien Hess  (sebastien.hess@obspm.fr)   *************
***********             Baptiste Cecconi(baptiste.cecconi@obspm.fr) *************
*********** adaptions by: Florian Topf  (florian.topf@oeaw.ac.at)   *************
********************************************************************************/


//ini_set('display_errors', 'true');
//ini_set('max_execution_time', '300');
//ConvertIMPExToMySQL();
ConvertIMPExToPgSQL();

function ConvertIMPExToMySQL(){
	$TreeURL="http://impex-fp7.fmi.fi/ws/Tree_FMI_HYB.xml";
	//$TreeURL="http://impex-fp7.fmi.fi/ws/Tree_FMI_GUMICS.xml";
	//$TreeURL="http://impex.latmos.ipsl.fr/tree.xml";
	//$TreeURL="http://dec1.sinp.msu.ru/~lucymu/paraboloid/SINP_tree.xml";
	$ConfigURL="http://eup0183.fzg.oeaw.ac.at/config";
	$server="localhost";
	$user="root";
	$pass="";
	$DBname="epn_test";
	$tablename="epn_table";
	//$table=ConvertIMPExToArray($TreeURL);
	$table=FullIMPExToArray($ConfigURL);
	ArrayToMySQL($table,$server,$user,$pass,$DBname,$tablename);
}

function ConvertIMPExToPgSQL(){
	$ConfigURL="http://eup0183.fzg.oeaw.ac.at/config";
	$server="localhost";
	$user="postgres";
	$pass="postgres";
	$DBname="gavo";
	$tablename="impex_sim_trees.epn_core";
	$table=FullIMPExToArray($ConfigURL);
	ArrayToPgSQL($table,$server,$user,$pass,$DBname,$tablename);
}

function ArrayToMySQL($table,$server,$user,$pass,$DBname,$tablename){
	echo "Connecting to ".$DBname." database ...\n";
	mysql_connect($server,$user,$pass);
	mysql_select_db($DBname) or die('Unable to connect ('.mysql_error().')...');
	echo "Connected.\n\n";
	echo "Deleting ".$tablename." table ...\n";
	$textdel="DROP TABLE `".$tablename."`";
	mysql_query($textdel);
	if(mysql_error()){
		echo mysql_error()."\n";
	}
	echo "Deleted.\n";
	echo "Creating ".$tablename." table ...\n";
	$textCreate="CREATE TABLE `".$DBname."`.`".$tablename."` (\n";
	$head=array_keys($table[0]);
	$nr=count($head);
	$nl=count($table);
	$line="";
	for($i=0;$i<$nr;$i++){
		$fieldname=$head[$i];
		$type="TEXT";
		if($fieldname=="index"){
			$type="BIGINT";
		}
		if ((strpos($fieldname,"min")!==FALSE)||(strpos($fieldname,"max")!==FALSE)||(strpos($fieldname,"size")!==FALSE)){
			$type="DOUBLE";
		}
		if (strpos($fieldname,"input_")!==FALSE){
			$type="LONGTEXT";
		}
		$textCreate.="`".$fieldname."` ".$type." NULL ";
		if ($i<($nr-1)){
			$textCreate.=",";
		}
		$textCreate.="\n";
	}
	$textCreate.=") ENGINE = MYISAM ;\n";
	echo $textCreate;
	mysql_query($textCreate);
	if(mysql_error()){
		echo mysql_error()."\n";
		return false;
	}
	echo "Created.\n\n";
	echo "Filling ".$tablename." table ...\n";
	for($j=0;$j<$nl;$j++){
		$line="";
		for($i=0;$i<$nr;$i++){
			$tmp=$table[$j][$head[$i]];
			if(strcmp($tmp," ")<=0){
				$tmp="";
			}
			$fieldname=$head[$i];
			$sep='"';
			if (strcmp($tmp," ")>0){
				$line.=$sep.$tmp.$sep;
			}
			elseif($fieldname=="index"){
				$line.=$j+1;
			}
			else{
				$line.="NULL";
			}
			if ($i<($nr-1)){
				$line.=",";
			}
		}
		//echo $line."\n";
		$insertrecord = "INSERT INTO `".$tablename."` VALUES (".$line.")";
		mysql_query($insertrecord);
		if(mysql_error()){
			echo mysql_error()."\n";
			return false;
		}
		echo "Filled.\n";
	}
	mysql_close();
	echo "Connexion closed.\n";
	return true;
}

function ArrayToPgSQL($table,$server,$user,$pass,$DBname,$tablename){
	echo "Connecting to ".$DBname." database ...\n";
	pg_connect("host=".$server." dbname=".$DBname." user=".$user." password=".$pass)
	or die('Unable to connect ('.pg_last_error().')...');
	echo "Connected.\n\n";
	echo "Deleting ".$tablename." table ...\n";
	$textdel="DROP TABLE IF EXISTS ".$tablename;
	pg_query($textdel);
	if(pg_last_error()){
		echo pg_last_error()."\n";
	}
	echo "Deleted.\n";
	echo "Creating ".$tablename." table ...\n";
	$textCreate="CREATE TABLE ".$tablename." (";
	$head=array_keys($table[0]);
	$nr=count($head);
	$nl=count($table);
	$line="";
	for($i=0;$i<$nr;$i++){
		$fieldname=$head[$i];
		$type="TEXT";
		if($fieldname=="index"){
			$type="BIGINT";
		}
		if ((strpos($fieldname,"min")!==FALSE)||(strpos($fieldname,"max")!==FALSE)||(strpos($fieldname,"size")!==FALSE)){
			$type="DOUBLE PRECISION";
		}
		if (strpos($fieldname,"input_")!==FALSE){
			$type="TEXT";
		}
		$textCreate.=$fieldname." ".$type." NULL ";
		if ($i<($nr-1)){
			$textCreate.=",";
		}
		$textCreate.="\n";
	}
	$textCreate.=");\n";
	echo $textCreate;
	pg_query($textCreate);
	if(pg_last_error()){
		echo pg_last_error()."\n";
		return false;
	}
	echo "Created.\n\n";
	echo "Filling ".$tablename." table ...\n";
	for($j=0;$j<$nl;$j++){
		$line="";
		for($i=0;$i<$nr;$i++){
			$tmp=$table[$j][$head[$i]];
			if(strcmp($tmp," ")<=0){
				$tmp="";
			}
			$fieldname=$head[$i];
			$sep="'";
			if (strcmp($tmp," ")>0){
				$line.=$sep.addslashes($tmp).$sep;
			}
			elseif($fieldname=="index"){
				$line.=$j+1;
			}
			else{
				$line.="NULL";
			}
			if ($i<($nr-1)){
				$line.=",";
			}
		}
		echo $line."\n";
		$insertrecord = "INSERT INTO ".$tablename." VALUES (".$line.")";
		pg_query($insertrecord);
		if(pg_last_error()){
			echo pg_last_error()."\n";
			return false;
		}
		echo "Filled.\n";
	}
	//fixing privileges on the table for GaVO
	$fixpriv1="GRANT ALL ON TABLE impex_sim_trees.epn_core TO gavoadmin WITH GRANT OPTION";
	pg_query($fixpriv1);
	$fixpriv2="GRANT ALL ON TABLE impex_sim_trees.epn_core TO gavo WITH GRANT OPTION";
	pg_query($fixpriv2);
	$fixpriv3="GRANT SELECT ON TABLE impex_sim_trees.epn_core TO untrusted";
	pg_query($fixpriv3);
	pg_close();
	echo "Connexion closed.\n";
	return true;
}

function FullIMPExToArray($configFileURL){
	$confg=simplexml_load_file($configFileURL);
	$countLine=0;
	$Table=array();
	//@TODO sometimes there are more than one tree element
	foreach($confg->database as $db){
		//@TODO observational trees are not compatible atm
		if($db["type"] == "simulation"){
			$treeURL="http://".$db->dns.$db->tree;
			echo $treeURL."\n";
			$tdb=ConvertIMPExToArray($treeURL);
			$nl=count($tdb);
			for($i=0;$i<$nl;$i++){
				$Table[$countLine]=$tdb[$i];
				$countLine++;
			}
		}
	}
	return $Table;
}

function getNameFromID($in,$Tree){
	foreach ($Tree->children() as $res){
		if(strcmp($res->ResourceID[0],$in)==0){
			return $res->ResourceHeader->ResourceName[0];
		}
	}
	return "";
}

function DURToJul($in){
	$date=explode("P",$in);
	$date=$date[1];
	$date=explode("T",$date);
	$time=$date[1];
	$date=$date[0];
	$jul=0;
	if (strcmp($date," ")>0){
		if (strpos($date,"Y")!==FALSE){
			$y=explode("Y",$date);
			if (count($y)>1){
				$date=$y[1];
			}
			$jul+=365.25*$y[0];
		}
	}
	if (strcmp($date," ")>0)
	{
		if (strpos($date,"M")!==FALSE){
			$y=explode("M",$date);
			if (count($y)>1){
				$date=$y[1];
			}
			$jul+=30*$y[0];
		}
		if (strcmp($date," ")>0){
			if (strpos($date,"D")!==FALSE){
				$y=explode("D",$date);
				if (count($y)>1){
					$date=$y[1];
				}
				$jul+=$y[0];
			}
			$date=$time;
			if (strcmp($date," ")>0){
				if (strpos($date,"H")!==FALSE){
					$y=explode("H",$date);
					if (count($y)>1){
						$date=$y[1];
					}
					$jul+=$y[0]/24.0;
				}
			}
			if (strcmp($date," ")>0)
			{
				if (strpos($date,"M")!==FALSE){
					$y=explode("M",$date);
					if (count($y)>1){
						$date=$y[1];
					}
					$jul+=$y[0]/1440.0;
				}
				if (strcmp($date," ")>0){
					if (strpos($date,"S")!==FALSE){
						$y=explode("S",$date);
						if (count($y)>1){
							$date=$y[1];
						}
						$jul+=$y[0]/86400.0;
					}
					return $jul;
				}
			}
		}
	}
}

function getResID($in,$Tree,$rname){
	foreach ($Tree->children() as $res){
		if(strcmp($res->ResourceID[0],$in)==0){
	 		return $res->$rname;
		}
	}
	return "";
}

function Loop($Element,$table,$line,$tree){
	$Elements=$Element->children();
	foreach ($Elements as $res) {
		try{   
			$name = $res->getName();
			//@TODO temporary removal of warnings
			if(($name != "ReleaseDate") && ($name != "RegionEnd") && ($name != "RegionBegin"))
				//calls individual functions based on encountered XML element name
				$test=call_user_func($name,$res,$table,$line,$tree);
		}
		catch(Exception $e) { }
		
		if ($test!=null){
			$table=$test;
		}
	}
	return $table;
}

function ConvertIMPExToArray($TreeURL){
	$Tree=simplexml_load_file($TreeURL);
	$countLine=0;
	$Table=array();
	foreach ($Tree->NumericalData as $res) {
		$Table[$countLine]=EPNArray("dataset","ts");
		$Table=Loop($res,$Table,$countLine,$Tree);
		$countLine++;
	}
	foreach ($Tree->DisplayData as $res){
		$Table[$countLine]=EPNArray("dataset","");
		$Table=Loop($res,$Table,$countLine,$Tree);
		$countLine++;
	}
	foreach ($Tree->Catalog as $res) {
		$Table[$countLine]=EPNArray("dataset","ca");
		$Table=Loop($res,$Table,$countLine,$Tree);
		$countLine++;
	}
	foreach ($Tree->SimulationModel as $res){
		$Table[$countLine]=EPNArray("dataset","");
		$Table=Loop($res,$Table,$countLine,$Tree);
		$countLine++;
	}
	foreach ($Tree->SimulationRun as $res){
		$Table[$countLine]=EPNArray("dataset","");
		$Table=Loop($res,$Table,$countLine,$Tree);
		$countLine++;
	}
	foreach ($Tree->NumericalOutput as $res) {
		$Table[$countLine]=EPNArray("dataset","");
		$Table=Loop($res,$Table,$countLine,$Tree);
		$countLine++;
	}
	foreach ($Tree->DisplayOutput as $res){
		$Table[$countLine]=EPNArray("dataset","");
		$Table=Loop($res,$Table,$countLine,$Tree);
		$countLine++;
	}
	foreach ($Tree->Granule as $res){
		$Table[$countLine]=EPNArray("granule","");
		$Table=Loop($res,$Table,$countLine,$Tree);
		$countLine++;
	}
	
	return $Table;
}

function addToList($in,$el){
	$tmp=explode(";",$in);
	if (!in_array($el,$tmp)){
		array_push($tmp,$el);
	}//single occurence
	if ($tmp[0]==""){
		array_shift($tmp);
	}
	return implode(";",$tmp);
}

function addToList2($in,$el){
	$tmp=explode(",",$in);
	if (!in_array($el,$tmp)){
		array_push($tmp,$el);
	}//single occurence
	if ($tmp[0]==""){
		array_shift($tmp);
	}
	return implode(",",$tmp);
}


function ISOtoJul($iso){
	$jd= floatval(gregoriantojd(intval(substr($iso,5,2)),intval(substr($iso,8,2)),intval(substr($iso,0,4))))-0.5;
	$jd +=(floatval(substr($iso,11,2))/(24.)+floatval(substr($iso,14,2))/(24.*60.)+floatval(substr($iso,17,6))/(24.*60.*60));
	return $jd;
}

//@TODO some things are still unclear
function EPNArray($rtype,$dtype){
	$EPNLabel=array(
			// compulsory parameters
			"index"=>"","resource_type"=>$rtype,"dataset_id"=>"","dataproduct_type"=>$dtype,"target_name"=>"","target_class"=>"",
			"time_min"=>0.0,"time_max"=>0.0,"time_sampling_step_min"=>0.0,"time_sampling_step_max"=>0.0,"time_exp_min"=>"",
			"time_exp_max"=>"","spectral_range_min"=>"","spectral_range_max"=>"","spectral_sampling_step_min"=>"",
			"spectral_sampling_step_max"=>"","spectral_resolution_min"=>"","spectral_resolution_max"=>"","c1min"=>"","c1max"=>"",
			"c2min"=>"","c2max"=>"","c3min"=>"","c3max"=>"","c1_resol_min"=>"","c1_resol_max"=>"","c2_resol_min"=>"",
			"c2_resol_max"=>"","c3_resol_min"=>"","c3_resol_max"=>"","spatial_frame_type"=>"","incidence_min"=>"",
			"incidence_max"=>"","emergence_min"=>"","emergence_max"=>"","phase_min"=>"","phase_max"=>"",
			"instrument_host_name"=>"","instrument_name"=>"","measurement_type"=>"",
			// optional parameters
			"access_url"=>"","access_format"=>"","access_estsize"=>"","preview_url"=>"","species"=>"","particle_spectral_type"=>"",
			"particle_spectral_range_min"=>"","particle_spectral_range_max"=>"",
			// service properties (service_protocol?)
			"processing_level"=>"","publisher"=>"","reference"=>"","service_title"=>"","target_region"=>"",
			// custom fields
			"reference_id"=>"","input_field"=>"","input_particle_nvT"=>"","input_process"=>"","input_parameter"=>"");
	return $EPNLabel;
}

//-----------------------------------------------------------------------------------------------------------------------------
// Helper functions for XML elements of the IMPEx data model
function SimulationDomain($Element,$table,$line,$tree){
	$unit=1;$u="";//meter or degree
	if (property_exists($Element,"Units")){
		$u=$Element->Units[0];
	}
	if (property_exists($Element,"UnitsConversion")){
		$e=explode(">",str_replace("&gt;",">",$Element->UnitsConversion[0]));
		$unit=$e[0]; $u=$e[1];
	}
	if (strcmp($u,"km")==0){
		$unit*=1000;
	}
	if (strcmp($u,"cm")==0){
		$unit*=1e-2;
	}
	if (strcmp($u,"mm")==0){
		$unit*=1e-3;
	}

	if (property_exists($Element,"ValidMin")){
		$vm=$Element->ValidMin[0]; 
		for ($i=0;$i<10;$i++){
			$vm=str_replace("  "," ",$vm);
		}
		$mns=explode(" ",$vm);
		$mns2=explode(",",$vm);
		if (count($mns2)>count($mns)){
			$mns=$mns2;
		}
		$mns2=explode(";",$vm);
		if (count($mns2)>count($mns)){
			$mns=$mns2;
		}
		if (strcmp($mns[0]," ")<=0){
			array_shift($mns);
		}
		$table[$line]['c1min']=$mns[0]*$unit;
		if (count($mns)>1){
			$table[$line]['c2min']=$mns[1]*$unit;
		}
		if (count($mns)>2){
			$table[$line]['c3min']=$mns[2]*$unit;
		}
	}
	if (property_exists($Element,"ValidMax")){
		$vm=$Element->ValidMax[0]; 
		for ($i=0;$i<10;$i++)
		{
			$vm=str_replace("  "," ",$vm);
		}
		$mns=explode(" ",$vm);
		$mns2=explode(",",$vm);
		if (count($mns2)>count($mns)){
			$mns=$mns2;
		}
		$mns2=explode(";",$vm);
		if (count($mns2)>count($mns)){
			$mns=$mns2;
		}
		if (strcmp($mns[0]," ")<=0){
			array_shift($mns);
		}
		$table[$line]['c1max']=$mns[0]*$unit;
		if (count($mns)>1){
			$table[$line]['c2max']=$mns[1]*$unit;
		}
		if (count($mns)>2){
			$table[$line]['c3max']=$mns[2]*$unit;
		}
	}
	if (property_exists($Element,"GridCellSize")){
		$vm=$Element->GridCellSize[0]; 
		for ($i=0;$i<10;$i++){
			$vm=str_replace("  "," ",$vm);
		}
		$mns=explode(" ",$vm);
		$mns2=explode(",",$vm);
		if (count($mns2)>count($mns)){
			$mns=$mns2;
		}
		$mns2=explode(";",$vm);
		if (count($mns2)>count($mns)){
			$mns=$mns2;
		}
		if (strcmp($mns[0]," ")<=0){
			array_shift($mns);
		}
		$table[$line]['c1_resol_min']=$mns[0]*$unit;
		$table[$line]['c1_resol_max']=$mns[0]*$unit;
		if (count($mns)>1){
			$table[$line]['c2_resol_min']=$mns[1]*$unit;
			$table[$line]['c2_resol_max']=$mns[1]*$unit;
		}
		if (count($mns)>2){
			$table[$line]['c3_resol_min']=$mns[2]*$unit;
			$table[$line]['c3_resol_max']=$mns[2]*$unit;
		}
	}
	if (property_exists($Element,"CoordinateSystem")){
		if (property_exists($Element->CoordinateSystem[0],"CoordinateRepresentation")){
			$table[$line]['spatial_frame_type']=strtolower($Element->CoordinateSystem[0]->CoordinateRepresentation[0]);
		}
	}
	return $table;
}

function SpatialDescription($Element,$table,$line,$tree){
	$table=SimulationDomain($Element,$table,$line,$tree);

	$unit=1;$u="";//meter or degree
	if (property_exists($Element,"Units")){
		$u=$Element->Units[0];
	}
	if (property_exists($Element,"UnitsConversion")){
		$e=explode(">",str_replace("&gt;",">",$Element->UnitsConversion[0]));
		$unit=$e[0]; $u=$e[1];
	}
	if (strcmp($u,"km")==0){
		$unit*=1000;
	}
	if (strcmp($u,"cm")==0){
		$unit*=1e-2;
	}
	if (strcmp($u,"mm")==0){
		$unit*=1e-3;
	}

	if (property_exists($Element,"RegionBegin")){
		$vm=$Element->RegionBegin[0]; 
		for ($i=0;$i<10;$i++){
			$vm=str_replace("  "," ",$vm);
		}
		$mns=explode(" ",$vm);
		$mns2=explode(",",$vm);
		if (count($mns2)>count($mns)){
			$mns=$mns2;
		}
		$mns2=explode(";",$vm);
		if (count($mns2)>count($mns)){
			$mns=$mns2;
		}
		if (strcmp($mns[0]," ")<=0){
			array_shift($mns);
		}
		$table[$line]['c1min']=$mns[0]*$unit;
		if (count($mns)>1){
			$table[$line]['c2min']=$mns[1]*$unit;
		}
		if (count($mns)>2){
			$table[$line]['c3min']=$mns[2]*$unit;
		}
	}
	if (property_exists($Element,"RegionEnd")){
		$vm=$Element->RegionEnd[0];
		for ($i=0;$i<10;$i++){
			$vm=str_replace("  "," ",$vm);
		}
		$mns=explode(" ",$vm);
		$mns2=explode(",",$vm);
		if (count($mns2)>count($mns)){
			$mns=$mns2;
		}
		$mns2=explode(";",$vm);
		if (count($mns2)>count($mns)){
			$mns=$mns2;
		}
		if (strcmp($mns[0]," ")<=0){
			array_shift($mns);
		}
		$table[$line]['c1max']=$mns[0]*$unit;
		if (count($mns)>1){
			$table[$line]['c2max']=$mns[1]*$unit;
		}
		if (count($mns)>2){
			$table[$line]['c3max']=$mns[2]*$unit;
		}
	}
	if (property_exists($Element,"Step")){
		$vm=$Element->Step[0];
		for ($i=0;$i<10;$i++){
			$vm=str_replace("  "," ",$vm);
		}
		$mns=explode(" ",$vm);
		$mns2=explode(",",$vm);
		if (count($mns2)>count($mns)){
			$mns=$mns2;
		}
		$mns2=explode(";",$vm);
		if (count($mns2)>count($mns)){
			$mns=$mns2;
		}
		if (strcmp($mns[0]," ")<=0){
			array_shift($mns);
		}
		$table[$line]['c1_resol_min']=$mns[0]*$unit;
		$table[$line]['c1_resol_max']=$mns[0]*$unit;
		if (count($mns)>1){
			$table[$line]['c2_resol_min']=$mns[1]*$unit;
			$table[$line]['c2_resol_max']=$mns[1]*$unit;
		}
		if (count($mns)>2){
			$table[$line]['c3_resol_min']=$mns[2]*$unit;
			$table[$line]['c3_resol_max']=$mns[2]*$unit;
		}
	}
	return $table;
}

function SimulationTime($Element,$table,$line,$tree){
	if (property_exists($Element,"TimeStart")){
		$table[$line]['time_min']=ISOtoJul($Element->TimeStart[0]);
	}
	if (property_exists($Element,"TimeStop")){
		$table[$line]['time_max']=ISOtoJul($Element->TimeStop[0]);
	}
	if (property_exists($Element,"TimeStep")){
		$table[$line]['time_sampling_step_min']=DURtoJul($Element->TimeStep[0]);
		$table[$line]['time_sampling_step_max']=DURtoJul($Element->TimeStep[0]);
	}
	return $table;
}

function StartDate($Element,$table,$line,$tree){
	$table[$line]['time_min']=ISOtoJul($Element[0]);
}

function StopDate($Element,$table,$line,$tree){
	$table[$line]['time_max']=ISOtoJul($Element[0]);
}

function TemporalDescription($Element,$table,$line,$tree){
	$E=$Element->TimeSpan;
	if (property_exists($E,"StartDate")){
		$table[$line]['time_min']=ISOtoJul($E->StartDate[0]);
	}
	if (property_exists($E,"StopDate")){
		$table[$line]['time_max']=ISOtoJul($E->StopDate[0]);
	}
	if (property_exists($Element,"Cadence")){
		$table[$line]['time_sampling_step_min']=DURtoJul($Element->Cadence[0]);
		$table[$line]['time_sampling_step_max']=DURtoJul($Element->Cadence[0]);
	}
	return $table;
}

function ObservedRegion($Element,$table,$line,$tree){
	$list_planet=array("Mercury","Venus","Earth","Mars","Jupiter","Saturn","Uranus","Neptune");
	$list_dplanet=array("Pluto","Ceres","Vesta","Charon");
	$list_sat=array("Moon","Phobos","Deimos","Amalthea","Io","Europa","Ganymede","Callisto","Enceladus","Japet","Rhea","Titan","Ariel","Triton");
	$list_star=array("Sun");
	$list_hs=array("Heliosphere","Interstellar");

	$tmp=explode(".",$Element);$target=array_shift($tmp);
	$region="";
	if(count($tmp)>0){
		$region=implode(".",$tmp);
	}
	$table[$line]['target_name']=addToList($table[$line]['target_name'],strtolower($target));
	$table[$line]['target_region']=addToList($table[$line]['target_region'],strtolower($region));
	if (in_array($target,$list_planet)){
		$table[$line]['target_class']=addToList($table[$line]['target_class'],"planet");
	}
	if (in_array($target,$list_dplanet)){
		$table[$line]['target_class']=addToList($table[$line]['target_class'],"dwarf_planet");
	}
	if (in_array($target,$list_sat)){
		$table[$line]['target_class']=addToList($table[$line]['target_class'],"satellite");
	}
	if (in_array($target,$list_star)){
		$table[$line]['target_class']=addToList($table[$line]['target_class'],"star");
	}
	if (in_array($target,$list_hs)){
		$table[$line]['target_class']=addToList($table[$line]['target_class'],"interplanetary_medium");
	}
	if ($target=="Comet"){
		$table[$line]['target_class']=addToList($table[$line]['target_class'],"comet");
	}
	if ($target=="Asteroid"){
		$table[$line]['target_class']=addToList($table[$line]['target_class'],"asteroid");
	}
	return $table;
}

function SimulatedRegion($Element,$table,$line,$tree){
	if ($Element!="Incident")
	{
		return ObservedRegion($Element,$table,$line,$tree);
	}
	return $table;
}

//@FIXME => here something went wrong instrument_name / instrument_host_name mixed up!
function InstrumentID($Element,$table,$line,$tree){
	$table[$line]['instrument_name']=addToList($table[$line]['instrument_name'],getNameFromID($Element,$tree));
	$OID=getResID($Element,$tree,"ObservatoryID");
	$OID=$OID[0];
	$table[$line]['instrument_host_name']=addToList($table[$line]['instrument_host_name'],getNameFromID($OID,$tree));
	return $table;
}

function SimulatedInstrumentID($Element,$table,$line,$tree){
	return InstrumentID($Element,$table,$line,$tree);
}

function ResourceID($Element,$table,$line,$tree){
	$table[$line]['dataset_id']=$Element;
	$IID=getResID($Element,$tree,"InputResourceID");
	$IID=$IID[0];
	$IID=getResID($IID,$tree,"SimulationDomain");
	$table=SimulationDomain($IID,$table,$line,$tree);
	return $table;
}

function ParentID($Element,$table,$line,$tree){
	for($i=0;$i<$line;$i++){
		if ($table[$i]['dataset_id']==$Element){
			$table[$line]=$table[$i];
			$table[$line]['resource_type']="granule";
		}
	}
	$table[$line]['dataset_id']=$Element;
	return $table;
}

function Source($Element,$table,$line,$tree){
	if ((strcmp($Element->SourceType[0],"Thumbnail")==0)||(strcmp($Element->SourceType[0],"Browse")==0)){
		$table[$line]['preview_url']=$Element->URL[0];
	} 
	else{
		$table[$line]['access_url']=$Element->URL[0];
	}
	if (property_exists($Element,"DataExtent")){
		$table[$line]['access_estsize']=$Element->Quantity[0];
	}
	return $table;
}

function AccessInformation($Element,$table,$line,$tree)
{
	$table[$line]['access_url']=$Element->AccessURL[0]->URL[0];
	$table[$line]['access_format']=$Element->Format[0];
	if ((strcmp($table[$line]['access_format'],"AVI")==0)||(strcmp($table[$line]['access_format'],"MPEG")==0)||(strcmp($table[$line]['access_format'],"Quicktime")==0)){
		$table[$line]['dataset_type']="mo";
	}
	if ((strcmp($table[$line]['access_format'],"PNG")==0)||
			(strcmp($table[$line]['access_format'],"GIF")==0)||
			(strcmp($table[$line]['access_format'],"JPEG")==0)||
			(strcmp($table[$line]['access_format'],"Postscript")==0)||
			(strcmp($table[$line]['access_format'],"FITS")==0)){
		$table[$line]['dataset_type']="im";
	}
	return $table;
}

function InputResourceID($Element,$table,$line,$tree)
{
	if (strcmp($Element[0]," ")>0){
		$table[$line]['reference_id']=addToList($table[$line]['reference_id'],$Element);
	}
	return $table;
}

function Model($Element,$table,$line,$tree)
{
	if (property_exists($Element,"ModelID")){
		if (strcmp($Element->ModelID[0]," ")>0){
			$table[$line]['reference_id']=addToList($table[$line]['reference_id'],$Element->ModelID[0]);
		}
	}
	return $table;
}


function MeasurementType($Element,$table,$line,$tree)
{
	$UCD=array("activityIndex"=>"meta.code;phys.magfield","current"=>"phys.elecCurrent","dopplergram"=>"spect.doppler.velocity","dust"=>"phys.particle.dust",
			"electricfield"=>"phys.elecField","energeticparticles"=>"phys.particle","ephemeris"=>"pos.bodyrc","imageintensity"=>"phot.flux;obs.image",
			"instrumentstatus"=>"instr.setup;meta.code.status","ioncomposition"=>"phys.atmol.ionStage","irradiance"=>"phot.flux","magneticfield"=>"phys.magField",
			"magnetogram"=>"phys.magField;obs.image","neutralatomimages"=>"phys.atmol;obs.image","neutralgas"=>"phys.atmol","profile"=>"",
			"radiance"=>"phot.flux.density","spectrum"=>"spect","thermalplasma"=>"phys.particle","wave"=>"em.radio","wave.active"=>"em.radio",
			"wave.passive"=>"em.radio");
	if (array_key_exists(strtolower($Element),$UCD)){
		$table[$line]['measurement_type']=addToList($table[$line]['measurement_type'],$UCD[strtolower($Element)]);
		if ((strcmp($UCD[strtolower($Element)],"spect")==0)&&(strcmp($table[$line]['dataproduct_type'],"ts")==0))
		{
			$table[$line]['dataproduct_type']="ds";
		}
	}
	return $table;
}

function SimulationProduct($Element,$table,$line,$tree)
{
	if (($table[$line]["time_min"]!="")&&($table[$line]["time_max"]!="")&&($table[$line]["time_min"]!=$table[$line]["time_max"])){
		$td=true;
	}
	else{
		$td=false;
	}
	if ($td){
		$prod=array("3dcubes"=>"vo","2dcuts"=>"im","timeseries"=>"ts","spatialseries"=>"sv","lines"=>"sv","spectra"=>"ds");
	} 
	else{
		$prod=array("3dcubes"=>"vo","2dcuts"=>"im","timeseries"=>"ts","spatialseries"=>"sv","lines"=>"sv","spectra"=>"sp");
	}
	if (array_key_exists(strtolower($Element),$prod)){
		$table[$line]['dataproduct_type']=addToList($table[$line]['dataproduct_type'],$prod[strtolower($Element)]);
	}
	return $table;
}

function ResourceHeader($Element,$table,$line,$tree)
{
	$table[$line]['service_title']=$Element->ResourceName[0];
	if (property_exists($Element,"InformationURL")){
		foreach($Element->InformationURL as $iu){
			$table[$line]['reference']=addToList($table[$line]['reference'],$iu);
		}
	}
	if (property_exists($Element,"Contact")){
		foreach($Element->Contact as $ct){
			if ((strcmp($ct->Role[0],"Publisher")==0)||(strcmp($ct->Role[0],"DataProducer")==0)){
				$table[$line]['publisher']=addToList($table[$line]['publisher'],$ct->PersonID[0]);
			}
		}
	}
	return $table;
}

function Parameter($Element,$table,$line,$tree){
	$E=null;
	if (property_exists($Element,"Particle")){
		$E=$Element->Particle[0];
		if (property_exists($E,"ChemicalFormula")){
			$table[$line]['species']=addToList($table[$line]['species'],$E->ChemicalFormula[0]);
		}
		if (property_exists($E,"EnergyRange")){
			$unit=1; $u=$E->EnergyRange[0]->Units[0];
			$what="energy";
			if (strcmp($u,"eV")==0){
				$unit=1;
				$what="energy";
			}
			if (strcmp($u,"keV")==0){
				$unit=1e3;
				$what="energy";
			}
			if (strcmp($u,"MeV")==0){
				$unit=1e6;
				$what="energy";
			}
			if (strcmp($u,"GeV")==0){
				$unit=1e9;
				$what="energy";
			}
			if (strcmp($u,"amu")==0){
				$unit=1;
				$what="mass";
			}
			if (strcmp($u,"amu/q")==0)
			{
				$unit=1;
				$what="mass/charge ratio";
			}
			$mn=$E->EnergyRange[0]->Low[0]*$unit;
			$mx=$E->EnergyRange[0]->High[0]*$unit;
			if (($mn<$table[$line]['particle_spectral_range_min'])||($table[$line]['particle_spectral_range_min']==0)){
				$table[$line]['particle_spectral_range_min']=$mn;
			}
			if ($mx>$table[$line]['particle_spectral_range_max']){
				$table[$line]['particle_spectral_range_max']=$mx;
			}
		}
	}
	if (property_exists($Element,"Wave")){
		$E=$Element->Wave[0];
		if (property_exists($E,"WaveQuantity")){
			if (strcmp($E->WaveQuantity[0],"ACElectricField")==0){
				$table[$line]['measurement_type']=addToList($table[$line]['measurement_type'],"phys.elecField");
			}
			else{
				if (strcmp($E->WaveQuantity[0],"ACMagneticField")==0){
					$table[$line]['measurement_type']=addToList($table[$line]['measurement_type'],"phys.magField");
				}
				else{
					$table[$line]['measurement_type']=addToList($table[$line]['measurement_type'],"em.radio");
				}
			}
		}
	}
	if (property_exists($Element,"Field")){
		$E=$Element->Field[0];
		if (property_exists($E,"FieldQuantity")){
			if (strcmp($E->FieldQunatity[0],"Magnetic")==0){
				$table[$line]['measurement_type']=addToList($table[$line]['measurement_type'],"phys.magField");
			}
			if (strcmp($E->FieldQunatity[0],"Electric")==0){
				$table[$line]['measurement_type']=addToList($table[$line]['measurement_type'],"phys.elecField");
			}
		}
	}
	if ($E!=null){
		if (property_exists($E,"FrequencyRange")){
			$unit=1; 
			$u=$E->FrequencyRange[0]->Units[0];
			if (strcmp($u,"mHz")==0){
				$unit=1e-3;
			}
			if (strcmp($u,"kHz")==0){
				$unit=1e3;
			}
			if (strcmp($u,"MHz")==0){
				$unit=1e6;
			}
			if (strcmp($u,"GHz")==0){
				$unit=1e9;
			}
			if (strcmp($u,"THz")==0){
				$unit=1e12;
			}
			$mn=$E->FrequencyRange[0]->Low[0]*$unit;
			$mx=$E->FrequencyRange[0]->High[0]*$unit;
			if (($mn<$table[$line]['spectral_range_min'])||($table[$line]['spectral_range_min']==0)){
				$table[$line]['spectral_range_min']=$mn;
			}
			if ($mx>$table[$line]['spectral_range_max']){
				$table[$line]['spectral_range_max']=$mx;
			}
		}
	}
	return $table;
}

function Property($Element,$table,$line,$tree){
	if(strcmp($Element->PropertyQuantity[0],"Platform")==0){
		$table[$line]['instrument_name']=addToList($table[$line]['instrument_name'],$Element->PropertyValue[0]);
	}
	if(strcmp($Element->PropertyQuantity[0],"IMFClockAngle")==0){
		$table[$line]['input_parameter']=addToList($table[$line]['input_parameter'],"IMFClockAngle:".$Element->PropertyValue[0]);
	}
	if(strcmp($Element->PropertyQuantity[0],"SolarUVFlux")==0){
		$table[$line]['input_parameter']=addToList($table[$line]['input_parameter'],"SolarUVFlux:".$Element->PropertyValue[0]);
	}
	return $table;
}

function InputField($Element,$table,$line,$tree){
	$nam=$Element->Name[0];
	$mod=$Element->FieldModel[0];
	$val=$Element->FieldValue[0];
	$un=$Element->Units[0];
	if ($un==null){
		$un="";
	}
	if (strcmp($mod,"  ")>0){
		$nam=$nam.": ".$mod;
	} 
	else{
		$nam=$nam.": ".$val." ".$un;
	}
	$table[$line]['input_field']=addToList($table[$line]['input_field'],$nam);
	return $table;
}

function InputProcess($Element,$table,$line,$tree){
	$nam=$Element->Name[0];
	$table[$line]['input_process']=addToList($table[$line]['input_process'],$nam);
	return $table;
}

function InputParameter($Element,$table,$line,$tree){
	foreach($Element->Property as $p){
		$table=Property($p,$table,$line,$tree);
	}
	return $table;
}


function InputPopulation($Element,$table,$line,$tree){
	$nam=$Element->Name[0];
	if (property_exists($Element,"ChemicalFormula")){
		$table[$line]['species']=addToList($table[$line]['species'],$Element->ChemicalFormula[0]);
	}
	$de="";$ude="";$ve="";$uve="";$te="";$ute="";
	if (property_exists($Element,"PopulationDensity")){
		$de=$Element->PopulationDensity[0];
		if ($de==null){
			$de="";
		}
		$ude=$Element->PopulationDensity[0]->attributes();
		$ude=$ude['Units'];
		if ($ude==null){
			$ude="";
		}
	}
	if (property_exists($Element,"PopulationFlowSpeed")){
		$ve=$Element->PopulationFlowSpeed[0];
		if ($ve==null){
			$ve="";
		}
		$uve=$Element->PopulationFlowSpeed[0]->attributes();
		$uve=$uve['Units'];
		if ($uve==null){
			$uve="";
		}
	}
	if (property_exists($Element,"PopulationTemperature")){
		$te=$Element->PopulationTemperature[0];
		if ($te==null){
			$te="";
		}
		$ute=$Element->PopulationTemperature[0]->attributes();
		$ute=$ute['Units'];
		if ($ute==null){
			$ute="";
		}
	}
	if (strcmp($de.$ude," ")>0){
		$nam=addToList2($nam,$de." ".$ude);
	}
	if (strcmp($ve.$uve," ")>0){
		$nam=addToList2($nam,$ve." ".$uve);
	}
	if (strcmp($te.$ute," ")>0){
		$nam=addToList2($nam,$te." ".$ute);
	}
	$table[$line]['input_particle_nvT']=addToList($table[$line]['input_particle_nvT'],$nam);
	return $table;
}

?>
