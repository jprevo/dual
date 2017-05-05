<?php

namespace Jprevo\Dual\DualBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class IndexController
 * @package Jprevo\Dual\DualBundle\Controller
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class IndexController extends Controller
{

    /**
     * @Route("_dual/", name="dual_index")
     */
    public function indexAction(Request $request)
    {
        return $this->render('DualBundle::index/index.html.twig');
    }
}