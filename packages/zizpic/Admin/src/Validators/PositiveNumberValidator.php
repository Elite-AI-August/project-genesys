<?php

namespace Inventory\Admin\Validators;

/**
 * Class PositiveNumberValidator.
 */
class PositiveNumberValidator
{
     /**
      * Validates if a number is positive or not.
      *
      * @param $attribute
      * @param $value
      * @param $params
      * @param $validator
      *
      * @return bool
      */
     public function validatePositive($attribute, $value, $params, $validator)
     {
         if (is_numeric($value) && $value == 0 || $value > 0) {
             return true;
         }

         return false;
     }
}
