<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelLogin;

class Login extends BaseController
{
    public function index()
    {
        return view('login/index');
    }
    public function cekUser()
    {
        $iduser = $this->request->getPost('iduser');
        $pass = $this->request->getPost('password');

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'iduser' => [
                'label' => 'ID User',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong'
                ]
            ],
        ]);

        if (!$valid) {
            $sessError = [
                'errIdUser' => $validation->getError('iduser'),
                'errPassword' => $validation->getError('password'),
            ];
            session()->setFlashdata($sessError);
            return redirect()->to(site_url('login/index'));
        } else {
            $modelLogin = new ModelLogin();

            $cekuserLogin = $modelLogin->find($iduser);
            if ($cekuserLogin == null) {
                $sessError = [
                    'errIdUser' => 'Maaf User Tidak Terdaftar',
                ];
                session()->setFlashdata($sessError);
                return redirect()->to(site_url('login/index'));
            } else {
                $passwordUser = $cekuserLogin['userpassword'];
                if (password_verify($pass, $passwordUser)) {
                    // next
                    $idlevel = $cekuserLogin['userlevelid'];
                    $simpan_session = [
                        'iduser' => $iduser,
                        'namauser' => $cekuserLogin['username'],
                        'atasan' => $cekuserLogin['atasan'],
                        'idlevel' => $idlevel
                    ];
                    session()->set($simpan_session);
                    return redirect()->to('/main/index');
                } else {
                    $sessError = [
                        'errPassword' => 'Maaf Password Anda Salah',
                    ];
                    session()->setFlashdata($sessError);
                    return redirect()->to(site_url('login/index'));
                }
            }
        }
    }
    public function keluar()
    {
        session()->destroy();
        return redirect()->to('login/index');
    }
}