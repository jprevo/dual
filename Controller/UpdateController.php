<?php

namespace Jprevo\Dual\DualBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class UpdateController
 * @package Jprevo\Dual\DualBundle\Controller
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class UpdateController extends Controller
{

    /**
     * @Route("_dual/create/{class}.html", name="dual_create", requirements={"class" = ".+"})
     */
    public function createAction(Request $request, $class)
    {
        $meta = $this->get('dual.mapper')->getMetaFromParam($class);
        $className = $meta->getName();

        $entity = new $className();

        $form = $this->get('dual.form_builder')
            ->createBuilder($entity, $meta)
            ->getForm();

        return $this->render('DualBundle::update/create.html.twig', [
            'meta' => $meta,
            'form' => $form->createView()
        ]);
    }
}