<?php
	require_once("DAO.class.php");

	$productId = $_GET['product_id'] ?? null;
	$dao = new DAO();

	if ($productId) {
		$taxes = $dao->getTaxesByProductId($productId);
		echo json_encode($taxes);
	} else {
		echo json_encode([]);
	}
?>
