<?php

namespace App\Service;

use App\Entity\Company;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class CompanyProvider
{
    public function __construct(
        private SerializerInterface $serializer
    )
    {
    }

    public function setDataCompany(Request $request, Company $company = null): Company
    {
        $company = $company ?: new Company();

        return $this->serializer->deserialize(
            $request->getContent(),
            Company::class,
            'json',
            ['object_to_populate' => $company]
        );
    }
}
