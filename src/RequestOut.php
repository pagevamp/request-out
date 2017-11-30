<?php

namespace Pv;

use GuzzleHttp\Client;

class RequestOut
{
    private $targetUrl;
    private $params = [];
    private $client;
    private $requestType;
    private $headers = [];
    private $dataType = 'form_params';

    public function __construct($targetUrl = null, $formData = [])
    {
        $this->client = new Client();
        if (!empty($targetUrl)) {
            $this->targetUrl = $targetUrl;
        }

        $this->params = $formData;
    }

    public function addHeader($header)
    {
        $this->headers = array_merge($this->headers, $header);
    }

    public function addHeaders(array $headers)
    {
        foreach ($headers as $header) {
            $this->addHeader($header);
        }
    }

    public function addParam($param)
    {
        $this->headers = array_merge($this->params, $param);
    }

    public function addParams(array $params)
    {
        foreach ($params as $param) {
            $this->addParam($param);
        }
    }

    public function post()
    {
        $this->requestType = 'post';

        return $this->request();
    }

    public function get()
    {
        $this->requestType = 'get';

        return $this->request();
    }

    public function delete()
    {
        $this->requestType = 'delete';

        return $this->request();
    }

    public function put()
    {
        $this->requestType = 'put';

        return $this->request();
    }

    public function getTargetUrl()
    {
        return $this->targetUrl;
    }

    public function setTargetUrl($targetUrl)
    {
        return $this->targetUrl = $targetUrl;
    }

    public function setParams($params)
    {
        return $this->params = $params;
    }

    public function postJson()
    {
        $this->requestType = 'post';
        $this->dataType = 'json';

        return $this->request();
    }

    private function request()
    {
        $requestType = $this->requestType;

        $request = $this->getRequestInstance($requestType);

        return $request->getBody()->getContents();
    }

    /**
     * @param $requestType
     *
     * @return mixed
     */
    private function getRequestInstance($requestType)
    {
        if (in_array($requestType, ['get', 'delete'])) {
            if (!empty($this->params)) {
                $this->targetUrl .= '?'.http_build_query($this->params);
            }

            if (!empty($this->headers)) {
                $this->params['headers'] = $this->headers;

                return $this->client->$requestType($this->targetUrl, ['headers' => $this->headers]);
            }

            return $this->client->$requestType($this->targetUrl);
        }

        $this->params = [$this->dataType => $this->params];

        if (!empty($this->headers)) {
            $this->params['headers'] = $this->headers;
        }

        return $this->client->$requestType($this->targetUrl, $this->params);
    }
}
