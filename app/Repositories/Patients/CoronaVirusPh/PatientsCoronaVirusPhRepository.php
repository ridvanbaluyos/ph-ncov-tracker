<?php
namespace App\Repositories\Patients\CoronaVirusPh;

use App\Repositories\PatientsRepositoryInterface;

/**
 * Class StatsCoronaStatsRepository
 * https://coronavirus-ph-api.now.sh
 *
 * @package    App\Repositories\Patients\CoronaVirusPh
 * @author     Ridvan Baluyos <ridvan@baluyos.net>
 * @link       https://github.com/ridvanbaluyos/ph-covidtracker
 * @license    MIT
 */
class PatientsCoronaVirusPhRepository implements PatientsRepositoryInterface
{
    /* API Base URL endpoint */
    private $url;

    /**
     * PatientsCoronaVirusPhRepository constructor.
     */
    public function __construct()
    {
        $this->url = 'https://coronavirus-ph-api.now.sh/cases';
    }

    /**
     * This function gets the patients database.
     *
     * @return array
     */
    public function getPatients()
    {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 240);
        $result = curl_exec($ch);
        $result = json_decode($result, true);

        $patients = $this->normalizeData($result);

        return $patients;
    }

    /**
     * This function normalizes the data that we fetch from the API.
     * Some of the columns are very long or are possibly politically incorrect,
     * so we will correct it here.
     *
     * @param $results
     * @return array
     */
    private function normalizeData($results)
    {
        $patients = [];
        foreach ($results as $result) {
            $patient = [];
            $patient['case'] = str_pad($result['case_no'], 3, 0, STR_PAD_LEFT);
            $patient['date'] = $result['date'];
            $patient['age'] = $result['age'];
            $patient['sex'] = $this->normalizeSex($result['gender']);
            $patient['nationality'] = $result['nationality'];
            $patient['hospital'] = $this->normalizeHospital($result['hospital_admitted_to']);
            $patient['travel_history'] = $result['had_recent_travel_history_abroad'];
            $patient['status'] = $result['status'];

            $patients[] = $patient;
        }

        return $patients;
    }

    /**
     * This function normalizes the sex column of the patients. We will use long
     * description instead of acronym.
     *
     * @param $sex
     * @return string
     */
    private function normalizeSex($sex)
    {
        switch ($sex) {
            case 'M':
                $sex = 'Male';
                break;
            case 'F':
                $sex = 'Female';
                break;
            default:
                $sex = 'Unspecified';
                break;
        }

        return $sex;
    }

    /**
     * This function normalizes the hospital names. There are several duplicated or inconsistent
     * hospital names. We will try to fix them in brute force. Also, some patients were transferred
     * or moved to other hospitals. This function will use the latest hospital information.
     *
     * @param $hospital
     * @return false|string
     */
    private function normalizeHospital($hospital)
    {
        if (stripos($hospital, 'transferred to ') !== false) {
            $hospital = substr($hospital, strpos($hospital, 'transferred to ') + 15);
        }

        if (stripos($hospital, 'Asian Hospital and Medical Center') !== false) {
            $hospital = 'Asian Hospital and Medical Center';
        }

        if (stripos($hospital, 'Dr. Jose N. Rodriguez Memorial Hospital') !== false) {
            $hospital = 'Dr. Jose N. Rodriguez Memorial Hospital';
        }

        if (stripos($hospital, 'Jose B. Lingad Memorial Regional Hospital') !== false) {
            $hospital = 'Jose B. Lingad Memorial Regional Hospital';
        }

        if (stripos($hospital, 'Lung Center of the Philippine') !== false) {
            $hospital = 'Lung Center of the Philippines';
        }

        if (stripos($hospital, 'Northern Mindanao Medical Center') !== false) {
            $hospital = 'Northern Mindanao Medical Center';
        }

        if (stripos($hospital, 'Philippine Heart Center') !== false) {
            $hospital = 'Philippine Heart Center';
        }

        if (stripos($hospital, 'Quirino Medical Center') !== false) {
            $hospital = 'Quirino Memorial Medical Center';
        }

        if (stripos($hospital, 'Research Institute for Tropical Medicine') !== false) {
            $hospital = 'Research Institute for Tropical Medicine';
        }

        if (stripos($hospital, 'San Lazaro Hospital') !== false) {
            $hospital = 'San Lazaro Hospital';
        }

        if (stripos($hospital, 'University of the East') !== false) {
            $hospital = 'University of the East - Ramon Magsaysay Memorial Medical Center';
        }

        if (stripos($hospital, 'the Silliman University Medical Center') !== false) {
            $hospital = 'Siliman University Medical Center';
        }

        if (stripos($hospital, 'St. Luke\'s Medical Center–Quezon City') !== false) {
            $hospital = 'St. Luke\'s Medical Center - Quezon City';
        }

        if (stripos($hospital, 'St. Luke\'s Medical Center–Global City') !== false) {
            $hospital = 'St. Luke\'s Medical Center - Bonifcacio Global City';
        }

        if (stripos($hospital, 'Chinese General Hospital') !== false) {
            $hospital = 'Chinese General Hospital and Medical Center';
        }

        if (stripos($hospital, 'RESU-NCR') !== false) {
            $hospital = 'RESU-NCR (Reporting Facility)';
        }

        if (stripos($hospital, 'University of Sto. Tomas') !== false) {
            $hospital = 'University of Santo Tomas Hospital';
        }

        if (stripos($hospital, 'University of Sto. Tomas') !== false) {
            $hospital = 'University of Santo Tomas Hospital';
        }

        if (stripos($hospital, 'University of Sto. Tomas') !== false) {
            $hospital = 'University of Santo Tomas Hospital';
        }

        return $hospital;
    }
}
