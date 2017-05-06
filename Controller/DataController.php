<?php

namespace Jprevo\Dual\DualBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class DataController
 * @package Jprevo\Dual\DualBundle\Controller
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class DataController extends Controller
{

    /**
     * @Route("_dual/data/display.html", name="dual_data_display")
     */
    public function displayAction(Request $request)
    {
        $em = $request->get('em');
        $className = $request->get('cl');

        $meta = $this->get('dual.mapper')->getMeta($em, $className);

        return $this->render('DualBundle::data/display.html.twig', [
            'meta' => $meta
        ]);
    }

    /**
     * @Route("_dual/data/{class}.html", name="dual_data", requirements={"class" = ".+"})
     */
    public function indexAction(Request $request, $class)
    {
        $meta = $this->get('dual.mapper')->getMetaFromParam($class);

        return $this->render('DualBundle::data/index.html.twig', [
            'meta' => $meta
        ]);
    }
}