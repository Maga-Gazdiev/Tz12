<?php

namespace App;

use App\Contracts\FormHandlerInterface;
use App\Dto\CompanyDto;
use App\Dto\MemberDto;
use App\Dto\AddressDto;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\CookieJarInterface;

class FormHandler implements FormHandlerInterface
{
    private CompanyDto $company;
    private array $errors = [];

    public function __construct(CompanyDto $company)
    {
        $this->company = $company;
    }

    public function validate(): bool
    {
        $this->errors = [];


        if (empty($this->company->companyName)) {
            $this->errors['companyName'] = 'Название компании обязательно.';
        }

        if (empty($this->company->companyDesignator)) {
            $this->errors['companyDesignator'] = 'Идентификатор компании обязателен.';
        }

        if (empty($this->company->contactFirstName)) {
            $this->errors['contactFirstName'] = 'Имя контактного лица обязательно.';
        }

        if (empty($this->company->contactEmail) || !filter_var($this->company->contactEmail, FILTER_VALIDATE_EMAIL)) {
            $this->errors['contactEmail'] = 'Корректный email контактного лица обязателен.';
        }

        if (empty($this->company->agentFirstName)) {
            $this->errors['companyDesignator'] = 'Идентификатор компании обязателен.';
        }

        $this->validateAddress($this->company->agentAddress, 'agentAddress');

        $this->validateAddress($this->company->companyAddress, 'companyAddress');


        foreach ($this->company->members as $index => $member) {
            $this->validateMember($member, $index);
        }


        return empty($this->errors);
    }

    private function validateAddress(AddressDto $address, string $prefix): void
    {
        if (empty($address->street)) {
            $this->errors["{$prefix}.street"] = 'Улица обязательна.';
        }

        if (empty($address->city)) {
            $this->errors["{$prefix}.city"] = 'Город обязателен.';
        }

        if (empty($address->state)) {
            $this->errors["{$prefix}.state"] = 'Штат обязателен.';
        }

        if (empty($address->zipCode)) {
            $this->errors["{$prefix}.zipCode"] = 'Почтовый индекс обязателен.';
        }
    }

    private function validateMember(MemberDto $member, mixed $index): void
    {
        if (empty($member->firstName)) {
            $this->errors["members[$index].firstName"] = 'Имя участника обязательно.';
        }

        $this->validateAddress($member->address, "members[$index].address");
    }

    public function createFormData()
    {
        if (!$this->validate()) {
            return null;
        }

        $formData = [
            "form1" => [
                "global_global_a_CDI_LegalName_ddeefb6273b139d18f85fc894696df98" => $this->company->entityType,
                "global_global_a_LSI_DOS_TrueNameVerification_5ea55a5092405c8db85a68ab93498f32" => $this->company->entityType
            ],
            "form2" => [
                "global_global_a_LSI_DOS1336_LegalStructure_306ce4ddfb53a0ed7cfae1771fa81c4f" => false,
                "global_global_a_LSI_DOS_NonEnglish_0b53511fa1d40938bba7abce99cb11a0" => false,
                "global_global_a_LSI_DOS_EnglishTranslation_8cbf53d53ea9ddf8b10b772a04488b14" => "",
                "global_global_a_LSI_DOS1336_PurposeClauseCheck_936084f9191ba4b9cc33a415c207379e" => false,
                "global_global_a_LSI_DOS_County_52240ae97c3ef6c950ca10fe2eee4003" => 33,
            ],
            "form3" => [
                "global_global_a_LSI_DOS_Secretary_StateAddress_84ca95b3d9cd775301b45f0cc484a2c1" => 1,
                "global_global_a_LSI_DOS_SoPName_4a649cba6667257c2be88e1eebc16b5a_1" => $this->company->contactFirstName,
                "global_global_a_LSI_DOS_SoPName_4a649cba6667257c2be88e1eebc16b5a_2" => "RAJAT BHARTI",
                "global_global_a_LSI_DOS_SoPAdd1_0b09febc29d5492738d12f99382a3abf" => $this->company->companyAddress->street,
                "global_global_a_LSI_DOS_SoPAdd2_93436b048d2f2f96c676ea6ff1b26426" => "",
                "global_global_a_LSI_DOS_SoPCity_967aa3adace44f185fd2e0b1b1a665d9" => $this->company->companyAddress->city,
                "global_global_a_LSI_DOS_SoPState_289dc832c724fd5da87685dcd2375939" => $this->company->companyAddress->state,
                "global_global_a_LSI_DOS_SoPZip_6aee49aeec454d12130e3060ae7982ca" => $this->company->companyAddress->zipCode,
                "global_global_a_LSI_DOS_SoPZip4_9bbb0a77d852b9fe9ea71372351c08da" => "",

                "global_global_a_LSI_DOS_SoPHasEmail_064802c583120c637080b80772e61809" => false,
                "global_global_a_LSI_DOS_SoPEmailAddress_29d6f753b21f60433d61e7cadbce4d93" => "email@gmail.com",
                "global_global_a_LSI_DOS_SoPEmailAddressVerify_634ab56a84ece52f1cf7f13363ba9416" => "email@gmail.com",

                "global_global_a_LSI_DOS_RegCheck_9ffa82b0fb1c1e1fb1c7a08afdd7575d" => $this->company->agentIsIndividual,
                "global_global_a_LSI_DOS_RegisteredAddress_97d9cc9b149e7b2a9f8ea458eeec57f6" => 1,
                "global_global_a_LSI_DOS_RAName_b2dcdb3704531f0190b19e6aebfd4909_1" => $this->company->agentFirstName,
                "global_global_a_LSI_DOS_RAName_b2dcdb3704531f0190b19e6aebfd4909_2" => "RAJAT BHARTI",
                "global_global_a_LSI_DOS_RAAdd1_1ea1f0e3b378bd6d709d8eb563b50ce7" => $this->company->agentAddress->street,
                "global_global_a_LSI_DOS_RAAdd2_a9c8327981498a9f2ce2570712c41750" => "",
                "global_global_a_LSI_DOS_RACity_f4d1cf092bbc03642160947741bb6ba4" => $this->company->agentAddress->city,
                "global_global_a_LSI_DOS_RAState_aa823a40fee8b129025442e257a5f01d" => $this->company->agentAddress->state,
                "global_global_a_LSI_DOS_RAZip_10923d5456ad3d2117ca078390606687" => $this->company->agentAddress->zipCode,
                "global_global_a_LSI_DOS_RAZip4_ec4cdfac0462857e119ccf1305b69ff6" => "",
            ],
            "form4" => [
                "global_global_a_LSI_DOS1336_ManagementStuctureCheck_db1db7850fba3f18b243f6fdede31535" => false,
                "global_global_a_LSI_DOS1336_ManagementStucture_605e8283d9e2300373e1bad2989f6cf6" => 2,
                "global_global_a_LSI_DOS1336_EffectiveDateCheck_b96946771675ed7b42f3a7259a467ae6" => true,
                "global_global_a_LSI_DOS1336_Existence_fa39e2b645baea31791617f9ea545553" => 1,
                "global_global_a_LSI_DOS_EffectiveDate_6232ef481830ced753534d09a81dd0bd" => "09/09/2024",
                "global_global_a_LSI_DOS1336_DurationDateCheck_f89c1a60106a5b946cbf31db672524c7" => false,
                "global_global_a_LSI_DOS1336_DurationDate_83d31a5ed7ebafeb0bdd2dd76b207a9a" => 2,
                "global_global_a_LSI_DOS_DurationDate_c0f64a1e7ba486a0259304235b754cb9" => "09/10/2024",
                "global_global_a_LSI_DOS1336_IncludeLiabilityStatement_7a78c9856a86e4dcd19c544a58bd2b51" => false,
            ],
            "form5" => [
                "global_global_a_LSI_DOS1336_OrgName_0c799e169920e6f83ab6e5b1cf7fafbb" => $this->company->companyDesignator,
                "global_global_a_LSI_DOS1336_OrgAdd1_d63d960136257d2b2d45e4079c284ba7" => $this->company->companyAddress->street,
                "global_global_a_LSI_DOS1336_OrgAdd2_7c5913c58aa1446ff60b32e7b27359b0" => "",
                "global_global_a_LSI_DOS1336_OrgCity_ba2c385a38dc1ab52274ceb78600e88b" => $this->company->companyAddress->city,
                "global_global_a_LSI_DOS1336_OrgState_ae774ad1c467aa261843ed029465f12a" => $this->company->companyAddress->state,
                "global_global_a_LSI_DOS1336_OrgZip_ca9ffb6b69504b18659bc439331559fb" => $this->company->companyAddress->zipCode,
                "global_global_a_LSI_DOS1336_OrgZip4_b5f884ae5f80cec3868e3ef744e3ad86" => "",
                "global_global_a_LSI_DOS_Signature_058b597cead5e44306f8344c6dc4ecec" => $this->company->companyDesignator
            ],
            "form6" => [
                "global_global_a_LSI_DOS_FilerName_4db81f98996ff5c5b2787dcb2946d397" => $this->company->companyDesignator,
                "global_global_a_LSI_DOS_FilerAdd1_4f65f01e4164a54f2a29e31040176180" => $this->company->companyAddress->street,
                "global_global_a_LSI_DOS_FilerAdd2_6de0477a9a8a1f9a38fd144a6af347c8" => "",
                "global_global_a_LSI_DOS_FilerCity_90f3d3b2d7e72f7076755a26e791ea59" => $this->company->companyAddress->city,
                "global_global_a_LSI_DOS_FilerState_9fef1ebdeb3e25263fd4b0710ff1d09d" => $this->company->companyAddress->state,
                "global_global_a_LSI_DOS_FilerZip_cb450355bc547f46e76f47ccd5e23232" => $this->company->companyAddress->zipCode,
                "global_global_a_LSI_DOS_FilerZip4_782aa88e390bfe7b151252ca6a959451" => "",
                "global_global_a_LSI_DOS_EmailAddress_48fa35443396cdef3a3f31fc87383525" => $this->company->contactEmail,
                "global_global_a_LSI_DOS_EmailVerification_ce1478f087fb894f164f64668ee2af8a" => $this->company->contactEmail,
            ],
            "form7" => [
                "global_global_a_LSI_DOS_PlainCopyReq_e2dd205c7c99049d1e38935cfb9c73c6" => true,
                "global_global_a_LSI_DOS_CertCopyReq_a71f53a71786536837e254ceb251b5a7" => true,
                "global_global_a_LSI_DOS_CertOfExistenceReq_57ea2f1176ad478bbab18ed6487e0c7c" => true,
            ],
        ];

        return $formData;
    }

    public function handle(): ?string
    {
        $formData = $this->createFormData();

        return json_encode($formData);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}