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


// 'SELECT * FROM question LEFT OUTER JOIN reponse on question.id = reponse.question_id
// WHERE (reponse.answer_id != :idAnswer OR reponse.answer_id is null) AND question.filter_id is NOT null';
    public function getQuestionNonReponduByAnswerWithFilter($answerId) {
        $qb = $this->getEntityManager()->createQueryBuilder();

        return $qb->select('q')
            ->from('INSEADTurkeyBundle:Question', 'q')
            ->leftJoin('q.reponses', 'r', 'WITH', 'q.id=r.question')
            ->where('r.answer != :answerId')
            ->setParameter('answerId', $answerId)
            ->orWhere('r.answer is null')
            ->andWhere('q.filter is not null')
            ->getQuery()
            ->getResult();
    }

// 'SELECT * FROM question LEFT OUTER JOIN reponse on question.id = reponse.question_id
// WHERE (reponse.answer_id != :idAnswer OR reponse.answer_id is null) AND question.filter_id is null';
    public function getQuestionNonReponduByAnswerWithOutFilter($answerId) {
        $qb = $this->getEntityManager()->createQueryBuilder();

        return $qb->select('q')
            ->from('INSEADTurkeyBundle:Question', 'q')
            ->leftJoin('q.reponses', 'r', 'WITH', 'q.id=r.question')
            ->where('r.answer != :answerId')
            ->setParameter('answerId', $answerId)
            ->orWhere('r.answer is null')
            ->andWhere('q.filter is null')
            ->getQuery()
            ->getResult();
    }

// ex Flo
    public function getQuestionWithFilterForRandom($filtreLocation, $filtreAge, $filfreGender) {

        $qb = $this->createQueryBuilder('q');

        $qb->where('q.filter IS NOT NULL')
            ->join('q.filter', 'f');
        if ($filtreLocation){
            $qb->where('f.locations = :filtre');
            $param = array('filtreLocation' => $filtreLocation);
        }
        if ($filtreAge){
            $qb->where('f.ageMin >= :ageMin');
//            $qb->andWhere('f.ageMax <= :ageMax');
            $param = array('filtreAge' => $filtreAge);
        }
        if ($filfreGender) {
            $qb->where('f.gender = :$filfreGender');
            $param = array('filterGender' => $filfreGender);
        }

        $qb->setParameters($param);
        return $qb->getQuery()->getResult();

    }


// PAs effacer
    public function getQuestionWithoutFilter() {

        return $this->createQueryBuilder('q')
            ->where('q.filter IS NULL')
            ->getQuery()
            ->getResult();
    }
}