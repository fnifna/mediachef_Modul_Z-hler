Aktuelle Angebote

<marquee  onMouseOver="stop()" onMouseOut="start()">
	<table cellspacing="0" cellpadding="0" style="table-layout:fixed">
    <tr>
	<?php 
	$now= date('Y',time())."-".date('m',time())."-".date('d',time());
  	error_reporting(E_ALL);
    try
    {
    	
    	/*** DB erstellen ***/
 		$dbh = new PDO("mysql:host=roddeck.net;dbname=d00f5eb0",'d00f5eb0', 'ticker');

        /*** set all errors to excptions ***/
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT a.artikel, a.preis, a.einheit, b.Anbieter FROM ang a, anb b WHERE a.Nutzer=b.id AND anz_bis>='".$now."' AND public=1 ORDER BY last_update DESC";
        $result = $dbh->query($sql);
		$i=0;
		foreach($result as $row) {
	?>
	<td class="ticker">
		<div class="Anbieter"><?php echo $row['Anbieter']; ?></div>
		<div class="Produkt"> +++ <?php echo $row['artikel']." - ".$row['preis']."/".$row['einheit']; ?> +++ </div>
	</td>
	<?php
}
  }
    catch(Exception $e)
    {
        echo $e->getMessage();
    }
?>
	</tr>
    </table>
</marquee>  