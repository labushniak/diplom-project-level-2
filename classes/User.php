<?php

class User {
    private $db = null, $data, $isLoggedIn, $session_name, $cookieName, $users_table;


    public function __construct($user = null)
    {
        $this->db = Database::getInstance();
        $this->session_name = Config::get('session.user_session');
        $this->cookieName = Config::get('cookie.cookie_name');
        $this->users_table = Config::get('mysql.users_table');
        if(!$user){
            if(Session::exists($this->session_name)){
                $user = Session::get($this->session_name); //id
                
                if($this->find($user)){
                    $this->isLoggedIn = true;
                }
            }
        }else{
            $this->find($user);
        }
    }

    public function create($fields = [])
    {
        $this->db->insert($this->users_table, $fields);
    }

    public function login($email = null, $password = null, $remember = false)
    {
        if(!$email && !$password && $this->exists()){
            Session::put($this->session_name, $this->data()->id);
        }else{
            $user = $this->find($email);
            if($user){
                if(password_verify($password, $this->data()->password)){
                    Session::put(Config::get('session.user_session'), $this->data()->id);
                    
                    if($remember) {
                        $hash = hash('sha256', uniqid());
                        
                        $hashCheck = $this->db->get('user_sessions', ['user_id', '=', $this->data()->id]);
                        
                        if(!$hashCheck->count()){
                            $this->db->insert('user_sessions', [
                                'user_id' => $this->data()->id,
                                'hash' => $hash
                            ]);
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }
                        
                        Cookie::put($this->cookieName, $hash, Config::get('cookie.cookie_expiry'));
                    }

                    return true;
                }
            }
        }

        return false;
        
    }

    public function find($value = null)
    {
        
        if(is_numeric($value)){
            $this->data = $this->db->get($this->users_table, ['id', '=', $value])->first();
        }else{
            $this->data = $this->db->get($this->users_table, ['email', '=', $value])->first();
        }

        if($this->data){
            return true;
        }

        return false;
    }

    public function data()
    {
        return $this->data;
    }

    public function isLoggedIn()
    {
        return $this->isLoggedIn;
    }

    public function logout()
    {
        $this->db->delete('user_sessions', ['user_id', '=', $this->data()->id]);
        Session::delete($this->session_name);
        Cookie::delete($this->cookieName);
    }

    public function exists()
    {
        return (!empty($this->data())) ? true : false;
    }

    public function update ($fields =[], $id = null)
    {
        if(!$id){
            $id = $this->data()->id;
        }

        $this->db->update($this->users_table, $id, $fields);

    }

    public function hasPermissions($key = null)
    {
        $group = $this->db->get('groups', ['id', '=', $this->data()->group_id]);
        
        if($group->count()){
            $permissions = $group->first()->permissions;
            $permissions = json_decode($permissions, true);
            
            if($permissions[$key]){
                return true;
            }
        }

        return false;

    }

    public function list($number = PHP_INT_MAX)
    {
        $list = $this->db->get($this->users_table, ['id', '>', 0]);
        $list->results = array_reverse($list->results);
        $ids = array_column($list->results, 'id');
        $usernames = array_column($list->results, 'username');
        $emails = array_column($list->results, 'email');
        $dates = array_column($list->results, 'date');
        $group_ids = array_column($list->results, 'group_id');
        $users_list = [];
        $i = 0;
        foreach($ids as $key => $id){
            if ($i < $number){
                    $date = new DateTime($dates[$key]);
                    $users_list[$i] = [$ids[$key], $usernames[$key], $emails[$key], $date->format('d/m/Y'), $group_ids[$key]];  
                }
            $i++;
            }

        return array_reverse($users_list);
            
    }

    public function date()
    {
        $date = new DateTime ($this->date);
        $this->date = $date->format('d/m/Y');
        return $this->date;
    }

    public function delete($id = null)
    {
        if (!$id) {
            $id = $this->data()->id;
        } 

        $this->db->delete ($this->users_table, ['id', '=',  $id]);
    }
    
}
