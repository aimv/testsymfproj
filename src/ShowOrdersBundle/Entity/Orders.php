<?php

namespace ShowOrdersBundle\Entity;

/**
 * Orders
 */
class Orders
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $customerId;

    /**
     * @var integer
     */
    private $productId;

    /**
     * @var integer
     */
    private $count;

    /**
     * @var \DateTime
     */
    private $dateCreate = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     */
    private $price;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set customerId
     *
     * @param integer $customerId
     *
     * @return Orders
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * Get customerId
     *
     * @return integer
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Set productId
     *
     * @param integer $productId
     *
     * @return Orders
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * Get productId
     *
     * @return integer
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Set count
     *
     * @param integer $count
     *
     * @return Orders
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set dateCreate
     *
     * @param \DateTime $dateCreate
     *
     * @return Orders
     */
    public function setDateCreate($dateCreate)
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    /**
     * Get dateCreate
     *
     * @return \DateTime
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Orders
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Customers", inversedBy="orders")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    private $customers;


    /**
     * Set customers
     *
     * @param \ShowOrdersBundle\Entity\Customers $customers
     *
     * @return Orders
     */
    public function setCustomers(\ShowOrdersBundle\Entity\Customers $customers = null)
    {
        $this->customers = $customers;

        return $this;
    }

    /**
     * Get customers
     *
     * @return \ShowOrdersBundle\Entity\Customers
     */
    public function getCustomers()
    {
        return $this->customers;
    }
	
	/**
     * @ORM\ManyToOne(targetEntity="Products", inversedBy="orders")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $products;
}
