<?php

namespace Jprevo\Dual\DualBundle\Twig;
use Jprevo\Dual\DualBundle\Data\Query;
use Jprevo\Dual\DualBundle\Mapping\Mapper;
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
    public function getPagination(Query $query, $pages, $path, array $parameters = [])
    {
        $current = $query->getPage();

        $min = $current - 4;
        $max = $current + 4;

        if ($min < 1) {
            $min = 1;
        }

        if ($max > $pages) {
            $max = $pages;
        }

        $pageListing = range($min, $max);

        return $this->getTwig()->render('DualBundle::common/pagination.html.twig', [
            'pages' => $pageListing,
            'max' => $pages,
            'current' => $current,
            'path' => $path,
            'params' => $parameters,
            'query' => $query
        ]);
    }

    /**
     * @param Query|string $query
     * @param array $override
     * @return string
     */
    public function getQueryUrl($query, array $override = [])
    {
        if (is_string($query)) {
            $query = new Query([
                'className' => $query
            ]);
        }

        $parameters = $query->toParameters();
        $parameters = array_merge($parameters, $override);

        $class = Mapper::classToParam($query->getClassName());
        $parameters['class'] = $class;

        unset($parameters['cl']);

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