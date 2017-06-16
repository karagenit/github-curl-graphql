<?php

    //Takes github oauth token & graphql request as json, returns json object (use json_decode)
    function get_curl($token, $json) {
        $curl = curl_init("https://api.github.com/graphql");
        $args = array("Content-Type: application/json", "Content-Length: ".strlen($json), "Authorization: bearer $token");
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $args);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, "GuestAgent");
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }

    function str_prep($str) {
        $str = str_replace("\n","",$str);   
        $str = str_replace("\"","\\\"",$str);
        return $str;
    }   

    //takes graphql query & variables (vars as json object, use json_encode(array)), returns json query
    function build_curl($query, $vars="") {
        $query = str_prep($query);
        $vars = str_replace("\n","",$vars); //can't use str_prep, as we can't escape quotes here

        $json = "{\n";
        $json .= '"query":"'.$query.'"';

        if(strlen($vars) != 0) {
            $json .= ',"variables":'.$vars;
        }

        $json .= "\n}";    
        return $json;
    }
?>
