<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Aws\Ssm\SsmClient;
use Aws\Exception\AwsException;
use Dotenv\Dotenv;

class Connection {
    public static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            try {
                $client = new SsmClient([
                    'version' => 'latest',
                    'region'  => 'us-east-1',
                ]);

                $result = $client->getParametersByPath([
                    'Path' => '/descontonamaquininha/',
                    'WithDecryption' => true,
                ]);

                $data = [];
                foreach ($result['Parameters'] as $param) {
                    $key = basename($param['Name']);
                    $data[$key] = $param['Value'];
                }

                $host   = $data['DB_HOST'];
                $user   = $data['DB_USER'];
                $pass   = $data['DB_PASS'];
                $dbname = $data['DB_NAME'];

            } catch (AwsException $e) {
                $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
                $dotenv->load();

                $host   = $_ENV['DB_HOST'] ?? 'localhost';
                $user   = $_ENV['DB_USER'] ?? 'root';
                $pass   = $_ENV['DB_PASS'] ?? '';
                $dbname = $_ENV['DB_NAME'] ?? 'meubanco';
            }

            try {
                $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
                self::$instance = new PDO($dsn, $user, $pass);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Erro ao conectar ao banco: " . $e->getMessage();
            }
        }
        return self::$instance;
    }
}
