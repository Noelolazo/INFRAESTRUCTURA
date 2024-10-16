<?php
class ConnectDB {

    private $password;
    private $user;
    private $databaseName;
    private $host;
    private $db;

    public function __construct() {
        $this -> connectON();
    }

    private function connectON() {
        try {
            $this -> db = new PDO("sqlsrv:Server=172.17.0.4,1433;Database=master", "sa", "Password2!");
            $this -> db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this -> consulta(); 
        } catch (Exception $error) {
            echo "No se ha podido conectar a la bd: ". $error -> getMessage();
        }
    }

    public function consulta() {
        $request = $this -> db -> prepare("SELECT @@version");
        $request-> execute();
        $datos = $request -> fetchAll(PDO::FETCH_ASSOC);
        var_dump($datos);
    }
}
echo "APACHE1 <br>";
new ConnectDB();

?>