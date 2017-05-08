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
     * @Route("_dual/data/{class}.html", name="dual_data", requirements={"class" = ".+"})
     */
    public function indexAction(Request $request, $class)
    {
        $query = Query::fromRequest($request);

        $meta = $this->get('dual.mapper')->getMeta(
            $query->getEmName(),
            $query->getClassName()
        );

        $result = $this->get('dual.executer')
            ->execute($query);

        return $this->render('DualBundle::data/index.html.twig', [
            'meta' => $meta,
            'result' => $result,
            'query' => $query
        ]);
    }
}