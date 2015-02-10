<?php

$path = dirname(dirname(__FILE__));
require_once($path . '/vendor/autoload.php');

use ZillowApi\ZillowApiClient;

$client = new ZillowApiClient('xxxxx');

try {
	$response = $client->execute('GetZestimate', ['zpid' => 84074482]);

    if($response->isSuccessful()) {
        print_r($response->getData());
    } else {
        echo $response->getCode() . ':' . $response->getMessage();
    }
} catch(\Exception $e) {
	echo $e->getMessage();
}