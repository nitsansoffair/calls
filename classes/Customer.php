<?php


class Customer {
    private $id;
    private $calls_in_continent = 0;
    private $duration_in_continent = 0;
    private $calls = 0;
    private $duration_calls = 0;

    function __construct($id){
        $this->id = $id;
    }

    function add_call($continent_number, $continent_ip, $duration){
        if($continent_number == $continent_ip){
            $this->calls_in_continent++;
            $this->duration_in_continent += $duration;
        }

        $this->calls++;
        $this->duration_calls += $duration;
    }

    function get_id(){
        return $this->id;
    }

    function get_calls_in_continent(){
        return $this->calls_in_continent;
    }

    function get_duration_in_continent(){
        return $this->duration_in_continent;
    }

    function get_calls(){
        return $this->calls;
    }

    function get_duration(){
        return $this->duration_calls;
    }
}