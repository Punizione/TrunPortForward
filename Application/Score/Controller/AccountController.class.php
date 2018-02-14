<?php
// +----------------------------------------------------------------------
// | Changjunese Scrore v2.0
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2017 https://www.northme.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Victor.Chen <victor.chen@northme.com>
// +----------------------------------------------------------------------
// | Create at: 2017/10/20 23:27
// +----------------------------------------------------------------------
namespace Score\Controller;
class AccountController extends BaseController
{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
    }

    public function _empty(){
        exit('未创建方法');
    }

    public function verification()
    {
        $this->assign('SideBar_Selected','account_verification');
        $this->meta_title = '身份认证';
        $this->display();
    }
}