<?php
//Parameter
$budget= 65000;   // pro Jahr in Euro
$arbeitszeit= 8; // Arbeitszeit in Stunden
$budget_monat=round(65000/12,2); // pro Monat in Euro
$budget_tag=round(65000/365,2); // pro Tag in Euro
$kost_kwh = 0.1; // Kosten pro kwh in Euro
$spitze= $budget_tag/$arbeitszeit/$kost_kwh/4; // max KW pro Viertelstunde

// Timestamp
function getTimestamp($time,$date) {
	return $timestamp=mktime(
						substr($time,0,2),
						substr($time,2,2),
						substr($time,4,2),
						substr($date,2,2),
						substr($date,4,2),
						substr($date,0,2)
						);
}

// Zeitstempel aktueller Tag 0 Uhr
function startdate() {
	$time=time();
	$month=strftime("%m",$time);
	$day=strftime("%d",$time);
	$year=strftime("%y",$time);

	return $timestamp=$year.$month.$day;	
}

// Zählerstand
function newZaehler() {
	error_reporting(E_ALL);
	try {
		/*** DB erstellen ***/
		$dbh = new PDO("sqlite:inc/db/zaehler.sqlite");
		/*** set all errors to excptions ***/
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$sql = "SELECT kwh FROM energielog ORDER BY OID DESC Limit 2";
		$result = $dbh->query($sql);
		$i=1;
		foreach($result as $row) {
			$zaehler[$i]=str_replace(',','.',$row['kwh']);
			$i++;		
		}
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		die();
	}
return round($zaehler=$zaehler[1]-$zaehler[2],3)*1000;
}

// Berechnung Anteil Spitzenlast
function proz_spitze() {
	global $spitze;
	$stand=newZaehler();
	$proz_spitze=round($stand/$spitze*100);
	return $proz_spitze;
}

// Berechnung Verbrauch Tag
function verbrauch_Tag(){
	global $kost_kwh;
	$kw_heute=0;	
	$tag = date("d",time());	
	$monat = date("m",time());
	$jahr = date("y", time());
	$heute = $jahr.$monat.$tag;
	$gestern = $jahr.$monat.$tag-1;
	error_reporting(E_ALL);
	try {
		/*** DB erstellen ***/
		$dbh = new PDO("sqlite:inc/db/zaehler.sqlite");
		/*** set all errors to excptions ***/
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$sql = "SELECT time, date, kwh, oid FROM energielog WHERE date<=".$gestern." ORDER BY OID DESC LIMIT 1";
		$result = $dbh->query($sql);
		foreach($result as $row) {
			$kw_gestern=str_replace(',','.',$row['kwh']);		
		}
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		die();
	}
	
	error_reporting(E_ALL);
	try {
		/*** DB erstellen ***/
		$dbh = new PDO("sqlite:inc/db/zaehler.sqlite");
		/*** set all errors to excptions ***/
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$sql = "SELECT time, date, kwh, oid FROM energielog WHERE date<=".$heute." ORDER BY OID DESC LIMIT 1";
		$result = $dbh->query($sql);
		foreach($result as $row) {
			$kw_heute=str_replace(',','.',$row['kwh']);		
		}
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		die();
	}	
	
if ($kw_heute<=0) { 
	return $sum=0; 
	} 
	else {
	return $sum=round(($kw_heute-$kw_gestern)*4000*$kost_kwh,2);
	}
}

function proz_budget_tag() {
	global $budget_tag;
	$sum=verbrauch_tag();
	return $proz_sum=round($sum/$budget_tag*100);
	}

// Berechnung Verbrauch Monat
function verbrauch_Monat(){
	global $kost_kwh;
	$tag = date("d",time());	
	$monat = date("m",time());
	$jahr = date("y", time());
	$erster_monat = $jahr.$monat."01";
	error_reporting(E_ALL);
	try {
		/*** DB erstellen ***/
		$dbh = new PDO("sqlite:inc/db/zaehler.sqlite");
		/*** set all errors to excptions ***/
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$sql = "SELECT time, date, kwh, oid FROM energielog WHERE date<".$erster_monat." ORDER BY OID DESC LIMIT 1";
		$result = $dbh->query($sql);
		foreach($result as $row) {
			$kw_letzter_monat=str_replace(',','.',$row['kwh']);	
		}
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		die();
	}	
	
	error_reporting(E_ALL);
	try {
		/*** DB erstellen ***/
		$dbh = new PDO("sqlite:inc/db/zaehler.sqlite");
		/*** set all errors to excptions ***/
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$sql = "SELECT time, date, kwh, oid FROM energielog WHERE date>=".$erster_monat." ORDER BY OID DESC LIMIT 1";
		$result = $dbh->query($sql);
		foreach($result as $row) {
			$kw_monat=str_replace(',','.',$row['kwh']);
		}
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		die();
	}		
   return $sum=round(($kw_monat-$kw_letzter_monat)*4000*$kost_kwh,2);
}

function proz_budget_monat() {
	global $budget_monat;
	$sum=verbrauch_monat();
	return $proz_sum=round($sum/$budget_monat*100);
	}

?>