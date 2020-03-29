<?php

namespace App\Helpers\Charts;

/**
 * Class ChartHelper
 * @package App\Helpers\Charts
 */
class ChartHelper
{
    public static function formatStackedBarChartByAgesSexes($stats)
    {
        // Labels
        $maleData = [];
        $femaleData = [];
        $tbaData = [];

        foreach ($stats as $ageBracket=>$sexes) {
            foreach ($sexes  as $sex=>$cases) {
                switch ($sex) {
                    case 'M':
                        array_push($maleData, count($cases));
                        break;
                    case 'F':
                        array_push($femaleData, count($cases));
                        break;
                    case 'TBA':
                        array_push($tbaData, count($cases));
                        break;
                }
            }
        }

        $labels = "['" . implode("','", array_keys($stats)) . "']";
        $maleData= "['" . implode("','", $maleData) . "']";
        $femaleData= "['" . implode("','", $femaleData) . "']";
        $tbaData= "['" . implode("','", $tbaData) . "']";

        return [
            'labels' => $labels,
            'maleData' => $maleData,
            'femaleData' => $femaleData,
            'tbaData' => $tbaData
        ];
    }

    public static function formatLineBarChartCasesByDates($stats)
    {
        $cumulative = [];

        $prev = null;
        foreach ($stats as $date=>$count) {
            if (!$prev) {
                $cumulative[$date] = $count;
            } else {
                $cumulative[$date] = $prev + $count;
            }
            $prev = $cumulative[$date];
        }

        $labels = "['" . implode("','", array_keys($stats)) . "']";
        $dates = "['" . implode("','", array_values($stats)) . "']";
        $cumulative = "['" . implode("','", array_values($cumulative)) . "']";

        return [
            'labels' => $labels,
            'dates' => $dates,
            'cumulative' => $cumulative
        ];
    }

    /**
     * This function formats the data to be used in a  line chart.
     *
     * @param $data
     * @return array
     */
    public static function formatLineChart($data)
    {
        $labels = "['" . implode("','", array_keys($data)) . "']";
        $confirmed = [];
        $deaths = [];
        $recoveries = [];
        $active = [];
        $recoveryRate = [];
        $mortalityRate = [];

        foreach ($data as $status) {
            array_push($confirmed, (int) $status['confirmed']);
            array_push($deaths, (int) $status['deaths']);
            array_push($recoveries, (int) $status['recovered']);
            array_push($active, (int) $status['confirmed'] - ($status['deaths'] + $status['recovered']));
            array_push($recoveryRate, $status['recoveryRate']);
            array_push($mortalityRate, $status['mortalityRate']);
        }

        // Assemble data for Charts
        $confirmed      = "['" . implode("','", array_values($confirmed)) . "']";
        $deaths         = "['" . implode("','", array_values($deaths)) . "']";
        $recoveries     = "['" . implode("','", array_values($recoveries)) . "']";
        $active         = "['" . implode("','", array_values($active)) . "']";
        $recoveryRate   = "['" . implode("','", array_values($recoveryRate)) . "']";
        $mortalityRate  = "['" . implode("','", array_values($mortalityRate)) . "']";

        return [
            'labels'        => $labels,
            'confirmed'     => $confirmed,
            'deaths'        => $deaths,
            'recoveries'    => $recoveries,
            'active'        => $active,
            'recoveryRate'  => $recoveryRate,
            'mortalityRate' => $mortalityRate,
        ];
    }
}