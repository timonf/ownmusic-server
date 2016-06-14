<?php

namespace ServerBundle\Controller\Management;

use ServerBundle\Form\Model\UploadRequest;
use ServerBundle\Form\Type\UploadType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction(Request $request)
    {
        $uploadRequest = new UploadRequest();
        $uploadForm = $this->createForm(UploadType::class, $uploadRequest);

        $uploadForm->handleRequest($request);

        if ($uploadForm->isValid()) {
            $uploadRequest = $uploadForm->getData();
            $this->get('upload_service')->uploadFiles($uploadRequest);

        }

        $tracks = $this->get('doctrine.orm.default_entity_manager')->getRepository('ServerBundle:Track')->findAll();

        return $this->render('ServerBundle:Management/Default:index.html.twig', [
            'form' => $uploadForm->createView(),
            'request' => $uploadRequest,
            'tracks' => $tracks,
        ]);
    }
}
