<?php

namespace Inventory\Admin\Validators;

use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Validator;
use Inventory\Admin\Services\WorkOrder\AssignmentService;

/**
 * Class UserAssignmentValidator.
 */
class UserAssignmentValidator extends Validator
{
    /**
     * Holds a list of the invalid users unavailable to be
     * assigned to a work order.
     *
     * @var array
     */
    protected $invalidUsers = [];

    /**
     * @var \Symfony\Component\Translation\TranslatorInterface
     */
    protected $translator;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var array
     */
    protected $rules;

    /**
     * @var array
     */
    protected $messages;

    /**
     * @var AssignmentService
     */
    protected $assignent;

    /**
     * @param \Symfony\Component\Translation\TranslatorInterface $translator
     * @param array                                              $data
     * @param array                                              $rules
     * @param array                                              $messages
     * @param AssignmentService                                  $assignment
     */
    public function __construct($translator, $data, $rules, $messages, AssignmentService $assignment)
    {
        $this->translator = $translator;
        $this->data = $data;
        $this->rules = $this->explodeRules($rules);
        $this->messages = $messages;

        $this->assignment = $assignment;
    }

    /**
     * @param $attribute
     * @param $users
     * @param $parameters
     *
     * @return bool
     */
    public function validateUserAssignment($attribute, $users, $parameters)
    {
        $workOrder_id = Route::getCurrentRoute()->getParameter('work_orders');

        foreach ($users as $user) {
            $assignment = $this->assignment
                    ->with('toUser')
                    ->where('work_order_id', $workOrder_id)
                    ->where('to_user_id', $user)
                    ->get()
                    ->first();

            if ($assignment) {
                $this->invalidUsers[] = $assignment->toUser->full_name;
            }
        }

        if (count($this->invalidUsers) > 0) {
            return false;
        }

        return true;
    }

    /**
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     *
     * @return string
     */
    protected function replaceUserAssignment($message, $attribute, $rule, $parameters)
    {
        $message = 'Worker(s): <ul>';

        foreach ($this->invalidUsers as $user) {
            $message .= sprintf('<li>%s</li>', $user);
        }

        $message .= '</ul> Have already been assigned to this work order. You must remove the assignment before you can re-assign them.';

        return $message;
    }
}
