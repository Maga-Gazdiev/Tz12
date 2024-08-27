<?php

namespace App;

use App\Contracts\FormHandlerInterface;
use App\Dto\CompanyDto;
use App\Dto\MemberDto;
use App\Dto\AddressDto;

class FormFiller implements FormHandlerInterface
{
    private string $baseUrl = 'https://www.businessexpress.ny.gov/app/interview';
    private string $requestId;
    private string $goalState;
    private array $data = [];
    private array $errors = [];
    private CompanyDto $company;

    public function __construct(CompanyDto $company)
    {
        $this->requestId = 'unique-request-id'; 
        $this->goalState = 'initial-goal-state'; 
        $this->company = $company;
    }

    public function validate(): bool
    {
        if (empty($this->company->companyName)) {
            $this->errors['companyName'] = 'Company name is required.';
        }
        if ($this->company->agentIsIndividual && (empty($this->company->agentFirstName) || empty($this->company->agentLastName))) {
            $this->errors['agentName'] = 'Agent first and last name are required.';
        }

        return empty($this->errors);
    }

    public function handle(): mixed
    {
        if (!$this->validate()) {
            return $this->errors;
        }

        $response = $this->sendForm();

        return $response === 'success' ? true : $response;
    }

    public function setField(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    private function sendForm()
    {
        $postData = array_merge([
            'requestId' => $this->requestId,
            'goal_state' => $this->goalState,
        ], $this->data);

        $ch = curl_init($this->baseUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    public function submitFirstForm($legalName, $nameCheckValidation) {
        $this->setField('global_global_a_CDI_LegalName_ddeefb6273b139d18f85fc894696df98', $legalName);
        $this->setField('nameCheckValidation_global_global_g_2_01d5a2743b9544dafdf5ca022d3e3c3f', $nameCheckValidation);
        $this->setField('global_global_a_LSI_DOS_TrueNameVerification_5ea55a5092405c8db85a68ab93498f32', $legalName);

        return $this->sendForm();
    }

    public function submitSecondForm($legalStructure, $nonEnglish, $purposeClauseCheck, $county) {
        $this->setField('global_global_a_LSI_DOS1336_LegalStructure_306ce4ddfb53a0ed7cfae1771fa81c4f', $legalStructure);
        $this->setField('global_global_a_LSI_DOS_NonEnglish_0b53511fa1d40938bba7abce99cb11a0', $nonEnglish);
        $this->setField('global_global_a_LSI_DOS1336_PurposeClauseCheck_936084f9191ba4b9cc33a415c207379e', $purposeClauseCheck);
        $this->setField('global_global_a_LSI_DOS_County_52240ae97c3ef6c950ca10fe2eee4003', $county);

        return $this->sendForm();
    }

    public function submitThirdForm($sopName, $sopAdd1, $sopCity, $sopState, $sopZip) {
        $this->setField('global_global_a_LSI_DOS_SoPName_4a649cba6667257c2be88e1eebc16b5a', $sopName);
        $this->setField('global_global_a_LSI_DOS_SoPAdd1_0b09febc29d5492738d12f99382a3abf', $sopAdd1);
        $this->setField('global_global_a_LSI_DOS_SoPCity_967aa3adace44f185fd2e0b1b1a665d9', $sopCity);
        $this->setField('global_global_a_LSI_DOS_SoPState_289dc832c724fd5da87685dcd2375939', $sopState);
        $this->setField('global_global_a_LSI_DOS_SoPZip_6aee49aeec454d12130e3060ae7982ca', $sopZip);

        return $this->sendForm();
    }

    public function submitFourthForm($managementStructureCheck, $effectiveDateCheck) {
        $this->setField('global_global_a_LSI_DOS1336_ManagementStuctureCheck_db1db7850fba3f18b243f6fdede31535', $managementStructureCheck);
        $this->setField('global_global_a_LSI_DOS1336_EffectiveDateCheck_b96946771675ed7b42f3a7259a467ae6', $effectiveDateCheck);

        return $this->sendForm();
    }

    public function submitFifthForm($orgName, $orgAdd1, $orgCity, $orgState, $orgZip) {
        $this->setField('global_global_a_LSI_DOS1336_OrgName_0c799e169920e6f83ab6e5b1cf7fafbb', $orgName);
        $this->setField('global_global_a_LSI_DOS1336_OrgAdd1_d63d960136257d2b2d45e4079c284ba7', $orgAdd1);
        $this->setField('global_global_a_LSI_DOS1336_OrgCity_ba2c385a38dc1ab52274ceb78600e88b', $orgCity);
        $this->setField('global_global_a_LSI_DOS1336_OrgState_ae774ad1c467aa261843ed029465f12a', $orgState);
        $this->setField('global_global_a_LSI_DOS1336_OrgZip_ca9ffb6b69504b18659bc439331559fb', $orgZip);

        return $this->sendForm();
    }

    public function submitSixthForm($filerName, $filerAdd1, $filerCity, $filerState, $filerZip, $email, $emailVerification) {
        $this->setField('global_global_a_LSI_DOS_FilerName_4db81f98996ff5c5b2787dcb2946d397', $filerName);
        $this->setField('global_global_a_LSI_DOS_FilerAdd1_4f65f01e4164a54f2a29e31040176180', $filerAdd1);
        $this->setField('global_global_a_LSI_DOS_FilerCity_90f3d3b2d7e72f7076755a26e791ea59', $filerCity);
        $this->setField('global_global_a_LSI_DOS_FilerState_9fef1ebdeb3e25263fd4b0710ff1d09d', $filerState);
        $this->setField('global_global_a_LSI_DOS_FilerZip_cb450355bc547f46e76f47ccd5e23232', $filerZip);
        $this->setField('global_global_a_LSI_DOS_EmailAddress_48fa35443396cdef3a3f31fc87383525', $email);
        $this->setField('global_global_a_LSI_DOS_EmailVerification_ce1478f087fb894f164f64668ee2af8a', $emailVerification);

        return $this->sendForm();
    }

    public function submitSummaryForm($plainCopyReq, $certCopyReq, $certOfExistenceReq) {
        $this->setField('global_global_a_LSI_DOS_PlainCopyReq_e2dd205c7c99049d1e38935cfb9c73c6', $plainCopyReq);
        $this->setField('global_global_a_LSI_DOS_CertCopyReq_a71f53a71786536837e254ceb251b5a7', $certCopyReq);
        $this->setField('global_global_a_LSI_DOS_CertOfExistenceReq_57ea2f1176ad478bbab18ed6487e0c7c', $certOfExistenceReq);

        return $this->sendForm();
    }
}