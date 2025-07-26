<?php
namespace App\Http\Controllers;

use App\Services\CatalogService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\StoreProductRequest;
 class CatalogController extends Controller
{
    protected $catalogService;
    public function __construct(CatalogService $catalogService){
        $this->catalogService =  $catalogService;
    }


    public function index(){
        return view('catalog.index');
    }


    public function fetch(){
       $products = $this->catalogService->getAll();
       $totalValue = $this->catalogService->calculateTotalValue($products);
         return response()->json([
        'products' => $products,
        'total_value' => $totalValue
    ]);
    }

    public function store(StoreProductRequest $request)
    {
         $this->catalogService->store($request->only('product_name', 'quantity', 'price'));
         return response()->json(['success' => true]);
    }

    public function update(StoreProductRequest $request)
    {
         $updated = $this->catalogService->update($request->only('id', 'product_name', 'quantity', 'price'));
        return response()->json(['success' => $updated]);
    }
}
 