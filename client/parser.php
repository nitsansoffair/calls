<?php
include '../classes/call.php';
include '../classes/Customer.php';

parse_customers();

function parse_customers(){
    if(($calls = fopen("../data/calls.csv", "r")) != false){
        $geonames = get_geonames();
        $customers = [];

        while (($line = fgetcsv($calls, 100, ",")) != false) {
            [$customer_id, $ip, $number_prefix, $duration] = [$line[0], $line[4], substr($line[3], 2, 3), $line[2]];

            if(isset($geonames[$number_prefix])){
                $continent_number = $geonames[$number_prefix];
                $call = new Call($customer_id, $ip, $duration, $continent_number);

                if(!isset($customers[$customer_id])){
                    $customers[$customer_id] = new Customer($customer_id, $call->get_continent_ip());
                }

                $customers[$customer_id]->add_call($continent_number, $duration);
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

            if ($number != null) {
                $geonames_array[$number] = $continent;
            }
        }

        fclose($geonames);

        return $geonames_array;
    }

    return null;
}