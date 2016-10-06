<?php

namespace ShowOrdersBundle\Entity;

/**
 * Products
 */
class Products
{
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
    private $dateCreate = 'CURRENT_TIMESTAMP';


	private $products;
	
	public function __construct()
    {
        $this->products = new ArrayCollection();
    }
	
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
     * Set name
     *
     * @param string $name
     *
     * @return Products
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Products
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
     * Set dateCreate
     *
     * @param \DateTime $dateCreate
     *
     * @return Products
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $orders;


    /**
     * Add order
     *
     * @param \ShowOrdersBundle\Entity\Products $order
     *
     * @return Products
     */
    public function addOrder(\ShowOrdersBundle\Entity\Products $order)
    {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \ShowOrdersBundle\Entity\Products $order
     */
    public function removeOrder(\ShowOrdersBundle\Entity\Products $order)
    {
        $this->orders->removeElement($order);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrders()
    {
        return $this->orders;
    }
}
