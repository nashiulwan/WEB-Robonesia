<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\KontakModel;
use App\Models\PartnerModel;
use App\Models\TimModel;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var RequestInterface
     */
    protected $request;

    /**
     * Instance of the Session object.
     *
     * @var \CodeIgniter\Session\Session
     */
    protected $session;

    /**
     * Lazy-loaded model instances.
     */
    protected $kontakModel;
    protected $partnerModel;
    protected $timModel;

    /**
     * Global data for views.
     */
    protected $kontak;
    protected $partner;
    protected $tim;

    /**
     * Helpers to be loaded automatically.
     *
     * @var array
     */
    protected $helpers = ['auth'];

    /**
     * Constructor
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Load session service
        $this->session = session();
        
        // Database connection
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
            
            // Cek apakah DatabaseSeeder ada
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

    /**
     * Lazy Load KontakModel
     */
    protected function getKontakModel()
    {
        if ($this->kontakModel === null) {
            $this->kontakModel = new KontakModel();
        }
        return $this->kontakModel;
    }

    /**
     * Lazy Load PartnerModel
     */
    protected function getPartnerModel()
    {
        if ($this->partnerModel === null) {
            $this->partnerModel = new PartnerModel();
        }
        return $this->partnerModel;
    }

    /**
     * Lazy Load TimModel
     */
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
            'partner' => $this->partner
        ]);

        echo view('layout/header', $data)
            . view($view, $data)
            . view('layout/footer', $data);
    }
}   