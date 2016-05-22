<?php


namespace mhndev\trycatch\Resources;

use GuzzleHttp\Client;

class UserResourceTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Client
     */
    protected $client;


    protected $baseUri = 'http://localhost:8000';


    protected $path = [
        'index'=>'/users',
        'create'=>'/users',
        'show'=>'/users',
        'delete'=>'/users',
        'update'=>'/users',
        //       'deleteBulk'=>'/users/bulk'
    ];

    protected function setUp()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUri
        ]);
    }

    public function testIndexAction()
    {
        $response = $this->client->get($this->path['index']);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $main = $data['data'];

        $this->assertArrayHasKey('status', $data);
        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('users', $main);

    }



    public function testCreateAction()
    {
        $response = $this->client->post($this->path['create'], [
            'form_params' => [
                'name' => 'majid',
                'phone'=> '09124971706',
                'street' =>'piroozi'
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $main = $data['data'];


        $this->assertArrayHasKey('status', $data);

        $this->assertArrayHasKey('user', $main);
        $this->assertEquals('created', $data['message']);
    }



    public function testShowAction()
    {
        $response = $this->client->post($this->path['create'], [
            'form_params' => [
                'name' => 'majid',
                'phone'=> '09124971706',
                'street' =>'piroozi'
            ]
        ]);


        $data = json_decode($response->getBody(), true);
        $newLyCreatedUserId = $data['data'][$data['data']['mainKey']][0];

        $response = $this->client->get($this->path['show'].'/'.$newLyCreatedUserId);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('status', $data);

        $this->assertEquals('found', $data['message']);
    }


    public function testDeleteResource()
    {
        $response = $this->client->post($this->path['create'], [
            'form_params' => [
                'name' => 'majid',
                'phone'=> '09124971706',
                'street' =>'piroozi'
            ]
        ]);


        $data = json_decode($response->getBody(), true);

        $newLyCreatedUserId = $data['data'][$data['data']['mainKey']][0];




        $response = $this->client->delete($this->path['delete'].'/'.$newLyCreatedUserId);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('status', $data);


        $this->assertEquals('deleted', $data['message']);
    }




    public function testUpdateAction()
    {
        $response = $this->client->post($this->path['create'], [
            'form_params' => [
                'name' => 'majid',
                'phone'=> '09124971706',
                'street' =>'piroozi'
            ]
        ]);


        $data = json_decode($response->getBody(), true);

        $newLyCreatedUserId = $data['data'][$data['data']['mainKey']][0];

        $response = $this->client->put($this->path['update'].'/'.$newLyCreatedUserId, [

            'form_params' => [
                'name' => 'John',
                'phone'=> '09124971706',
                'street' =>'piroozi'
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('status', $data);

        $this->assertEquals('John', $data['data']['user']['name']);

        $this->assertEquals('updated', $data['message']);
    }

//
//        public function testDeleteBulkAction()
//        {
//            $response = $this->client->post($this->path['create'], [
//                'body' => [
//                    'name' => 'majid',
//                    'phone'=> '09124971706',
//                    'street' =>'piroozi'
//                ]
//            ]);
//
//
//            $data = json_decode($response->getBody(), true);
//
//            $newLyCreatedUserId1 = $data['user'][0];
//
//
//
//            $response = $this->client->post($this->path['create'], [
//                'body' => [
//                    'name' => 'hamid',
//                    'phone'=> '09124971706',
//                    'street' =>'piroozi'
//                ]
//            ]);
//
//
//            $data = json_decode($response->getBody(), true);
//
//            $newLyCreatedUserId2 = $data['user'][0];
//
//
//
//            $response = $this->client->get($this->path['deleteBulk'], [
//                'body' => [
//                    'ids' => [$newLyCreatedUserId1, $newLyCreatedUserId2]
//                ]
//            ]);
//
//            $this->assertEquals(200, $response->getStatusCode());
//
//            $data = json_decode($response->getBody(), true);
//
//            $this->assertArrayHasKey('status', $data);
//
//
//            $this->assertEquals('deleted', $data['message']);
//        }
}
