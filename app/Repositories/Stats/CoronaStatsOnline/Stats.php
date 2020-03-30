<?php

namespace App\Repositories\Stats\CoronaStatsOnline;

use App\Repositories\Stats\StatsRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * Class CoronaStatsOnlineRepository
 * https://github.com/mathdroid/covid-19-api
 *
 * @package     App\Repositories\Stats\CoronaStatsOnline
 * @author      Ridvan Baluyos <ridvan@baluyos.net>
 * @link        https://github.com/sagarkarira/coronavirus-tracker-cli
 * @license     MIT
 */
class Stats implements StatsRepositoryInterface
{
    /* API Base URL endpoint */
    private $baseUrl;

    /* API Endpoint */
    private $endpoint;

    /**
     * CoronaStatsOnline constructor.
     */
    public function __construct()
    {
        $this->baseUrl = 'https://corona-stats.online';
    }

    /**
     * Sends the request to the API.
     *
     * @return mixed
     */
    public function request()
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->endpoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 240);
            $result = curl_exec($ch);

            return json_decode($result, true);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * This function gets the global stats.
     *
     * @return mixed
     */
    public function getStats()
    {
        $serializedKey = md5(serialize('global_stats'));
        if (Cache::has($serializedKey)) {
            $globalStats = Cache::get($serializedKey);
        } else {
            $this->endpoint = $this->baseUrl . '?format=json';
            $globalStats = $this->request();
            $expiresAt = Carbon::now()->addMinutes(30);
            Cache::put($serializedKey, $globalStats, $expiresAt);
        }

        return $globalStats;
    }
}
