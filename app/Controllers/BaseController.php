<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\KontakModel;
use App\Models\PartnerModel;
use App\Models\TimModel;

abstract class BaseController extends Controller
{
    protected $request;
    protected $session;
    protected $kontakModel;
    protected $partnerModel;
    protected $timModel;
    protected $kontak;
    protected $partner;
    protected $tim;
    protected $helpers = ['auth'];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->session = session();
        $db = \Config\Database::connect();

        // Cek apakah tabel masih kosong
        $artikelCount   = $db->table('artikel')->countAllResults();
        $kontakCount    = $db->table('pengaturan_kontak')->countAllResults();
        $partnerCount   = $db->table('pengaturan_partner')->countAllResults();
        $timCount       = $db->table('pengaturan_tim')->countAllResults();

        // Jalankan seeder jika tabel kosong
        if ($artikelCount == 0 || $kontakCount == 0 || $partnerCount == 0 || $timCount == 0) {
            $db->transStart();
            $seeder = \Config\Database::seeder();

            if (class_exists('App\Database\Seeds\DatabaseSeeder')) {
                $seeder->call('DatabaseSeeder');
            } else {
                log_message('error', 'Seeder DatabaseSeeder tidak ditemukan.');
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                log_message('error', 'Gagal menjalankan seeder.');
            }
        }

        // Inisialisasi data global untuk views
        $this->kontak = $this->getKontakModel()->first();
        $this->partner = $this->getPartnerModel()->findAll();
        $this->tim = $this->getTimModel()->findAll();
    }

    protected function getKontakModel()
    {
        if ($this->kontakModel === null) {
            $this->kontakModel = new KontakModel();
        }
        return $this->kontakModel;
    }

    protected function getPartnerModel()
    {
        if ($this->partnerModel === null) {
            $this->partnerModel = new PartnerModel();
        }
        return $this->partnerModel;
    }

    protected function getTimModel()
    {
        if ($this->timModel === null) {
            $this->timModel = new TimModel();
        }
        return $this->timModel;
    }

    /**
     * Render View with Global Data
     */
    protected function renderView($view, $data = [])
    {
        $data = array_merge($data, [
            'tim' => $this->tim,
            'kontak' => $this->kontak,
            'partner' => $this->partner,
        ]);

        echo view('layout/header', $data)
            . view($view, $data)
            . view('layout/footer', $data);
    }

    protected function renderViewDashboardSiswa($view, $data = [])
    {
        $data = array_merge($data, [
            'kontak' => $this->kontak,
        ]);

        echo view($view, $data);
    }
}
