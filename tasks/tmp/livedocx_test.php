#!/usr/bin/php
<?php

// Turn up error reporting
error_reporting (E_ALL|E_STRICT);

// Turn off WSDL caching
ini_set ('soap.wsdl_cache_enabled', 0);

// Define credentials for LD
define ('USERNAME', 'fpdev2012');
define ('PASSWORD', 'qwer1234');

// SOAP WSDL endpoint
define ('ENDPOINT', 'https://api.livedocx.com/1.2/mailmerge.asmx?WSDL');

// Define timezone
date_default_timezone_set('Europe/Berlin');

// -----------------------------------------------------------------------------

//
// SAMPLE #1 - License Agreement
//

print('Starting sample #1 (license-agreement)...');

// Instantiate SOAP object and log into LiveDocx

$soap = new SoapClient(ENDPOINT);

$soap->LogIn(
    array(
        'username' => USERNAME,
        'password' => PASSWORD
    )
);

// Upload template

$data = file_get_contents('./license-agreement-template.docx');

$soap->SetLocalTemplate(
    array(
        'template' => base64_encode($data),
        'format'   => 'docx'
    )
);

// Assign data to template

$fieldValues = array (
    'software' => 'Magic Graphical Compression Suite v2.5',
    'licensee' => 'Henry Döner-Meyer',
    'company'  => 'Megasoft Co-Operation',
    'date'     => date('F d, Y'),
    'time'     => date('H:i:s'),
    'city'     => 'Berlin',
    'country'  => 'Germany'
);

$soap->SetFieldValues(
    array (
        'fieldValues' => assocArrayToArrayOfArrayOfString($fieldValues)
    )
);

// Build the document

$soap->CreateDocument();

// Get document as PDF

$result = $soap->RetrieveDocument(
    array(
        'format' => 'pdf'
    )
);

$data = $result->RetrieveDocumentResult;

file_put_contents('./license-agreement-document.pdf', base64_decode($data));

// Get document as bitmaps (one per page)

$result = $soap->GetAllBitmaps(
    array(
        'zoomFactor' => 100,
        'format'     => 'png'
    )
);

$data = array();

if (isset($result->GetAllBitmapsResult->string)) {
    $pageCounter = 1;
    if (is_array($result->GetAllBitmapsResult->string)) {
        foreach ($result->GetAllBitmapsResult->string as $string) {
            $data[$pageCounter] = base64_decode($string);
            $pageCounter++;
        }
    } else {
       $data[$pageCounter] = base64_decode($result->GetAllBitmapsResult->string);
    }
}

foreach ($data as $pageCounter => $pageData) {
    $pageFilename = sprintf('./license-agreement-document-page-%s.png', $pageCounter);
    file_put_contents($pageFilename, $pageData);
}

// Get document as Windows metafiles (one per page)

$result = $soap->GetAllMetafiles();

$data = array();

if (isset($result->GetAllMetafilesResult->string)) {
    $pageCounter = 1;
    if (is_array($result->GetAllMetafilesResult->string)) {
        foreach ($result->GetAllMetafilesResult->string as $string) {
            $data[$pageCounter] = base64_decode($string);
            $pageCounter++;
        }
    } else {
       $data[$pageCounter] = base64_decode($result->GetAllMetafilesResult->string);
    }
}

foreach ($data as $pageCounter => $pageData) {
    $pageFilename = sprintf('./license-agreement-document-page-%s.wmf', $pageCounter);
    file_put_contents($pageFilename, $pageData);
}

// Log out (closes connection to backend server)

$soap->LogOut();

unset($soap);

print('DONE.' . PHP_EOL);

// -----------------------------------------------------------------------------

//
// SAMPLE #2 - Telephone Bill
//

print('Starting sample #2 (telephone-bill)...');

// Instantiate SOAP object and log into LiveDocx

$soap = new SoapClient(ENDPOINT);

$soap->LogIn(
    array(
        'username' => USERNAME,
        'password' => PASSWORD
    )
);

// Upload template

$data = file_get_contents('./telephone-bill-template.doc');

// Assign field values data to template

$soap->SetLocalTemplate(
    array(
        'template' => base64_encode($data),
        'format'   => 'doc'
    )
);

$fieldValues = array (
    'customer_number' => sprintf("#%'10s",  rand(0,1000000000)),
    'invoice_number'  => sprintf("#%'10s",  rand(0,1000000000)),
    'account_number'  => sprintf("#%'10s",  rand(0,1000000000)),
    'phone'           => '+49 421 335 9000',
    'date'            => date('F d, Y'),
    'name'            => 'James Henry Brown',
    'service_phone'   => '+49 421 335 910',
    'service_fax'     => '+49 421 335 9180',
    'month'           => date('F Y'),
    'monthly_fee'     =>  '€ 15.00',
    'total_net'       => '€ 100.00',
    'tax'             =>      '19%',
    'tax_value'       =>  '€ 15.00',
    'total'           => '€ 130.00'
);

$soap->SetFieldValues(
    array (
        'fieldValues' => assocArrayToArrayOfArrayOfString($fieldValues)
    )
);

// Assign block field values data to template

$blockFieldValues = array (
    array ('connection_number' => '+49 421 335 912', 'connection_duration' => '00:00:07', 'fee' => '€ 0.03'),
    array ('connection_number' => '+49 421 335 913', 'connection_duration' => '00:00:07', 'fee' => '€ 0.03'),
    array ('connection_number' => '+49 421 335 914', 'connection_duration' => '00:00:07', 'fee' => '€ 0.03'),
    array ('connection_number' => '+49 421 335 916', 'connection_duration' => '00:00:07', 'fee' => '€ 0.03')
);

$soap->SetBlockFieldValues(
    array (
        'blockName'        => 'connection',
        'blockFieldValues' => multiAssocArrayToArrayOfArrayOfString($blockFieldValues)
    )
);

// Build the document

$soap->CreateDocument();

// Get document as PDF

$result = $soap->RetrieveDocument(
    array(
        'format' => 'pdf'
    )
);

$data = $result->RetrieveDocumentResult;

file_put_contents('./telephone-bill-document.pdf', base64_decode($data));

// Log out (closes connection to backend server)

$soap->LogOut();

unset($soap);

print('DONE.' . PHP_EOL);

// -----------------------------------------------------------------------------

//
// SAMPLE #3 - Supported Formats
//

print('Starting sample #3 (supported-formats)...' . PHP_EOL);

// Instantiate SOAP object and log into LiveDocx

$soap = new SoapClient(ENDPOINT);

$soap->LogIn(
    array(
        'username' => USERNAME,
        'password' => PASSWORD
    )
);

// Get an object containing an array of supported template formats

$result = $soap->GetTemplateFormats();

print(PHP_EOL . 'Template format (input):' . PHP_EOL);

foreach ($result->GetTemplateFormatsResult->string as $format) {
    printf('- %s%s', $format, PHP_EOL);
}

// Get an object containing an array of supported document formats

print(PHP_EOL . 'Document format (output):' . PHP_EOL);

$result = $soap->GetDocumentFormats();

foreach ($result->GetDocumentFormatsResult->string as $format) {
    printf('- %s%s', $format, PHP_EOL);
}

// Get an object containing an array of supported image formats

print(PHP_EOL . 'Image format (output):' . PHP_EOL);

$result = $soap->GetImageFormats();

foreach ($result->GetImageFormatsResult->string as $format) {
    printf('- %s%s', $format, PHP_EOL);
}

print(PHP_EOL . 'DONE.' . PHP_EOL);

// Log out (closes connection to backend server)

$soap->LogOut();

unset($soap);

// -----------------------------------------------------------------------------

//
// SAMPLE #4 - Supported Formats
//

print('Starting sample #4 (supported-fonts)...' . PHP_EOL);

// Instantiate SOAP object and log into LiveDocx

$soap = new SoapClient(ENDPOINT);

$soap->LogIn(
    array(
        'username' => USERNAME,
        'password' => PASSWORD
    )
);

// Get an object containing an array of supported fonts

$result = $soap->GetFontNames();

foreach ($result->GetFontNamesResult->string as $format) {
    printf('- %s%s', $format, PHP_EOL);
}

print(PHP_EOL . 'DONE.' . PHP_EOL);

// Log out (closes connection to backend server)

$soap->LogOut();

unset($soap);

// -----------------------------------------------------------------------------

/**
 * Convert a PHP assoc array to a SOAP array of array of string
 *
 * @param array $assoc
 * @return array
 */
function assocArrayToArrayOfArrayOfString ($assoc)
{
    $arrayKeys   = array_keys($assoc);
    $arrayValues = array_values($assoc);

    return array ($arrayKeys, $arrayValues);
}

/**
 * Convert a PHP multi-depth assoc array to a SOAP array of array of array of string
 *
 * @param array $multi
 * @return array
 */
function multiAssocArrayToArrayOfArrayOfString ($multi)
{
    $arrayKeys   = array_keys($multi[0]);
    $arrayValues = array();

    foreach ($multi as $v) {
        $arrayValues[] = array_values($v);
    }

    $_arrayKeys = array();
    $_arrayKeys[0] = $arrayKeys;

    return array_merge($_arrayKeys, $arrayValues);
}