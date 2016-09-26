<?php
namespace Arkitecht\RevelAPI\Objects;


use Arkitecht\RevelAPI\RevelAPI;

abstract class RevelApiObject
{
    protected $api;

    public function __construct(RevelAPI $api)
    {
        $this->api = $api;
    }

    public static function fromJson($api,$jsonObject)
    {
        $object = new static($api);
        foreach ( $jsonObject as $param => $value )
            $object->$param = $value;
        return $object;
    }
}