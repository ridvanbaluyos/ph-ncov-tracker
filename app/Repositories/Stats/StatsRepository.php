<?php
namespace App\Repositories\Stats;

use App\Repositories\Stats\CoronaVirusPh\Stats as CoronaVirusPhStats;


/**
 * Class StatsRepository
 * @package App\Repositories
 */
class StatsRepository implements StatsRepositoryInterface
{
    private $statsRepository;

    public function __construct(StatsRepositoryInterface $statsRepository = null)
    {
        if ($statsRepository instanceof StatsRepositoryInterface) {
            $this->statsRepository = $statsRepository;
        } else {
            $this->statsRepository = new CoronaVirusPhStats();
        }
    }

    /**
     * @inheritDoc
     */
    public function getStats()
    {
        return $this->statsRepository->getStats();
    }

    public function getStatsByCountry($countryCode = null)
    {
        return $this->statsRepository->getStatsByCountry($countryCode);
    }
}
