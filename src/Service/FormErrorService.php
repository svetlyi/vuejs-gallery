<?php

namespace App\Service;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;

class FormErrorService
{
    public function toArray(FormInterface $form): array
    {
        $errors = [];
        // Global
        foreach ($form->getErrors() as $error) {
            $errors[$form->getName()][] = $error->getMessage();
        }

        // Fields
        foreach ($form as $child /** @var Form $child */) {
            if (!$child->isValid()) {
                foreach ($child->getErrors() as $error) {
                    $errors[$child->getName()][] = $error->getMessage();
                }
            }
        }

        return $errors;
    }
}
