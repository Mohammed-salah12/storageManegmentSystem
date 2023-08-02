<?php

namespace App\repositories;

use App\Models\Category;
use Illuminate\Support\Facades\Redirect;

class CategoryRepository
{
    private $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function deletedActions()
    {
        return $this->model->with('category')->onlyTrashed()->get();
    }

    public function restore($id)
    {
        $record = $this->model->withTrashed()->findOrFail($id);
        $record->restore();
    }

    public function forceDelete($id)
    {
        $record = $this->model->withTrashed()->findOrFail($id);
        $record->forceDelete();
    }

    function generateResponse($action, $data = [])
    {
        $view = 'cms.categories.' . $action;
        return response()->view($view, $data);
    }
    public function getPage()
    {
        return $this->model->get();
    }
    function generateSweetAlertResponse($status)
    {
        $response = [];

        if ($status === 'success') {
            $response['icon'] = 'success';
            $response['title'] = 'Worked successfully';
            $responseCode = 200;
        } else {
            $response['icon'] = 'error';
            $response['title'] = 'Something went wrong ';
            $responseCode = 400;
        }

        return response()->json($response, $responseCode);
    }
    public function getCategoriesByUserWithPaginate($userId)
    {
        return $this->model->where('user_id', $userId)->latest()->paginate(5);
    }
    public function redirectToRoute($routeName, $routeParams = [])
    {
        return Redirect::route($routeName, $routeParams);
    }

    public function findId($id)
    {
        return $this->model->findOrFail($id);
    }
    public function delete($id)
    {
        return $this->model->destroy($id);

    }

}
