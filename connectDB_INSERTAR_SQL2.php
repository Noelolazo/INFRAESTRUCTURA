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
        $request = $this -> db -> prepare("EXEC select_gente");
        $request-> execute();
        $datos = $request -> fetchAll(PDO::FETCH_ASSOC);
        $db2 = new PDO("sqlsrv:Server=172.17.0.5,1433;Database=master", "sa", "Password2!");
        $db2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        foreach ($datos as $row) {
            $dni = $row['DNI']; // Asegúrate de que el nombre de la columna es correcto
            $nombre = $row['nombre']; // Asegúrate de que el nombre de la columna es correcto
    
            $callProcedure = $db2->prepare("EXEC insertar_gente @DNI = :dni, @nombre = :nombre");
            $callProcedure->bindParam(':dni', $dni);
            $callProcedure->bindParam(':nombre', $nombre);
            $callProcedure->execute();
        }
    }
}


new ConnectDB();

?>