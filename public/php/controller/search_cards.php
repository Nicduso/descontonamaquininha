<?php
	require_once ("DAO.class.php");

	$query = $_GET['query'] ?? '';
	$brand = $_GET['brand_name'] ?? '';

	$dao = new DAO();
	$results = $dao->search($query, $brand);

	foreach ($results as $product) {
		$discount = intval($product['discount']);
		$title = htmlspecialchars($product['title']);
		$brandName = htmlspecialchars($product['brand_name']);
		$link = htmlspecialchars($product['link_promo']);
		$photo = htmlspecialchars($product['photo']);
		$details = htmlspecialchars($product['more_info']);
		$color = htmlspecialchars($product['color_brand']);
		$colorText = htmlspecialchars($product['color_text']);

		echo "<div class='card-item'>
				<div class='card-content' style='background-color: {$color}; color: {$colorText};'>
					<img class='machine-image' src='{$photo}' alt='maquininha {$brandName}'>
					<h2 class='machine-title'>Você ganhou {$discount}% na sua {$title}!</h2>
					<a class='machine-link' href='{$link}' target='_blank'>Compre com desconto aqui!</a>
				</div>
				<button class='card-more' onclick='showDetails(`{$details}`)'>Detalhes</button>
			</div>";
	}
?>
