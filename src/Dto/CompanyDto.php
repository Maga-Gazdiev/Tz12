<?php

namespace App\Dto;

class CompanyDto
{
    public string $entityType;
    public string $entityState;

    public string $activityType;

    public string $companyName;
    public string $companyDesignator;
    public AddressDto $companyAddress;

    public string $contactFirstName;
    public string $contactLastName;
    public string $contactEmail;
    public string $contactMobile;

    /** @var [MemberDto] $members **/
    public array $members;

    public bool $agentIsIndividual;
    public string $agentFirstName;
    public string $agentLastName;
    public string $agentCompanyName;
    public AddressDto $agentAddress;
}