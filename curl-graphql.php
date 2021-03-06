<?php
/**
 * This library is used to easily communicate with Github's GraphQL (v4) API
 */

    /**
     * This function sends a query built by build_curl() to Github's GraphQL Server
     * 
     * @param string $token Github OAuth Token to Authenticate with the GraphQL Server
     * @param string $json  JSON Object to be sent to the GraphQL Server, generated by build_curl()
     * @return string       JSON Object returned by the cURL Query, use json_decode() to access
     */
    function get_curl($token, $json) {
        $curl = curl_init("https://api.github.com/graphql");
        $args = array("Content-Type: application/json", 
                      "Content-Length: ".strlen($json), 
                      "Authorization: bearer $token");

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $args);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, "GuestAgent");

        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }

    /**
     * This function builds the JSON query to be sent via get_curl()
     *
     * @param string $query Query to be used, in the GraphQL Syntax
     * @param mixed[] $vars [Optional] Any Variables to be sent with the GraphQL Query 
     * @return string       JSON Object to be passed to get_curl()
     */
    function build_curl($query, $vars=array()) {
        $json = array();
        $json['query'] = $query;
        $json['variables'] = $vars;
        return json_encode($json);
    }
?>
