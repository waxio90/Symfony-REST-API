<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidateData
{
    public function __construct(
        private ValidatorInterface $validator
    )
    {
    }

    public function validateAndReturnJsonErrors($object): ?JsonResponse
    {
        $errors = $this->validator->validate($object);
        if (count($errors) > 0) {
            $jsonErrors = [];

            foreach ($errors as $error) {
                $jsonErrors[$error->getPropertyPath()][] = $error->getMessage();
            }

            return new JsonResponse($jsonErrors, Response::HTTP_BAD_REQUEST);
        }

        return null;
    }
}
