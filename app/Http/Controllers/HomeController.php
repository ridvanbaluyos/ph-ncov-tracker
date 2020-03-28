<?php

namespace App\Http\Controllers;
use App\Helpers\Charts\ChartHelper;

use http\Client\Response;
use Illuminate\Http\Request;

use App\Repositories\Stats\CoronaVirusPh\Stats as CoronaVirusPhStats;
use App\Repositories\Stats\Mathdroid\Stats as MathdroidStats;
use App\Repositories\Stats\StatsRepository;
use App\Repositories\PatientsRepository;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {
        $coronaVirusPh = new CoronaVirusPhStats();
        $coronaStats = new StatsRepository($coronaVirusPh);
        $stats = $coronaStats->getStats();

        $chartAgeGender = ChartHelper::formatStackedBarChartByAgesSexes($stats['ages_sexes']);
        $chartCasesDates = ChartHelper::formatLineBarChartCasesByDates($stats['dates']);

        $data['stats'] = $stats;
        $data['charts']['chartAgeGender'] = $chartAgeGender;
        $data['charts']['chartCasesDates'] = $chartCasesDates;

        return response()->view('home', ['data' => $data]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getPatients(Request $request)
    {
        $coronaVirusPh = new PatientsRepository();
        $patients = $coronaVirusPh->getPatients();

        $data['patients'] = $patients;

        return response()->view('patients', ['data' => $data]);
    }

    public function getGlobalStats(Request $request)
    {
        $mathdroid = new MathdroidStats();
        $coronaStats = new StatsRepository($mathdroid);
        $statsGlobal = $coronaStats->getGlobalStats();
        $statsTopCountriesByCases = $coronaStats->getTopCountriesByStatus('confirmed');
        $statsTopCountriesByDeaths = $coronaStats->getTopCountriesByStatus('deaths');
        $statsTopCountriesByRecovery = $coronaStats->getTopCountriesByStatus('recovered');

        $stats = [
            'global' => $statsGlobal,
            'top_countries' => [
                'confirmed' => $statsTopCountriesByCases,
                'deaths' => $statsTopCountriesByDeaths,
                'recoveries' => $statsTopCountriesByRecovery,
            ],
            'countries' => []
        ];
//        $statsByCountry = $coronaStats->getStatsByCountry();

        $data['stats'] = $stats;
        return response()->view('global-stats', ['data' => $data]);
    }
}
