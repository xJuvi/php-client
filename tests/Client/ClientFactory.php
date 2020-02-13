<?php

namespace Sms77\Tests\Client;

use Sms77\Api\Client;

final class ClientFactory
{
    /**
     * Call this method to get singleton
     * @return Client
     */
    public static function Instance()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new Client(getenv('SMS77_API_KEY'), 'php-api-test');
        }

        return $instance;
    }

    /**
     * Private constructor to avoid instantiation
     */
    private function __construct()
    {

    }
}