<?php

namespace App\Controllers;

class TestEmail extends BaseController
{
    public function index()
    {
        $email = \Config\Services::email();

        $email->setTo('cristianomessiiiuu@gmail.com'); // Ganti dengan email penerima
        $email->setSubject('Tes Email PustakaHub');
        $email->setMessage('<h3>Halo!</h3><p>Email berhasil dikirim dari PustakaHub.</p>');

        if ($email->send()) {
            echo "Email berhasil dikirim.";
        } else {
            echo "<pre>";
            print_r($email->printDebugger(['headers']));
            echo "</pre>";
        }
    }
}