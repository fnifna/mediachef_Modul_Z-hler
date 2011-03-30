<?php
	include_once('inc/functions.inc.php');
//	include_once('inc/connect.inc.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de"> 
<head> 
<title>Lastgangüberblick</title> 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
<meta http-equiv="Content-Style-Type" content="text/css" /> 
<meta http-equiv="Content-Script-Type" content="text/javascript" /> 
<script src="http://code.jquery.com/jquery-1.4.4.js"></script>
<script type="text/javascript" src="jquery/js/jquery-ui-1.8.7.custom.min.js"></script>
<script type="text/javascript" src="jquery/jquery.calendar-1.0.js"></script>
<script type="text/javascript" src="inc/ajax.js"></script>
<script type="text/javascript">
      $().ready(function () {
        $("#cal-event").calendar({ dateChanged: function (date) { alert('You clicked a ' + date.toDateString()); return false; } });
        $("#cal-cust").calendar({ year: 2008, month: 3, current: new Date(2008, 3, 2) });
        $("#cal-url").calendar({ templateUrl: '/blog/year-month-day.php' });
      });
    </script>
 <link href="design/format.css" type="text/css" rel="stylesheet" />
 </head>

  <body>
<div id="header">
	<div id="title">
		<h2>Lastgangüberblick</h2>
    </div>
	<div id="menu">
		<ul class="mainmenu">
    		<li class="menupoint"><a href="index.php?seite=energie">Energie</a></li>
    	<!--	<li class="menupoint"><a href="index.php?seite=kuehlung">Kühlung</a></li>            -->
    	</ul>
	</div>
</div>    
	<div id="content">
		<?php
		$seite = (isset($_GET['seite']))? $_GET['seite'] : '';
		
		switch ($seite) {
		default : case "energie" : include("energie.php");
		break; 
		case "kuehlung" : include("kuehlung.php");
		break;
		
		
		case "login" : include("inc/login.inc.php");
		
		}
	?>		


		<br clear="all" />
<div id="nachrichten">
		<marquee  onMouseOver="stop()" onMouseOut="start()">
		 <?php 
		 	$ergebnis = mysql_query("SELECT Nachricht FROM d00f5eb0.msg as MSG WHERE MSG.anz_bis>= NOW() AND MSG.public=1 ORDER BY last_update DESC");
			while($row = mysql_fetch_object($ergebnis))
  				{
		?>
			
				<div style="float:left; padding-right:40px; ">
					<div class="Nachricht"> +++ <?php echo $row->Nachricht; ?> +++ </div>
				</div>
<?php
	}
	?>
			</marquee>
		</div>

<div id="ticker">
<?php
include('ticker.php');  
?>
</div> 

		</div>
	
  </body>
</html>
