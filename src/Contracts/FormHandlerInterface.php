<?php

namespace App\Contracts;

interface FormHandlerInterface
{
    public function validate(): bool;
    public function handle(): ?string;
    public function getErrors(): array;
}