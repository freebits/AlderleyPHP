<?php
function get_pagination_offset($page, $limit = 9) {
    return ($page - 1) * $limit;
}
?>
