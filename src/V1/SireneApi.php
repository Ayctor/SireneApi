<?php

namespace SireneApi\V1;

use GuzzleHttp\Client;

class SireneApi
{
    /**
     * Base api endpoint
     *
     * @var  string
     */
    private string $endpoint = 'https://entreprise.data.gouv.fr/api/sirene/v1/';

    /**
     * GuzzleHttp client
     *
     * @var  null
     */
    private $client = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->endpoint,
        ]);
    }

    /**
     * Get establishment by siret
     *
     * @param string $siret
     *
     * @return stdClass|array
     */
    public function getBySiret(string $siret)
    {
        return $this->request('siret/' . $siret);
    }

    /**
     * Get establishments by siren
     *
     * @param string $siren
     *
     * @return stdClass|array
     */
    public function getBySiren(string $siren)
    {
        return $this->request('siren/' . $siren);
    }

    /**
     * Get companies or establishments by RNA
     *
     * @param string $rna
     *
     * @return stdClass|array
     */
    public function getByRna(string $rna)
    {
        return $this->request('rna/' . $rna);
    }

    /**
     * Get companies or establishments by full text
     *
     * @param string $text
     *
     * @return stdClass|array
     */
    public function getByFullText(string $text, $params = [])
    {
        return $this->request('full_text/' . $text, $params);
    }

    /**
     * Make an HTTP GET request for retrieving data
     *
     * @param string $method
     *
     * @return stdClass|array
     */
    public function request(string $method, $params = [])
    {
        $response = $this->client->request('GET', $method, [
            'query' => $params,
        ]);

        if ($response->getStatusCode() == 200) {
            $response = json_decode($response->getBody());
        }

        return $response;
    }
}
