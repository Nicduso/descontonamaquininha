<?php foreach ($products as $product):
	$bgClass = 'bg-' . str_replace('#', '', $product->getBrandColor());
	$textClass = 'text-' . str_replace('#', '', $product->getTextColor());
?>
	<div class="card-item">
		<div class="card-content <?= $bgClass ?> <?= $textClass ?>">
			<img class="machine-image" src="<?= $product->getPhoto() ?>" alt="maquininha <?= htmlspecialchars($product->getBrandName()) ?>">
			<h2 class="machine-title">Você ganhou <?= intval($product->getDiscount()) ?>% na sua <?= htmlspecialchars($product->getTitle()) ?>!</h2>
			<a class="machine-link" href="<?= htmlspecialchars($product->getLinkPromo()) ?>">Compre com desconto aqui!</a>
		</div>
		<button class="card-more">Detalhes</button>
	</div>
<?php endforeach; ?>
