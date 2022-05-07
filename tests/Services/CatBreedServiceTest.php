<?php


namespace Services;

use App\Models\BaseTestClass;
use App\Models\QueryCache;
use App\Services\TheCatAPIServices\CatBreedsService;


class CatBreedServiceTest extends BaseTestClass
{

    private $catBreedService;
    private const QUERY = 'sibe';

    public function __construct()
    {
        parent::__construct();
        $this->catBreedService = new CatBreedsService();
    }

    public function testGetBreedService()
    {
        $this->deleteIndex();
        $this->assertIsArray($this->catBreedService->getBreedsService());
    }

    public function testGetBreedsServiceCache()
    {
        $this->assertJson($this->catBreedService->getBreedsService());
    }

    public function testSearchBreedsService()
    {
        $this->deleteSearch(self::QUERY);
        $this->assertIsArray($this->catBreedService->searchBreedsService(self::QUERY));
    }

    public function testSearchBreedsServiceCache()
    {
        $this->assertJson($this->catBreedService->searchBreedsService(self::QUERY));
    }

    private function deleteIndex()
    {
       QueryCache::where('query', '=', 'index')->delete();
    }

    private function deleteSearch($query)
    {
        QueryCache::where('query', '=', $query)->delete();

    }
}
