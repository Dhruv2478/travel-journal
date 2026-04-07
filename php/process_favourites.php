<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['xmlString'])) {
    $xmlData = $_POST['xmlString'];
    $dir = '../xml/';
    $xsdFile = '../xsd/favourites.xsd'; 

    // 1. Load the XML into a DOMDocument for validation
    $xml = new DOMDocument();
    // Suppress internal errors so we can handle them manually
    libxml_use_internal_errors(true);
    
    if (!$xml->loadXML($xmlData)) {
        die("Error: Invalid XML format.");
    }

    // 2. VALIDATE AGAINST XSD
    if ($xml->schemaValidate($xsdFile)) {
        // VALIDATION PASSED: Proceed to save
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        
        $filename = "fav_" . time() . ".xml";
        
        if (file_put_contents($dir . $filename, $xmlData)) {
            header("Location: ../php/view_favourites.php");
            exit();
        }
    } else {
        // VALIDATION FAILED: Show the errors
        $errors = libxml_get_errors();
        echo "<div style='color: #721c24; background: #f8d7da; padding: 20px; border-radius: 8px; font-family: sans-serif;'>";
        echo "<h3><i class='fas fa-exclamation-triangle'></i> XML Validation Error</h3>";
        echo "<p>The data does not match the required schema (XSD). Details:</p><ul>";
        foreach ($errors as $error) {
            echo "<li>" . htmlspecialchars($error->message) . "</li>";
        }
        echo "</ul><a href='../html/add_favourite.html' style='color: #721c24; font-weight: bold;'>Go Back and Fix</a></div>";
        libxml_clear_errors();
    }
}
?>