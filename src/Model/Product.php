<?php

namespace App\Model;

class Product
{
    public string $title;
    public string $description;
    public float $price;
    public float $discount;

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'discount' => $this->discount,
        ];
    }
}
