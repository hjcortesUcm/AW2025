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
        
        if ($foundedUserDTO && $foundedUserDTO->password() === $userDTO->password()) 
        {
            return $foundedUserDTO;
        } 

        return false;
    }

    private function buscaUsuario($username)
    {
        // $username = user';DELETE FROM usuarios
        
        $query = sprintf("SELECT Id, UserName, Password FROM Usuarios WHERE username='%s'", $this->realEscapeString($username));

        $rs = $this->ExecuteQuery($query);

        if ($rs && count($rs) == 1)
        {
            $user = new userDTO($rs[0]['Id'], $rs[0]['UserName'], $rs[0]['Password']);

            return $user;
        }

        return false;
    }

    public function create($userDTO)
    {
        $createdUserDTO = false;

        $query = sprintf("INSERT INTO Usuarios(UserName, Password) VALUES ('%s', '%s')"
            , $this->realEscapeString($userDTO->userName())
            , $this->realEscapeString($userDTO->password())
        );

        $conn = $this->ExecuteCommand($query);

        if ( $conn ) 
        {
            $idUser = $conn->insert_id;
            
            $createdUserDTO = new userDTO($idUser, $userName, $password);
        } 

        return $createdUserDTO;
    }

}
?>