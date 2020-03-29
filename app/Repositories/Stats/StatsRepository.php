<?php
namespace App\Repositories\Stats;

use App\Repositories\Stats\CoronaVirusPh\Stats as CoronaVirusPhStats;


/**
 * Class StatsRepository
 * @package App\Repositories
 */
class StatsRepository implements StatsRepositoryInterface
{
    /* The Stats Repository to be used. */
    private $statsRepository;

    /**
     * StatsRepository constructor.
     * @param StatsRepositoryInterface|null $statsRepository
     */
    public function __construct(StatsRepositoryInterface $statsRepository = null)
    {
        if ($statsRepository instanceof StatsRepositoryInterface) {
            $this->statsRepository = $statsRepository;
        } else {
            $this->statsRepository = new CoronaVirusPhStats();
        }
    }

    /**
     * @return mixed|null
     */
    public function getStats()
    {
        return $this->statsRepository->getStats();
    }

    /**
     * @param null $countryCode
     * @return array
     */
    public function getStatsByCountry($countryCode = null)
    {
        return $this->statsRepository->getStatsByCountry($countryCode);
    }

    /**
     * @param string $status
     * @param int $limit
     */
    public function getTopCountriesByStatus(string $status, int $limit = 5)
    {
        return $this->statsRepository->getTopCountriesByStatus($status, $limit);
    }

    /**
     * @return array
     */
    public function getGlobalStats()
    {
        return $this->statsRepository->getGlobalStats();
    }

    /**
     * @param null $country
     * @param null $startDate
     * @param null $endDate
     */
    public function getDailyStatsByCountry($country = null, $startDate = null, $endDate = null)
    {
        $startDate = $startDate ?? '2020-01-22';
        $endDate = $endDate ?? date('Y-m-d');

        if (is_null($country)) {
            return $this->statsRepository->getDailyStatsGlobal($startDate, $endDate);
        } else {
            return $this->statsRepository->getDailyStatsByCountry($country, $startDate, $endDate);
        }
    }
}
