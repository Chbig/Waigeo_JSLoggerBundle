<?php

namespace Waigeo\JSLoggerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Waigeo\JSLoggerBundle\Model\ServiceResponse;

class JSLoggerController extends Controller
{
    public function indexAction()
    {
        return $this->render('WaigeoJSLoggerBundle:Default:index.html.twig');
    }

    public function saveLogAction(Request $request)
    {
        $response = new ServiceResponse();
        $serializer = $this->container->get('waigeo_js_logger.serializer');

        try{
            $message = $request->query->get('message');
            $url = $request->query->get('url');
            $lineNumber = $request->query->get('lineNumber');
            $colNumber = $request->query->get('colNumber');
            $userAgent = $request->query->get('userAgent');
            $logsManager = $this->container->get('waigeo_js_logger.logsManager');

            $logsManager->saveLogError($message, $url, $lineNumber, $colNumber, $userAgent);
            $response->setData(true);
        }
        catch(Exception $e){
            $response->setSuccess(false);
        }

        $response = $serializer->serialize($response, 'json');
        return new JsonResponse($response);
    }

    public function listLogsAction(Request $request)
    {
        $response = new ServiceResponse();
        $serializer = $this->container->get('waigeo_js_logger.serializer');

        try{
            $pageSize = $request->query->get('pageSize');
            $pageIndex = $request->query->get('pageIndex');
            $filterMessage = $request->query->get('filterMessage');
            $filterUrl = $request->query->get('filterUrl');
            $filterUserAgent = $request->query->get('filterUserAgent');
            $sortField = $request->query->get('sortField');
            $sortOrder = $request->query->get('sortOrder');

            $logsManager = $this->container->get('waigeo_js_logger.logsManager');
            $response->setData($logsManager->listLogsError($pageSize, $pageIndex, $filterMessage, $filterUrl, $filterUserAgent, $sortField, $sortOrder));
        }
        catch(Exception $e){
            $response->setSuccess(false);
        }

        $response = $serializer->serialize($response, 'json');
        return new JsonResponse($response);
    }
}
