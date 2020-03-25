<?php


namespace App\Controller\admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;


class EasyadminBackController extends EasyAdminController
{

    public function Message()
    {
        dump($this->entity);
    }


}