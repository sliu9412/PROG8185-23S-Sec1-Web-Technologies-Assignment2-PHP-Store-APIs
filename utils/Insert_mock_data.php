<?php
require_once("connect_db.php");
require_once("mock_data.php");

function InsertMockData($data_array, $table_name)
{
    $fields_str = join(",", array_keys($data_array[0]));
    $values = "";
    foreach ($data_array as $item) {
        $value_arr = array_values($item);
        $value_str = "(";
        foreach ($value_arr as $field_value) {
            $value_str .= "'$field_value',";
        }
        $value_str = substr($value_str, 0, strlen($value_str) - 1);
        $values .= $value_str . "),";
    }
    $values = substr($values, 0, strlen($values) - 1);
    $query = $GLOBALS["db"]->prepare("INSERT INTO $table_name ($fields_str) VALUES $values");
    $query->execute();
    JsonResponse("Insert data into $table_name successfully");
}

ApiWrapper("InsertMockData", "POST", $mock_users, "userinfo");
ApiWrapper("InsertMockData", "POST", $mock_products, "product");
