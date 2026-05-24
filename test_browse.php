<?php
$html = file_get_contents('http://localhost/rentease/browse');
if (strpos($html, 'product-card') !== false) {
    echo "Product cards found!\n";
}
if (strpos($html, 'bg-error-container') !== false) {
    echo "Error container found!\n";
}
if (strpos($html, 'No items found') !== false) {
    echo "No items found text found!\n";
}
