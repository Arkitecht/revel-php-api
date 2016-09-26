<?php
namespace Arkitecht\RevelAPI\Objects;


use Arkitecht\RevelAPI\RevelAPI;

class Device extends RevelApiObject
{
    public function get($id='')
    {
        if ($id) {
            return Device::fromJson($this->api, $this->api->makeRequest('/devices/'.$id));
        } else {
            $api = $this->api;

            return collect($this->api->makeRequest('/devices'))->map(function ($json) use ($api) {
                return Device::fromJson($api, $json);
            });
        }
    }

    public function postCommand($idOrCommand = '', $commandOrValue = '', $value = '')
    {

        if (func_num_args() == 2) {
            if (!$this->id)
                throw new \Exception('need a device id');
            $id = $this->id;
            $command = $idOrCommand;
            $value = $commandOrValue;
        } elseif (func_num_args() == 3) {
            $id = $idOrCommand;
            $command = $commandOrValue;
        }

        $json = [['name' => $command, 'arg' => $value]];

        $this->api->makeRequest('/devices/' . $id . '/commands', 'POST', [], [], $json);

    }

    public function reload($id='')
    {
        if ( $id )
            return $this->postCommand($id,'reload','');
        else
            return $this->postCommand('reload','');
    }

    public function pingData()
    {
        if ( property_exists($this,'ping_data') ) {
            return $this->ping_data;
        }
        return null;
    }

}