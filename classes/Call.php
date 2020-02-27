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

        $this->set_continent_ip();
    }

    private function set_continent_ip(){
        if($this->ip != null){
            $curl = curl_init("http://api.ipstack.com/" . $this->ip . "?access_key=1bbc2841a6647a4b4ce5176b79e6d9a0");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = json_decode(curl_exec($curl));

            if(isset($response)){
                $this->continent_ip = $response->continent_code;
            } else {
                error_log("Error get continent ip of customer id: " . $this->customer_id . " with call ip: " . $this->ip);
            }
        }
    }

    function get_continent_ip(){
        return $this->continent_ip;
    }

    function has_continent_ip(){
        return $this->continent_ip != null;
    }
}