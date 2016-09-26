<?php
namespace Arkitecht\RevelAPI\Objects;


use Arkitecht\RevelAPI\RevelAPI;

class Account extends RevelApiObject
{
    public function get()
    {
        return static::fromJson($this->api,$this->api->makeRequest('/account'));

    }
}