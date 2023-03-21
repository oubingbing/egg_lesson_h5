<?php
/**
 * Created by PhpStorm.
 * User: bingbing
 * Date: 2020/12/27
 * Time: 16:42
 */

namespace App\Service;


use App\Repositories\AdminRep;

class AdminService extends BaseServiceAbstract
{
    private $rep;

    public function __construct(AdminRep $rep)
    {
        $this->rep = $rep;
    }

    public function findById($id)
    {
        $result = $this->rep->find($id);
        return $result;
    }

}