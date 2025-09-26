<?php
	require_once __DIR__ . '/../model/Connection.class.php';
	require_once __DIR__ . '/../model/Register.class.php';

	class DAO {
		public function insert(Register $product) {
			try {
				$sql = "INSERT INTO products (
					brand_id, title, discount, link_promo, more_info, photo,
					includes, screen, resolution, battery, connections,
					processor, weight, dimensions, memories, operating_system, free_shipping
				) VALUES (
					:brand_id, :title, :discount, :link_promo, :more_info, :photo,
					:includes, :screen, :resolution, :battery, :connections,
					:processor, :weight, :dimensions, :memories, :operating_system, :free_shipping
				)";

				$p_sql = Connection::getInstance()->prepare($sql);
				$p_sql->bindValue(':brand_id', $product->getBrandId());
				$p_sql->bindValue(':title', $product->getTitle());
				$p_sql->bindValue(':discount', $product->getDiscount());
				$p_sql->bindValue(':link_promo', $product->getLinkPromo());
				$p_sql->bindValue(':more_info', $product->getMoreInfo());
				$p_sql->bindValue(':photo', $product->getPhoto());
				$p_sql->bindValue(':includes', $product->getIncludes());
				$p_sql->bindValue(':screen', $product->getScreen());
				$p_sql->bindValue(':resolution', $product->getResolution());
				$p_sql->bindValue(':battery', $product->getBattery());
				$p_sql->bindValue(':connections', $product->getConnections());
				$p_sql->bindValue(':processor', $product->getProcessor());
				$p_sql->bindValue(':weight', $product->getWeight());
				$p_sql->bindValue(':dimensions', $product->getDimensions());
				$p_sql->bindValue(':memories', $product->getMemories());
				$p_sql->bindValue(':operating_system', $product->getOperatingSystem());
				$p_sql->bindValue(':free_shipping', $product->getFreeShipping());

				$p_sql->execute();
				return Connection::getInstance()->lastInsertId();
			} catch(Exception $e) {
				echo "Erro ao registrar produto: " . $e->getMessage();
			}
		}

		public function insertTax($tax) {
			try {
				$sql = "INSERT INTO taxes (billing, debit, credit, other)
						VALUES (:billing, :debit, :credit, :other)";
				$p_sql = Connection::getInstance()->prepare($sql);
				$p_sql->bindValue(':billing', $tax['billing']);
				$p_sql->bindValue(':debit', $tax['debit']);
				$p_sql->bindValue(':credit', $tax['credit']);
				$p_sql->bindValue(':other', $tax['other']);

				$p_sql->execute();
				return Connection::getInstance()->lastInsertId();
			} catch(Exception $e) {
				echo "Erro ao registrar taxa: " . $e->getMessage();
			}
		}

		public function linkProductTax($productId, $taxId) {
			try {
				$sql = "INSERT INTO technical_taxes (product_id, tax_id)
						VALUES (:product_id, :tax_id)";
				$p_sql = Connection::getInstance()->prepare($sql);
				$p_sql->bindValue(':product_id', $productId);
				$p_sql->bindValue(':tax_id', $taxId);
				return $p_sql->execute();
			} catch(Exception $e) {
				echo "Erro ao vincular taxa ao produto: " . $e->getMessage();
			}
		}

		public function insertFull(Register $product, array $taxes) {
			try {
				$conn = Connection::getInstance();
				$conn->beginTransaction();

				$productId = $this->insert($product);
				$product->setId($productId);

				foreach ($taxes as $tax) {
					$taxId = $this->insertTax($tax);
					$this->linkProductTax($productId, $taxId);
				}

				$conn->commit();
			} catch(Exception $e) {
				$conn->rollBack();
				echo "Erro ao cadastrar produto completo: " . $e->getMessage();
			}
		}

		public function search($query = '', $brandFilter = '') {
			try {
				$sql = "
					SELECT
						p.id AS product_id,
						p.title,
						p.discount,
						p.link_promo,
						p.more_info,
						p.photo,
						p.includes,
						p.screen,
						p.resolution,
						p.battery,
						p.connections,
						p.processor,
						p.weight,
						p.dimensions,
						p.memories,
						p.operating_system,
						p.free_shipping,
						b.brand_name,
						b.color_brand,
						b.color_text
					FROM products p
					JOIN brands b ON p.brand_id = b.id
					WHERE (p.title LIKE :query OR b.brand_name LIKE :query)
				";

				if (!empty($brandFilter)) {
					$sql .= " AND b.brand_name = :brandFilter";
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
				$conn = Connection::getInstance();

				$sqlUnlink = "DELETE FROM technical_taxes WHERE product_id = :id";
				$stmtUnlink = $conn->prepare($sqlUnlink);
				$stmtUnlink->bindValue(":id", $id);
				$stmtUnlink->execute();

				$sqlProd = "DELETE FROM products WHERE id = :id";
				$stmtProd = $conn->prepare($sqlProd);
				$stmtProd->bindValue(":id", $id);
				return $stmtProd->execute();

			} catch(Exception $e) {
				echo "Não foi possível excluir: " . $e->getMessage();
			}
		}

		public function modifyFull($productId, Register $product, array $taxes) {
			try {
				$conn = Connection::getInstance();
				$conn->beginTransaction();

				$sqlProduct = "UPDATE products SET
					brand_id = :brand_id,
					title = :title,
					discount = :discount,
					link_promo = :link_promo,
					more_info = :more_info,
					photo = :photo,
					includes = :includes,
					screen = :screen,
					resolution = :resolution,
					battery = :battery,
					connections = :connections,
					processor = :processor,
					weight = :weight,
					dimensions = :dimensions,
					memories = :memories,
					operating_system = :operating_system,
					free_shipping = :free_shipping
					WHERE id = :id";

				$p_sql = $conn->prepare($sqlProduct);
				$p_sql->bindValue(':id', $productId);
				$p_sql->bindValue(':brand_id', $product->getBrandId());
				$p_sql->bindValue(':title', $product->getTitle());
				$p_sql->bindValue(':discount', $product->getDiscount());
				$p_sql->bindValue(':link_promo', $product->getLinkPromo());
				$p_sql->bindValue(':more_info', $product->getMoreInfo());
				$p_sql->bindValue(':photo', $product->getPhoto());
				$p_sql->bindValue(':includes', $product->getIncludes());
				$p_sql->bindValue(':screen', $product->getScreen());
				$p_sql->bindValue(':resolution', $product->getResolution());
				$p_sql->bindValue(':battery', $product->getBattery());
				$p_sql->bindValue(':connections', $product->getConnections());
				$p_sql->bindValue(':processor', $product->getProcessor());
				$p_sql->bindValue(':weight', $product->getWeight());
				$p_sql->bindValue(':dimensions', $product->getDimensions());
				$p_sql->bindValue(':memories', $product->getMemories());
				$p_sql->bindValue(':operating_system', $product->getOperatingSystem());
				$p_sql->bindValue(':free_shipping', $product->getFreeShipping());
				$p_sql->execute();

				$conn->prepare("DELETE FROM technical_taxes WHERE product_id = :product_id")
					->execute([':product_id' => $productId]);

				foreach ($taxes as $tax) {
					$taxId = $this->insertTax($tax);
					$this->linkProductTax($productId, $taxId);
				}

				$conn->commit();
				return true;

			} catch (Exception $e) {
				$conn->rollBack();
				echo "Erro ao modificar dados completos: " . $e->getMessage();
				return false;
			}
		}

		public function listAll() {
			try {
				$sql = "SELECT
							p.*,
							b.brand_name,
							b.color_brand,
							b.color_text
						FROM products p
						JOIN brands b ON p.brand_id = b.id";

				$p_sql = Connection::getInstance()->prepare($sql);
				$p_sql->execute();

				$results = $p_sql->fetchAll(PDO::FETCH_ASSOC);
				$products = [];

				foreach ($results as $row) {
					$product = new Register();
					$product->setId($row['id']);
					$product->setBrandName($row['brand_name']);
					$product->setBrandColor($row['color_brand']);
					$product->setTextColor($row['color_text']);
					$product->setTitle($row['title']);
					$product->setDiscount($row['discount']);
					$product->setLinkPromo($row['link_promo']);
					$product->setMoreInfo($row['more_info']);
					$product->setPhoto($row['photo']);
					$product->setIncludes($row['includes']);
					$product->setScreen($row['screen']);
					$product->setResolution($row['resolution']);
					$product->setBattery($row['battery']);
					$product->setConnections($row['connections']);
					$product->setProcessor($row['processor']);
					$product->setWeight($row['weight']);
					$product->setDimensions($row['dimensions']);
					$product->setMemories($row['memories']);
					$product->setOperatingSystem($row['operating_system']);
					$product->setFreeShipping($row['free_shipping']);

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
            $sql = "SELECT DISTINCT brand_name FROM brands ORDER BY brand_name ASC";
            $p_sql = Connection::getInstance()->prepare($sql);
            $p_sql->execute();

            return $p_sql->fetchAll(PDO::FETCH_COLUMN);
        } catch (Exception $e) {
            echo "Erro ao buscar marcas: " . $e->getMessage();
            return [];
        }
    }

		public function getOrCreateBrandId($brandName) {
			try {
				$conn = Connection::getInstance();
				$sql = "SELECT id FROM brands WHERE brand_name = :brand_name LIMIT 1";
				$stmt = $conn->prepare($sql);
				$stmt->bindValue(':brand_name', $brandName);
				$stmt->execute();
				$result = $stmt->fetch(PDO::FETCH_ASSOC);

				if ($result) {
					return $result['id'];
				}

				$insert = "INSERT INTO brands (brand_name) VALUES (:brand_name)";
				$insertStmt = $conn->prepare($insert);
				$insertStmt->bindValue(':brand_name', $brandName);
				$insertStmt->execute();

				return $conn->lastInsertId();
			} catch (Exception $e) {
				echo "Erro ao buscar ou criar marca: " . $e->getMessage();
				return null;
			}
		}

		public function getTaxesByProductId($productId) {
			try {
				$sql = "SELECT
							t.id AS tax_id,
							t.billing,
							t.debit,
							t.credit,
							t.other
						FROM technical_taxes tt
						JOIN taxes t ON tt.tax_id = t.id
						WHERE tt.product_id = :product_id";

				$stmt = Connection::getInstance()->prepare($sql);
				$stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
				$stmt->execute();
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (Exception $e) {
				return [];
			}
		}
	}
?>
