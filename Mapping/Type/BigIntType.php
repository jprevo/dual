<?php

namespace Jprevo\Dual\DualBundle\Mapping\Type;

/**
 * Class BigIntType
 * @package Jprevo\Dual\DualBundle\Mapping\Type
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class BigIntType extends StringType
{

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'bigint';
    }

}