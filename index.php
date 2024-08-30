<?php

require 'vendor/autoload.php';

use App\Dto\AddressDto;
use App\Dto\CompanyDto;
use App\Dto\MemberDto;
use App\FormHandler;

$companyAddress = new AddressDto();
$companyAddress->street = "20 Barton St.";
$companyAddress->extra = "gdfgdchdgch";
$companyAddress->city = "Albany";
$companyAddress->state = "NY";
$companyAddress->zipCode = "14511";

$agentAddress = new AddressDto();
$agentAddress->street = "456 Agent St";
$agentAddress->extra = "";
$agentAddress->city = "Albany";
$agentAddress->state = "NY";
$agentAddress->zipCode = "14511";

$member2 = new MemberDto();
$member2->isIndividual = true;
$member2->firstName = "John Doe";
$member2->lastName = "Name";
$member2->companyName = "Name";
$member2->address = $agentAddress;
$member2->percentOfOwnership = 50;

$company = new CompanyDto();
$company->entityType = "Test LLC";
$company->entityState = "NY";
$company->activityType = "General Business";
$company->companyName = "Test LLC";
$company->companyDesignator = "General Business";
$company->companyAddress = $companyAddress;
$company->contactFirstName = "MuhammadGZD";
$company->contactLastName = "Name";
$company->contactEmail = "gazdievmaga63@gmail.com";
$company->contactMobile = "555-1234";
$company->members = ["agent" => $member2];
$company->agentIsIndividual = true;
$company->agentFirstName = "Name Agent";
$company->agentLastName = "Fm Agent";
$company->agentCompanyName = "CompanyAG";
$company->agentAddress = $agentAddress;

$handler = new FormHandler($company);
$data = $handler->handle();
$errors = $handler->getErrors();

if (!empty($errors)) {
    echo "Ошибки при валидации данных формы:\n";
    foreach ($errors as $field => $error) {
        echo "$field: $error\n";
    }
} else {
    file_put_contents("formData.json", $data);

    $command = 'node src/js/sendForm.js';
    $output = shell_exec($command);

    if ($output === null) {
        echo "Не удалось выполнить Node.js скрипт.";
    } else {
        echo "Вывод Node.js скрипта:\n$output";
    }
}


// $formData = [
//     "form1" => [
//         "global_global_a_CDI_LegalName_ddeefb6273b139d18f85fc894696df98" => "Test LLC",
//         "global_global_a_LSI_DOS_TrueNameVerification_5ea55a5092405c8db85a68ab93498f32" =>"Test LLC"
//     ],
//     "form2" => [
//         "global_global_a_LSI_DOS1336_LegalStructure_306ce4ddfb53a0ed7cfae1771fa81c4f" => true,
//         "global_global_a_LSI_DOS_NonEnglish_0b53511fa1d40938bba7abce99cb11a0" => true,
//         "global_global_a_LSI_DOS_EnglishTranslation_8cbf53d53ea9ddf8b10b772a04488b14" => "dcfsdsd",
//         "global_global_a_LSI_DOS1336_PurposeClauseCheck_936084f9191ba4b9cc33a415c207379e" => true,
//         "global_global_a_LSI_DOS_County_52240ae97c3ef6c950ca10fe2eee4003" => 33,
//     ],
//     "form3" => [
//         "global_global_a_LSI_DOS_Secretary_StateAddress_84ca95b3d9cd775301b45f0cc484a2c1" => 1,
//         "global_global_a_LSI_DOS_SoPName_4a649cba6667257c2be88e1eebc16b5a_1" => "MuhammadGZD",
//         "global_global_a_LSI_DOS_SoPName_4a649cba6667257c2be88e1eebc16b5a_2" => "RAJAT BHARTI",
//         "global_global_a_LSI_DOS_SoPAdd1_0b09febc29d5492738d12f99382a3abf" => "20 Barton St.",
//         "global_global_a_LSI_DOS_SoPAdd2_93436b048d2f2f96c676ea6ff1b26426" => "",
//         "global_global_a_LSI_DOS_SoPCity_967aa3adace44f185fd2e0b1b1a665d9" => "Albany",
//         "global_global_a_LSI_DOS_SoPState_289dc832c724fd5da87685dcd2375939" => "NY",
//         "global_global_a_LSI_DOS_SoPZip_6aee49aeec454d12130e3060ae7982ca" => "14511",
//         "global_global_a_LSI_DOS_SoPZip4_9bbb0a77d852b9fe9ea71372351c08da" => "",
//         "global_global_a_LSI_DOS_SoPHasEmail_064802c583120c637080b80772e61809" => false,
//         "global_global_a_LSI_DOS_SoPEmailAddress_29d6f753b21f60433d61e7cadbce4d93" => "email@gmail.com",
//         "global_global_a_LSI_DOS_SoPEmailAddressVerify_634ab56a84ece52f1cf7f13363ba9416" => "email@gmail.com",
//         "global_global_a_LSI_DOS_RegCheck_9ffa82b0fb1c1e1fb1c7a08afdd7575d" => true,
//         "global_global_a_LSI_DOS_RegisteredAddress_97d9cc9b149e7b2a9f8ea458eeec57f6" => 1,
//         "global_global_a_LSI_DOS_RAName_b2dcdb3704531f0190b19e6aebfd4909_1" => "Bb",
//         "global_global_a_LSI_DOS_RAName_b2dcdb3704531f0190b19e6aebfd4909_2" => "RAJAT BHARTI",
    
//         "global_global_a_LSI_DOS_RAAdd1_1ea1f0e3b378bd6d709d8eb563b50ce7" => "21 Barton St.",
//         "global_global_a_LSI_DOS_RAAdd2_a9c8327981498a9f2ce2570712c41750" => "",
//         "global_global_a_LSI_DOS_RACity_f4d1cf092bbc03642160947741bb6ba4" => "Albany",
//         "global_global_a_LSI_DOS_RAState_aa823a40fee8b129025442e257a5f01d" => "NY",
//         "global_global_a_LSI_DOS_RAZip_10923d5456ad3d2117ca078390606687" => "14511",
//         "global_global_a_LSI_DOS_RAZip4_ec4cdfac0462857e119ccf1305b69ff6" => "",
//     ],
//     "form4" => [
//         "global_global_a_LSI_DOS1336_ManagementStuctureCheck_db1db7850fba3f18b243f6fdede31535" => true,
//         "global_global_a_LSI_DOS1336_ManagementStucture_605e8283d9e2300373e1bad2989f6cf6" => 2,
//         "global_global_a_LSI_DOS1336_EffectiveDateCheck_b96946771675ed7b42f3a7259a467ae6" => true,
//         "global_global_a_LSI_DOS1336_Existence_fa39e2b645baea31791617f9ea545553" => 2,
//         "global_global_a_LSI_DOS_EffectiveDate_6232ef481830ced753534d09a81dd0bd" => "09/09/2024",
//         "global_global_a_LSI_DOS1336_DurationDateCheck_f89c1a60106a5b946cbf31db672524c7" => true,
//         "global_global_a_LSI_DOS1336_DurationDate_83d31a5ed7ebafeb0bdd2dd76b207a9a" => 2,
//         "global_global_a_LSI_DOS_DurationDate_c0f64a1e7ba486a0259304235b754cb9" => "09/10/2024",
//         "global_global_a_LSI_DOS1336_IncludeLiabilityStatement_7a78c9856a86e4dcd19c544a58bd2b51" => true,
//     ],
//     "form5" => [
//         "global_global_a_LSI_DOS1336_OrgName_0c799e169920e6f83ab6e5b1cf7fafbb" => "MuhammadGZD",
//         "global_global_a_LSI_DOS1336_OrgAdd1_d63d960136257d2b2d45e4079c284ba7" => "20 Barton St.",
//         "global_global_a_LSI_DOS1336_OrgAdd2_7c5913c58aa1446ff60b32e7b27359b0" => "",
//         "global_global_a_LSI_DOS1336_OrgCity_ba2c385a38dc1ab52274ceb78600e88b" => "Albany",
//         "global_global_a_LSI_DOS1336_OrgState_ae774ad1c467aa261843ed029465f12a" => "NY",
//         "global_global_a_LSI_DOS1336_OrgZip_ca9ffb6b69504b18659bc439331559fb" => "14511",
//         "global_global_a_LSI_DOS1336_OrgZip4_b5f884ae5f80cec3868e3ef744e3ad86" => "",
//         "global_global_a_LSI_DOS_Signature_058b597cead5e44306f8344c6dc4ecec" => "MuhammadGZD"
//     ],
//     "form6" => [
//         "global_global_a_LSI_DOS_FilerName_4db81f98996ff5c5b2787dcb2946d397" => "LLC",
//         "global_global_a_LSI_DOS_FilerAdd1_4f65f01e4164a54f2a29e31040176180" => "20 Barton St.",
//         "global_global_a_LSI_DOS_FilerAdd2_6de0477a9a8a1f9a38fd144a6af347c8" => "",
//         "global_global_a_LSI_DOS_FilerCity_90f3d3b2d7e72f7076755a26e791ea59" => "Albany",
//         "global_global_a_LSI_DOS_FilerState_9fef1ebdeb3e25263fd4b0710ff1d09d" => "NY",
//         "global_global_a_LSI_DOS_FilerZip_cb450355bc547f46e76f47ccd5e23232" => "14511",
//         "global_global_a_LSI_DOS_FilerZip4_782aa88e390bfe7b151252ca6a959451" => "",
//         "global_global_a_LSI_DOS_EmailAddress_48fa35443396cdef3a3f31fc87383525" => "gazdievmaga63@gmail.com",
//         "global_global_a_LSI_DOS_EmailVerification_ce1478f087fb894f164f64668ee2af8a" => "gazdievmaga63@gmail.com",
//     ],
//     "form7" => [
//         "global_global_a_LSI_DOS_PlainCopyReq_e2dd205c7c99049d1e38935cfb9c73c6" => true,
//         "global_global_a_LSI_DOS_CertCopyReq_a71f53a71786536837e254ceb251b5a7" => true,
//         "global_global_a_LSI_DOS_CertOfExistenceReq_57ea2f1176ad478bbab18ed6487e0c7c" => true,
//     ],
// ];

// file_put_contents("formData.json", json_encode($formData));