<?php


class Call
{
    private $customer_id;
    private $ip;
    private $continent_ip;
    private $continent_number;
    private $duration;

    function __construct($customer_id, $ip, $duration, $continent_number){
        $this->customer_id = $customer_id;
        $this->ip = $ip;
        $this->duration = $duration;
        $this->continent_number = $continent_number;

        $this->set_continents();
    }

    private function set_continents(){
        if($this->ip != null){
            $curl = curl_init("http://api.ipstack.com/" . $this->ip . "?access_key=1bbc2841a6647a4b4ce5176b79e6d9a0");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $json = curl_exec($curl);

            $this->continent_ip = json_decode($json)->continent_code;
        }
    }

    function get_continent_ip(){
        return $this->continent_ip;
    }
}