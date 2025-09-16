<?php

namespace Tests\Unit;

use App\Models\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function test_category_can_be_created(): void
    {
        $category = new Category([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'description' => 'A test category',
            'weight' => 1
        ]);

        $this->assertEquals('Test Category', $category->name);
        $this->assertEquals('test-category', $category->slug);
        $this->assertEquals(1, $category->weight);
    }
}
