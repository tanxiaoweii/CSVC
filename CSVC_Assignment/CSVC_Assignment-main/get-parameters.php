<?php
# Include aws.phar from the same directory
require_once 'aws.phar';

use Aws\Ssm\SsmClient;

// Retrieve settings from Parameter Store
error_log('Retrieving settings');

$az = file_get_contents('http://169.254.169.254/latest/meta-data/placement/availability-zone');
$region = substr($az, 0, -1);
$ssm_client = new SsmClient([
    'version' => 'latest',
    'region'  => $region
]);

try {
    # Retrieve settings from Parameter Store
    $result = $ssm_client->getParametersByPath(['Path' => '/example/', 'WithDecryption' => true]);

    # Extract individual parameters and map them to the expected variables
    $values = [];
    foreach ($result['Parameters'] as $parameter) {
        $values[$parameter['Name']] = $parameter['Value'];
    }

    // Map the retrieved values to expected variables for connection.php
    $mysql_hostname = $values['/example/endpoint'] ?? 'localhost';
    $mysql_user = $values['/example/username'] ?? 'root';
    $mysql_password = $values['/example/password'] ?? '';
    $mysql_database = $values['/example/database'] ?? 'wings';

} catch (Exception $e) {
    // Set default values if an error occurs
    $mysql_hostname = 'localhost';
    $mysql_user = 'root';
    $mysql_password = '';
    $mysql_database = 'wings';
    error_log("Error retrieving SSM parameters: " . $e->getMessage());
}
?>

