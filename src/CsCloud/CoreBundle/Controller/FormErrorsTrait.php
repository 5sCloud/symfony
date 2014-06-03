<?php

namespace CsCloud\CoreBundle\Controller;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;

/**
 * Helper methods for retrieving form errors in an array without error bubbling
 * setting for each widget
 *
 * @author Alessandro Chitolina <alekitto@gmail.com>
 */
trait FormErrorsTrait
{
    /**
     * Get all forms errors
     *
     * @return array
     */
    public function getAllErrors($form, $plain = false)
    {
        $errors = array();

        if (count($globalErrors = $form->getErrors())) {
            $errors["global"] = $globalErrors;
        }
        $errors += $this->_getAllErrors($form, $plain);

        return $errors;
    }

    /**
     * Returns all errors from a Type
     *
     * @return array
     */
    private function _getAllErrors($children, $plain, &$errors = array())
    {
        foreach ($children as $child) {
            $vars = $child->createView()->vars;
            if (count($childErrors = $child->getErrors())) {
                foreach ($childErrors as $error) {
                    $errors[$vars["name"]][] = $error->getMessage();
                }
            }

            $subchildErrors = array();
            foreach ($child as $subchild) {
                $this->_getAllErrors($subchild, $plain, $subchildErrors);
            }

            if(count($subchildErrors)) {
                $errors[$vars["name"]][] = $subchildErrors;
            }
        }

    	return $plain ? (call_user_func_array('array_merge', $errors) ?: array()) : $errors;
    }

    protected function _addErrors($form, $errors)
    {
        foreach ($errors as $field => $error) {
            if (is_array($error)) {
                $this->_addErrors($form->get($field), $error);
                continue;
            }

            $form->addError(new FormError($error));
        }
    }

    public function addErrorsToForm(Form $form, $errors = array())
    {
        if (isset($errors->global)) {
            $this->_addErrors($form, $errors->global);
        }

        unset($errors->global);
        $this->_addErrors($form, $errors);
    }
}
