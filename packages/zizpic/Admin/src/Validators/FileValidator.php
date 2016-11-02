<?php

namespace Inventory\Admin\Validators;

use Illuminate\Support\Facades\Input;

/**
 * Class FileValidator.
 */
class FileValidator extends BaseValidator
{
    /**
     * {@inheritDoc}
     */
    protected $rules = [
        'files' => 'required',
    ];

    /**
     * {@inheritDoc}
     */
    public function passes()
    {
        return $this->validateFiles();
    }

    /**
     * Validates files inside the files form field individually.
     *
     * @return bool
     */
    public function validateFiles()
    {
        // Make sure files have been uploaded
        if (Input::hasFile('files')) {

            // Get the uploaded files
            $files = Input::file('files');

            // Make sure the files is an array and more than one exists
            if (is_array($files) && count($files) > 0) {
                foreach ($files as $file) {

                    // Dynamically set the input to the current file
                    $this->setInput(['files' => $file]);

                    $validator = $this->validator();

                    // Check the file against the validator
                    if ($validator->passes()) {
                        continue;
                    } else {
                        // Set the messages for the file and return false
                        $this->setErrors($validator->messages());

                        return false;
                    }
                }

                return true;
            }
        } else {
            $errors = [
                'files' => trans('validation.required', ['attribute' => 'files']),
            ];

            $this->setErrors($errors);
        }

        return false;
    }
}
