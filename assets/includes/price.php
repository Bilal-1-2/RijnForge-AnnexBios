<?php

/**
 
 
 * @param float|int $price The price value.
 * @return string Formatted price string.
 */
function formatPrice($price) {
    return number_format((float)$price, 2, ',', '');
}
?>
