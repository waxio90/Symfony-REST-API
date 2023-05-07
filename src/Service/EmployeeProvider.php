<?php

namespace App\Service;

use App\Entity\Employee;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class EmployeeProvider
{
    public function __construct(
        private SerializerInterface $serializer
    )
    {
    }

    public function setDataEmployee(Request $request, Employee $employee = null): Employee
    {
        $employee = $employee ?: new Employee();

        return $this->serializer->deserialize(
            $request->getContent(),
            Employee::class,
            'json',
            ['object_to_populate' => $employee]
        );
    }
}
