<?php

use App\Dto\CompanyDto;
use App\Dto\AddressDto;
use App\Dto\MemberDto;
use App\FormFiller;

$companyAddress = new AddressDto();
$companyAddress->street = "123 Main St";
$companyAddress->extra = "Suite 100";
$companyAddress->city = "New York";
$companyAddress->state = "NY";
$companyAddress->zipCode = "10001";

$agentAddress = new AddressDto();
$agentAddress->street = "456 Agent St";
$agentAddress->extra = "";
$agentAddress->city = "Albany";
$agentAddress->state = "NY";
$agentAddress->zipCode = "12207";

$member1Address = new AddressDto();
$member1Address->street = "789 Member St";
$member1Address->extra = "Apt 5B";
$member1Address->city = "Buffalo";
$member1Address->state = "NY";
$member1Address->zipCode = "14201";

$member1 = new MemberDto();
$member1->isIndividual = true;
$member1->firstName = "John";
$member1->lastName = "Doe";
$member1->companyName = "";
$member1->address = $member1Address;
$member1->percentOfOwnership = 50;

$company = new CompanyDto();
$company->entityType = "LLC";
$company->entityState = "NY";
$company->activityType = "General Business";
$company->companyName = "Test LLC";
$company->companyDesignator = "LLC";
$company->companyAddress = $companyAddress;
$company->contactFirstName = "Jane";
$company->contactLastName = "Smith";
$company->contactEmail = "jane.smith@example.com";
$company->contactMobile = "555-1234";
$company->members = [$member1];
$company->agentIsIndividual = true;
$company->agentFirstName = "John";
$company->agentLastName = "Agent";
$company->agentCompanyName = "";
$company->agentAddress = $agentAddress;

$formFiller = new FormFiller($company);

$response = $formFiller->submitFirstForm($company->companyName, true);

$response = $formFiller->submitSecondForm(
    $company->entityType, 
    false,          
    true,       
    '061'            
);

$response = $formFiller->submitThirdForm(
    $company->agentFirstName . ' ' . $company->agentLastName, 
    $company->agentAddress->street,
    $company->agentAddress->city,
    $company->agentAddress->state,
    $company->agentAddress->zipCode
);

$response = $formFiller->submitFourthForm(false, false);

$response = $formFiller->submitFifthForm(
    $company->contactFirstName . $company->contactLastName,
    $company->companyAddress->street,
    $company->companyAddress->city,
    $company->companyAddress->state,
    $company->companyAddress->zipCode
);

$response = $formFiller->submitSixthForm(
    $company->contactFirstName . $company->contactLastName,
    $company->companyAddress->street,
    $company->companyAddress->city,
    $company->companyAddress->state,
    $company->companyAddress->zipCode,
    $company->contactEmail,
    $company->contactEmail 
);

$response = $formFiller->submitSummaryForm(false, false, false);

echo $response;
