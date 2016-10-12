<?php

namespace ViewOrdersBundle\Entity;

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
     * @var \ViewOrdersBundle\Entity\Customers
     */
    private $customer;

    /**
     * @var \ViewOrdersBundle\Entity\Products
     */
    private $product;


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
     * Set customer
     *
     * @param \ViewOrdersBundle\Entity\Customers $customer
     *
     * @return Orders
     */
    public function setCustomer(\ViewOrdersBundle\Entity\Customers $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \ViewOrdersBundle\Entity\Customers
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set product
     *
     * @param \ViewOrdersBundle\Entity\Products $product
     *
     * @return Orders
     */
    public function setProduct(\ViewOrdersBundle\Entity\Products $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \ViewOrdersBundle\Entity\Products
     */
    public function getProduct()
    {
        return $this->product;
    }
}
