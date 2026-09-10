<?php
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __construct() {
        // Lê as variáveis de ambiente definidas no serviço "web" do docker-compose.yml.
        // O valor depois de "?:" é usado como fallback, caso a variável não esteja definida
        // (por exemplo, se alguém rodar o PHP fora do Docker).
        $this->host     = getenv('DB_HOST') ?: 'db';
        $this->db_name  = getenv('DB_NAME') ?: 'brawldex';
        $this->username = getenv('DB_USER') ?: 'root';
        $this->password = getenv('DB_PASSWORD') ?: 'root';
    }

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Cria a tabela 'produtos' automaticamente se ela ainda não existir
            $sql = "CREATE TABLE IF NOT EXISTS produtos (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(150) NOT NULL,
                descricao TEXT,
                preco DECIMAL(10,2) NOT NULL,
                quantidade INT NOT NULL
            )";
            $this->conn->exec($sql);

        } catch(PDOException $exception) {
            echo "Erro na conexão com o Banco: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>