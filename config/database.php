<?php
class Database {
    private static $instance = null;

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            try {
                $host =  DB_HOST ;
                $dbname = DB_NAME; 
                $username = DB_USER;
                $password = DB_PASS;
                $port = DB_PORT;

                self::$instance = new PDO(
                    "pgsql:host=$host;dbname=$dbname;port=$port",
                    $username,
                    $password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false
                    ]
                );
            } catch (PDOException $e) {
                die("Erreur de connexion postgreSQL: " . $e->getMessage());
            }
        }
        return self::$instance;
    }

    // 2. Raccourci pour les requêtes de lecture (SELECT)
public static function executeSelect($sql,$params=[],$one=false){
     $pdo = self :: getConnection();
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    if($one){
        return $stmt->fetch();
    }else{
    return $stmt->fetchAll();
}
}

 // 3. Raccourci pour les requêtes d'écriture (INSERT, UPDATE)
public static function executeUpdate($sql, $params = []){
    $pdo = self :: getConnection();
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($params);
}

// 4. Raccourci pour les requêtes de suppression (DELETE)
public static function executeDelete($sql, $params = []){
    $pdo = self :: getConnection();
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($params);
}

}
