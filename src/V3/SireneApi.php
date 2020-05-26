<?php

namespace SireneApi\V3;

use GuzzleHttp\Client;

class SireneApi
{
    /**
     * Base api endpoint
     *
     * @var  string
     */
    private string $endpoint = 'https://entreprise.data.gouv.fr/api/sirene/v3/';

    /**
     * GuzzleHttp client
     *
     * @var  null
     */
    private $client = null;

    /**
     * API method
     *
     * @var  string
     */
    private string $method = 'unites_legales';

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
     * Set the method to companies
     *
     * @return SireneApi
     */
    public function companies(): self
    {
        $this->method = 'unites_legales';

        return $this;
    }

    /**
     * Set the method to establishments
     *
     * @return SireneApi
     */
    public function establishments(): self
    {
        $this->method = 'etablissements';

        return $this;
    }

    /**
     * Get all companies or establishments
     *
     * @return array
     */
    public function all(): array
    {
        return $this->request($this->method);
    }

    /**
     * Get establishment by siret
     *
     * @param string $siret
     *
     * @throws \Exception if the method is not "etablissements"
     *
     * @return array
     */
    public function getBySiret(string $siret): array
    {
        if ($this->method !== 'etablissements') {
            throw new \Exception('API method must be set to "etablissements". Use the establisments() method first in order to set the method.');
        }

        return $this->request($this->method, [
            'siret' => $siret,
        ]);
    }

    /**
     * Get companies by siren
     *
     * @param string $siren
     *
     * @return array
     */
    public function getBySiren(string $siren): array
    {
        return $this->request($this->method, [
            'siren' => $siren,
        ]);
    }

    /**
     * Get companies or establishments by params
     *
     * @param mixed  $params
     * @param string $value
     *
     * @return array
     */
    public function getBy($params, ?string $value = null): array
    {
        if (is_array($params)) {
            return $this->request($this->method, $params);
        } else {
            if (is_string($params) && !is_null($value)) {
                return $this->request($this->method, [
                    $params => $value,
                ]);
            } else {
                throw new \Exception('The first params must be an array or a string. If you set a string, set the value in second params');
            }
        }
    }

    /**
     * Make an HTTP GET request for retrieving data
     *
     * @param string $method
     * @param array  $params
     *
     * @return array
     */
    public function request(string $method, $params = []): array
    {
        $response = $this->client->request('GET', $method, [
            'query' => $params,
        ]);

        if ($response->getStatusCode() == 200) {
            $response = json_decode($response->getBody());

            return $response->$method;
        }

        return $response;
    }
}
