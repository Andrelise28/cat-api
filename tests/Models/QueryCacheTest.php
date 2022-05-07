<?php


namespace Models;

use App\Models\BaseTestClass;
use App\Models\QueryCache;

class QueryCacheTest extends BaseTestClass
{
    private $queryCache;
    const QUERY ="query";

    public function __construct()
    {
        parent::__construct();
        $this->queryCache = new QueryCache();
    }

    public function testSaveCache()
    {
        $query = 'test';
        $data = [
            'id' => 999,
            'query' => 'teste',
            'data' => [
                'id' => "Abys",
                'lap' => 1,
                'rex' => 0
            ]
        ];

        $data = json_encode($data);
        $this->queryCache->saveCache($query, $data);

        $query = QueryCache::where(self::QUERY, $query)->first();
        $this->assertJson($data, $query);
    }

    public function testQueryExists()
    {
        $query = 'test';
        $result = $this->queryCache->queryExists($query);
        $this->assertEquals($query, $result[self::QUERY]);
    }


}