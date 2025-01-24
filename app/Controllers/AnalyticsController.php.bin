namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ArticleModel;

class AnalyticsController extends BaseController
{
    public function index()
    {
        return view('admin/analytics');
    }

    public function getChartData()
    {
        $articleModel = new ArticleModel();

        // Data untuk jumlah artikel per kategori
        $categories = $articleModel->select('category, COUNT(id) as total')
            ->groupBy('category')
            ->findAll();

        // Data total view per artikel
        $views = $articleModel->select('title, views')->findAll();

        // Kirimkan data dalam format JSON
        return $this->response->setJSON([
            'categories' => $categories,
            'views' => $views
        ]);
    }
}
