<?php

namespace Jprevo\Dual\DualBundle\Mapping\Type;

/**
 * Class DateTimeType
 * @package Jprevo\Dual\DualBundle\Mapping\Type
 * @author Jonathan Prévost <php.dual@gmail.com>
 */
class DateTimeTZType extends DateTimeType
{

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'datetimetz';
    }
}