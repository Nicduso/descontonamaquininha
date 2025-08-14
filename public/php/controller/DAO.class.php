<?php
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

		public function search($title) {
			try {
				$sql = "SELECT * FROM products WHERE title LIKE :title";
				$p_sql = Connection::getInstance()-> prepare($sql);
				$p_sql->bindValue(":title", "%{$title}%");
				$p_sql->execute();
				$list = $p_sql->fetchAll(PDO::FETCH_ASSOC);

				return $list;
			} catch(Exception $e) {
				echo "Erro ao consultar Registro".$e->getMessage();
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
	}
?>
