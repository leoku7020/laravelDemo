<?php

namespace App\Formatters;

use Illuminate\Http\Request;

class ApiOutput
{
    /**
     * @var integer
     */
    protected $code = 100;
    /**
     * @var string
     */
    protected $message = 'Get something successful.';
    protected $request;

    public function __construct()
    {
        $this->request = app(Request::class);
    }

    /**
     * @param array $data
     * @param string $message
     * @param integer $code
     * @return array
     */
    public function successFormat($data = [], $message = '', $code = '')
    {
        if ($message !== '') {
            $this->message = $message;
        }
        if ($code !== '') {
            $this->code = $code;
        }

        return $this->formatting(['data' => $data]);
    }

    /**
     * @param string $message
     * @param integer $code
     * @param array $data
     * @return array
     */
    public function failFormat($message = '', $code = '', $data = [])
    {
        if ($message !== '') {
            $this->message = $message;
        }
        if ($code !== '') {
            $this->code = $code;
        }

        return $this->formatting(['errors' => $data]);
    }

    /**
     * @param array $data
     * @param integer $total
     * @param integer $timestamp
     * @param array $fields 自定義欄位
     * @return array
     */
    public function paginationFormat($data = [], $total = 0, $timestamp = 0, $fields = [])
    {
        $data = [
            'data_list' => $data,
            'total' => $total,
        ];
        if ($timestamp > 0) {
            $data = array_merge($data, ['timestamp' => $timestamp]);
        }
        if (!empty($fields)) {
            $data = array_merge($data, $fields);
        }

        return $this->formatting(['data' => $data]);
    }

    /**
     * @param array $data
     * @return array
     */
    public function formatting($data = [])
    {
        $default = $this->getDefaultFormat($this->request);

        return array_merge($default, $data);
    }

    /**
     * Get base format, url, params, method, status code and message.
     *
     * @param Request $request
     * @return array
     */
    public function getDefaultFormat(Request $request)
    {
        return [
            'url' =>$request->fullUrl(),
            'method' => $request->getMethod(),
            'code' => $this->code,
            'message' => $this->message,
        ];
    }
}
