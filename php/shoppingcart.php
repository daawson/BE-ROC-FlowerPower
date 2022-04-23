<?php
class Cart{

    public $cart_items_count = 0;
    public $cart_totalPrice = 0;
    public $cart_btw = 0;
    public $cart_items = array();

    public $transport_price = 3.95;

    function AddCartItem(CartItem $cItem){
        $cItem->cartItemID = $this->cart_items_count;
        array_push($this->cart_items, $cItem);        
        $this->cart_items_count++;
        $this->recalculatePrice();  
        header("location: ../cart.php");
    }

    function RemoveCartItem($cartItemID){
        $this->cart_items = array_filter($this->cart_items, function($x) use ($cartItemID) { return $x->cartItemID != $cartItemID; });
        $this->recalculatePrice();
        header("location: ../cart.php");
    }
    function HasItemInCart($article_id){  
        $isFound = false;      
        if(sizeof($this->cart_items) > 0){
            foreach($this->cart_items as $item){
                if($item->article_id == $article_id){
                    $isFound = true;
                    break;
                }
            }
        }

        return $isFound;
    }
    function ClearCart(){
        unset($this->cart_items);
        $this->cart_items = array();
        $this->recalculatePrice();
    }
    
    function recalculatePrice(){
        $this->cart_totalPrice = 0;
        if(sizeof($this->cart_items) > 0){
            foreach($this->cart_items as $cItem){
                $this->cart_totalPrice += $cItem->article_price; 
            }
            $this->cart_totalPrice += $this->transport_price;
            $this->cart_btw = $this->cart_totalPrice * 0.09;
        }
    }
    
    function GetCartCount(){
        return sizeof($this->cart_items);
    }

    function GetCartContent(){
        if(sizeof($this->cart_items) > 0){
            echo "<table class='data-table'><tr><th>Verwijder</th><th>Artikelnaam</th></th><th>Aantal</th><th>Prijs</th></tr>";
            $c = 0;
            foreach($this->cart_items as $cItem){
                echo "<tr>";
                echo "<td><a href='php/editCart.php?remove=".$cItem->cartItemID."'>Verwijder</a></td>";
                // echo "<td>".$c."</td>";
                echo "<td>".$cItem->article_name."</td>";
                echo "<td>".$cItem->article_quantity."</td>";
                echo "<td>€".$cItem->article_price."</td>";              
               
                echo "</tr>";
                $c++;
            }
            //echo "<tr>";
            echo "<tr><td></td><td><b>Extra</b></td><td></td><td></td></tr>";
            echo "<tr><td></td><td>Bezorgkosten</td><td></td><td>€".number_format((float)$this->transport_price, 2, '.', '')."</td></tr>";
            echo "<tr><td></td><td></td><td></td><td><b>Totaal prijs</b></td></tr>";
            echo "<tr><td></td><td></td><td></td><td>9% Btw<br> €".number_format((float)$this->cart_btw, 2, '.', '')."</td></tr>";
            echo "<tr><td></td><td></td><td></td><td>€". number_format((float)$this->cart_totalPrice, 2, '.', '')."</td></tr>";
            echo "</table>";

            echo "<a id='place-order' href='payment.php'>Verder</a>";
        }
        else{
            echo "Je winkelwagen is leeg!";
        }
    }
}

class CartItem{
    public $cartItemID, $article_id, $article_name, $article_quantity, $article_price;

    function __construct($aid, $aname, $aquantity, $aprice) {       
        $this->article_id = $aid;
        $this->article_name = $aname;
        $this->article_quantity = $aquantity;
        $this->article_price = $aprice * $aquantity;
    }
}

?>