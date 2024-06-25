<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class SMSCService {

    protected $client;
    protected $baseUrl;
    protected $login;
    protected $password;
    protected $charset;
    protected $https;
    protected $debug;

    public function __construct() {
        $this->client = new \GuzzleHttp\Client();
        $this->baseUrl = config('smsc.base_url');
        $this->login = config('smsc.login');
        $this->password = config('smsc.password');
        $this->charset = config('smsc.charset', 'utf-8');
        $this->https = config('smsc.https', false);
        $this->debug = config('smsc.debug', false);
    }

    public function sendSMS($phones, $message, $translit = 0, $time = 0, $id = 0, $format = 0, $sender = false, $query = "", $files = []) {
        $formats = [
            1 => "flash=1", "push=1", "hlr=1", "bin=1", "bin=2", "ping=1", "mms=1", "mail=1", "call=1", "viber=1", "soc=1"
        ];

        $params = [
            'cost' => 3,
            'phones' => $phones,
            'mes' => $message,
            'translit' => $translit,
            'id' => $id,
            'fmt' => 1,
            'charset' => $this->charset,
        ];

        if ($format > 0) {
            $params += $formats[$format];
        }

        if ($sender) {
            $params['sender'] = $sender;
        }

        if ($time) {
            $params['time'] = $time;
        }

        if ($query) {
            parse_str($query, $queryParams);
            $params = array_merge($params, $queryParams);
        }

        $response = $this->sendCommand('send', $params, $files);

        if ($this->debug) {
            if ($response[1] > 0) {
                Log::info("Message sent successfully. ID: {$response[0]}, Total SMS: {$response[1]}, Cost: {$response[2]}, Balance: {$response[3]}");
            } else {
                Log::error("Error: " . -$response[1] . ($response[0] ? ", ID: " . $response[0] : ""));
            }
        }

        return $response;
    }

    public function getSMSCost($phones, $message, $translit = 0, $format = 0, $sender = false, $query = "") {
        $formats = [
            1 => "flash=1", "push=1", "hlr=1", "bin=1", "bin=2", "ping=1", "mms=1", "mail=1", "call=1", "viber=1", "soc=1"
        ];

        $params = [
            'cost' => 1,
            'phones' => $phones,
            'mes' => $message,
            'translit' => $translit,
            'fmt' => 1,
            'charset' => $this->charset,
        ];

        if ($format > 0) {
            $params += $formats[$format];
        }

        if ($sender) {
            $params['sender'] = $sender;
        }

        if ($query) {
            parse_str($query, $queryParams);
            $params = array_merge($params, $queryParams);
        }

        $response = $this->sendCommand('send', $params);

        if ($this->debug) {
            if ($response[1] > 0) {
                Log::info("Cost of sending: {$response[0]}. Total SMS: {$response[1]}");
            } else {
                Log::error("Error: " . -$response[1]);
            }
        }

        return $response;
    }

    protected function sendCommand($cmd, $params = [], $files = []) {
        $protocol = $this->https ? 'https' : 'http';
        $url = "{$protocol}://smsc.kz/sys/{$cmd}.php";
        $params['login'] = $this->login;
        $params['psw'] = $this->password;

        $options = [
            'query' => $params,
            'timeout' => 60,
        ];

        if ($files) {
            $options['multipart'] = [];
            foreach ($files as $key => $filePath) {
                $options['multipart'][] = [
                    'name' => "file{$key}",
                    'contents' => fopen($filePath, 'r')
                ];
            }
        }

        try {
            $response = $this->client->request('POST', $url, $options);
            $body = (string)$response->getBody();

            return explode(',', $body);
        } catch (\Exception $e) {
            Log::error("HTTP Request failed: " . $e->getMessage());

            return [","];
        }
    }

}