<?php
// Include NuSOAP library from the 2019WS folder
require("../lib/nusoap.php");

// Create the server instance
$server = new soap_server();

// Initialize WSDL support
$NAMESPACE = 'http://localhost/travel-journal/search-service';
$server->debug_flag = false;
$server->configureWSDL('DestinationSearch', $NAMESPACE);
$server->wsdl->schemaTargetNamespace = $NAMESPACE;


//Destination
$server->wsdl->addComplexType(
    'Destination',
    'complexType',
    'struct',
    'sequence',
    '',
    array(
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'title' => array('name' => 'title', 'type' => 'xsd:string'),
        'author' => array('name' => 'author', 'type' => 'xsd:string'),
        'date' => array('name' => 'date', 'type' => 'xsd:string'),
        'image' => array('name' => 'image', 'type' => 'xsd:string'),
        'excerpt' => array('name' => 'excerpt', 'type' => 'xsd:string'),
        'rating' => array('name' => 'rating', 'type' => 'xsd:string')
    )
);

// DestinationArray[]
$server->wsdl->addComplexType(
    'DestinationArray',
    'complexType',
    'array',
    '',
    'SOAP-ENC:Array',
    array(),
    array(
        array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:Destination[]')
    ),
    'tns:Destination'
);

//WSDL FUNCTIONS REGISTRATION 

$server->register(
    'searchDestinations',           // method name
    array('category' => 'xsd:string', 'query' => 'xsd:string'),  // input parameters
    array('output' => 'tns:DestinationArray'),  // output parameters
    $NAMESPACE
);

//PROCESS REQUEST
@$server->service(file_get_contents("php://input"));

//searchDestinations(category, query) 
function searchDestinations($category, $query) {
    require("../database/database_connection.php");

    // Sanitize and prepare inputs
    $category = trim($category) ?? 'All';
    $query = trim($query) ?? '';

    // Build SQL query
    $params = [];
    $types = '';
    $where = [];

    // Filter by category if not "All"
    if ($category !== 'All' && $category !== '') {
        $where[] = "category = ?";
        $params[] = $category;
        $types .= 's';
    }

    // Filter by search query
    if ($query !== '') {
        $where[] = "(title LIKE ? OR excerpt LIKE ?)";
        $params[] = '%' . $query . '%';
        $params[] = '%' . $query . '%';
        $types .= 'ss';
    }

    // Main SQL query
    $sql = "SELECT id, title, author, DATE_FORMAT(date, '%M %e, %Y') AS formatted_date, image, excerpt, rating
            FROM posts";

    // Add WHERE conditions if any
    if (!empty($where)) {
        $sql .= " WHERE " . implode(' AND ', $where);
    }

    // Order by most recent
    $sql .= " ORDER BY date DESC";

    // Prepare and execute
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        return array();
    }

    // Bind parameters if needed
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    // Build response array
    $destinations = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $destination = array(
                'id' => $row['id'],
                'title' => $row['title'],
                'author' => $row['author'],
                'date' => $row['formatted_date'],
                'image' => $row['image'],
                'excerpt' => $row['excerpt'],
                'rating' => $row['rating']
            );
            $destinations[] = $destination;
        }
        $stmt->free_result();
    }

    $stmt->close();

    return $destinations;
}

?>
