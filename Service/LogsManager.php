<?php
namespace Waigeo\JSLoggerBundle\Service;

use Doctrine\ORM\EntityManager;
use Waigeo\JSLoggerBundle\Entity\LogEntry;

class LogsManager
{
    /**
     * @var Il s'agit du service entitymanager qui récupère les repositories
     */
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function saveLogError($message, $url, $lineNumber, $colNumber, $userAgent){
        $logEntry = new LogEntry();
        $logEntry->setCreatedDate(new \DateTime('NOW', new \DateTimeZone('Europe/Paris')));
        $logEntry->setMessage($message);
        $logEntry->setUrl($url);
        $logEntry->setLineNumber($lineNumber);
        $logEntry->setColNumber($colNumber);
        $logEntry->setUserAgent($userAgent);

        $this->em->persist($logEntry);
        $this->em->flush();
    }

    public function listLogsError($pageSize, $pageIndex, $filterMessage, $filterUrl, $filterUserAgent, $sortField, $sortOrder){
        $logEntryRepository = $this->em->getRepository('Waigeo\JSLoggerBundle\Entity\LogEntry');

        $logList = $logEntryRepository->listLogsError($pageSize, $pageIndex, $filterMessage, $filterUrl, $filterUserAgent, $sortField, $sortOrder);

        return array(
            "data" => $logList,
            "itemsCount" =>  $logEntryRepository->countLogs($filterMessage, $filterUrl, $filterUserAgent)
        );
    }
}