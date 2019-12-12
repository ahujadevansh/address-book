<?php

function db_connect()
{
    static $connection;

    if(!$connection):
        $config = parse_ini_file('../config.ini');
        $connection = mysqli_connect($config['host'], $config['username'], $config['password'], $config['dbname'], $config['port']);
    endif;

    if($connection === false):
        return mysqli_connect_error();
    endif;

    return $connection;
}

function db_query($query)
{
    $connection = db_connect();

    $result = mysqli_query($connection, $query);
    return $result;
}

function db_error()
{
    $connection = db_connect();
    return mysqli_error($connection);
}

function db_select($query)
{
    $result = db_query($query);

    if($result === false):
        return false;
    endif;
    
    $rows = array();
    while($row = mysqli_fetch_assoc($result)):
        $rows[] = $row;
    endwhile;

    return $rows;
}

function db_quote($value)
{
    $connection = db_connect();
    return mysqli_real_escape_string($connection, $value);
}

function dd($variable)
{
    die(var_dump($variable));
}