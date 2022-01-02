<?php

namespace ElasticSearch\Authentication;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class Connection
{
    private static ?ClientBuilder $client = null;

    public function __construct()
    {
        self::$client = ClientBuilder::create();
    }
    
    /**
     * You can connect to Elastic Cloud using Basic authentication
     *
     * @param  string $cloud_id
     * @return self
     */
    public function cloudId(string $cloud_id) :Connection
    {
        self::$client = self::$client->setElasticCloudId($cloud_id);

        return $this;
    }
    
    /**
     * Set the username and password to login ElasticSearch
     *
     * @param  mixed $username
     * @param  mixed $password
     * @return self
     */
    public function basicAuth(string $username, string $password) :Connection
    {
        self::$client = self::$client->setBasicAuthentication($username, $password);

        return $this;
    }
    
    /**
     * Self-signed certificates are certs that have not been signed by a public CA. 
     * They are signed by your own organization. 
     * Self-signed certificates are often used for internal purposes, 
     * when you can securely spread the root certificate yourself.
     *
     * @param  string $certificate
     * @return self
     */
    public function sslVerification(string $certificate) :Connection
    {
        self::$client = self::$client->setSSLVerification($certificate);

        return $this;
    }
    
    /**
     * CIf your Elasticsearch cluster is secured by API keys as described here, 
     * you can use these values to connect the client with your cluster, 
     * as illustrated in the following code snippet.
     *
     * @param  string $id
     * @param  string $key
     * @return self
     */
    public function apiKey(string $id, string $key) :Connection
    {
        self::$client = self::$client->setApiKey($id, $key);

        return $this;
    }
    
    /**
     * If your Elasticsearch server is protected by HTTP authentication, 
     * you need to provide the credentials to ES-PHP so that requests can be authenticated server-side. 
     * Authentication credentials are provided as part of the host array when instantiating the client:
     *
     * @param  array $hosts
     * @return self
     */
    public function hosts(array $hosts) :Connection
    {
        self::$client = self::$client->setHosts($hosts);

        return $this;
    }

    /**
     * @return Client
     */
    public static function client(): Client
    {
        if (is_null(self::$client))
            return ClientBuilder::create()->build();

        return self::$client->build();
    }
}