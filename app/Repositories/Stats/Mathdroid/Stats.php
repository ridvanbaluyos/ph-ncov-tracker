<?php
namespace App\Repositories\Stats\Mathdroid;

use App\Repositories\Stats\StatsRepositoryInterface;

/**
 * Class MathdroidStatsRepository
 * @package App\Http\Repositories\Mathdroid
 */
class Stats implements StatsRepositoryInterface
{
    /* API Base URL endpoint */
    private $baseUrl;

    /* API Endpoint */
    private $endpoint;

    /**
     * MathdroidStatsRepository constructor.
     */
    public function __construct()
    {
        $this->baseUrl = 'https://covid19.mathdro.id/api';
    }

    /**
     * @return mixed
     */
    public function request()
    {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $this->endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 240);
        $result = curl_exec($ch);
        $stats = json_decode($result, true);

        return $stats;
    }

    public function getStats()
    {
        // TODO: Implement getStats() method.
    }

    public function getGlobalStats()
    {
        $this->endpoint = $this->baseUrl;
        return $this->request();
    }

    public function getStatsByCountry($countryCode = null)
    {
        $this->endpoint =  $this->baseUrl . '/countries/' . $countryCode;
        return $this->request();
    }

    public function getTopCountriesByStatus($status, $limit = 5)
    {
        $this->endpoint = $this->baseUrl . '/' . $status;
        $stats = $this->request();

        if (is_null($stats)) {
            echo $this->endpoint;
            dd($status);
        }
        $stats = array_slice($stats, 0, $limit);

        return $stats;
    }
}
