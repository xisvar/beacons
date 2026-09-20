<?php
/**
 * Cart: a shopping cart stored in $_SESSION['cart'] as productId => quantity.
 * Money is handled in whole cents. Tax is calculated on the subtotal.
 */
class Cart
{
    private $catalog;

    public function __construct(Catalog $catalog)
    {
        $this->catalog = $catalog;
        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
    }

    /** Add a quantity of a product. Returns array(bool ok, string message). */
    public function add($productId, $qty)
    {
        $product = $this->catalog->find($productId);
        if ($product === null) {
            return array(false, 'That product could not be found.');
        }
        if (!Validator::intBetween($qty, 1, 99)) {
            return array(false, 'Please enter a quantity from 1 to 99.');
        }
        $qty  = (int) $qty;
        $have = isset($_SESSION['cart'][$product->getId()]) ? $_SESSION['cart'][$product->getId()] : 0;
        if ($have + $qty > $product->getStock()) {
            return array(false, 'Sorry, only ' . $product->getStock() . ' of ' . $product->getName() . ' are available.');
        }
        $_SESSION['cart'][$product->getId()] = $have + $qty;
        return array(true, $qty . ' x ' . $product->getName() . ' added to your cart.');
    }

    /** Set the quantity for a product already in the cart. Zero removes it. */
    public function update($productId, $qty)
    {
        $product = $this->catalog->find($productId);
        if ($product === null || !isset($_SESSION['cart'][$product->getId()])) {
            return array(false, 'That item is not in your cart.');
        }
        if (!Validator::intBetween($qty, 0, 99)) {
            return array(false, 'Please enter a quantity from 0 to 99.');
        }
        $qty = (int) $qty;
        if ($qty === 0) {
            return $this->remove($productId);
        }
        if ($qty > $product->getStock()) {
            return array(false, 'Sorry, only ' . $product->getStock() . ' of ' . $product->getName() . ' are available.');
        }
        $_SESSION['cart'][$product->getId()] = $qty;
        return array(true, 'Quantity updated for ' . $product->getName() . '.');
    }

    public function remove($productId)
    {
        $productId = (int) $productId;
        if (!isset($_SESSION['cart'][$productId])) {
            return array(false, 'That item is not in your cart.');
        }
        unset($_SESSION['cart'][$productId]);
        return array(true, 'Item removed from your cart.');
    }

    public function clear()
    {
        $_SESSION['cart'] = array();
    }

    /**
     * Cart lines with current product data. Items that no longer exist are
     * dropped, and quantities are trimmed to current stock.
     * @return array[] each: product, qty, line_cents
     */
    public function lines()
    {
        $lines = array();
        foreach ($_SESSION['cart'] as $id => $qty) {
            $product = $this->catalog->find($id);
            if ($product === null || $product->getStock() < 1) {
                unset($_SESSION['cart'][$id]);
                continue;
            }
            if ($qty > $product->getStock()) {
                $qty = $product->getStock();
                $_SESSION['cart'][$id] = $qty;
            }
            $lines[] = array('product' => $product, 'qty' => (int) $qty, 'line_cents' => $product->getPriceCents() * (int) $qty);
        }
        return $lines;
    }

    public function isEmpty()
    {
        return count($this->lines()) === 0;
    }

    /** Total number of individual items in the cart. */
    public function count()
    {
        $total = 0;
        foreach ($this->lines() as $line) {
            $total += $line['qty'];
        }
        return $total;
    }

    public function subtotalCents()
    {
        $total = 0;
        foreach ($this->lines() as $line) {
            $total += $line['line_cents'];
        }
        return $total;
    }

    public function taxCents()
    {
        return (int) round($this->subtotalCents() * TAX_RATE);
    }

    public function totalCents()
    {
        return $this->subtotalCents() + $this->taxCents();
    }
}
