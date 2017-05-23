<?php

namespace Jprevo\Dual\DualBundle\Controller;

use Jprevo\Dual\DualBundle\Mapping\Mapper;
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
        $class = Mapper::paramToClass($class);
        $meta = $this->get('dual.mapper')->getMeta($class);
        $className = $meta->getName();

        $entity = new $className();

        $form = $this->get('dual.form_builder')
            ->createBuilder($entity)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('dual.executer')->save($entity);

            return $this->redirectToRoute('dual_data', [
                'class' => $class
            ]);
        }

        return $this->render('DualBundle::update/create.html.twig', [
            'meta' => $meta,
            'form' => $form->createView()
        ]);
    }
}