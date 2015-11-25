<?php
namespace SoftwareEngineerTest;

// Question 1a

$DB_HOST = 'localhost';
$DB_NAME = 'phptest';
$DB_USER = 'root';
$DB_PASS = '';

if(!($dbl = mysql_connect($DB_HOST, $DB_USER, $DB_PASS))){
	throw new \Exception('Can\'t connect to host with specified credentials');
}
if(!mysql_select_db($DB_NAME, $dbl)) {
	throw new \Exception('Can\'t not select database.');
}

// write your sql to get customer_data here
$sql = "SELECT *, IFNULL(occupation_name,'un-employed') occupation_name FROM `customer` LEFT JOIN `customer_occupation` USING (customer_occupation_id)";

$conditions = array();
foreach(array('occupation_name') as $search_field){
	if(isset($_GET[$search_field])){
		$conditions[] = " $search_field='".mysql_real_escape_string($_GET[$search_field])."'";
	}
}
if(count($conditions)){
	$sql .= ' WHERE '.implode(' AND ', $conditions);
}

$result = mysql_query($sql);
if(mysql_num_rows($result) == 0) {
	echo 'No data found';
	exit;
}
?>

<h2>Customer List</h2>

<table>
	<tr>
		<th>Customer ID</th>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Occupation</th>
	</tr>
	<?php
	while($row = mysql_fetch_assoc($result)){
		echo '<tr>';
		foreach(
			array(
				'customer_id',
				'first_name',
				'last_name',
				'occupation_name'
				) as $field)
			echo '<td>'.htmlspecialchars($row[$field]).'</td>';
		echo '</tr>';
	}

?>
</table>
