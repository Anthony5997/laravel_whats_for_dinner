<?php

namespace App\Admin\Controllers;

use App\Models\Ingredient;
use App\Models\IngredientCategory;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class IngredientController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Ingrédients';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Ingredient());


        $grid->filter(function($filter){

            // Remove the default id filter
            $filter->disableIdFilter();
        
            // Add a column filter
            $filter->like('name', 'Nom');
            $filter->in('ingredient.category_name', "Catégorie")->multipleSelect(IngredientCategory::orderBy('category_name', 'asc')->pluck('category_name','category_name'));
        
        });
     

        $grid->column('id', __('Id'));
        $grid->column('name', __('Nom'));
        $grid->column('image',  __('Image'))->image('', 50,50);
        $grid->column('ingredient.category_name', "Catégorie");
        $grid->column('ingredient_category_id', __('ID de Catégorie'));
        $grid->column('created_at', __('Crée le'))->date('d-m-Y');
        // $grid->column('updated_at', __('Mis à jour le'))->date('d-m-Y');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Ingredient::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Nom'));
        $show->field('image',  __('Image'))->image('', 50,50);
        $show->field('ingredient_category_id', __('ID de Catégorie'));
        $show->field('created_at', __('Crée le'))->date('d-m-Y');
        $show->field('updated_at', __('Mis à jour le'))->date('d-m-Y');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Ingredient());

        $form->text('name', __('Nom'));
        // $form->image('image', __('Image'));

        $form->image('image', __('Image'))->name(function($file) {
            $type = explode('.', $file->getClientOriginalName());
            $file_path = public_path("images/ingredients/".request('name') . $type[0].'' . time().'.'.$type[1]);
            copy($file, $file_path);
        return "ingredients/".request('name') . $type[0].'' . time().'.'.$type[1];
      })->required();

        $form->select('ingredient_category_id')->options(IngredientCategory::orderBy('category_name', 'asc')->pluck('category_name','id'));

        return $form;
    }
}
