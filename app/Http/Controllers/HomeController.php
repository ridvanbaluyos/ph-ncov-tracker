<?php

namespace App\Http\Controllers;
use App\Helpers\Charts\ChartHelper;

use http\Client\Response;
use Illuminate\Http\Request;

use App\Repositories\StatsRepository;
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
        $coronaStats = new StatsRepository();
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
}
