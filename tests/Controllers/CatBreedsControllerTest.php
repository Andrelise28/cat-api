<?php


namespace Controllers;

use App\Controller\CatBreedsController;
use App\Models\BaseTestClass;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;

class CatBreedsControllerTest extends BaseTestClass
{

    private $catBreedController;
    private const URL_SEARCH = '/v1/breeds/search?';
    private const URL_SHOW = '/v1/breeds/breeds?';

    public function __construct()
    {
        parent::__construct();
        $this->catBreedController = new CatBreedsController();
    }

    /**
     * @test
     */
    public function testConstruct()
    {
        $catBreedsController = new CatBreedsController();
        $this->assertInstanceOf(CatBreedsController::class, $catBreedsController);
    }

    /**
     * @test
     */
    public function testBreeds()
    {
        $environment = Environment::mock([]);
        $request = Request::createFromEnvironment($environment);
        $response = new Response();

        $result = $this->catBreedController->breeds($request, $response);

        $this->assertNotEmpty($result);
    }

    /**
     * @test
     */
    public function testSearch()
    {
        $param = 'sibe';

        $environment = Environment::mock([
            'REQUEST_METHOD' => 'POST',
            'REQUEST_URI' => self::URL_SEARCH,
            'QUERY_STRING' => 'q='. $param,
        ]);
        $request = Request::createFromEnvironment($environment);
        $response = new Response();
        $result = $this->catBreedController->search($request, $response);
        $this->assertEquals(200, $result->getStatusCode());
    }
      /**
     * @test
     */
    public function testShowBreeds()
    {
        $environment = Environment::mock([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => self::URL_SHOW,
        ]);
        $request = Request::createFromEnvironment($environment);
        $response = new Response();
        $result = $this->catBreedController->breeds($request, $response);
        $this->assertNotEmpty($result);
        $this->assertEquals(200, $result->getStatusCode());
    }
}