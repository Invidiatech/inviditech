<?php
namespace App\Services;
use Illuminate\Support\Facades\Storage;
class CatalogService
{
protected $file='product.json';
public function getAll(): array
{
  if(!Storage::exists($this->file)){
    return [];
}

$products =json_decode(Storage::get($this->file), true);
        usort($products, fn($a, $b) => strtotime($b['submitted_at']) <=> strtotime($a['submitted_at']));
        return $products;
}

public function store(array $data): void 
{
  $products =  $this->getAll();
   $newProduct = [
    'id' => uniqid(),
    'product_name' => $data['product_name'],
    'quantity' => $data['quantity'],
    'price' => $data['price'],
    'submitted_at' => now()->toDateTimeString(),
];
   $products[] = $newProduct;
     Storage::put($this->file, json_encode($products,JSON_PRETTY_PRINT));
}
 
public function update(array $data): bool
{
    $products=$this->getAll();
    $updated = false;
    foreach($products as &$product){
        if($product['id']===$data['id']){
            $product['product_name'] = $data['product_name'];
            $product['quantity']= $data['quantity'];
            $product['price']= $data['price'];
            $updated=true;
            break;
        }
    }
    if($updated){
         Storage::put($this->file, json_encode($products, JSON_PRETTY_PRINT));
    }
    return $updated;
} 
public function calculateTotalValue(array $products): float
    {
        return collect($products)->sum(function ($product) {
            return $product['quantity'] * $product['price'];
        });
    }
}