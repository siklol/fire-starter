<?php
namespace Scandio\Library\Http;

class Curl implements HttpRequestInterface
{

    /**
     * Retrieves data per GET
     *
     * @param $url
     * @param array $options
     * @return mixed
     */
    public function get($url, $options = array())
    {
        $options = array(
            CURLOPT_RETURNTRANSFER => true
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    /**
     * Retrieves data via POST
     *
     * @param string $url
     * @param array $data
     * @param array $options
     * @return mixed
     */
    public function post($url, array $data, $options = array())
    {
        // TODO: Implement post() method.
        throw new \Exception("CURL POST NOT IMPLEMENTED");
    }
}