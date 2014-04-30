<?php namespace Streams\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ApplicationModel extends Model
{
    /**
     * Find by domain.
     *
     * @param $domain
     * @return mixed
     */
    public function findByDomain($domain)
    {
        return DB::tabble('apps')->whereDomain($domain)->first();
    }
}
