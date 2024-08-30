const puppeteer = require('puppeteer-extra');
const StealthPlugin = require('puppeteer-extra-plugin-stealth');
const proxyChain = require('proxy-chain');
const fs = require('fs');

puppeteer.use(StealthPlugin());

async function runPuppeteerTask() {
    try {
    const oldProxyUrl = 'http://TqwVhB:b6NZsz@200.10.36.202:8000';
    const username = 'MuhammadGZD';
    const password = 'Mgfudhn@0006mrgb';

    const newProxyUrl = await proxyChain.anonymizeProxy(oldProxyUrl);

    const browser = await puppeteer.launch({
        headless: false,
        args: [
            `--proxy-server=${newProxyUrl}`,
            '--no-sandbox',
            '--disable-setuid-sandbox',
        ],
    });

    const page = await browser.newPage();

    await page.setExtraHTTPHeaders({
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.5735.198 Safari/537.36',
    });

    await page.goto('https://www.businessexpress.ny.gov/app/loginregister/?p_next_page=%2Fcc%2FCore%2FstartIntake%3FlicenseTypeCode%3DDOS1336%26appTypeCode%3DINITAPP', { waitUntil: 'networkidle2' });
    await page.waitForSelector('a.btn-nygov');
    await page.click('a.btn-nygov');
    await page.waitForNavigation({ waitUntil: 'networkidle2' });

    await page.waitForSelector('#loginform\\:username');
    await page.type('#loginform\\:username', username);
    await page.type('#loginform\\:password', password);
    await page.click('#loginform\\:signinButton');
    await page.waitForNavigation({ waitUntil: 'networkidle2' });

    await page.goto('https://www.businessexpress.ny.gov/app/dashboard/recentActivity', { waitUntil: 'networkidle2' });

    const formData = JSON.parse(fs.readFileSync('formData.json', 'utf8'));

    //Первая форма
    await page.waitForSelector('#global_global_a_CDI_LegalName_ddeefb6273b139d18f85fc894696df98');
    await page.type('#global_global_a_CDI_LegalName_ddeefb6273b139d18f85fc894696df98', formData.form1['global_global_a_CDI_LegalName_ddeefb6273b139d18f85fc894696df98']);
    await page.waitForSelector('#nameCheck_global_global_g_2_01d5a2743b9544dafdf5ca022d3e3c3f');
    await page.evaluate(() => new Promise(resolve => setTimeout(resolve, 2000)));
    await page.click('#nameCheck_global_global_g_2_01d5a2743b9544dafdf5ca022d3e3c3f');
    await page.type('#global_global_a_LSI_DOS_TrueNameVerification_5ea55a5092405c8db85a68ab93498f32', formData.form1['global_global_a_LSI_DOS_TrueNameVerification_5ea55a5092405c8db85a68ab93498f32']);
    await page.evaluate(() => new Promise(resolve => setTimeout(resolve, 2000)));
    await page.waitForFunction(() => document.querySelector('#btnNext') !== null);
    await page.waitForSelector('#btnNext');
    await page.click('#btnNext');


    await page.evaluate(() => new Promise(resolve => setTimeout(resolve, 5000)));

    //Вторая форма
    const purposeClauseCheck = formData.form2['global_global_a_LSI_DOS1336_LegalStructure_306ce4ddfb53a0ed7cfae1771fa81c4f'];
    if (purposeClauseCheck) {
        await page.click('#checkboxOneInput_global_global_a_LSI_DOS1336_LegalStructure_306ce4ddfb53a0ed7cfae1771fa81c4f');
    }
    const nonEnglish = formData.form2['global_global_a_LSI_DOS_NonEnglish_0b53511fa1d40938bba7abce99cb11a0'];
    const valueToSelect = nonEnglish ? 'true' : 'false';
    if (valueToSelect) {
        await page.evaluate((value) => {
            const radioButton = document.querySelector(`input[type="radio"][value="${value}"]`);
            if (radioButton) {
                radioButton.click();
            }
        }, valueToSelect);

        await page.type('#global_global_a_LSI_DOS_EnglishTranslation_8cbf53d53ea9ddf8b10b772a04488b14', formData.form2['global_global_a_LSI_DOS_EnglishTranslation_8cbf53d53ea9ddf8b10b772a04488b14']);
    }
    const purposeClause = formData.form2['global_global_a_LSI_DOS1336_PurposeClauseCheck_936084f9191ba4b9cc33a415c207379e'];
    if (purposeClause) {
        await page.click('#checkboxOneInput_global_global_a_LSI_DOS1336_PurposeClauseCheck_936084f9191ba4b9cc33a415c207379e');
    }
    const countyValue = formData.form2['global_global_a_LSI_DOS_County_52240ae97c3ef6c950ca10fe2eee4003'];
    const formattedCountyValue = countyValue.toString().padStart(3, '0');
    await page.evaluate((value) => {
        const selectElement = document.querySelector('select#global_global_a_LSI_DOS_County_52240ae97c3ef6c950ca10fe2eee4003');
        if (selectElement) {
            selectElement.value = value;
            selectElement.dispatchEvent(new Event('change'));
        }
    }, formattedCountyValue);
    await page.click('#btnNext');


    await page.evaluate(() => new Promise(resolve => setTimeout(resolve, 10000)));

    //Третья форма
    const radio = formData.form3['global_global_a_LSI_DOS_Secretary_StateAddress_84ca95b3d9cd775301b45f0cc484a2c1'];
    if (radio == 1) {
        const selector = '#radio_label_input_select_global_global_a_LSI_DOS_Secretary_StateAddress_84ca95b3d9cd775301b45f0cc484a2c1_1';
        await page.waitForSelector(selector, { visible: true });
        const radioInput = await page.$(selector);
        await page.evaluate(element => element.click(), radioInput);

        await page.type('#global_global_a_LSI_DOS_SoPName_4a649cba6667257c2be88e1eebc16b5a', formData.form3['global_global_a_LSI_DOS_SoPName_4a649cba6667257c2be88e1eebc16b5a_1']);
        await page.type('#global_global_a_LSI_DOS_SoPAdd1_0b09febc29d5492738d12f99382a3abf', formData.form3['global_global_a_LSI_DOS_SoPAdd1_0b09febc29d5492738d12f99382a3abf']);
        await page.type('#global_global_a_LSI_DOS_SoPAdd2_93436b048d2f2f96c676ea6ff1b26426', formData.form3['global_global_a_LSI_DOS_SoPAdd2_93436b048d2f2f96c676ea6ff1b26426']);
        await page.type('#global_global_a_LSI_DOS_SoPCity_967aa3adace44f185fd2e0b1b1a665d9', formData.form3['global_global_a_LSI_DOS_SoPCity_967aa3adace44f185fd2e0b1b1a665d9']);

        const stateFirst = formData.form3['global_global_a_LSI_DOS_SoPState_289dc832c724fd5da87685dcd2375939'];
        const formattedstateFirst = stateFirst.toString();
        await page.evaluate((value) => {
            const selectElement = document.querySelector('select#global_global_a_LSI_DOS_SoPState_289dc832c724fd5da87685dcd2375939');
            if (selectElement) {
                selectElement.value = value;
                selectElement.dispatchEvent(new Event('change'));
            }
        }, formattedstateFirst);

        await page.type('#global_global_a_LSI_DOS_SoPZip_6aee49aeec454d12130e3060ae7982ca', formData.form3['global_global_a_LSI_DOS_SoPZip_6aee49aeec454d12130e3060ae7982ca']);
        await page.type('#global_global_a_LSI_DOS_SoPZip4_9bbb0a77d852b9fe9ea71372351c08da', formData.form3['global_global_a_LSI_DOS_SoPZip4_9bbb0a77d852b9fe9ea71372351c08da']);
    } else if (radio == 2) {
        const selector = '#radio_label_input_select_global_global_a_LSI_DOS_Secretary_StateAddress_84ca95b3d9cd775301b45f0cc484a2c1_2';
        await page.waitForSelector(selector, { visible: true });
        const radioInput = await page.$(selector);
        await page.evaluate(element => element.click(), radioInput);

        const countyValue = formData.form3['global_global_a_LSI_DOS_SoPName_4a649cba6667257c2be88e1eebc16b5a_2'];

        await page.waitForSelector('select#global_global_a_LSI_DOS_SoPName_4a649cba6667257c2be88e1eebc16b5a', { visible: true });

        await page.evaluate((value) => {
            const selectElement = document.querySelector('select#global_global_a_LSI_DOS_SoPName_4a649cba6667257c2be88e1eebc16b5a');
            if (selectElement) {
                selectElement.value = value;
                selectElement.dispatchEvent(new Event('change', { bubbles: true }));
            }
        }, countyValue);
    }

    const rd2 = formData.form3['global_global_a_LSI_DOS_SoPHasEmail_064802c583120c637080b80772e61809'];
    if (rd2) {
        await page.click('#checkboxOneInput_global_global_a_LSI_DOS_SoPHasEmail_064802c583120c637080b80772e61809');

        await page.type('#global_global_a_LSI_DOS_SoPEmailAddress_29d6f753b21f60433d61e7cadbce4d93', formData.form3['global_global_a_LSI_DOS_SoPEmailAddress_29d6f753b21f60433d61e7cadbce4d93']);
        await page.type('#global_global_a_LSI_DOS_SoPEmailAddressVerify_634ab56a84ece52f1cf7f13363ba9416', formData.form3['global_global_a_LSI_DOS_SoPEmailAddressVerify_634ab56a84ece52f1cf7f13363ba9416']);
    }

    const rd3 = formData.form3['global_global_a_LSI_DOS_RegCheck_9ffa82b0fb1c1e1fb1c7a08afdd7575d'];
    if (rd3) {
        await page.click('#checkboxOneInput_global_global_a_LSI_DOS_RegCheck_9ffa82b0fb1c1e1fb1c7a08afdd7575d');

        const rd4 = formData.form3['global_global_a_LSI_DOS_RegisteredAddress_97d9cc9b149e7b2a9f8ea458eeec57f6'];
        if (rd4 == 1) {
            const selector = '#radio_label_input_select_global_global_a_LSI_DOS_RegisteredAddress_97d9cc9b149e7b2a9f8ea458eeec57f6_1';
            await page.waitForSelector(selector, { visible: true });
            const radioInput = await page.$(selector);
            await page.evaluate(element => element.click(), radioInput);

            await page.type('#global_global_a_LSI_DOS_RAName_b2dcdb3704531f0190b19e6aebfd4909', formData.form3['global_global_a_LSI_DOS_RAName_b2dcdb3704531f0190b19e6aebfd4909_1']);
            await page.type('#global_global_a_LSI_DOS_RAAdd1_1ea1f0e3b378bd6d709d8eb563b50ce7', formData.form3['global_global_a_LSI_DOS_RAAdd1_1ea1f0e3b378bd6d709d8eb563b50ce7']);
            await page.type('#global_global_a_LSI_DOS_RAAdd2_a9c8327981498a9f2ce2570712c41750', formData.form3['global_global_a_LSI_DOS_RAAdd2_a9c8327981498a9f2ce2570712c41750']);
            await page.type('#global_global_a_LSI_DOS_RACity_f4d1cf092bbc03642160947741bb6ba4', formData.form3['global_global_a_LSI_DOS_RACity_f4d1cf092bbc03642160947741bb6ba4']);

            const stateFirst = formData.form3['global_global_a_LSI_DOS_RAState_aa823a40fee8b129025442e257a5f01d'];
            const formattedstateFirst = stateFirst.toString();
            await page.evaluate((value) => {
                const selectElement = document.querySelector('select#global_global_a_LSI_DOS_RAState_aa823a40fee8b129025442e257a5f01d');
                if (selectElement) {
                    selectElement.value = value;
                    selectElement.dispatchEvent(new Event('change'));
                }
            }, formattedstateFirst);

            await page.type('#global_global_a_LSI_DOS_RAZip_10923d5456ad3d2117ca078390606687', formData.form3['global_global_a_LSI_DOS_RAZip_10923d5456ad3d2117ca078390606687']);
            await page.type('#global_global_a_LSI_DOS_RAZip4_ec4cdfac0462857e119ccf1305b69ff6', formData.form3['global_global_a_LSI_DOS_RAZip4_ec4cdfac0462857e119ccf1305b69ff6']);
        } else if (rd4 == 2) {
            const selector = '#radio_label_input_select_global_global_a_LSI_DOS_RegisteredAddress_97d9cc9b149e7b2a9f8ea458eeec57f6_2';
            await page.waitForSelector(selector, { visible: true });
            const radioInput = await page.$(selector);
            await page.evaluate(element => element.click(), radioInput);

            const countyValue = formData.form3['global_global_a_LSI_DOS_RAName_b2dcdb3704531f0190b19e6aebfd4909_2'];

            await page.waitForSelector('select#global_global_a_LSI_DOS_RAName_b2dcdb3704531f0190b19e6aebfd4909', { visible: true });

            await page.evaluate((value) => {
                const selectElement = document.querySelector('select#global_global_a_LSI_DOS_RAName_b2dcdb3704531f0190b19e6aebfd4909');
                if (selectElement) {
                    selectElement.value = value;
                    selectElement.dispatchEvent(new Event('change', { bubbles: true }));
                }
            }, countyValue);
        }
    }
    await page.click('#btnNext');


    await page.evaluate(() => new Promise(resolve => setTimeout(resolve, 10000)));

    //Четвертая форма
    const ch = formData.form4['global_global_a_LSI_DOS1336_ManagementStuctureCheck_db1db7850fba3f18b243f6fdede31535'];
    if (ch) {
        await page.click('#checkboxOneInput_global_global_a_LSI_DOS1336_ManagementStuctureCheck_db1db7850fba3f18b243f6fdede31535');

        const rd5 = formData.form4['global_global_a_LSI_DOS1336_ManagementStucture_605e8283d9e2300373e1bad2989f6cf6'];

        if (rd5 == 1) {
            const selector = '#radio_label_input_select_global_global_a_LSI_DOS1336_ManagementStucture_605e8283d9e2300373e1bad2989f6cf6_1';
            await page.waitForSelector(selector, { visible: true });
            const radioInput = await page.$(selector);
            await page.evaluate(element => element.click(), radioInput);
        } else if (rd5 == 2) {
            const selector = '#radio_label_input_select_global_global_a_LSI_DOS1336_ManagementStucture_605e8283d9e2300373e1bad2989f6cf6_2';
            await page.waitForSelector(selector, { visible: true });
            const radioInput = await page.$(selector);
            await page.evaluate(element => element.click(), radioInput);
        } else if (rd5 == 3) {
            const selector = '#radio_label_input_select_global_global_a_LSI_DOS1336_ManagementStucture_605e8283d9e2300373e1bad2989f6cf6_3';
            await page.waitForSelector(selector, { visible: true });
            const radioInput = await page.$(selector);
            await page.evaluate(element => element.click(), radioInput);
        } else if (rd5 == 4) {
            const selector = '#radio_label_input_select_global_global_a_LSI_DOS1336_ManagementStucture_605e8283d9e2300373e1bad2989f6cf6_4';
            await page.waitForSelector(selector, { visible: true });
            const radioInput = await page.$(selector);
            await page.evaluate(element => element.click(), radioInput);
        }
    }

    const ch2 = formData.form4['global_global_a_LSI_DOS1336_EffectiveDateCheck_b96946771675ed7b42f3a7259a467ae6'];
    if (ch2) {
        await page.click('#checkboxOneInput_global_global_a_LSI_DOS1336_EffectiveDateCheck_b96946771675ed7b42f3a7259a467ae6');

        const rd6 = formData.form4['global_global_a_LSI_DOS1336_Existence_fa39e2b645baea31791617f9ea545553'];

        if (rd6 == 1) {
            const selector = '#radio_label_input_select_global_global_a_LSI_DOS1336_Existence_fa39e2b645baea31791617f9ea545553_1';
            await page.waitForSelector(selector, { visible: true });
            const radioInput = await page.$(selector);
            await page.evaluate(element => element.click(), radioInput);
        } else if (rd6 == 2) {
            const selector = '#radio_label_input_select_global_global_a_LSI_DOS1336_Existence_fa39e2b645baea31791617f9ea545553_2';
            await page.waitForSelector(selector, { visible: true });
            const radioInput = await page.$(selector);
            await page.evaluate(element => element.click(), radioInput);

            await page.type('#global_global_a_LSI_DOS_EffectiveDate_6232ef481830ced753534d09a81dd0bd', formData.form4['global_global_a_LSI_DOS_EffectiveDate_6232ef481830ced753534d09a81dd0bd']);
        }
    }

    const ch3 = formData.form4['global_global_a_LSI_DOS1336_DurationDateCheck_f89c1a60106a5b946cbf31db672524c7'];
    if (ch3) {
        await page.click('#checkboxOneInput_global_global_a_LSI_DOS1336_DurationDateCheck_f89c1a60106a5b946cbf31db672524c7');

        const rd7 = formData.form4['global_global_a_LSI_DOS1336_DurationDate_83d31a5ed7ebafeb0bdd2dd76b207a9a'];

        if (rd7 == 1) {
            const selector = '#radio_label_input_select_global_global_a_LSI_DOS1336_DurationDate_83d31a5ed7ebafeb0bdd2dd76b207a9a_1';
            await page.waitForSelector(selector, { visible: true });
            const radioInput = await page.$(selector);
            await page.evaluate(element => element.click(), radioInput);
        } else if (rd7 == 2) {
            const selector = '#radio_label_input_select_global_global_a_LSI_DOS1336_DurationDate_83d31a5ed7ebafeb0bdd2dd76b207a9a_2';
            await page.waitForSelector(selector, { visible: true });
            const radioInput = await page.$(selector);
            await page.evaluate(element => element.click(), radioInput);

            await page.type('#global_global_a_LSI_DOS_DurationDate_c0f64a1e7ba486a0259304235b754cb9', formData.form4['global_global_a_LSI_DOS_DurationDate_c0f64a1e7ba486a0259304235b754cb9']);
        }
    }

    const ch4 = formData.form4['global_global_a_LSI_DOS1336_IncludeLiabilityStatement_7a78c9856a86e4dcd19c544a58bd2b51'];
    if (ch4) {
        await page.click('#checkboxOneInput_global_global_a_LSI_DOS1336_IncludeLiabilityStatement_7a78c9856a86e4dcd19c544a58bd2b51');
    }
    await page.click('#btnNext');


    await page.evaluate(() => new Promise(resolve => setTimeout(resolve, 5000)));

    //Пятая форма
    await page.type('#global_global_a_LSI_DOS1336_OrgName_0c799e169920e6f83ab6e5b1cf7fafbb', formData.form5['global_global_a_LSI_DOS1336_OrgName_0c799e169920e6f83ab6e5b1cf7fafbb']);
    await page.type('#global_global_a_LSI_DOS1336_OrgAdd1_d63d960136257d2b2d45e4079c284ba7', formData.form5['global_global_a_LSI_DOS1336_OrgAdd1_d63d960136257d2b2d45e4079c284ba7']);
    await page.type('#global_global_a_LSI_DOS1336_OrgAdd2_7c5913c58aa1446ff60b32e7b27359b0', formData.form5['global_global_a_LSI_DOS1336_OrgAdd2_7c5913c58aa1446ff60b32e7b27359b0']);
    await page.type('#global_global_a_LSI_DOS1336_OrgCity_ba2c385a38dc1ab52274ceb78600e88b', formData.form5['global_global_a_LSI_DOS1336_OrgCity_ba2c385a38dc1ab52274ceb78600e88b']);
    const st = formData.form5['global_global_a_LSI_DOS1336_OrgState_ae774ad1c467aa261843ed029465f12a'];
    const formattedstateFirst = st.toString();
    await page.evaluate((value) => {
        const selectElement = document.querySelector('select#global_global_a_LSI_DOS1336_OrgState_ae774ad1c467aa261843ed029465f12a');
        if (selectElement) {
            selectElement.value = value;
            selectElement.dispatchEvent(new Event('change'));
        }
    }, formattedstateFirst);
    await page.type('#global_global_a_LSI_DOS1336_OrgZip_ca9ffb6b69504b18659bc439331559fb', formData.form5['global_global_a_LSI_DOS1336_OrgZip_ca9ffb6b69504b18659bc439331559fb']);
    await page.type('#global_global_a_LSI_DOS1336_OrgZip4_b5f884ae5f80cec3868e3ef744e3ad86', formData.form5['global_global_a_LSI_DOS1336_OrgZip4_b5f884ae5f80cec3868e3ef744e3ad86']);
    await page.type('#global_global_a_LSI_DOS_Signature_058b597cead5e44306f8344c6dc4ecec', formData.form5['global_global_a_LSI_DOS_Signature_058b597cead5e44306f8344c6dc4ecec']);
    await page.click('#btnNext');


    await page.evaluate(() => new Promise(resolve => setTimeout(resolve, 5000)));

    //Шестая форма
    await page.type('#global_global_a_LSI_DOS_FilerName_4db81f98996ff5c5b2787dcb2946d397', formData.form6['global_global_a_LSI_DOS_FilerName_4db81f98996ff5c5b2787dcb2946d397']);
    await page.type('#global_global_a_LSI_DOS_FilerAdd1_4f65f01e4164a54f2a29e31040176180', formData.form6['global_global_a_LSI_DOS_FilerAdd1_4f65f01e4164a54f2a29e31040176180']);
    await page.type('#global_global_a_LSI_DOS_FilerAdd2_6de0477a9a8a1f9a38fd144a6af347c8', formData.form6['global_global_a_LSI_DOS_FilerAdd2_6de0477a9a8a1f9a38fd144a6af347c8']);
    await page.type('#global_global_a_LSI_DOS_FilerCity_90f3d3b2d7e72f7076755a26e791ea59', formData.form6['global_global_a_LSI_DOS_FilerCity_90f3d3b2d7e72f7076755a26e791ea59']);
    const st2 = formData.form6['global_global_a_LSI_DOS_FilerState_9fef1ebdeb3e25263fd4b0710ff1d09d'];
    const formattedstateSc = st2.toString();
    await page.evaluate((value) => {
        const selectElement = document.querySelector('select#global_global_a_LSI_DOS_FilerState_9fef1ebdeb3e25263fd4b0710ff1d09d');
        if (selectElement) {
            selectElement.value = value;
            selectElement.dispatchEvent(new Event('change'));
        }
    }, formattedstateSc);
    await page.type('#global_global_a_LSI_DOS_FilerZip_cb450355bc547f46e76f47ccd5e23232', formData.form6['global_global_a_LSI_DOS_FilerZip_cb450355bc547f46e76f47ccd5e23232']);
    await page.type('#global_global_a_LSI_DOS_FilerZip4_782aa88e390bfe7b151252ca6a959451', formData.form6['global_global_a_LSI_DOS_FilerZip4_782aa88e390bfe7b151252ca6a959451']);
    //await page.type('#global_global_a_LSI_DOS_EmailAddress_48fa35443396cdef3a3f31fc87383525', formData.form6['global_global_a_LSI_DOS_EmailAddress_48fa35443396cdef3a3f31fc87383525']);
    await page.type('#global_global_a_LSI_DOS_EmailVerification_ce1478f087fb894f164f64668ee2af8a', formData.form6['global_global_a_LSI_DOS_EmailVerification_ce1478f087fb894f164f64668ee2af8a']);

    await page.click('#btnNext');


    //Страница загрузки сертификата
    await page.evaluate(() => new Promise(resolve => setTimeout(resolve, 10000)));

    await page.click('#btnNext');

    await page.evaluate(() => new Promise(resolve => setTimeout(resolve, 5000)));

    await page.click('#btnNext');

    await page.evaluate(() => new Promise(resolve => setTimeout(resolve, 10000)));

    //Страница с выборкой
    const costCh = formData.form7['global_global_a_LSI_DOS_PlainCopyReq_e2dd205c7c99049d1e38935cfb9c73c6'];
    if (costCh) {
        await page.click('#checkboxOneInput_global_global_a_LSI_DOS_PlainCopyReq_e2dd205c7c99049d1e38935cfb9c73c6');
    }

    const costCh2 = formData.form7['global_global_a_LSI_DOS_CertCopyReq_a71f53a71786536837e254ceb251b5a7'];
    if (costCh2) {
        await page.click('#checkboxOneInput_global_global_a_LSI_DOS_CertCopyReq_a71f53a71786536837e254ceb251b5a7');
    }

    const costCh3 = formData.form7['global_global_a_LSI_DOS_CertOfExistenceReq_57ea2f1176ad478bbab18ed6487e0c7c'];
    if (costCh3) {
        await page.click('#checkboxOneInput_global_global_a_LSI_DOS_CertOfExistenceReq_57ea2f1176ad478bbab18ed6487e0c7c');
    }

    await page.click('#btnNext');

    await page.evaluate(() => new Promise(resolve => setTimeout(resolve, 5000)));

    await page.click('#btnNext');
} catch (error) {
    console.error('Error occurred:', error);
    console.log('Retrying...');
    await runPuppeteerTask(); 
}
};

runPuppeteerTask();