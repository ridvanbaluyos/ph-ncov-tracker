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
    private $url;

    /* Country Code */
    private $countryCode = null;

    /**
     * MathdroidStatsRepository constructor.
     */
    public function __construct()
    {
        $this->url = 'https://covid19.mathdro.id/api';
    }

    /**
     * @return mixed
     */
    public function getStats()
    {
        if ($this->countryCode !== null) {
            $this->url = $this->url . '/countries/' . $this->countryCode;
        }

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 240);
        $result = curl_exec($ch);
        $stats = json_decode($result, true);

        return $stats;
    }

    public function getStatsByCountry($countryCode = null)
    {
        $this->countryCode = $countryCode;
        return $this->getStats();
    }

    /**
     * @param $stats
     * @return mixed
     */
    private function getTotalActive($stats)
    {
        return $stats['confirmed']['value'] - $stats['deaths']['value'] - $stats['recovered']['value'];
    }
}
