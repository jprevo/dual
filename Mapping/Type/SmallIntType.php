<?php

namespace Jprevo\Dual\DualBundle\Mapping\Type;

/**
 * Class SmallIntType
 * @package Jprevo\Dual\DualBundle\Mapping\Type
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class SmallIntType extends IntegerType
{

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'smallint';
    }

}