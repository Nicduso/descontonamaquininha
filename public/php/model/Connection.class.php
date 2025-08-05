<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Aws\Ssm\SsmClient;
use Dotenv\Dotenv;

class Connection {
	public static $instance;

	public static function getInstance() {
		if (!isset(self::$instance)) {
			try {
				// Verifica ambiente
				$environment = $_ENV['APP_ENV'] ?? 'local';

				if ($environment === 'local') {
					// Usa .env local
					$dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
					$dotenv->load();

					$host = $_ENV['DB_HOST'];
					$dbname = $_ENV['DB_NAME'];
					$user = $_ENV['DB_USER'];
					$pass = $_ENV['DB_PASS'];
				} else {
					// Usa AWS Parameter Store
					$ssm = new SsmClient([
						'version'     => 'latest',
						'region'      => 'us-east-1',
						'credentials' => [
							'key'    => $_ENV['AWS_ACCESS_KEY_ID'],
							'secret' => $_ENV['AWS_SECRET_ACCESS_KEY'],
						],
					]);

					$host   = $ssm->getParameter(['Name' => '/descontonamaquininha/DB_HOST', 'WithDecryption' => true])['Parameter']['Value'];
					$user   = $ssm->getParameter(['Name' => '/descontonamaquininha/DB_USER', 'WithDecryption' => true])['Parameter']['Value'];
					$pass   = $ssm->getParameter(['Name' => '/descontonamaquininha/DB_PASS', 'WithDecryption' => true])['Parameter']['Value'];
					$dbname = $ssm->getParameter(['Name' => '/descontonamaquininha/DB_NAME', 'WithDecryption' => true])['Parameter']['Value'];
				}

				self::$instance = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
				self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch(Exception $e) {
				echo "Erro ao conectar o Banco de Dados: " . $e->getMessage();
			}
		}
		return self::$instance;
	}
}
?>
