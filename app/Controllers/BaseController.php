<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\KontakModel;
use App\Models\PartnerModel;
use App\Models\ArtikelModel;
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
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = ['auth'];
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    protected $session;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $this->session = service('session');
        // Preload any models, libraries, etc, here.
        $db = \Config\Database::connect();

        // Cek apakah tabel masih kosong
        $artikelCount   = $db->table('artikel')->countAll();
        $kontakCount    = $db->table('pengaturan_kontak')->countAll();
        $partnerCount   = $db->table('pengaturan_partner')->countAll();
        $timCount       = $db->table('pengaturan_tim')->countAll();

        if ($artikelCount == 0 || $kontakCount == 0 || $partnerCount == 0 || $timCount == 0) {
            $seeder = \Config\Database::seeder();
            if ($seeder instanceof \CodeIgniter\Database\Seeder) {
                $seeder->call('DatabaseSeeder');
            } else {
                log_message('error', 'Seeder service tidak tersedia atau tidak valid.');
            }
        }

        // E.g.: $this->session = service('session');
    }

    protected $kontak;
    protected $partner;

    public function __construct()
    {
        $kontakModel = new KontakModel();
        $partnerModel = new PartnerModel();

        $this->partner = $partnerModel->findAll();
        $this->kontak = $kontakModel->first(); // Mengambil data kontak pertama dari tabel
    }

    protected function renderView($view, $data = [])
    {
        $data['kontak'] = $this->kontak; // Menyediakan data kontak untuk semua view
        $data['partner'] = $this->partner; // Menambahkan data partner

        echo view('layout/header', $data);
        echo view($view, $data);
        echo view('layout/footer', $data);
    }
}
