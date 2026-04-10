<?php
error_reporting(0);
require_once("../lib/nusoap.php");

$category = $_GET["category"] ?? 'All';
$query    = $_GET["query"]    ?? '';

// SOAP call for DB destinations
$url    = "http://localhost/travelweb/search-service/server.php?wsdl";
$client = new nusoap_client($url, 'wsdl');
$response = $client->call('searchDestinations', array('category' => $category, 'query' => $query));

// Build XML document
$XMLDocument = new SimpleXMLElement('<?xml version="1.0" ?><SearchResults></SearchResults>');

$hasResults = false;

//  Add DB results
if (!$client->fault && !$client->getError()) {
    if (is_array($response) && count($response) > 0) {
        foreach ($response as $record) {
            $destination = $XMLDocument->addChild('destination');
            $destination->addAttribute('id',     $record['id']);
            $destination->addChild('title',      $record['title']);
            $destination->addChild('author',     $record['author']);
            $destination->addChild('date',       $record['date']);
            $destination->addChild('image',      $record['image']);
            $destination->addChild('excerpt',    $record['excerpt']);
            $destination->addChild('rating',     $record['rating']);
            $destination->addChild('category',   $category);
            $hasResults = true;
        }
    }
}

// Load & merge XML file destinations 
$xmlFile = '../xml/destinations.xml';
$xsdFile = '../xsd/destinations.xsd';

if (file_exists($xmlFile)) {
    libxml_use_internal_errors(true);

    $xmlDom = new DOMDocument();
    $xmlDom->load($xmlFile);

    if ($xmlDom->schemaValidate($xsdFile)) {
        $xmlData = simplexml_import_dom($xmlDom);

        foreach ($xmlData->destination as $dest) {
            $id       = (string) $dest['id'];
            $title    = (string) $dest->title;
            $author   = (string) $dest->author;
            $date     = (string) $dest->date;
            $image    = (string) $dest->image;
            $excerpt  = (string) $dest->excerpt;
            $rating   = (string) $dest->rating;
            $destCat  = (string) $dest->category;

            // Apply category filter
            if ($category !== 'All' && $category !== '' && $destCat !== $category) {
                continue;
            }

            // Apply search query filter (title or excerpt)
            if ($query !== '') {
                $q = strtolower($query);
                if (strpos(strtolower($title), $q) === false &&
                    strpos(strtolower($excerpt), $q) === false) {
                    continue;
                }
            }

            $destination = $XMLDocument->addChild('destination');
            $destination->addAttribute('id',   'xml_' . $id); // prefix to avoid ID clash with DB
            $destination->addChild('title',    htmlspecialchars($title));
            $destination->addChild('author',   htmlspecialchars($author));
            $destination->addChild('date',     htmlspecialchars($date));
            $destination->addChild('image',    htmlspecialchars($image));
            $destination->addChild('excerpt',  htmlspecialchars($excerpt));
            $destination->addChild('rating',   htmlspecialchars($rating));
            $destination->addChild('category', htmlspecialchars($destCat));
            $hasResults = true;
        }
    }

    libxml_clear_errors();
}

// Output 
if (!$hasResults) {
    echo "<p class='no-posts'>No destinations found matching your search.</p>";
    exit;
}

$XSLDocument = new DOMDocument();
$XSLDocument->load("search_results.xsl");
$XSLProcessor = new XSLTProcessor();
$XSLProcessor->importStylesheet($XSLDocument);
echo $XSLProcessor->transformToXML($XMLDocument);
?>