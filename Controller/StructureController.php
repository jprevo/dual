<?php

namespace Jprevo\Dual\DualBundle\Controller;

use Jprevo\Dual\DualBundle\Mapping\Mapper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class LayoutController
 * @package Jprevo\Dual\DualBundle\Controller
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class StructureController extends Controller
{

    /**
     * @Route("_dual/structure/{class}.html", name="dual_structure", requirements={"class" = ".+"})
     */
    public function indexAction(Request $request, $class)
    {
        $class = Mapper::paramToClass($class);
        $meta = $this->get('dual.mapper')->getMeta($class);

        return $this->render('DualBundle::structure/index.html.twig', [
            'meta' => $meta
        ]);
    }
}