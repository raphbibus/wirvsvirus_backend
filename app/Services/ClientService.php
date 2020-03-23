<?php

namespace App\Services;

class ClientService
{
    /**
     * @param array $requestData
     * @return array
     */
    public static function getClientStoreData( array $requestData ) {
        $storeData = [
            'username' => $requestData['username'],
            'password' => app('hash')->make($requestData['password']),
            'display_name' => $requestData['display_name']
        ];

        if( isset($requestData['nation']) ) {
            $storeData['nation'] = $requestData['nation'];
        }

        if( isset($requestData['city']) ) {
            $storeData['city'] = $requestData['city'];
        }

        return $storeData;
    }
}
