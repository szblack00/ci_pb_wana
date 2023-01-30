<?php

namespace App\Controllers;

use Config\Database;
use Hermawan\DataTables\DataTable;
use App\Controllers\BaseController;

class Users extends BaseController
{
    public function index()
    {
        return view('users/data');
    }
    function listData()
    {
        if ($this->request->isAJAX()) {
            $db = Database::connect();
            $builder = $db->table('users')->select('userid, username,levelnama, useraktif')->join('levels', 'levelid = userlevelid');

            return DataTable::of($builder)
                ->addNumbering('nomor')
                ->add('status', function ($row) {
                    return '';
                })

                ->add('aksi', function ($row) {
                    return '';
                })
                ->toJson(true);
        }
    }
}