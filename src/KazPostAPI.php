<?php
namespace RustemKaimolla\KazPost;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class KazPostAPI
{
    /**
     * URL API КазПочты
     * @var string
     */
    protected $api_url = 'http://track.kazpost.kz/api/v2/';
    /**
     * Хранит ответ сервера в виде массива
     * @var array
     */
    protected $data = [];

    /**
     * Экземпляр GuzzleHttp\Client
     * @var Client
     */
    private $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => $this->api_url]);
    }

    /**
     * Функция для получения данных о посылке
     * @param string $track_code трек код посылки
     * @return $this
     */
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

    /**
     * Функция возвращает значения парамертра посылки
     * @param $name 'имя параметра посылки'
     * @return mixed
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
    }

    /**
     * Возвращает все данные посылки в виде массива
     * @return array
     */
    public function get_data(): array
    {
        return $this->data;
    }

}
