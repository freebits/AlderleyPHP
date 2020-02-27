<?php
function get_database($db_uri, $db_user)
{
    return new PDO($db_uri, $db_user);
}
