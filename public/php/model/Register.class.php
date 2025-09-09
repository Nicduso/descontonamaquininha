<?php
  class Register {
    private $id;
		private $brandId;
		private $brandName;
		private $brandColor;
		private $textColor;
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

		public function setBrandId($brandId) {
			$this->brandId = $brandId;
		}

		public function getBrandId() {
			return $this->brandId;
		}

		public function setBrandName($brandName) {
			$this->brandName = $brandName;
		}

		public function getBrandName() {
			return $this->brandName;
		}

		public function setBrandColor($brandColor) {
			$this->brandColor = $brandColor;
		}

		public function getBrandColor() {
			return $this->brandColor;
		}

		public function setTextColor($textColor) {
			$this->textColor = $textColor;
		}

		public function getTextColor() {
			return $this->textColor;
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
