<?php

namespace App\Repository;

use App\Entity\TvSeries;
use App\Entity\TvSeriesIntervals;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TvSeriesIntervals>
 *
 * @method TvSeriesIntervals|null find($id, $lockMode = null, $lockVersion = null)
 * @method TvSeriesIntervals|null findOneBy(array $criteria, array $orderBy = null)
 * @method TvSeriesIntervals[]    findAll()
 * @method TvSeriesIntervals[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TvSeriesIntervalsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TvSeriesIntervals::class);
    }

    /**
     * @return Collection Returns a Collection of TvSeriesIntervals objects
     */
    public function getNextTvSeriesInterval(DateTime $date, string $title = null): Collection {
        $expressionBuilder = Criteria::expr();
        $startDay = $date->format('w');
        $tvSeriesIds = [];
        $weekdays = [
            0 => 'Sunday',
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
        ];

        //checks if there's any show with the title that was searched for 
        //if there is, gets the IDs of those shows
        if($title != null){
            $result = $this->getEntityManager()->getRepository(TvSeries::class)->findByTitle($title);
            foreach($result as $tvSeries){
                $tvSeriesIds[] = $tvSeries->getId();
            }
        }

        $count = 0;
        $day = $startDay;
        $flag = true;
        do {
            $criteria = new Criteria();
            $criteria->where($expressionBuilder->eq('week_day', $weekdays[$day]));

            //if its the same day as specified, filter by time greater or equal
            if($day == $startDay && $flag){
                $criteria->andWhere($expressionBuilder->gte('show_time', $date));
                $flag = false; //this flag is so that when we loop around the same day we dont compare hours again
            }

            //if title was provided, add clause with the series IDs
            if($title != null){
                $criteria->andWhere($expressionBuilder->in('id_tv_series', $tvSeriesIds));
            } 

            $criteria->setMaxResults(1)
                ->orderBy(['show_time' => Criteria::ASC]);
            $tvSeriesIntervals = $this->matching($criteria);
            
            //we will repeat this 8 times, or until we find a match
            if($day == 6){
                $day = 0;
            } else {
                $day++;
            }
            $count++;

        } while($tvSeriesIntervals->isEmpty() && $count <= 7);

        return $tvSeriesIntervals;
    }

//    /**
//     * @return TvSeriesIntervals[] Returns an array of TvSeriesIntervals objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TvSeriesIntervals
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
