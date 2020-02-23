<?php
function pagination($page, $limit = 9) {
    return array($limit, ($page - 1) * $limit);
}
?>
