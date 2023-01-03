<?php 

// namespace App\Models\Repositories;

// use Illuminate\Database\Eloquent\Model;
// use InvalidArgumentException;

// abstract class BaseRepository
// {
//     protected $model;

//     public function __construct(Model $model)
//     {
//         $this->model = $model;
//     }

//     public function getAll() {
//         return $this->model->all();
//     }

//     public function getById($id) {
//         return $this->model->find($id);
//     }

//     public function getByIds($ids)
//     {
//         if ($ids == null) {
//             return array();
//         }
//         if (is_array($ids)) {
//             return $this->model->whereIn('id', $ids)->get();
//         }

//         throw new \InvalidArgumentException("Argument must be an array of indexes to get");
//     }

//     /**
//      * @return Model
//      */
//     public function newInstance() {
//         return $this->model->newInstance();
//     }

//     public function create($data) {
//         if (is_array($data)) {
//             return $this->model->create($data);
//         }

//         if (get_class($data) == get_class($this->model)) {
//             return $data->save();
//         }

//         throw new InvalidArgumentException("L'argument de create doit être de type array ou de type ".get_class($this->model));
//     }

//     public function update($data, $id = 0, $attribute="id") {
//         if ($data instanceof Model) {
//             return $data->save();
//         }
//         if (is_array($data)) {
//             return $this->model->where($attribute, '=', $id)->update($data);
//         }

//         throw new \InvalidArgumentException("Arguments must be a model or an array with an ID");
//     }

//     public function delete($ids) {
//         return $this->model->destroy($ids);
//     }

//     public function getCount() {
//         return $this->model->count();
//     }

// }