<?php


class Customer {
    private $id;
    private $continent;
    private $calls_in_continent;
    private $duration_in_continent;
    private $calls;
    private $duration_calls;

    function __construct($id, $continent){
        $this->id = $id;
        $this->continent = $continent;
    }

    function add_call($continent, $duration){
        if($continent == $this->continent){
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