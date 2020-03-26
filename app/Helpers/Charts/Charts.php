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
}