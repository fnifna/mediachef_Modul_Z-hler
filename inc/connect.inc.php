<?php
$link = mysql_connect('roddeck.net', 'd00f5eb0', 'ticker');
if (!$link) {
    die('keine Verbindung möglich: ' . mysql_error());
}
?>