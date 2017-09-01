<?php

namespace Waigeo\JSLoggerBundle\Repository;

use Waigeo\JSLoggerBundle\Entity\LogEntry;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class LogEntryRepository extends EntityRepository
{
    /**
     * @return mixed Retourne une liste de compte extranet
     */
    public function listLogsError($pageSize, $pageIndex, $filterMessage, $filterUrl, $filterUserAgent, $sortField, $sortOrder)
    {
        $queryParameters = array();

        $queryBuilder = $this->createQueryBuilder('l')
            ->select('l');

        $this->addFilterToTheQuery($queryBuilder, $queryParameters, $filterMessage, $filterUrl, $filterUserAgent);

        // Ajout du tri si présent
        if($sortField !== null && $sortField != ''){
            switch ($sortField){
                case "message": $queryBuilder->orderBy('l.message', $sortOrder);
                    break;
                case "url": $queryBuilder->orderBy('l.url', $sortOrder);
                    break;
                case "userAgent": $queryBuilder->orderBy('l.userAgent', $sortOrder);
                    break;
            }
        }
        else{
            $queryBuilder->orderBy('l.createdDate', 'DESC');
        }

        $listLogsQuery = $queryBuilder
            ->setParameters($queryParameters)
            ->setFirstResult(($pageIndex - 1) * $pageSize) // le page index n'est pas en base 0 (comme doctrine l'attend) mais en base 1
            ->setMaxResults($pageSize)
            ->getQuery();

        return $listLogsQuery->getArrayResult();
    }

    /*
     * Retourne le nombre de logs d'erreurs qui correspondent aux critères
     */
    public function countLogs($filterMessage, $filterUrl, $filterUserAgent)
    {
        $queryParameters = array();

        $queryBuilder = $this->createQueryBuilder('l')
            ->select('COUNT(l)');

        $this->addFilterToTheQuery($queryBuilder, $queryParameters, $filterMessage, $filterUrl, $filterUserAgent);

        $countLogsQuery = $queryBuilder
            ->setParameters($queryParameters)
            ->getQuery();

        return $countLogsQuery->getSingleScalarResult();
    }

    /**
     * Méthode permettant d'ajouter les filtres à la requête spécifié
     * @param $queryBuilder
     * @param $queryParameters
     * @param $filterMessage
     * @param $filterUrl
     * @param $filterUserAgent
     */
    private function addFilterToTheQuery(&$queryBuilder, &$queryParameters, $filterMessage, $filterUrl, $filterUserAgent){

        $queryBuilder->where('l.message LIKE :message')
            ->andWhere('l.url LIKE :url')
            ->andWhere('l.userAgent LIKE :userAgent');

        $queryParameters['message'] = "%". $filterMessage . "%";
        $queryParameters['url'] = "%". $filterUrl . "%";
        $queryParameters['userAgent'] = "%". $filterUserAgent . "%";
    }
}