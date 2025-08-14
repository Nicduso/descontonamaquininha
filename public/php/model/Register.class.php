<?php
  class Register {
    private $id;
		private $brand;
		private $title;
		private $discount;
		private $link_promo;
		private $more_info;
		private $photo;

		public function setID($id) {
			$this->id = $id;
		}

		public function getID() {
			return $this->id;
		}

		public function setBrand($brand) {
			$this->brand = $brand;
		}

		public function getBrand() {
			return $this->brand;
		}

		public function setTitle($title) {
			$this->title = $title;
		}

		public function getTitle() {
			return $this->title;
		}

		public function setDiscount($discount) {
			$this->discount = $discount;
		}

		public function getDiscount() {
			return $this->discount;
		}

		public function setLinkPromo($link_promo) {
			$this->link_promo = $link_promo;
		}

		public function getLinkPromo() {
			return $this->link_promo;
		}

		public function setMoreInfo($more_info) {
			$this->more_info = $more_info;
		}

		public function getMoreInfo() {
			return $this->more_info;
		}

		public function setPhoto($photo) {
			$this->photo = $photo;
		}

		public function getPhoto() {
			return $this->photo;
		}
	}
?>
