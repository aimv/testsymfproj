<?php

namespace ViewOrdersBundle\Entity;

/**
 * Products
 */
class Products {

	/**
	 * @var integer
	 */
	private $id;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $price;

	/**
	 * @var \DateTime
	 */
	private $dateCreate;// = 'CURRENT_TIMESTAMP';

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set name
	 *
	 * @param string $name
	 *
	 * @return Products
	 */
	public function setName($name) {
		$this->name = $name;

		return $this;
	}

	/**
	 * Get name
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Set price
	 *
	 * @param string $price
	 *
	 * @return Products
	 */
	public function setPrice($price) {
		$this->price = $price;

		return $this;
	}

	/**
	 * Get price
	 *
	 * @return string
	 */
	public function getPrice() {
		return $this->price;
	}

	/**
	 * Set dateCreate
	 *
	 * @param \DateTime $dateCreate
	 *
	 * @return Products
	 */
	//public function setDateCreate($dateCreate) {
	//	$this->dateCreate = $dateCreate;

	//	return $this;
	//}

	/**
	 * Get dateCreate
	 *
	 * @return \DateTime
	 */
	public function getDateCreate() {
		return $this->dateCreate;
	}
	
	public function setDateCreateValue() {
		$this->dateCreate = new \DateTime();
		return $this;
	}
	
	/**
	 * @var \DateTime
	 */
	private $dateUpdate; // = 'CURRENT_TIMESTAMP';

	/**
	 * Set dateUpdate
	 *
	 * @param \DateTime $dateUpdate
	 *
	 * @return Customers
	 */
	//public function setDateUpdate($dateUpdate)
	//{
	//    $this->dateUpdate = $dateUpdate;
	//    return $this;
	//}

	/**
	 * Get dateUpdate
	 *
	 * @return \DateTime
	 */
	public function getDateUpdate() {
		return $this->dateUpdate;
	}

	public function setDateUpdateValue() {
		$this->dateUpdate = new \DateTime();
		return $this;
	}	

	function __toString() {
		return $this->getName() . " (ID" . $this->getId() . ")";
	}

}
