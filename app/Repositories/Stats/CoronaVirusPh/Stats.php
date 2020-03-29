<?php
namespace App\Repositories\Stats\CoronaVirusPh;

use App\Repositories\Stats\StatsRepositoryInterface;
use Illuminate\Support\Facades\Cache;

/**
 * Class StatsCoronaStatsRepository
 * https://coronavirus-ph-api.now.sh
 *
 * @package    App\Http\Repositories\Stats\CoronaStats
 * @author     Ridvan Baluyos <ridvan@baluyos.net>
 * @link       https://github.com/ridvanbaluyos/ph-covidtracker
 * @license    MIT
 */
class Stats implements StatsRepositoryInterface
{
    /* API Base URL endpoint */
    private $url;

    /**
     * StatsCoronaStatsRepository constructor.
     */
    public function __construct()
    {
        $this->url = 'https://coronavirus-ph-api.now.sh/cases';
    }

    /**
     * This function gets the statistics of the patients.
     *
     * @return mixed|null
     */
    public function request()
    {
        $serializedKey = md5(serialize('stats_') . date('Y-m-d'));
        try {
            if (Cache::has($serializedKey)) {
                return Cache::get($serializedKey);
            } else {
                $ch = curl_init();
                curl_setopt($ch,CURLOPT_URL, $this->url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 240);
                $result = curl_exec($ch);
                $cases = json_decode($result, true);
                $stats = $this->normalizeData($cases);
                $stats['ages_sexes'] = $this->getAgeBySexData($cases);
                //$stats['dates_statuses'] = $this->getDatesByStatusData($cases);

                Cache::forever($serializedKey, $stats);
                return $stats;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getStats()
    {
        return $this->request();
    }

    /**
     * Unavailable for this repository.
     *
     * @param $countryCode
     * @return array
     */
    public function getStatsByCountry($countryCode)
    {
        return [];
    }


    /**
     * Unavailable for this repository.
     *
     * @return array
     */
    public function getGlobalStats()
    {
        return [];
    }

    /**
     * Unavailable for this repository.
     *
     * @param string $status
     * @param int $limit
     */
    public function getTopCountriesByStatus(string $status, int $limit)
    {
    }

    /**
     * This function normalizes the data that we fetch from the API. We will assemble
     * the statistics based on a category, and return the classified data structure.
     *
     * Classifications:
     *  dates - # of patients per day
     *  sexes - # of patients per sex
     *  status - # of patients per status
     *  travel_history - # of patients per travel history
     *
     * @param $cases
     * @return mixed
     */
    private function normalizeData($cases)
    {
        // TODO: Optimize and simplify.
        $stats['ages'] = [
            '~17' => 0,
            '18-30' => 0,
            '31-45' => 0,
            '46-60' => 0,
            '61~' => 0,
            'tba' => 0,
        ];
        $stats['dates'] = [];
        $stats['sexes'] = [];
        $stats['status'] = [];
        $stats['travel_history'] = [];

        $dateCtr = [];
        $sexCtr = [];
        $statusCtr = [];
        $travelHistoryCtr = [];

        $stats['status']['confirmed'] = count($cases);
        foreach ($cases as $case)
        {
            // Dates Stats
            $date = $case['date'];
            if (!array_key_exists($date, $stats['dates'])) {
                $dateCtr[$date] = 1;
                $stats['dates'][$date] = $dateCtr[$date];
            } else {
                $stats['dates'][$date] = ++$dateCtr[$date];
            }

            // Sex Stats
            $sex = $case['gender'];
            if (!array_key_exists($sex, $stats['sexes'])) {
                $sexCtr[$sex] = 1;
                $stats['sexes'][$sex] = $sexCtr[$sex];
            } else {
                $stats['sexes'][$sex] = ++$sexCtr[$sex];
            }

            // Status Stats
            $status = strtolower($case['status']);
            if (!array_key_exists($status, $stats['status'])) {
                $statusCtr[$status] = 1;
                $stats['status'][$status] = $statusCtr[$status];
            } else {
                $stats['status'][$status] = ++$statusCtr[$status];
            }

            // Travel History Stats
            $travelHistory = $case['had_recent_travel_history_abroad'];
            if (!array_key_exists($travelHistory, $stats['travel_history'])) {
                $travelHistoryCtr[$travelHistory] = 1;
                $stats['travel_history'][$travelHistory] = $travelHistoryCtr[$travelHistory];
            } else {
                $stats['travel_history'][$travelHistory] = ++$travelHistoryCtr[$travelHistory];
            }

            // Age Stats
            $age = $case['age'];
            if (!is_integer($age)) {
                ++$stats['ages']['tba'];
            } elseif ($age < 17) {
                ++$stats['ages']['~17'];
            } elseif ($age >= 17 && $age <= 30) {
                ++$stats['ages']['18-30'];
            } elseif ($age >= 31 && $age <= 45) {
                ++$stats['ages']['31-45'];
            } elseif ($age >= 46 && $age <= 60) {
                ++$stats['ages']['46-60'];
            } elseif ($age >= 61) {
                ++$stats['ages']['61~'];
            }
        }

        return $stats;
    }

    public function getDailyStatsGlobal(?string $startDate, ?string $endDate)
    {
    }

    public function getDailyStatsByCountry($country, ?string $startDate, ?string $endDate)
    {
    }

    private function getDatesByStatusData($cases)
    {
        $stats = [];
        $datesStatusCtr = [];
        foreach ($cases as $case) {
            // Dates Stats
            $date = $case['date'];
            $status = strtolower($case['status']);
            if (!array_key_exists($date, $stats)) {
                $stats['dates'][$date] = [];
                if (!array_key_exists($status, $stats['dates'][$date])) {
                    $datesStatusCtr[$date][$status] = 1;
                    $stats['dates'][$date][$status] = ++$datesStatusCtr[$date][$status];
                } else {
                    $stats['dates'][$date][$status] = ++$datesStatusCtr[$date][$status];
                }
            } else {
                if (!array_key_exists($status, $stats['dates'][$date])) {
                    $stats['dates'][$date][$status] = ++$datesStatusCtr[$date][$status];
                } else {
                    $stats['dates'][$date][$status] = [];
                }
            }
        }

        return $stats;
    }

    private function getAgeBySexData($cases)
    {
        $sexes = [
            'M' => [],
            'F' => [],
            'TBA' => []
        ];
        $ageBrackets = [
            '0-17' => $sexes,
            '18-30' => $sexes,
            '31-45' => $sexes,
            '45-60' => $sexes,
            '61-100' => $sexes,
            'TBA' => $sexes
        ];
        $data = $ageBrackets;

        foreach ($cases as $case) {
            $age = $case['age'];
            $sex = $case['gender'];

            foreach ($ageBrackets as $ageBracket => $v) {
                // TBA
                if ($ageBracket === 'TBA') {
                    if ($age === 'TBA') {
                        $data[$ageBracket][$sex][] = $case['case_no'];
                    }
                } else {
                    list($startAge, $endAge) = explode('-', $ageBracket);

                    if ($age >= $startAge && $age <= $endAge) {
                        $data[$ageBracket][$sex][] = $case['case_no'];
                    }
                }
            }
        }

        return $data;
    }
}
