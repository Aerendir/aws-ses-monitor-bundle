<?php

namespace SerendipityHQ\Bundle\AwsSesMonitorBundle\Controller;

use Aws\Credentials\Credentials;
use SerendipityHQ\Bundle\AwsSesMonitorBundle\Service\HandlerFactory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller to handle notifications.
 */
class NotifyController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function notifyAction(Request $request)
    {
        /** @var HandlerFactory $factory */
        $factory = $this->get('aws_ses_monitor.handler.factory');

        $monitorHandler = $factory->buildHandler($request);
        $responseCode = $monitorHandler->handleRequest($request, $this->getCredentials());

        return new Response('', $responseCode);
    }

    /**
     * @return Credentials
     */
    protected function getCredentials()
    {
        $credentials = $this->getParameter('aws_ses_monitor.aws_config')['credentials_service_name'];

        return $this->get($credentials);
    }
}