<?php

namespace App\Core\Http\Controllers\Site;

use App\Core\Models\AttributeGroup;
use App\Core\Models\Product;
use Illuminate\Http\Request;

/**
 * Class IndexsController
 * @package App\Http\Controllers
 */
class IndexController extends BaseController
{
    public $viewPathBase = 'site.home.';
    public $errorRedirectPath = 'site::';


    /**
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function home(Request $request)
    {
        $product = new Product();
        $attr = new AttributeGroup();
        dd($attr->meta);
        return $this->view('index');
    }
}
