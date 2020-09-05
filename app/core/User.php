<?
class User extends ActiveRecord\Model {
    static $table = 'users';
    protected $user;

    public function auth($login,$pass) {
        $user = self::find('all',array('conditions' => array('login=? and pass=?',$login,md5($pass))));
        
        if(!empty($user) && $user[0]->id > 0) {
            $this->user = $user[0];
            $sessionArr['id'] = $this->user->id;
            $sessionArr['role'] = $this->user->role;
            
            $_SESSION['USER'] = $sessionArr;
            return true;
        } else
            return false;
    }

    public function isAdmin(){
        if(!empty($this->user) && $this->user->role == 'admin')
            return true;
        else    
            return false;
    }
}