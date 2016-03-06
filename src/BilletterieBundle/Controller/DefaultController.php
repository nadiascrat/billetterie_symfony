<?php

namespace BilletterieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BilletterieBundle:Default:index.html.twig');
    }
}
