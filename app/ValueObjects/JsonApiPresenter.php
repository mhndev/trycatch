<?php

namespace mhndev\trycatch\ValueObjects;

use mhndev\NanoFramework\Http\Interfaces\iResponse;

/**
 * Class JsonApiPresenter
 * @package Tourism\value_objects
 */
class JsonApiPresenter
{
    /**
     * @var string
     */
    private $status = ResponseStatuses::ERROR;

    /**
     * @var string
     */
    private $message = '';

    /**
     * @var string
     */
    private $description = '';

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var
     */
    private $dataMainKey;

    /**
     * @var int
     */
    private $statusCode = 400;


    /**
     * @var array
     */
    private $pagination = [];

    /**
     * @param mixed $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param mixed $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param mixed $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }


    /**
     * @param mixed $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        if(empty($this->data))
            return null;

        if ( is_array($this->data) && $this->isAssoc($this->data)) {
            $data = [
                $this->getDataMainKey() => $this->data[$this->getDataMainKey()],
                'mainKey' => $this->getDataMainKey(),
            ];
            foreach ($this->data as $key => $value) {

                if ($key != $this->getDataMainKey()) {
                    $data[$key] = $value;
                }
            }


        } else {
            $data = [
                $this->getDataMainKey() => $this->data,
                'mainKey' => $this->getDataMainKey(),
            ];
        }


        $pagination = $this->getPagination();
        if (!empty($pagination)) {
            $data['pagination'] = [
                "total" => $pagination['total'],
                "per_page" => $pagination['per_page'],
                "page" => $pagination['current_page'],
                "last_page" => $pagination['last_page'],
                "next_page_url" => $pagination['next_page_url'],
                "prev_page_url" => $pagination['prev_page_url'],
                "from" => $pagination['from'],
                "to" => $pagination['to'],
            ];
        }

        return $data;
    }

    /**
     * @param mixed $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param iResponse $response
     * @return mixed
     */
    public function toJsonResponse(iResponse $response)
    {
        $responseBody = [
            'status' => $this->status,
            'message' => $this->message,
            'description' => $this->description,
        ];

        if(!empty($this->data)){
            $responseBody['data'] = $this->getData();
        }


        $response = $response->withBody(json_encode($responseBody));

        return $response->withHeader('Content-type', 'application/json')->withStatusCode($this->statusCode);
    }

    /**
     * @return array
     */
    public function toJson()
    {
        return json_encode([
            'status' => $this->status,
            'message' => $this->message,
            'description' => $this->description,
            'data' => $this->getData()
        ]);
    }

    /**
     * @return mixed
     */
    public function getDataMainKey()
    {
        return $this->dataMainKey;
    }

    /**
     * @param mixed $dataMainKey
     * @return $this
     */
    public function setDataMainKey($dataMainKey)
    {
        $this->dataMainKey = $dataMainKey;

        return $this;
    }

    /**
     * @return array
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * @param array $pagination
     * @return $this
     */
    public function setPagination($pagination)
    {
        $this->pagination = $pagination;

        return $this;
    }

    /**
     * @param $arr
     * @return bool
     */
    protected function isAssoc($arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
