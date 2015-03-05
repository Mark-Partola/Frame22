<?php namespace Components\Auth;

class Com_Auth{

    private $login;
    private $password;
    private $table;
    private $db;

    function __construct($login, $password, \PDO $db){

        $this->login = $login;
        $this->password = $password;
        $this->prefix = TABLE_PREFIX;
        $this->table = $this->prefix . 'users';
        $this->db = $db;

    }

    public function checkAuth() {

        try {
            $sql = "SELECT  `user`.`id`, 
                            `role`.`privileges` as `role`, 
                            `role`.`title`, 
                            `priv`.`action`,
                            `act`.`title`
                        FROM `$this->table` as `user`
                            INNER JOIN `{$this->prefix}roles` as `role`
                                ON `user`.`role` = `role`.`id`
                            INNER JOIN `{$this->prefix}privileges` as `priv`
                                ON `role`.`privileges` = `priv`.`id_role`
                            INNER JOIN `{$this->prefix}actions` as `act`
                                ON `priv`.`action` = `act`.`id`
                                    WHERE `user`.`login` = '$this->login'
                                        AND `user`.`password` = '$this->password'";

            $stmt = $this->db->query($sql);

            $result = false;
            if($stmt)
                $result = $stmt->fetchAll();

            if($result) return $result;
            else return false;

        } catch (\Exception $e) {
            return false;
        }

    }

    public function setTable($table){
    $this->table = $table;
    }

}