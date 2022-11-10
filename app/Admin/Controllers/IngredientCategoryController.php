<?php

namespace App\Admin\Controllers;

use App\Models\IngredientCategory;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class IngredientCategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = "Catégorie d'ingrédient";

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new IngredientCategory());

        $grid->filter(function($filter){

            // Remove the default id filter
            $filter->disableIdFilter();
        
            // Add a column filter
            $filter->like('name', 'Nom');
        
        });


        $grid->column('id', __('Id'));
        $grid->column('category_name', __('Nom de catégorie'));
        $grid->column('category_image',  __('Image de catégorie'))->image('', 50,50);
        $grid->column('created_at', __('Crée le'))->date('d-m-Y');
        $grid->column('updated_at', __('Modifié le'))->date('d-m-Y');

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
        $show = new Show(IngredientCategory::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('category_name', __('Nom de catégorie'));
        $show->field('category_image',__('Image de catégorie'))->image('', 50,50);
        $show->field('created_at', __('Crée le'))->date('d-m-Y');
        $show->field('updated_at', __('Modifié le'))->date('d-m-Y');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new IngredientCategory());

        $form->text('category_name', __('Nom de catégorie'));
        $form->text('category_image', __('Image de catégorie'));

        return $form;
    }
}
