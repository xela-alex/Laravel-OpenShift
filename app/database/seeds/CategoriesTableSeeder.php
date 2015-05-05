<?php

class CategoriesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('category')->delete();

        $categories = array(
            array( // 1
                'name'         => 'Humanitarian aid',
            ),
            array( // 2
                'name'         => 'Addictions',
            ),
            array( // 3
                'name'         => 'Sport',
            ),
            array( // 4
                'name'         => 'Childrens',
            ),
        );

        DB::table('category')->insert( $categories );

        DB::table('project_category')->delete();


        $category_base = (int)DB::table('category')->first()->id - 1;
        $pro_base = (int)DB::table('project')->first()->id - 1;


        $pro_category = array(
            array(
                'project_id'       => $pro_base + 1,
                'category_id'      => $category_base +1,
            ),
            array(
                'project_id'       => $pro_base + 2,
                'category_id'      => $category_base +2,
            ),

        );

        DB::table('project_category')->insert( $pro_category );
    }

}