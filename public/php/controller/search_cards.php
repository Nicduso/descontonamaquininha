<?php
	require_once ("DAO.class.php");

	$query = $_GET['query'] ?? '';
	$brand = $_GET['brand'] ?? '';

	$dao = new DAO();
	$results = $dao->search($query, $brand);

	foreach ($results as $product) {
		$discount = intval($product['discount']);
		$title = htmlspecialchars($product['title']);
		$brandName = htmlspecialchars($product['brand']);
		$link = htmlspecialchars($product['link_promo']);
		$photo = htmlspecialchars($product['photo']);
		$brandClass = strtolower(str_replace(' ', '-', $product['brand']));
		$details = htmlspecialchars($product['more_info']);

		echo "<div class='card-item'>
				<div class='card-content {$brandClass}'>
					<img class='machine-image' src='{$photo}' alt='maquininha {$brandName}'>
					<h2 class='machine-title {$brandClass}'>Você ganhou {$discount}% na sua {$title}!</h2>
					<a class='machine-link' href='{$link}' target='_blank'>Compre com desconto aqui!</a>
				</div>
				<button class='card-more' onclick='showDetails(`{$details}`)'>Detalhes</button>
			</div>";
	}
?>
