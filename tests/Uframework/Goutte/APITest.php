<?php

use Goutte\Client;

class APITest extends TestCase{
    private $client;
    private $endpoint;

    public function setUp() {
        $this->client = new Client();
        $this->endpoint = 'http://33.33.33.10:82';
    }

    public function testGetStatuses() {
        $this->client->request('GET', sprintf('%s/statuses', $this->endpoint));
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatus());
        $this->assertEquals('text/html', $response->getHeader('Content-Type'));
    }

/*
    public function testGetStatusesInJSON() {
        $this->client->setHeader('Accept', 'application/json');
        $this->client->request('GET', sprintf('%s/statuses', $this->endpoint));
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatus());
        $this->assertEquals('application/json', $response->getHeader('Content-Type'));
    }

    public function testGetStatusesInXML() {
        $this->client->setHeader('Accept', 'application/xml');
        $this->client->request('GET', sprintf('%s/statuses', $this->endpoint));
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatus());
        $this->assertEquals('application/xml', $response->getHeader('Content-Type'));
    }
*/
    
    public function testGetStatusesNotExisting() {
        $this->client->request('GET', sprintf('%s/statuses/0', $this->endpoint));
        $response = $this->client->getResponse();
        $this->assertEquals(404,$response->getStatus());
    }

    public function testGetStatusesIdExisting() {
        $this->client->request('GET', sprintf('%s/statuses/1', $this->endpoint));
        $response = $this->client->getResponse();
        $this->assertEquals(200,$response->getStatus());
    }

    public function testDeleteStatusesId() {
        $this->client->request('DELETE', sprintf('%s/statuses/1', $this->endpoint));
        $response = $this->client->getResponse();
        $this->assertEquals(200,$response->getStatus());
    }

    public function testLogIn() {
        $this->client->request('GET', sprintf('%s/logIn', $this->endpoint));
        $response = $this->client->getResponse();
        $this->assertEquals(200,$response->getStatus());
    }
}