<?php

require("IUser.php");
require("userDTO.php");
require(__DIR__ . "/../comun/baseDAO.php");

class userDAO extends baseDAO implements IUser
{
    public function __construct()
    {

    }

    public function login($userDTO)
    {
        $foundedUserDTO = $this->buscaUsuario($userDTO->username());
        
        if ($foundedUserDTO && self::testHashPassword( $userDTO->password(), $foundedUserDTO->password())) 
        {
            return $foundedUserDTO;
        } 

        return false;
    }

    private function buscaUsuario($username)
    {
        $escUserName = $this->realEscapeString($username);

        $conn = application::getInstance()->getConexionBd();

        $query = "SELECT Id, UserName, Password FROM Usuarios WHERE username = ?";

        $stmt = $conn->prepare($query);

        $stmt->bind_param("s", $escUserName);

        $stmt->execute();

        $stmt->bind_result($Id, $UserName, $Password);

        if ($stmt->fetch())
        {
            $user = new userDTO($Id, $UserName, $Password);

            $stmt->close();

            return $user;
        }

        return false;
    }

    public function create($userDTO)
    {
        $createdUserDTO = false;

        $escUserName = $this->realEscapeString($userDTO->userName());

        $hashedPassword = self::hashPassword($userDTO->password());

        $conn = application::getInstance()->getConexionBd();

        $query = "INSERT INTO Usuarios(UserName, Password) VALUES (?, ?)";

        $stmt = $conn->prepare($query);

        $stmt->bind_param("ss", $escUserName, $hashedPassword);

        if ($stmt->execute())
        {
            $idUser = $conn->insert_id;
            
            $createdUserDTO = new userDTO($idUser, $userDTO->userName(), $userDTO->password());

            return $createdUserDTO;
        }

        return $createdUserDTO;
    }

    private static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    private static function testHashPassword($password, $hashedPassword)
    {
        $result = password_verify($password, $hashedPassword);

        return $result;
    }
}
?>