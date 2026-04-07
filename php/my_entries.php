<?php
session_start();
include '../database/database_connection.php';
include '../database/database_connection.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../php/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$xmlfile_Doc = "../xml/my_entry.xml";
$xsdfile_Doc = "../xsd/my_entry.xsd";
$xslfile_Doc = "../xsl/my_entry.xsl";


$xml = new DOMDocument();
if (!$xml->load($xmlfile_Doc)) {
    die("Error: Could not load XML file.");
}

if (!$xml->schemaValidate($xsdfile_Doc)) {
    die("Error: XML does not validate against the XSD schema.");
}

$xsl = new DOMDocument();
if (!$xsl->load($xslfile_Doc)) {
    die("Error: Could not load XSL file.");
}

$proc = new XSLTProcessor();
$proc->importStylesheet($xsl);
echo $proc->transformToXML($xml);

?>
