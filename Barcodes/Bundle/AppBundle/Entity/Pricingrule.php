<?php

namespace Barcodes\Bundle\AppBundle\Entity;

/**
 * Pricingrule
 */
class Pricingrule
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string|null
     */
    private $manufacturer;

    /**
     * @var string|null
     */
    private $category;

    /**
     * @var string|null
     */
    private $product;

    /**
     * @var string
     */
    private $pricetype;

    /**
     * @var string
     */
    private $operator;

    /**
     * @var int
     */
    private $value;

    /**
     * @var string
     */
    private $channel;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set manufacturer.
     *
     * @param string|null $manufacturer
     *
     * @return Pricingrule
     */
    public function setManufacturer($manufacturer = null)
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * Get manufacturer.
     *
     * @return string|null
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * Set category.
     *
     * @param string|null $category
     *
     * @return Pricingrule
     */
    public function setCategory($category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category.
     *
     * @return string|null
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set product.
     *
     * @param string|null $product
     *
     * @return Pricingrule
     */
    public function setProduct($product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product.
     *
     * @return string|null
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set pricetype.
     *
     * @param string $pricetype
     *
     * @return Pricingrule
     */
    public function setPricetype($pricetype)
    {
        $this->pricetype = $pricetype;

        return $this;
    }

    /**
     * Get pricetype.
     *
     * @return string
     */
    public function getPricetype()
    {
        return $this->pricetype;
    }

    /**
     * Set operator.
     *
     * @param string $operator
     *
     * @return Pricingrule
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;

        return $this;
    }

    /**
     * Get operator.
     *
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * Set value.
     *
     * @param int $value
     *
     * @return Pricingrule
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value.
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set channel.
     *
     * @param string $channel
     *
     * @return Pricingrule
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * Get channel.
     *
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Pricingrule
     */
    public function setCreatedAt($createdAt = null)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return Pricingrule
     */
    public function setUpdatedAt($updatedAt = null)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
