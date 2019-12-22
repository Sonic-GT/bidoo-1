<link rel="stylesheet" type="text/css" href="style.css">
<form method="post">
	<input type="text" name="auction" placeholder="Auction Name">
	<button name="btnOK">Ok</button>
</form>

<?php
include_once "mysql_utils.php";

if(isset($_REQUEST['btnOK']))
{
	$auction = $_REQUEST['auction'];
	$parts = split('_', $auction);
	if(ctype_digit($parts[0]))//Check if a string contains numbers
	{
		//Case 1000_Puntate...
		echo "<a href='product_stats.php?product=$parts[1]&value=$parts[0]&btnOK=' target='_blank'>$auction</a>";
	}
	else
	{
		//Case Amazon_100...
		echo "<a href='product_stats.php?product=$parts[0]&value=$parts[1]&btnOK=' target='_blank'>$auction</a>";
	}

	//Utenti che partecipano
	$users = query("SELECT * FROM (SELECT a.id_utente, COUNT(*) AS puntate_usate FROM $auction AS a GROUP BY a.id_utente) AS t ORDER BY t.puntate_usate DESC ");
	$users = $users->fetch_all();
	echo "<table>";
	echo "<tr>";
	echo "<td><b>ID UTENTE</b></td>";
	echo "<td><b>PUNTATE USATE</b></td>";
	echo "</tr>";
	foreach ($users as $key => $value)
	{
		$id_utente = $value[0];
		$puntate_usate = $value[1];
		echo "<tr>";
		echo "<td><a href='user_info.php?id_utente=$id_utente' target='_blank'>$id_utente</a></td>";
		echo "<td>$puntate_usate</td>";
		echo "</tr>";
	}
	echo "</table>";
}
?>