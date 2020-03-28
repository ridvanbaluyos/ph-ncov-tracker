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

    public function __construct(StatsRepositoryInterface $statsRepository = null)
    {
        if ($statsRepository instanceof StatsRepositoryInterface) {
            $this->statsRepository = $statsRepository;
        } else {
            $this->statsRepository = new CoronaVirusPhStats();
        }
    }

    public function getStats()
    {
        return $this->statsRepository->getStats();
    }

    public function getStatsByCountry($countryCode = null)
    {
        return $this->statsRepository->getStatsByCountry($countryCode);
    }

    public function getTopCountriesByStatus(string $status, int $limit = 5)
    {
        return $this->statsRepository->getTopCountriesByStatus($status, $limit);
    }

    public function getGlobalStats()
    {
        return $this->statsRepository->getGlobalStats();
    }
}
