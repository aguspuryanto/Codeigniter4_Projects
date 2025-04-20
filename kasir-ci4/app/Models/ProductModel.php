<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['barcode', 'name', 'category', 'price', 'stock', 'image'];
    protected $useTimestamps = true;

    public function getProductByBarcode($barcode)
    {
        return $this->where('barcode', $barcode)->first();
    }

    public function search($keyword)
    {
        return $this->like('name', $keyword)
            ->orLike('barcode', $keyword)
            ->orLike('category', $keyword)
            ->findAll();
    }
}
