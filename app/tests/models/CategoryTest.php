<?php

use Illuminate\Database\Query\Builder;

class CategoryTest extends TestCase {

    public function setUp(){
        parent::setUp();
        $this->category = Category::find(1);
    }

    public function testName()
    {
        $this->assertEquals( $this->category->name, 'Humanitarian aid' );
    }

    public function testNameIsAString()
    {
        $this->assertInternalType( 'string', $this->category->name);
    }

    public function testCategoryWithThatNameIsUnique()
    {
        $categories = Category::where('name', '=', 'Humanitarian aid')->get();
        $this->assertEquals( count($categories), 1);
    }

}
