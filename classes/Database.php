<?php
class Database
{
    private static $instance = NULL; //свойство должно быть статичным, так как присваивание происходит только 1 раз
    private $pdo, $query, $error = false;
    /*
        Parametrs:
            
        Description: конструктор класса должен быть приватным
    
        Return value: 
    */
    private function __construct()
    {
        try{

        $this->pdo = new PDO('mysql:host='.Config::get('mysql.host').';dbname=' .Config::get('mysql.database'), Config::get('mysql.username'), Config::get('mysql.password'));

        //echo "соединение создано <br>";
        } catch(PDOException $exception){
            die($exception->getMessage());
        }
        
    }

    /*
        Parametrs:
            
        Description: функция должна быть статичной и вызывать только 1 экземпляр класса
    
        Return value: PHP Object
    */
    public static function getInstance()
    {
        if(!self::$instance){
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function query($sql, $params = [])
    {
        
        $this->error = false;
        $this->query = $this->pdo->prepare($sql);
        
        //проверяем количество элементов в массиве
        if(count($params)){
            //привязываем к каждому параметру значение из массива params
            $i = 1;
            foreach($params as $param){
                $this->query->bindValue($i, $param);
                $i++;
            }
        }

        //выполняем запрос и проверяем на наличие ошибки
        if(!$this->query->execute()){
            $this->error = true;
        } else {
            $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
            $this->count = $this->query->rowCount();
        }

        return $this;
    }

    public function get($table, $where = [])
    {
        return $this->action('SELECT *', $table, $where);
    }

    public function delete($table, $where =[])
    {
        return $this->action('DELETE', $table, $where);
    }

    public function action($action, $table, $where = [])
    {
       $operators = ['>', '<', '=', '>=', '<=', '!='];

       $field = $where[0];
       $operator = $where[1];
       $value = $where[2];
       
       if(count($where) === 3){//в массиве $where должно быть строго 3 элемента
            if(in_array($operator, $operators)){ //оператор должен совпадать с перечисленными в массиве
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                
                if(!$this->query($sql, [$value])->error()){ //true, если error в методе query примет значение false (метод отработает без ошибок)
                    return $this;

                }

            }
       }
    }

    public function insert($table, $fields =[])
    {
        
        $values = '';
        foreach($fields as $field){
            $values .= "?,";
        }

        $sql = "INSERT INTO {$table} (`" .implode('`, `', array_keys($fields)). "`) VALUES (" .rtrim($values, ","). ")";
        
        if(!$this->query($sql, $fields)->error()){
            return true;
        }
        
        return false;

    }

    public function update($table, $id, $fields =[])
    {
        
        $value ='';
        foreach ($fields as $key => $field){
            $value .= "{$key} = ?,";
        }
        $value = rtrim($value, ",");

        $sql = "UPDATE {$table} SET {$value} WHERE id = {$id}";

        if(!$this->query($sql, $fields)->error()){
            return true;
        }

        return false;
    }

    public function first()
    {
        return $this->results()[0];
    }

    public function results()
    {
        return $this->results;
    }

    public function count()
    {
        return $this->count;
    }

    public function error()
    {
        return $this->error;
    }
}