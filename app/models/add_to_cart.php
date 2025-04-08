<?php
//models/add_to_cart
function getCartItems()
{
    return $_SESSION['cart'] ?? [];
}
