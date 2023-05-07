<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EmployeeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $employee = new Employee();
        $employee->setFirstName('Tomasz');
        $employee->setLastName('Nowak');
        $employee->setEmail('t.nowak@mail.com');
        $employee->setCompany($this->getReference(CompanyFixtures::COMPANY_EMPLOYEE_REFERENCE));
        $manager->persist($employee);

        $employee1 = new Employee();
        $employee1->setFirstName('Anna');
        $employee1->setLastName('Kowalska');
        $employee1->setEmail('anna.kowalska@wp.com');
        $employee1->setPhoneNumber('705-645-858');
        $employee1->setCompany($this->getReference(CompanyFixtures::COMPANY_EMPLOYEE_REFERENCE));
        $manager->persist($employee1);

        $employee2 = new Employee();
        $employee2->setFirstName('Władysław');
        $employee2->setLastName('Makowski');
        $employee2->setEmail('wmakowski@onet.com');
        $employee2->setCompany($this->getReference(CompanyFixtures::COMPANY_EMPLOYEE_REFERENCE));
        $manager->persist($employee2);

        $employee3 = new Employee();
        $employee3->setFirstName('Adam');
        $employee3->setLastName('Nowakowski');
        $employee3->setEmail('nowakowski1@gmail.com');
        $employee3->setPhoneNumber('779002258');
        $employee3->setCompany($this->getReference(CompanyFixtures::COMPANY_EMPLOYEE_REFERENCE_2));
        $manager->persist($employee3);

        $employee4 = new Employee();
        $employee4->setFirstName('Agnieszka');
        $employee4->setLastName('Kozłowska');
        $employee4->setEmail('kozlowska.aga@gmail.com');
        $employee4->setCompany($this->getReference(CompanyFixtures::COMPANY_EMPLOYEE_REFERENCE_2));
        $manager->persist($employee4);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CompanyFixtures::class,
        ];
    }
}
