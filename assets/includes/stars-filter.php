<?php
function filter_stars($stars) {
    // Round to the nearest 0.5
    $rounded = round($stars * 2) / 2;
    
    // Calculate full stars, half star, and empty stars
    $full = floor($rounded);
    $half = ($rounded - $full) == 0.5 ? 1 : 0;
    $empty = 5 - $full - $half;
    
    // Generate HTML for stars
    $html = '';
    for ($i = 0; $i < $full; $i++) {
        $html .= '<img src="assets/icons/star.svg" alt="full star" class="star-icon">';
    }
    if ($half) {
        $html .= '<img src="assets/icons/half-star.svg" alt="half star" class="star-icon">';
    }
    for ($i = 0; $i < $empty; $i++) {
        $html .= '<img src="assets/icons/empty-star.svg" alt="empty star" class="star-icon">';
    }
    
    return $html;
}
?>
