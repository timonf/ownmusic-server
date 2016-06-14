<?php

namespace ServerBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use ServerBundle\Model\Track;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/tracks")
 */
class TrackController extends Controller
{
    /**
     * @Method("GET")
     * @ParamConverter()
     * @Route("/{track}", name="track_file")
     * @param Track $track
     * @return Response
     */
    public function getAction(Track $track)
    {
        $file = $track->getFiles()[0]->getFile();
        return new BinaryFileResponse($file);
    }
}
