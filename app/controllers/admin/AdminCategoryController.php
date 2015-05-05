<?php

class AdminCategoryController extends BaseController
{
    protected $category;

    public function __construct(Category $category)
    {
        parent::__construct();
        $this->category = $category;
    }

    public function listCategories()
    {
        $categories = Category::orderBy('name', 'ASC')->get();

        $data = array(
            'categories' => $categories,
        );

        Return View::make('admin/category/list')->with($data);
    }

    public function createAndEdit()
    {
        $id = Input::get('id');

        $rules = array(
            'name'    => 'required|min:3',
        );

        $validator = Validator::make(Input::all(), $rules);

        if($validator->passes()) {
            if ($id == 0) {
                $this->category->name = Input::get('name');
                $this->category->save();

                Return Redirect::to('admin/category/list')->with('success', Lang::get('admin/category.successfullyCreated'));
            } else {
                $this->category = Category::find($id);

                if ($this->category) {
                    if (count($this->category->project)) {
                        return Redirect::to('admin/category/list')->with('error', Lang::get('admin/category.usedInProject'));
                    } else {
                        $this->category->name = Input::get('name');
                        $this->category->save();

                        Return Redirect::to('admin/category/list')->with('success', Lang::get('admin/category.successfullyEdited'));
                    }
                } else {
                    Return Redirect::to('admin/category/list')->with('error', Lang::get('admin/category.categoryDoesNotExist'));
                }
            }
        }
        else
        {
            return Redirect::to('admin/category/list')
                ->withInput(Input::all())
                ->with('error', Lang::get('admin/category.nameTooShort'));
        }

    }

    public function delete($id)
    {
        $category = Category::find($id);

        if ($category) {
            if (count($category->project)) {
                return Redirect::to('admin/category/list')->with('error', Lang::get('admin/category.usedInProject'));
            }
            else
            {
                $category->delete($category->id);
                Return Redirect::to('admin/category/list')->with('success', Lang::get('admin/category.successfullyDeleted'));
            }
        } else {
            Return Redirect::to('admin/category/list')->with('error', Lang::get('admin/category.categoryDoesNotExist'));
        }

    }

}