<?php

namespace Jprevo\Dual\DualBundle\Controller;

use Jprevo\Dual\DualBundle\Data\Query;
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
     * @Route("_dual/data/select.html", name="dual_data_select")
     */
    public function selectAction(Request $request)
    {
        $multiple = $request->get('multiple', false);

        $query = Query::fromRequest($request);

        $meta = $this->get('dual.mapper')->getMeta(
            $query->getClassName()
        );

        $result = $this->get('dual.executer')
            ->execute($query);

        return $this->render('DualBundle::data/select.html.twig', [
            'meta' => $meta,
            'result' => $result,
            'query' => $query,
            'multiple' => $multiple
        ]);
    }

    /**
     * @Route("_dual/data/{class}.html", name="dual_data", requirements={"class" = ".+"})
     */
    public function indexAction(Request $request, $class)
    {
        $query = Query::fromRequest($request);

        $meta = $this->get('dual.mapper')->getMeta(
            $query->getClassName()
        );

        $result = $this->get('dual.executer')
            ->execute($query);

        $vars = [
            'meta' => $meta,
            'result' => $result,
            'query' => $query
        ];

        if ($request->isXmlHttpRequest()) {
            return $this->render('DualBundle::data/display.html.twig', $vars);
        }

        return $this->render('DualBundle::data/index.html.twig', $vars);
    }


}