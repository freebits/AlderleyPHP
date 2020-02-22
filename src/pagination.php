<?php
function pagination($page) {
    $limit = 9;
    $offset = ($page * $limit) - $limit;
    $pagination_range = array($limit, $offset);
    return $pagination_range;
}
?>
