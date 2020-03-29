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
     * This controller gets the home page.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {
        $mathdroid = new MathdroidStats();
        $coronaStats = new StatsRepository($mathdroid);
        $statsByCountry = $coronaStats->getStatsByCountry('PH');
        $dailyTimeSeriesByCountry = $coronaStats->getDailyStatsByCountry('Philippines');
        $data['statsByCountry'] = $statsByCountry;
        $data['dailyTimeSeriesByCountry'] = $dailyTimeSeriesByCountry;
        $data['lastUpdate'] = $statsByCountry['lastUpdate'];
        $chartDailyTimeSeriesByCountry = ChartHelper::formatLineChart($dailyTimeSeriesByCountry);

        $data['charts'] = [
            'dailyTimeSeriesByCountry' => $chartDailyTimeSeriesByCountry
        ];

        return response()->view('home', ['data' => $data]);
    }

    /**
     * This controller gets the patients page.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getPatients(Request $request)
    {
        $patientsCoronaVirusPh = new PatientsRepository();
        $patients = $patientsCoronaVirusPh->getPatients();

        $coronaVirusPh = new CoronaVirusPhStats();
        $coronaStats = new StatsRepository($coronaVirusPh);
        $stats = $coronaStats->getStats();

        $chartAgeGender = ChartHelper::formatStackedBarChartByAgesSexes($stats['ages_sexes']);
        $chartCasesDates = ChartHelper::formatLineBarChartCasesByDates($stats['dates']);

        $data['stats'] = $stats;
        $data['charts']['chartAgeGender'] = $chartAgeGender;
        $data['charts']['chartCasesDates'] = $chartCasesDates;
        $data['patients'] = $patients;

        return response()->view('patients', ['data' => $data]);
    }

    /**
     * This function gets the global stats page.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getGlobalStats(Request $request)
    {
        $mathdroid = new MathdroidStats();
        $coronaStats = new StatsRepository($mathdroid);
        $statsGlobal = $coronaStats->getGlobalStats();
        $statsTopCountriesByCases = $coronaStats->getTopCountriesByStatus('confirmed');
        $statsTopCountriesByDeaths = $coronaStats->getTopCountriesByStatus('deaths');
        $statsTopCountriesByRecovery = $coronaStats->getTopCountriesByStatus('recovered');

        //$dailyTimeSeriesByCountry = $coronaStats->getDailyStatsByCountry();
        //$statsByCountry = $coronaStats->getDailyStatsByCountry('Philippines');
        //$chartCasesByDatesCountry = ChartHelper::formatLineBarChartCasesByDatesCountry($statsByCountry);
        $stats = [
            'global' => $statsGlobal,
            'top_countries' => [
                'confirmed' => $statsTopCountriesByCases,
                'deaths' => $statsTopCountriesByDeaths,
                'recoveries' => $statsTopCountriesByRecovery,
            ],
            'charts' => [
                //'casesByDatesCountry' => $chartCasesByDatesCountry,
            ]
        ];

        $data = $stats;
        return response()->view('global-stats', ['data' => $data]);
    }
}
