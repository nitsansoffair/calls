<?php
require_once '../classes/call.php';
require_once '../classes/Customer.php';

function customers_to_array($file_route){
    $customers = parse_customers($file_route);
    $customers_arr = [];

    foreach ($customers as $customer){
        $customers_arr[$customer->get_id()] = [
            "calls_in_continent" => $customer->get_calls_in_continent(),
            "duration_in_continent" => parse_duration($customer->get_duration_in_continent()),
            "calls" => $customer->get_calls(),
            "duration" => parse_duration($customer->get_duration())
        ];
    }

    ksort($customers_arr, SORT_NUMERIC);

    return $customers_arr;
}

function parse_customers($file_route){
    if(($calls = fopen($file_route, "r")) != false){
        $geonames = get_geonames();
        $customers = [];

        while (($line = fgetcsv($calls, 100, ",")) != false) {
            $number = str_replace(".", "", $line[3]);
            [$customer_id, $ip, $number_prefix, $duration] = [$line[0], $line[4], substr($number, 0, 3), $line[2]];
            $continent_number = get_continent($geonames, $number_prefix);

            if(isset($continent_number)){
                $call = new Call($customer_id, $ip, $duration, $continent_number);

                if(!isset($customers[$customer_id])){
                    $customers[$customer_id] = new Customer($customer_id);
                }

                if($call->has_continent_ip()){
                    $customers[$customer_id]->add_call($continent_number, $call->get_continent_ip(), $duration);
                }
            } else {
                error_log("error get continent number of customer id " . $customer_id . " with number prefix: " . $number_prefix .
                    " and number " . $line[3]);
            }
        }

        fclose($calls);

        return $customers;
    }
}

function get_geonames(){
    if(($geonames = fopen("../data/geonames.txt", "r")) != false) {
        $geonames_array = [];

        while (($line = fgetcsv($geonames, 500, "\t")) != false) {
            [$continent, $number] = [$line[8], str_replace("-", "", str_replace("+", "", $line[12]))];

            if(strpos($number, " and ") != false){
                $numbers = explode(" and ", $number, 2);
                $geonames_array[$numbers[0]] = $continent;
                $geonames_array[$numbers[1]] = $continent;
            } else if ($number != null && is_numeric($number)) {
                $geonames_array[$number] = $continent;
            }
        }

        fclose($geonames);

        ksort($geonames_array, SORT_NUMERIC);

        return $geonames_array;
    }

    return null;
}

function get_continent($geonames, $input_number){
    if(isset($geonames[$input_number])){
        return $geonames[$input_number];
    }

    foreach ($geonames as $prefix => $continent){
        if(strpos($input_number, $prefix, 0) == 0){
            return $continent;
        }
    }

    return null;
}

function parse_duration($duration_in_seconds){
    $duration = "";

    if($duration_in_seconds > 60){
        $duration .= floor($duration_in_seconds / 60) . " min";
        $duration_in_seconds = $duration_in_seconds % 60;
    }

    if($duration_in_seconds > 0){
        if($duration != ""){
            $duration .= ", ";
        }

        $duration .= $duration_in_seconds . " sec";
    }

    return $duration . ".";
}