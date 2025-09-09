<?php
require_once __DIR__ . '/../model/Connection.class.php';

class DAO {
    public function insert($products) {
        try {
            $sql = "INSERT INTO products(brand_id, title, discount, link_promo, more_info, photo)
                    VALUES(:brand_id, :title, :discount, :link_promo, :more_info, :photo)";
            $p_sql = Connection::getInstance()->prepare($sql);
            $p_sql->bindValue(':brand_id', $products->getBrandId());
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
            $sql = "SELECT p.*, b.brand_name, b.color_brand, b.color_text
                    FROM products p
                    JOIN brands b ON p.brand_id = b.id
                    WHERE (p.title LIKE :query OR b.brand_name LIKE :query)";
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
            $sql = "DELETE FROM products WHERE id = :id";
            $p_sql = Connection::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);

            return $p_sql->execute();
        } catch(Exception $e) {
            echo "Não foi possível excluir.".$e->getMessage();
        }
    }

    public function modify($id, Register $products) {
        try {
            $sql = "UPDATE products
                    SET brand_id = :brand_id, title = :title, discount = :discount,
                        link_promo = :link_promo, more_info = :more_info, photo = :photo
                    WHERE id = :id";
            $p_sql = Connection::getInstance()->prepare($sql);

            $p_sql->bindValue(":id", $id);
            $p_sql->bindValue(':brand_id', $products->getBrandId());
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
            $sql = "SELECT p.*, b.brand_name, b.color_brand, b.color_text
                    FROM products p
                    JOIN brands b ON p.brand_id = b.id";
            $p_sql = Connection::getInstance()->prepare($sql);
            $p_sql->execute();

            $results = $p_sql->fetchAll(PDO::FETCH_ASSOC);
            $products = [];

            foreach ($results as $row) {
                $product = new Register();
                $product->setBrandName($row['brand_name']);
                $product->setBrandColor($row['color_brand']);
								$product->setTextColor($row['color_text']);
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
            $sql = "SELECT DISTINCT brand_name FROM brands ORDER BY brand_name ASC";
            $p_sql = Connection::getInstance()->prepare($sql);
            $p_sql->execute();

            return $p_sql->fetchAll(PDO::FETCH_COLUMN);
        } catch (Exception $e) {
            echo "Erro ao buscar marcas: " . $e->getMessage();
            return [];
        }
    }
}
?>
