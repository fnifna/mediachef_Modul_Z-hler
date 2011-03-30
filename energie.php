<!-- GOOGLE START  --> 
		<script type='text/javascript' src='https://www.google.com/jsapi'></script>
		<script type='text/javascript'>
		
<!--  ###### Spitzenlast  ######   -->
			google.load('visualization', '1', {packages:['gauge']});
			google.setOnLoadCallback(drawChart);
			function drawChart() {
			  var data = new google.visualization.DataTable();
			  var stand = <?php echo $proz_spitze=proz_spitze(); ?>;  // prozentualer Anteil an der Spitzenlast
			  data.addColumn('string', 'Label');
			  data.addColumn('number', 'Value');
			  data.addRows(1);
			  data.setValue(0, 0, '%');
			  data.setValue(0, 1, stand);        
			 
			  var chart = new google.visualization.Gauge(document.getElementById('chart_div'));
			  var options = {width: 600, height: 120, redFrom: 90, redTo: 100,yellowFrom:75, yellowTo: 90, minorTicks: 5};
			  chart.draw(data, options);
			}
			
<!--  ######  Diagramm   ########  -->      
			google.load('visualization', '1', {packages: ['corechart']});
			function drawVisualization() {
			  // Create and populate the data table.
			  var data = new google.visualization.DataTable();
			  data.addColumn('string', 'x');
			  data.addColumn('number', 'kW');
						  
			<?php
			  	
				$startdate=startdate();
				
				error_reporting(E_ALL);
				try {
					/*** DB erstellen ***/
					$dbh = new PDO("sqlite:inc/db/zaehler.sqlite");
					/*** set all errors to excptions ***/
					$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
					$sql = "SELECT kwh FROM energielog WHERE date <".$startdate." ORDER BY OID DESC LIMIT 1";
					$result = $dbh->query($sql);
					foreach($result as $row) {
						$letzter_eintrag=$row['kwh'];	
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
					
					$sql = "SELECT kwh, time FROM energielog WHERE date >=".$startdate." ORDER BY OID ASC";
					$result = $dbh->query($sql);
					foreach($result as $row) {
						$aktueller_eintrag=str_replace(",",".",$row['kwh']);
						$eintrag=round(($aktueller_eintrag-str_replace(",",".",$letzter_eintrag))*1000,0);
						$time=substr($row['time'],0,2).":".substr($row['time'],2,2);
						echo "data.addRow(['$time', ".$eintrag."]);";
						$letzter_eintrag=$row['kwh'];
					}
				}
				catch(Exception $e)
				{
					echo $e->getMessage();
					die();
				}	
				
				?>        
			
			  // Create and draw the visualization.
			  new google.visualization.LineChart(document.getElementById('visualization')).
			draw(data, {curveType: "function",
			width: 550, height: 300,
			vAxis: {maxValue: 60}}
			 );
			}
			google.setOnLoadCallback(drawVisualization);
</script>
<style type="text/css">
<!--

div#chart_div{
	background-color:
<?php
				if ($proz_spitze>=75 && $proz_spitze<90) {
					echo "yellow"; 
		  		}
		  		elseif($proz_spitze>=90) {	
		  			echo "red"; 
		  		}		 
?>;}
-->
</style>
<?php
$proz_budget_tag=proz_budget_tag();
if ($proz_budget_tag>=75 && $proz_budget_tag<90) {
	$farbe_tag="yellow";	
	}
	elseif ($proz_budget_tag>90) {
			$farbe_tag="red";
		}
		
$proz_budget_monat=proz_budget_monat();
if ($proz_budget_monat>=75 && $proz_budget_monat<90) {
	$farbe_monat="yellow";	
	}
	elseif ($proz_budget_monat>90) {
			$farbe_monat="red";
		}
		
?>


<div id="left">
	<h2>Spitzenlast</h2>
	<div id='chart_div'></div>
</div>

<div id="middle">
	<h2>gesch&auml;tzte Budgetaussch&ouml;pfung</h2>
	<table>
	<tr><td>vom Tagesbudget:</td><td>vom Monatsbudget:</td></tr>
	<tr><td class="budget"><h1 class="prozent" style="color:<?php echo $farbe_tag; ?>;"><?php echo $proz_budget_tag; ?> %</h1></td>
	<td class="budget"><h1  class="prozent" style="color:<?php echo $farbe_monat; ?>;"><?php echo $proz_budget_monat; ?> %</h1></td></tr>	
	</table>	

	<h2>Heute verbraucht</h2>
	<h1 class="euro"><?php echo str_replace('.',',',verbrauch_tag()); ?> &euro; <span style="font-size:0.8em;">von</span> <?php echo str_replace('.',',',$budget_tag); ?> &euro;</h1>
	<h2>bisheriger Monatsverbrauch</h2>
	<h1 class="euro"><?php  echo str_replace('.',',',verbrauch_monat()); ?> &euro; <span style="font-size:0.8em;">von</span> <?php echo str_replace('.',',',$budget_monat); ?> &euro;</h1>
</div>

<div id="right">
	<div id="visualization"></div>
</div>
