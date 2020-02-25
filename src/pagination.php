<?php
function pagination($page, $limit = 9) {
    return ($page - 1) * $limit;
}
?>
