<?php

namespace Mawuekom\GeoTargetIp;

use Mawuekom\HttpRequestWrapper\HttpRequest;

trait GeoTargetIp
{

    public static function locate($ip = null, $deep_detect = true, $retrieve_method = "file")
    {
        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            $ip = $_SERVER['REMOTE_ADDR'];

            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                }

                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                }
            }
        }

        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            if ($retrieve_method == 'file') {
                $ip_details = @json_decode(file_get_contents('http://www.geoplugin.net/json.gp?ip='.$ip));
            }

            else {
                $request = new HttpRequest();
                $response = $request ->get('http://www.geoplugin.net/php.gp?ip='.$ip);
                $ip_details = (object) unserialize($response ->getBody() ->getContents());
            }
            
            return [
                'city' => @$ip_details->geoplugin_city,
                'state' => @$ip_details->geoplugin_regionName,
                'region' => [
                    'code' => @$ip_details->geoplugin_regionCode,
                    'name' => @$ip_details->geoplugin_regionName
                ],
                'country' => [
                    'code' => @$ip_details->geoplugin_countryCode,
                    'name' => @$ip_details->geoplugin_countryName
                ],
                'continent' => [
                    'code' => @$ip_details->geoplugin_continentCode,
                    'name' => @$ip_details->geoplugin_continentName
                ],
                'area_code' => @$ip_details->geoplugin_areaCode,
                'latitude' => @$ip_details->geoplugin_latitude,
                'longitude' => @$ip_details->geoplugin_longitude,
                'dmaCode' => @$ip_details->geoplugin_dmaCode,
                'currency' => [
                    'code' => @$ip_details->geoplugin_currencyCode,
                    'symbol' =>@$ip_details->geoplugin_currencySymbol
                ]
            ];
        }
    }
}
