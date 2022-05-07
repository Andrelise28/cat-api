<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Util\Json;

/**
 * @property integer                                  id
 * @property string                                   query
 * @property Json				                      data
 * @property \Carbon\Carbon                           created_at
 * @property \Carbon\Carbon                           update_at
 */
class QueryCache extends Model
{
    public $table = "query_cache";

    protected $casts = [
        'data' => 'json'
    ];

    public function queryExists($query)
    {
        return QueryCache::where('query', $query)->first();
    }

    public function saveCache($query, $breedResult)
    {
        $queryCache = new QueryCache();
        $queryCache->query = $query;
        $queryCache->data = $breedResult;
        $queryCache->save();
    }
}
