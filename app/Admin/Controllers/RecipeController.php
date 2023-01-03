<?php

namespace App\Admin\Controllers;

use App\Models\Recipe;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class RecipeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Recettes';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Recipe());

        // $grid->column('id', __('Id'));
        $grid->column('title', __('Titre'));
        // $grid->column('summary', __('Résumé'));
        $grid->column('image', __('Image'))->image('', 50,50);;
        $grid->column('ready_in_minutes', __('Temps de réalisation'));
        $grid->column('servings', __('Nombre de personnes'));
        $grid->column('preparation_minutes', __('Préparation'));
        $grid->column('cooking_minutes', __('Cuisson'));
        $grid->column('vegetarian', __('Végétarien'));
        $grid->column('vegan', __('Vegan'));
        $grid->column('gluten_free', __('Sans Gluten'));
        $grid->column('dairy_free', __('Sans Produit Laitier'));
        $grid->column('created_at', __('Créé le'))->date('d-m-Y');
        // $grid->column('updated_at', __('MAJ le'))->date('d-m-Y');
        // $grid->column('user_id', __('User id'));
        $grid->column('global_rating', __('Note Globale'));
        $grid->column('is_new', __('Nouveautée'));

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
        $show = new Show(Recipe::findOrFail($id));

        // $show->field('id', __('Id'));
        $show->field('title', __('Titre'));
        // $show->field('summary', __('Résumé'));
        $show->field('image', __('Image'))->image('', 50,50);
        $show->field('ready_in_minutes', __('Temps de réalisation'));
        $show->field('servings', __('Nombre de personnes'));
        $show->field('preparation_minutes', __('Préparation'));
        $show->field('cooking_minutes', __('Cuisson'));
        $show->field('vegetarian', __('Végétarien'));
        $show->field('vegan', __('Vegan'));
        $show->field('gluten_free', __('Sans Gluten'));
        $show->field('dairy_free', __('Sans Produit Laitier'));
        $show->field('created_at', __('Créé le'))->date('d-m-Y');
        // $show->field('updated_at', __('MAJ le'))->date('d-m-Y');
        // $show->field('user_id', __('User id'));
        $show->field('global_rating', __('Note Globale'));
        $show->field('is_new', __('Nouveautée'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Recipe());

        $form->text('title', __('Title'));
        $form->text('summary', __('Résumé'));
        $form->image('image', __('Image'))->image('image', __('Image'))->name(function($file) {
            $type = explode('.', $file->getClientOriginalName());
            $file_path = public_path("images/recipe/".request('name') . $type[0].'' . time().'.'.$type[1]);
            copy($file, $file_path);
        return "recipe/".request('name') . $type[0].'' . time().'.'.$type[1];
      })->required();;
        $form->number('ready_in_minutes', __('Temps de réalisation'));
        $form->number('servings', __('Nombre de personnes'));
        $form->number('preparation_minutes', __('Préparation'));
        $form->number('cooking_minutes', __('Cuisson'));
        $form->switch('vegetarian', __('Végétarien'));
        $form->switch('vegan', __('Vegan'));
        $form->switch('gluten_free', __('Sans Gluten'));
        $form->switch('dairy_free', __('Sans Produit Laitier'));
        // $form->text('user_id', __('User id'));
        $form->decimal('global_rating', __('Note Globale'));
        $form->switch('is_new', __('Nouveautée'));

        return $form;
    }
}
