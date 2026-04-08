<?php
error_reporting(0);
// Include NuSOAP library
require_once("../lib/nusoap.php");

// Get input parameters
$category = $_GET["category"] ?? 'All';
$query = $_GET["query"] ?? '';

// Create a SOAP client
$url = "http://localhost/travel-journal/search-service/server.php?wsdl";
$client = new nusoap_client($url, 'wsdl');

// Call the search web service
$response = $client->call('searchDestinations', array('category' => $category, 'query' => $query));

// Check for SOAP faults or errors
if ($client->fault) {
    echo "<p class='no-posts'>Error: Service fault detected.</p>";
} else {
    $error = $client->getError();
    if ($error) {
        echo "<p class='no-posts'>Error: " . htmlspecialchars($error) . "</p>";
    } else {
        // Convert SOAP Response to XML and apply XSLT transformation
        $XMLDocument = new SimpleXMLElement('<?xml version="1.0" ?><SearchResults></SearchResults>');

        if (is_array($response) && count($response) > 0) {
            foreach ($response as $record) {
                $destination = $XMLDocument->addChild('destination');
                $destination->addAttribute('id', $record['id']);
                $destination->addChild('title', $record['title']);
                $destination->addChild('author', $record['author']);
                $destination->addChild('date', $record['date']);
                $destination->addChild('image', $record['image']);
                $destination->addChild('excerpt', $record['excerpt']);
                $destination->addChild('rating', $record['rating']);
                $destination->addChild('category', $category);
            }
        } else {
            // No results found
            echo "<p class='no-posts'>No destinations found matching your search.</p>";
            exit;
        }
        // Apply XSLT to display the results
        $XSLDocument = new DOMDocument();
        $XSLDocument->load("search_results.xsl");
        $XSLProcessor = new XSLTProcessor();
        $XSLProcessor->importStylesheet($XSLDocument);
        echo $XSLProcessor->transformToXML($XMLDocument);
    }
}
?>


