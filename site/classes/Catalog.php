<?php
/**
 * Catalog: the collection of all products.
 * Administrator edits (price and stock) are kept in the session as
 * "overrides" and layered on top of the base data. The final assignment
 * will replace the overrides with UPDATE statements on the database.
 */
class Catalog
{
    private $products = array();

    public function __construct(array $rows, array $overrides = array())
    {
        foreach ($rows as $id => $row) {
            if (isset($overrides[$id]) && is_array($overrides[$id])) {
                $row = array_merge($row, $overrides[$id]);
            }
            $this->products[(int) $id] = new Product($id, $row);
        }
    }

    /** @return Product[] */
    public function all()
    {
        return $this->products;
    }

    /** @return Product|null */
    public function find($id)
    {
        $id = (int) $id;
        return isset($this->products[$id]) ? $this->products[$id] : null;
    }

    /** @return string[] sorted list of distinct category names */
    public function categories()
    {
        $list = array();
        foreach ($this->products as $product) {
            $list[$product->getCategory()] = true;
        }
        $names = array_keys($list);
        sort($names);
        return $names;
    }

    /** @return Product[] products in one category, or all when $category is empty */
    public function inCategory($category)
    {
        if ($category === '' || $category === null) {
            return $this->products;
        }
        $found = array();
        foreach ($this->products as $id => $product) {
            if ($product->getCategory() === $category) {
                $found[$id] = $product;
            }
        }
        return $found;
    }
}
