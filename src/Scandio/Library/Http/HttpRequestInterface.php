<?php
namespace Scandio\Library\Http;

interface HttpRequestInterface
{
    /**
     * Retrieves data per GET
     *
     * @param $url
     * @param array $options
     * @return mixed
     */
    public function get($url, $options = array());

    /**
     * Retrieves data via POST
     *
     * @param string $url
     * @param array $data
     * @param array $options
     * @return mixed
     */
    public function post($url, array $data, $options = array());
}