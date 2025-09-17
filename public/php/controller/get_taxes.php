<?php
	require_once("DAO.class.php");

	$brandId = $_GET['brand_id'] ?? null;
	$dao = new DAO();

	if ($brandId) {
		try {
			$conn = Connection::getInstance();
			$sql = "SELECT tt.tax_id, t.billing, t.debit, t.credit, t.other
					FROM technical_taxes tt
					JOIN taxes t ON tt.tax_id = t.id
					JOIN technical tech ON tt.technical_id = tech.id
					WHERE tech.brand_id = :brand_id";
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':brand_id', $brandId);
			$stmt->execute();
			$taxes = $stmt->fetchAll(PDO::FETCH_ASSOC);
			echo json_encode($taxes);
		} catch (Exception $e) {
			echo json_encode([]);
		}
	} else {
		echo json_encode([]);
	}
?>
