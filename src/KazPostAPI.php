<?php

namespace RustemKaimolla\KazPost;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * @property mixed|null status_code
 */
class KazPostAPI
{
    /**
     * URL API КазПочты
     * https://post.kz/external-api/tracking/api/v2/CC016466342KZ/events
     *
     * @var string
     */
    protected string $api_url = 'https://post.kz/external-api/tracking/api/v2/';
	
	/**
	 * Трек код
	 *
	 * @var
	 */
	protected string $track_code;
    
    /**
     * Хранит ответ сервера в виде массива
     *
     * @var array
     */
    protected array $data;
    
    /**
     * Хранит события посылки(перемешения)
     *
     * @var array
    */
    protected array $events;
    
    /**
     * Последний пункт нахождения
     *
     * @var array
    */
    protected array $last;
	
	/**
	 * Ряд и ячейка
	 *
	 * @var array
	 */
	protected array $inbox;

    /**
     * Экземпляр GuzzleHttp\Client
     *
     * @var Client
     */
    private Client $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => $this->api_url]);
    }

    /**
     * Получает данные о посылке
     *
     * @param string $track_code трек код посылки
     *
     * @return $this
     */
    public function get(string $track_code):self
    {
    	$this->track_code = $track_code;
        try {
            $response = $this->client->request('GET', $track_code . '/events');

            if($response->getStatusCode() === 200){
                $this->data = json_decode($response->getBody(), true);
                $this->events = $this->data['events'];
                $this->last = $this->data['events'][0];
            }

        } catch (GuzzleException $e) {
            exit("Ошибка выполнения HTTP запроса");
        }
        return $this;
    }
	
	/**
	 * Получает ряд и ячейку посылки
	 *
	 * @return $this
	 */
	public function inbox(): self
    {
	    try {
		    $response = $this->client->request(
		    	'GET',
			    'https://post.kz/mail-app/public/supermarket?barcode=' . $this->track_code . '&index=' . $this->last['activity'][0]['dep_code']);
		
		    if($response->getStatusCode() === 200){
			    $this->inbox = json_decode($response->getBody(), true);
		    }
		
	    } catch (GuzzleException $e) {
		    exit("Ошибка выполнения HTTP запроса");
	    }
	    return $this;
    }

    /**
     * Возвращает значения парамертра посылки
     *
     * @param $name 'имя параметра посылки'
     *
     * @return mixed
     */
    public function __get(string $name)
    {
	    return $this->data[$name] ?? null;
    }

    /**
     * Возвращает все данные посылки в виде массива
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
	
	/**
	 * Возвращает ряд и ячейку
	 *
	 * @return array
	 */
	public function getInbox(): array
    {
    	return $this->inbox;
    }
	
	/**
	 * Возвращает информацию о перемещении посылки
	 *
	 * @return array
	 */
	public function events(): array
    {
    	return $this->events;
    }
	
	/**
	 * Возвращает последнее местонахождение
	 *
	 * @return array
	 */
	public function getLast(): array
    {
    	return $this->last;
    }
}
