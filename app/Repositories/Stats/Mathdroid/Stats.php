<?php
namespace App\Repositories\Stats\Mathdroid;

use App\Repositories\Stats\StatsRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

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
     * Sends the request to the API.
     * @return mixed
     */
    public function request()
    {
        try {
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, $this->endpoint);
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
    public function getGlobalStats()
    {
        $serializedKey = md5(serialize('global_stats'));
        if (Cache::has($serializedKey)) {
            $globalStats = Cache::get($serializedKey);
        } else {
            $this->endpoint = $this->baseUrl;
            $globalStats = $this->request();
            $expiresAt = Carbon::now()->addMinutes(30);
            Cache::put($serializedKey, $globalStats, $expiresAt);
        }

        return $globalStats;
    }

    public function getDailyStatsGlobal($startDate, $endDate)
    {
        $serializedKey = md5(serialize('global_daily_stats'));
        if (Cache::has($serializedKey)) {
            $globalDailyStats = Cache::get($serializedKey);
        } else {
            $this->endpoint = $this->baseUrl . '/daily';
            $result = $this->request();

            $globalDailyStats = [];
            foreach ($result as $dailyStats) {
                $date = $dailyStats['reportDate'];
                $globalDailyStats[$date] = [
                    'confirmed' => $dailyStats['confirmed']['total'] ?? 0,
                    'recovered' => $dailyStats['recovered']['total'] ?? 0,
                    'deaths' => $dailyStats['deaths']['total'] ?? 0,
                    'deltaConfirmed' => $dailyStats['deltaConfirmed'] ?? 0,
                    'deltaRecovered' => $dailyStats['deltaRecovered'] ?? 0,
                    'deltaDeaths' => $dailyStats['deltaDeaths'] ?? 0,
                ];
            }
        }

        return $globalDailyStats;
    }

    /**
     * This function gets the stats of a country.
     *
     * @param $country
     * @return mixed
     */
    public function getStatsByCountry($country)
    {
        $serializedKey = md5(serialize('stats_by_country_' . $country));
        if (Cache::has($serializedKey)) {
            $statsByCountry = Cache::get($serializedKey);
        } else {
            $this->endpoint =  $this->baseUrl . '/countries/' . $country;
            $statsByCountry = $this->request();
            $expiresAt = Carbon::now()->addMinutes(30);
            Cache::put($serializedKey, $statsByCountry, $expiresAt);
        }

        return $statsByCountry;
    }

    public function getStats()
    {
        // TODO: Implement getStats() method.
    }


    public function getTopCountriesByStatus($status, $limit = 5)
    {
        $serializedKey = md5(serialize('top_countries_by_status') . $status);
        if (Cache::has($serializedKey)) {
            $stats = Cache::get($serializedKey);
        } else {
            $this->endpoint = $this->baseUrl . '/' . $status;
            $stats = $this->request();
            $stats = array_slice($stats, 0, $limit);

            $expiresAt = Carbon::now()->addMinutes(30);
            Cache::put($serializedKey, $stats, $expiresAt);

        }

        return $stats;
    }

    public function getDailyStatsByCountry($country, $startDate, $endDate)
    {
        $dateCtr = $startDate;
        $daily = [];

        while ($dateCtr <= $endDate) {
            $serializedKey = md5(serialize('daily_stats_by_country') . $country . $dateCtr);

            if (Cache::has($serializedKey)) {
                $dailyTimeSeries = Cache::get($serializedKey);
            } else {
                $dateParam = date('n-d-Y', strtotime($dateCtr));
                $url = 'https://covid19.mathdro.id/api/daily/' . $dateParam;

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 240);
                $result = curl_exec($ch);
                $dailyTimeSeries = json_decode($result, true);

                $expiresAt = Carbon::now()->addDays(1);
                Cache::put($serializedKey, $dailyTimeSeries, $expiresAt);
            }

            if (!empty($dailyTimeSeries)) {
                foreach ($dailyTimeSeries as $timeSeries) {
                    if ($timeSeries['countryRegion'] === 'Philippines') {
                        $confirmed = ($timeSeries['confirmed'] === '')
                            ? 0
                            : $timeSeries['confirmed'];
                        $deaths = ($timeSeries['deaths'] === '')
                            ? 0
                            : $timeSeries['deaths'];
                        $recovered = ($timeSeries['recovered'] === '')
                            ? 0
                            : $timeSeries['recovered'];

                        $recoveryRate  = ($confirmed !== 0)
                            ? round($recovered / $confirmed, 4) * 100
                            : 0;
                        $mortalityRate = ($confirmed !== 0)
                            ? round($deaths / $confirmed, 4) * 100
                            : 0;

                        $daily[$dateCtr] = [
                            'confirmed' => $confirmed,
                            'deaths' => $deaths,
                            'recovered' => $recovered,
                            'active' => $confirmed - ($deaths + $recovered),
                            'mortalityRate' => $recoveryRate,
                            'recoveryRate'  => $mortalityRate,
                        ];
                    }
                }

            }
            $dateCtr = date('Y-m-d', strtotime($dateCtr . ' +1 day'));
        }

       return $daily;
    }
}
