<?php
namespace Score\Controller;
use Score\Model\SessionsModel;
use Think\Auth;

class AuthController extends BaseController{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
    }

    public function login(){
        if (isset($_POST['loginSubmit'])) {
            $uname = $_POST['uname'];
            $passwd = $_POST['passwd'];
            $Q = M('users')->where(array("uname"=>$uname,"passwd"=>$passwd))->select();
            if (count($Q)==1) {
                session('uid',$Q[0]['uid']);
                M('users')->where(array("uid"=>$Q[0]['uid']))->data(array(
                    "ip"=>get_client_ip(),
                    "last_login_time"=>getDateTime(),
                    "last_login_ip" => get_client_ip()
                ))->save();
                (new SessionsModel())->createSession(session('uid'));
                redirect('/overview');
            }else {
                $this->error('我们无法认证您提交的凭据。',"/auth/login",3);
            }
        }
        $this->meta_title=L('Auth_LoginTo').C('site-name');
        $this->display();
    }

    public function logout(){
        session(null);
        cookie(null);
        $this->success('成功退出！正在跳转到首页...','/');
    }

    public function register(){
        $this->meta_title = L('Auth_RegisterTo').C('site-name');
        if (isset($_POST['registerSubmit'])) {
            $email = I('post.email');
            $uname = I('post.uname');
            $passwd = I('post.passwd');
            if (!preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i", $email)or
                trim($uname)=='' or
                trim($passwd) == ''
            ) {$this->error('There is something wrong with the info you just entered.','/auth/register',3);exit;}
            else {
                if (M('users')->where(array("uname"=>$uname))->select()) {$this->error('该用户已存在！','/auth/register');exit;}
                $uid = M('users')->data(array(
                    "uname" => $uname,
                    "passwd" => $passwd,
                    "email"=>$email,
                    "last_login_ip" => get_client_ip(),
                    "reg_time" => getDateTime(),
                ))->add();
                session('uid',$uid);
                (new SessionsModel())->createSession(session('uid'));
                $this->success('Registration succeed! Now restricting to the panel...','/overview',3);exit;
            }
        }
        $this->display();
    }
}