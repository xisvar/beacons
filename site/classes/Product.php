<?php
/**
 * Product: one item for sale in the Mission Store.
 * Wraps a row from the products array (later, a row from the products table).
 */
class Product
{
    private $id;
    private $name;
    private $category;
    private $priceCents;
    private $stock;
    private $image;
    private $short;
    private $description;

    public function __construct($id, array $row)
    {
        $this->id          = (int) $id;
        $this->name        = $row['name'];
        $this->category    = $row['category'];
        $this->priceCents  = (int) $row['price_cents'];
        $this->stock       = (int) $row['stock'];
        $this->image       = $row['image'];
        $this->short       = $row['short'];
        $this->description = $row['description'];
    }

    public function getId()          { return $this->id; }
    public function getName()        { return $this->name; }
    public function getCategory()    { return $this->category; }
    public function getPriceCents()  { return $this->priceCents; }
    public function getStock()       { return $this->stock; }
    public function getImage()       { return $this->image; }
    public function getShort()       { return $this->short; }
    public function getDescription() { return $this->description; }

    public function getPrice()
    {
        return money($this->priceCents);
    }

    public function inStock()
    {
        return $this->stock > 0;
    }

    /** Friendly stock label used on the product list and detail pages. */
    public function stockLabel()
    {
        if ($this->stock <= 0) {
            return 'Out of stock';
        }
        if ($this->stock <= 10) {
            return 'Only ' . $this->stock . ' left';
        }
        return $this->stock . ' in stock';
    }
}
