<?php
require_once ("../controller/DAO.class.php");

$dao = new DAO();
$title = $_GET['title'] ?? '';
$products = $dao->search($title);

foreach ($products as $product) {
	echo "<tr class='content-row'>";
	echo "<td class='table-content'>{$product['id']}</td>";
	echo "<td class='table-content'>{$product['brand']}</td>";
	echo "<td class='table-content'>{$product['title']}</td>";
	echo "<td class='table-content'>
		<a href='?delete={$product['id']}'><i class='material-icons delete-icon'>delete</i></a>
		<button onclick='fillForm(".json_encode($product).")'><i class='material-icons edit-icon'>edit</i></button>
	</td>";
	echo "</tr>";
}
?>
