<?php
require_once ("DAO.class.php");

$dao = new DAO();
$title = $_GET['title'] ?? '';
$products = $dao->search($title);

foreach ($products as $product) {
$json = htmlspecialchars(json_encode($product), ENT_QUOTES, 'UTF-8');
	echo "<tr class='content-row'>";
	echo "<td class='table-content'>{$product['id']}</td>";
	echo "<td class='table-content'>{$product['brand_name']}</td>";
	echo "<td class='table-content'>{$product['title']}</td>";
	echo "<td class='table-content'>
			<a href='product_registration.php?delete={$product['id']}'><i class='material-icons delete-icon'>delete</i></a></td>";
	echo "<td class='table-content'>
			<button onclick='fillForm($json)' class='edit-icon'><i class='material-icons'>edit</i></button></td>";
	echo "</tr>";
}
?>
