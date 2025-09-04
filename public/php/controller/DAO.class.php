<?php
	require_once __DIR__ . '/../model/Connection.class.php';
	class DAO {
		public function insert($products) {
			try {
				$sql = "INSERT INTO products(brand, title, discount, link_promo, more_info, photo) VALUES(:brand, :title, :discount, :link_promo, :more_info, :photo)";
				$p_sql = Connection::getInstance()->prepare($sql);
				$p_sql->bindValue(':brand', $products->getBrand());
				$p_sql->bindValue(':title', $products->getTitle());
				$p_sql->bindValue(':discount', $products->getDiscount());
				$p_sql->bindValue(':link_promo', $products->getLinkPromo());
				$p_sql->bindValue(':more_info', $products->getMoreInfo());
				$p_sql->bindValue(':photo', $products->getPhoto());

				return $p_sql->execute();
			} catch(Exception $e) {
				echo "Erro ao registrar: ".$e->getMessage();
			}
		}

	public function search($query = '', $brandFilter = '') {
		try {
			$sql = "SELECT * FROM products WHERE (title LIKE :query OR brand LIKE :query)";
			if (!empty($brandFilter)) {
				$sql .= " AND brand = :brandFilter";
			}

			$p_sql = Connection::getInstance()->prepare($sql);
			$p_sql->bindValue(":query", "%{$query}%");
			if (!empty($brandFilter)) {
				$p_sql->bindValue(":brandFilter", $brandFilter);
			}
			$p_sql->execute();

			return $p_sql->fetchAll(PDO::FETCH_ASSOC);
		} catch(Exception $e) {
			echo "Erro ao consultar Registro: " . $e->getMessage();
			return [];
		}
	}

		public function delete($id) {
			try {
				$sql = "DELETE FROM products WHERE id = :id";
				$p_sql = Connection::getInstance()-> prepare($sql);
				$p_sql->bindValue(":id", $id);

				return $p_sql->execute();
			} catch(Exception $e) {
				echo "Não foi possível excluir.".$e->getMessage();
			}
		}

		public function modify($id, Register $products) {
			try {
				$sql = "UPDATE products SET brand = :brand, title = :title, discount = :discount, link_promo = :link_promo, more_info = :more_info, photo = :photo WHERE id = :id";
				$p_sql = Connection::getInstance()->prepare($sql);

				$p_sql->bindValue(":id", $id);
				$p_sql->bindValue(':brand', $products->getBrand());
				$p_sql->bindValue(':title', $products->getTitle());
				$p_sql->bindValue(':discount', $products->getDiscount());
				$p_sql->bindValue(':link_promo', $products->getLinkPromo());
				$p_sql->bindValue(':more_info', $products->getMoreInfo());
				$p_sql->bindValue(':photo', $products->getPhoto());

				return $p_sql->execute();
			} catch (Exception $e) {
				echo "Erro ao alterar Registro: " . $e->getMessage();
			}
		}

		public function listAll() {
			try {
				$sql = "SELECT * FROM products";
				$p_sql = Connection::getInstance()->prepare($sql);
				$p_sql->execute();

				$results = $p_sql->fetchAll(PDO::FETCH_ASSOC);
				$products = [];

				foreach ($results as $row) {
					$product = new Register();
					$product->setBrand($row['brand']);
					$product->setTitle($row['title']);
					$product->setDiscount($row['discount']);
					$product->setLinkPromo($row['link_promo']);
					$product->setMoreInfo($row['more_info']);
					$product->setPhoto($row['photo']);

					$products[] = $product;
				}

				return $products;
			} catch (Exception $e) {
				echo "Erro ao listar produtos: " . $e->getMessage();
				return [];
			}
		}

		public function getUniqueBrands() {
			try {
				$sql = "SELECT DISTINCT brand FROM products ORDER BY brand ASC";
				$p_sql = Connection::getInstance()->prepare($sql);
				$p_sql->execute();

				return $p_sql->fetchAll(PDO::FETCH_COLUMN); 
			} catch (Exception $e) {
				echo "Erro ao buscar operadoras: " . $e->getMessage();
				return [];
			}
		}
	}
?>
