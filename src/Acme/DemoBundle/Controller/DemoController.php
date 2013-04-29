<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Acme\DemoBundle\Form\ContactType;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DemoController extends Controller
{
    /**
     * @Route("/", name="_demo")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/hello/{name}", name="_demo_hello")
     * @Template()
     */
    public function helloAction($name)
    {
        return array('name' => $name);
    }

    /**
     * @Route("/contact", name="_demo_contact")
     * @Template()
     */
    public function contactAction()
    {
        $form = $this->get('form.factory')->create(new ContactType());

        $request = $this->get('request');
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $mailer = $this->get('mailer');
                // .. setup a message and send it
                // http://symfony.com/doc/current/cookbook/email.html

                $this->get('session')->getFlashBag()->set('notice', 'Message sent!');

                return new RedirectResponse($this->generateUrl('_demo'));
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/vk", name="_demo_vk")
     * @Template()
     */
    public function vkAction()
    {

        $authBaseUrl = 'https://oauth.vk.com/authorize?';
        $clientId = 'client_id=' . '3610855';
        $scope = 'scope=' . 'PERMISSIONS';
        $redirectUrl = 'redirect_url=' . 'http://localhost/apitest/web/app_dev.php/demo/vk';
        $responseType = 'response_type=' . 'code ';
        $fullAuthUrl = $authBaseUrl . $clientId . '&' . $scope . '&' . $redirectUrl . '&' . $responseType;

        return array(
            'name' => 'Vova',
            'authUrl' => $fullAuthUrl,
        );
    }
}
