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

    public function getGenerateData(Request $request)
    {
        // January 22, 2020 is the earliest data we have for mathdroid API.
        $startTime = $request->input('startTime', '2020-01-22');
        $endTime = $request->input('endTime', date('Y-m-d'));

        $mathdroid = new MathdroidStats();
        $coronaStats = new StatsRepository($mathdroid);

        $dailyStats = $coronaStats->getDailyStatsByCountry('Philippines', $startTime, $endTime);

        dd($dailyStats);
    }
}
