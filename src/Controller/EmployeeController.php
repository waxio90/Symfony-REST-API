<?php

namespace App\Controller;

use App\Entity\Company;
use App\Repository\EmployeeRepository;
use App\Service\EmployeeProvider;
use App\Service\ValidateData;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/companies/{id}/employees')]
class EmployeeController extends AbstractController
{
    public function __construct(
        private EmployeeRepository $employeeRepository,
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
        private ValidateData $validateData,
        private EmployeeProvider $employeeProvider
    )
    {
    }

    #[Route('/', name: 'employees-company', methods: ["GET"])]
    public function index(Company $company): JsonResponse
    {
        $employees = $company->getEmployees();
        $json = $this->serializer->serialize($employees, 'json', ['groups' => 'api']);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/{employeeId}', name: 'show-employee', methods: ["GET"])]
    public function showEmployee(Company $company, string $employeeId): JsonResponse
    {
        $employee = $this->employeeRepository->find(intval($employeeId));
        if (!$employee || $employee->getCompany() !== $company) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        $json = $this->serializer->serialize($employee, 'json', ['groups' => 'api']);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/', name: 'create-emloyee', methods: ["POST"])]
    public function create(Request $request, Company $company): JsonResponse
    {
        $employee = $this->employeeProvider->setDataEmployee($request);
        $employee->setCompany($company);

        $response = $this->validateData->validateAndReturnJsonErrors($employee);
        if ($response !== null) {
            return $response;
        }

        $this->entityManager->persist($employee);
        $this->entityManager->flush();

        $json = $this->serializer->serialize($employee, 'json', ['groups' => 'api']);

        return new JsonResponse($json, Response::HTTP_CREATED, [], true);
    }

    #[Route('/{employeeId}', name: 'update-employee', methods: ["PUT"])]
    public function update(Request $request, Company $company, string $employeeId): JsonResponse
    {
        $employee = $this->employeeRepository->find(intval($employeeId));
        if (!$employee || $employee->getCompany() !== $company) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        $employee = $this->employeeProvider->setDataEmployee($request, $employee);

        $response = $this->validateData->validateAndReturnJsonErrors($employee);
        if ($response !== null) {
            return $response;
        }

        $this->entityManager->flush();

        $json = $this->serializer->serialize($employee, 'json', ['groups' => 'api']);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/{employeeId}', name: 'delete-employee', methods: ["DELETE"])]
    public function delete(Company $company, string $employeeId): JsonResponse
    {
        $employee = $this->employeeRepository->find(intval($employeeId));
        if (!$employee || $employee->getCompany() !== $company) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($employee);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
