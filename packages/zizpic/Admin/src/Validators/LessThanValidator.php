<?php

namespace Inventory\Admin\Validators;

/**
 * Class LessThanNumberValidator.
 */
class LessThanValidator
{
    /**
     * Validates a form field to make sure the inputted number is less than the
     * set number.
     *
     * @param string $attribute
     * @param string $number
     * @param array  $parameters
     *
     * @return bool
     */
    public function validateLessThan($attribute, $number, $parameters)
    {
        if (is_numeric($number)) {
            if ($number < $parameters[0]) {
                return true;
            }
        }

        return false;
    }
}
