<?php foreach ($products as $product): ?>
	<div class="card-item">
		<div class="card-content" style="background-color: <?php echo $product->getBrandColor(); ?>;">
			<img class="machine-image" src="<?= $product->getPhoto() ?>" alt="maquininha <?= htmlspecialchars($product->getBrandName()) ?>">
			<h2 class="machine-title" style="color: <?php echo $product->getTextColor(); ?>;">Você ganhou <?= intval($product->getDiscount()) ?>% na sua <?= htmlspecialchars($product->getTitle()) ?>!</h2>
			<a class="machine-link" target="_blank" href="<?= htmlspecialchars($product->getLinkPromo()) ?>">Compre com desconto aqui!</a>
		</div>
		<button class="card-more" onclick="showDetails(`<?= htmlspecialchars($product->getMoreInfo(), ENT_QUOTES); ?>`)">Detalhes</button>
	</div>
<?php endforeach; ?>
