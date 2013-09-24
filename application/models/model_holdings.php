<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_holdings
 *
 * @author user
 */
class Model_Holdings extends Model {

    public function getHoldings($user_id) {
        $db = $this->mysqlConnect();
        $sql = "select * from holdings where user_id = " . $user_id;
        $query = $db->prepare($sql);
        $query->execute();

        $holdings = $query->fetchAll();

        foreach($holdings as &$holding){
            if(!empty($holding['created_at'])){
                $holding['created_at'] = $this->_timeformat($holding['created_at']);
            }
            if(!empty($holding['date_end_contract'])){
                $holding['date_end_contract'] = $this->_timeformat($holding['date_end_contract']);
            }
        }

        return $holdings;
    }

    public function addHoldings(array $holdings) {

        $db = $this->mysqlConnect();

        // сделать серверную валидацию ПОСТа!!!

        $result = array();

        // проверка на пустоту
        $error = false;
        foreach ($holdings as $key => $val) {
            if ($val == '') {
                $result['error'][$key] = 'Пустое значение';
                $error = true;
            }
        }

        if ($error) {
            return $result;
        }

        if ($holdings['rule'] != 'on') {
            $result['error']['rule'] = 'Добавление невозможно без согласия с правилами';
            return $result;
        }

        if ((int) $holdings['sum'] == 0) {
            $result['error']['sum'] = 'Введите число!';
            return $result;
        }


        if($holdings['plan'] ==0){
            $result['error']['plan'] = 'Выберите план';
            return $result;
        }


        try {
            $keys = '';
            $values = '';
            $q = $db->prepare("DESCRIBE holdings");
            $q->execute();
            $table_fields = $q->fetchAll(PDO::FETCH_COLUMN);

            $holdings['created_at'] = date('Y-m-d G:i:s', \strtotime('now'));
            $holdings['date_end_contract'] = date('Y-m-d G:i:s', \strtotime('+'.$holdings['plan'].' month'));

            foreach ($table_fields as $value) {
                if ($value === end($table_fields)) {
                    $keys .= '`' . $value . '`';
                } else {
                    $keys .= '`' . $value . '`,';
                }

                if (!empty($holdings[$value])) {
                    if ($value === end($table_fields)) {
                        $values .= '\'' . $holdings[$value] . '\'';
                    } else {
                        $values .= '\'' . $holdings[$value] . '\',';
                    }
                } else {
                    if ($value === end($table_fields)) {
                        $values .= 'null';
                    } else {
                        $values .= 'null,';
                    }
                }
            }

            $sql = "INSERT INTO `holdings` (" . $keys . ") VALUES (" . $values . ")";
            $query = $db->prepare($sql);
            $query->execute();
            return true;
        } catch (Exception $exc) {
            print $exc->__toString();
            return false;
        }
    }

    private function _timeformat($pubdate) {
        $time = strtotime("{$pubdate}");
        $labelTime = date('d.m.Y', $time);
        $arrM = array(
            '01' => 'января', '02' => 'февраля', '03' => 'марта', '04' => 'апреля',
            '05' => 'мая', '06' => 'июня', '07' => 'июля', '08' => 'августа',
            '09' => 'сентября', '10' => 'октября', '11' => 'ноября', '12' => 'декабря');
        if ($labelTime == date('d.m.Y')) {
            return 'Сегодня, ' . date('H:i', $time);
        } elseif ($labelTime == ( date('d') - 1 ) . '.' . date('m.Y')) {
            return 'Вчера, ' . date('H:i', $time);
        } elseif (date('Y', $time) == date('Y')) {
            return date('d', $time) . ' ' . $arrM[date('m', $time)] . ', ' . date('H:i', $time);
        } else {
            return date('d', $time) . ' ' . $arrM[date('m', $time)] . ' ' . date('Y', $time) . ', ' . date('H:i', $time);
        }
    }

}
