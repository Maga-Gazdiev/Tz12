<?php

namespace App\Dto;

class MemberDto
{
    public bool $isIndividual;
    public string $firstName;
    public string $lastName;
    public string $companyName;
    public AddressDto $address;
    public int $percentOfOwnership;
}