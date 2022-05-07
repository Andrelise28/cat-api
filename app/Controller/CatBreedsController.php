<?php

namespace App\Controller;

use App\Services\TheCatAPIServices\CatBreedsService;
use Slim\Http\Request;
use Slim\Http\Response;

class CatBreedsController
{

    private $catBreedsService;

    public function __construct()
    {
        $this->catBreedsService = new CatBreedsService();
    }

    public function breeds(Request $request, Response $response)
    {
        $request->getHeaders();
        return $response->withJson(['Breeds' => $this->catBreedsService->getBreedsService()], 200);
    }
	
	public function search(Request $request, Response $response)
	{
		$params = $request->getQueryParams();
        return $response->withJson($this->catBreedsService->searchBreedsService($params['q']), 200);
    }

}
