<?php
require_once __DIR__ . "/DAO.class.php";
require_once __DIR__ . "/../model/Register.class.php";

$query = $_GET['query'] ?? '';
$brand = $_GET['brand_name'] ?? '';

$dao = new DAO();
$results = $dao->search($query, $brand);

$products = [];

foreach ($results as $row) {
	$product = new Register();
	$product->setTitle($row['title']);
	$product->setPhoto($row['photo']);
	$product->setDiscount($row['discount']);
	$product->setBrandName($row['brand_name']);
	$product->setLinkPromo($row['link_promo']);
	$product->setMoreInfo($row['more_info']);
	$product->setBrandColor($row['color_brand']);
	$product->setTextColor($row['color_text']);
	$products[] = $product;
}

include __DIR__ . '/../view/render_cards.php';
?>
