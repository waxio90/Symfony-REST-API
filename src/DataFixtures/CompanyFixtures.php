<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CompanyFixtures extends Fixture
{
    public const COMPANY_EMPLOYEE_REFERENCE = 'company-employee';
    public const COMPANY_EMPLOYEE_REFERENCE_2 = 'company-employee-2';

    public function load(ObjectManager $manager): void
    {
        $company = new Company();
        $company->setName('Audi');
        $company->setNip('5643215551');
        $company->setAddress('Cienista 30');
        $company->setCity('Wałbrzych');
        $company->setPostalCode('81-201');
        $manager->persist($company);

        $company2 = new Company();
        $company2->setName('Volvo');
        $company2->setNip('3847985543');
        $company2->setAddress('Złota 18');
        $company2->setCity('Warszawa');
        $company2->setPostalCode('00-015');
        $manager->persist($company2);

        $manager->flush();
        $this->addReference(self::COMPANY_EMPLOYEE_REFERENCE, $company);
        $this->addReference(self::COMPANY_EMPLOYEE_REFERENCE_2, $company2);
    }
}
