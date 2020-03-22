<?php
namespace App\Http\Repositories\Mathdroid;

use App\Repositories\StatsRepositoryInterface;

/**
 * Class MathdroidStatsRepository
 * @package App\Http\Repositories\Mathdroid
 */
class MathdroidStatsRepository implements StatsRepositoryInterface
{
    /* API Base URL endpoint */
    private $url;

    /**
     * MathdroidStatsRepository constructor.
     */
    public function __construct()
    {
        $this->url = 'https://covid19.mathdro.id/api/countries/PH';
    }

    /**
     * @return mixed
     */
    public function getStats()
    {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 240);
        $result = curl_exec($ch);
        $stats = json_decode($result, true);
        $stats['active']['value'] = $this->getTotalActive($stats);

        return $stats;
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
