<?php

class Model_Account extends Model {

    public function getUsers() {
        $db = $this->mysqlConnect();
        $sql = "select * from users";
        $query = $db->prepare($sql);
        $query->execute();

        $users = $query->fetchAll();

        return $users;
    }

    public function getUsersById($user_id) {
        $db = $this->mysqlConnect();
        $sql = "select * from users where id=" . $user_id;
        $query = $db->prepare($sql);
        $query->execute();

        $users = $query->fetchAll();

        return $users;
    }

    public function addUser(array $user) {
        $db = $this->mysqlConnect();

        // сделать серверную валидацию ПОСТа!!!

        $result = array();

        // проверка на пустоту
        $error = false;
        foreach ($user as $key => $val) {
            if ($val == '') {
                $result['error'][$key] = 'Пустое значение';
                $error = true;
            }
        }

        if ($error) {
            return $result;
        }

        // проверка на правильность написания email

        if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
            $result['error']['email'] = 'Не правильный E-mail';
            return $result;
        }

//        // проверка на существование e-mail

        $sql = "SELECT * FROM `users` where email like '%" . $user['email'] . "%'";
        $query = $db->prepare($sql);
        $query->execute();
        $exist_email = $query->fetch(\PDO::FETCH_ASSOC);

        if ($exist_email) {
            $result['error']['email'] = 'E-mail уже существует!';
            return $result;
        }

        // проверка на повтор пароля


        if ($user['password'] != $user['repeat_password']) {
            $result['error']['repeat_password'] = 'Пароли не совпадают!';
            return $result;
        }


        try {
            $user['created_at'] = date('Y-m-d G:i:s', \strtotime('now'));
            $user['updated_at'] = date('Y-m-d G:i:s', \strtotime('now'));
            $user['password'] = md5($user['password'] . 'cabinet');
            $keys = '';
            $values = '';
            $q = $db->prepare("DESCRIBE users");
            $q->execute();
            $table_fields = $q->fetchAll(PDO::FETCH_COLUMN);
            foreach ($table_fields as $value) {
                if ($value === end($table_fields)) {
                    $keys .= '`' . $value . '`';
                } else {
                    $keys .= '`' . $value . '`,';
                }

                if (!empty($user[$value])) {
                    if ($value === end($table_fields)) {
                        $values .= '\'' . $user[$value] . '\'';
                    } else {
                        $values .= '\'' . $user[$value] . '\',';
                    }
                } else {
                    if ($value === end($table_fields)) {
                        $values .= 'null';
                    } else {
                        $values .= 'null,';
                    }
                }
            }

            $sql = "INSERT INTO `users` (" . $keys . ") VALUES (" . $values . ")";

            $query = $db->prepare($sql);
            $query->execute();
            return true;
        } catch (Exception $exc) {
            print $exc->__toString();
            return false;
        }
    }

    public function login($user) {
        $db = $this->mysqlConnect();
        $sql = "SELECT * FROM `users` where email = '" . $user['email'] . "' and password = '" . md5($user['password'] . 'cabinet')."'";
        $query = $db->prepare($sql);
        $query->execute();
        $exist_user = $query->fetch(\PDO::FETCH_ASSOC);

        if($exist_user){
            return true;
        } else {
            return false;
        }
    }

}
