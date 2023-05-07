<?php

namespace App\Controller;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use App\Service\CompanyProvider;
use App\Service\ValidateData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/companies', name: 'api-companies')]
class CompanyController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private CompanyRepository $companyRepository,
        private SerializerInterface $serializer,
        private CompanyProvider $companyProvider,
        private ValidateData $validateData
    )
    {
    }

    #[Route('/', name: 'list-companies', methods: ["GET"])]
    public function index(): JsonResponse
    {
        $companies = $this->companyRepository->findAll();
        $json = $this->serializer->serialize($companies, 'json', ['groups' => 'api']);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/{id}', name: 'show-company', methods: ["GET"])]
    public function show(Company $company): JsonResponse
    {
        $json = $this->serializer->serialize($company, 'json', ['groups' => 'api']);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }


    #[Route('/', name: 'create-company', methods: ["POST"])]
    public function create(Request $request): JsonResponse
    {
        $company = $this->companyProvider->setDataCompany($request);

        $response = $this->validateData->validateAndReturnJsonErrors($company);
        if ($response !== null) {
            return $response;
        }

        $this->entityManager->persist($company);
        $this->entityManager->flush();

        $json = $this->serializer->serialize($company, 'json', ['groups' => 'api']);

        return new JsonResponse($json, Response::HTTP_CREATED, [], true);
    }

    #[Route('/{id}', name: 'update-company', methods: ["PUT"])]
    public function update(Request $request, Company $company): JsonResponse
    {
        $company = $this->companyProvider->setDataCompany($request, $company);

        $response = $this->validateData->validateAndReturnJsonErrors($company);
        if ($response !== null) {
            return $response;
        }

        $this->entityManager->flush();

        $json = $this->serializer->serialize($company, 'json', ['groups' => 'api']);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/{id}', name: 'delete-company', methods: ["DELETE"])]
    public function delete(Company $company): JsonResponse
    {
        $this->entityManager->remove($company);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
