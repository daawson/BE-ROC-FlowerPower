<?php
class Cart{

    public $cart_items_count = 0, $cart_totalPrice = 0;
    public $cart_items = array();

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

    function recalculatePrice(){
        $this->cart_totalPrice = 0;
        if(sizeof($this->cart_items) > 0){
            foreach($this->cart_items as $cItem){
                $this->cart_totalPrice += $cItem->article_price; 
            }
        }
    }
    
    function GetCartCount(){
        return sizeof($this->cart_items);
    }

    function GetCartContent(){
        if(sizeof($this->cart_items) > 0){
            echo "<table class='data-table'><tr><th>Artikel ID</th><th>Artikelnaam</th></th><th>Aantal</th><th>Prijs</th><th>Verwijder</th></tr>";
            $c = 0;
            foreach($this->cart_items as $cItem){
                echo "<tr>";
                echo "<td>".$c."</td>";
                echo "<td>".$cItem->article_name."</td>";
                echo "<td>".$cItem->article_quantity."</td>";
                echo "<td>€".$cItem->article_price."</td>";                
                echo "<td><a href='php/editCart.php?remove=".$cItem->cartItemID."'>Verwijder</a></td>";
                echo "</tr>";
                $c++;
            }
            echo "<tr>";
            echo "<tr><td></td><td></td><td></td><td></td><td><b>Totaal prijs</b></td></tr>";
            echo "<tr><td></td><td></td><td></td><td></td><td>€". $this->cart_totalPrice."</td></tr>";
            echo "</table>";
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