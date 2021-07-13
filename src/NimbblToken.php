<?php

namespace Nimbbl\Api;

use JsonSerializable;
use Requests;


class NimbblToken
{
    protected static $headers = array(
        'Nimbbl-API'  =>  1
    );

    /**
     *  @param $id Customer id description
     */

    public function generateToken()
    {
        $nimbblSegment = new NimbblSegment();
        $nimbblSegment->track(array(
                "userId" => NimbblApi::getKey(),
                "event" => "Authorization Submitted",
                "properties" => [
                  "access_key" => NimbblApi::getKey(),
                  "kit_name" => 'php-sdk',
                  "kit_version" => '1'
                ],
        ));
        $tokenResponse = Requests::post(NimbblApi::getTokenEndpoint(), ['Content-Type' => 'application/json'], json_encode(['access_key' => NimbblApi::getKey(), 'access_secret' => NimbblApi::getSecret()]));
        $tokenResponseBody = json_decode($tokenResponse->body, true);
        
        $newtokenResponseBody = new NimbblToken();
        if (key_exists('error', $tokenResponseBody)) {
            $nimbblSegment->track(array(
                    "userId" => NimbblApi::getKey(),
                    "event" => "Authorization Received",
                    "properties" => [
                        "access_key" => NimbblApi::getKey(),
                        "auth_status" => "failed",
                        "kit_name" => 'php-sdk',
                        "kit_version" => '1'
                    ],
            ));
            $newtokenResponseBody->error = $tokenResponseBody['error'];
        }
        else {
            NimbblApi::setToken($tokenResponseBody['token']);
            NimbblApi::setMerchantId($tokenResponseBody['auth_principal']['sub_merchant_id']);
            $nimbblSegment->track(array(
                    "userId" => NimbblApi::getKey(),
                    "event" => "Authorization Received",
                    "properties" => [
                        "access_key" => NimbblApi::getKey(),
                        "auth_status" => "success",
                        "kit_name" => 'php-sdk',
                        "kit_version" => '1'
                    ],
            ));
            $attributes = array();
            foreach ($tokenResponseBody as $key => $value) {
                $attributes[$key] = $value;
            }
            $newtokenResponseBody->attributes = $attributes;
        }
        return $newtokenResponseBody;
    }
}


