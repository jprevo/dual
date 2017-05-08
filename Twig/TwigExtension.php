<?php

namespace Jprevo\Dual\DualBundle\Twig;
use Jprevo\Dual\DualBundle\Data\Query;
use Symfony\Component\Routing\Router;

/**
 * Class TwigExtension
 * @package Jprevo\Dual\DualBundle\Twig
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class TwigExtension extends \Twig_Extension
{

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var Router
     */
    protected $router;

    /**
     * TwigExtension constructor.
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig, Router $router)
    {
        $this->twig = $twig;
        $this->router = $router;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('dual_pagination', array($this, 'getPagination'), ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('dual_query_url', array($this, 'getQueryUrl'))
        );
    }

    /**
     * @param int $pages
     * @param int $current
     * @param string $path
     * @param array $parameters
     * @return string
     */
    public function getPagination($pages, $current, $path, array $parameters = [])
    {
        return $this->getTwig()->render('DualBundle::common/pagination.html.twig', [

        ]);
    }

    /**
     * @param Query $query
     * @param array $override
     * @return string
     */
    public function getQueryUrl(Query $query, array $override = [])
    {
        $parameters = $query->toParameters();
        $parameters = array_merge($parameters, $override);

        $class = $query->getEmName() . ':' . str_replace('\\', '/', $query->getClassName());
        $parameters['class'] = $class;

        unset($parameters['cl']);
        unset($parameters['em']);

        return $this->getRouter()->generate('dual_data', $parameters);
    }

    /**
     * @return \Twig_Environment
     */
    protected function getTwig()
    {
        return $this->twig;
    }

    /**
     * @return Router
     */
    protected function getRouter()
    {
        return $this->router;
    }
}