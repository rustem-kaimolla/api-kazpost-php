<?php
namespace RustemKaimolla\KazPost;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class API
{
    protected $api_url = 'http://track.kazpost.kz/api/v2/';
    private   $client;
    protected $data = [];

    public function __construct()
    {
        $this->client = new Client(['base_uri' => $this->api_url]);
    }

    public function get(string $track_code):self
    {
        try {
            $response = $this->client->request('GET', $track_code);

            if($response->getStatusCode() === 200){
                $this->data = json_decode($response->getBody(), true);
            }

        } catch (GuzzleException $e) {
            exit("Ошибка выполнения HTTP запроса");
        }
        return $this;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
    }

    public function get_data(): array
    {
        return $this->data;
    }

}
