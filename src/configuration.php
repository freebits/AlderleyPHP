<?php
function get_configuration($cfg_file_path)
{
    return parse_ini_file($cfg_file_path);
}
