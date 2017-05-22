<?php
/**
 * Created by PhpStorm.
 * User: acrobat
 * Date: 11/05/2017
 * Time: 00:24
 */

namespace INSEAD\TurkeyBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class QuestionRepository extends \Doctrine\ORM\EntityRepository
{
    public function getQuestionWithFilter() {

        return $this->createQueryBuilder('q')
                    ->where('q.filter IS NOT NULL')
                    ->getQuery()
                    ->getResult();
    }

    public function getQuestionWithoutFilter() {

        return $this->createQueryBuilder('q')
            ->where('q.filter IS NULL')
            ->getQuery()
            ->getResult();
    }
}