<?php

namespace Jprevo\Dual\DualBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class LayoutController
 * @package Jprevo\Dual\DualBundle\Controller
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class LayoutController extends Controller
{

    /**
     * @Route("_dual/sidebar.html", name="dual_layout_sidebar")
     */
    public function sidebarAction(Request $request)
    {
        $tree = $this->get('dual.mapper')->getTree();

        return $this->render('DualBundle::layout/sidebar.html.twig', [
            'tree' => $tree
        ]);
    }
}