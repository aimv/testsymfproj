<?php

namespace ViewOrdersBundle\Entity;

/**
 * Customers
 */
class Customers {

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
	private $lastname;

	/**
	 * @var string
	 */
	private $email;

	/**
	 * @var \DateTime
	 */
	private $dateCreate; //= 'CURRENT_TIMESTAMP';

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
	 * @return Customers
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
	 * Set lastname
	 *
	 * @param string $lastname
	 *
	 * @return Customers
	 */
	public function setLastname($lastname) {
		$this->lastname = $lastname;

		return $this;
	}

	/**
	 * Get lastname
	 *
	 * @return string
	 */
	public function getLastname() {
		return $this->lastname;
	}

	/**
	 * Set email
	 *
	 * @param string $email
	 *
	 * @return Customers
	 */
	public function setEmail($email) {
		$this->email = $email;

		return $this;
	}

	/**
	 * Get email
	 *
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Set dateCreate
	 *
	 * @param \DateTime $dateCreate
	 *
	 * @return Customers
	 */
	//public function setDateCreate($dateCreate)
	//{
	//    $this->dateCreate = $dateCreate;
	//    return $this;
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
		return $this->getName() . " " . $this->getLastname() . " (ID" . $this->getId() . ")";
	}

}
