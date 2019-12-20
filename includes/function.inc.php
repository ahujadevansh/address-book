<?php

function db_connect() 
{
    static $connection;

    if(!$connection):
        $config  = parse_ini_file('../config.ini');
        $connection = mysqli_connect($config['host'], $config['username'], $config['password'], $config['dbname'], $config['port']);
    endif;

    if($connection === false):
        return mysqli_connect_error();
    endif;

    return $connection;
}

function db_error()
{
    $connection = db_connect();
    return mysqli_error_list($connection);
}

function db_query($query)
{
    $connection = db_connect();
    $result = mysqli_query($connection, $query);

    return $result;
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

function db_insert($table, $data)
{
    if(is_array($data)):
        $columns = array_keys($data);
        $values = array_values($data);
        for($i=0; $i<count($values); $i++)
        {
            $values[$i] = add_single_quote(db_quote($values[$i]));
        }
        $values = "(" . implode(',', $values) . ")";
        $columns = "(" . implode(',', $columns) . ")";
        
        $query = "INSERT INTO $table$columns VALUES $values;";

        return db_query($query);

    else:
        return false;
    endif;

}

function db_update($table, $data, $condition)
{
    if(is_array($data)):
        $columns = array_keys($data);
        $values = array_values($data);
        $col_val = [];
        for($i=0; $i<count($values); $i++)
        {
            $values[$i] = add_single_quote(db_quote($values[$i]));
            $col_val[] = $columns[$i] . " = " . $values[$i];
        }
        $col_val = implode(', ', $col_val);
        $query = "UPDATE $table SET $col_val WHERE $condition;";
        return db_query($query);

    else:
        return false;
    endif;

}

function db_quote($value)
{
    $connection  = db_connect();
    return mysqli_real_escape_string($connection, $value);
}

function dd($variable)
{
    die(var_dump($variable));
}

function add_single_quote($variable)
{
    return "'$variable'";
}

function redirect($url)
{
    header("location: $url");
}

?>