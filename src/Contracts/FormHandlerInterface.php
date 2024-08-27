<?php

namespace App\Contracts;

use App\Dto\CompanyDto;

interface FormHandlerInterface
{
    public function validate(): bool;

    public function handle(): mixed;
}
