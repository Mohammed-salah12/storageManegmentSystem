<?php

namespace App\repositories;

use App\Models\Product;
use Illuminate\Support\Facades\Redirect;

class ProductRepository
{
    private $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function deletedActions()
    {
        return $this->model->onlyTrashed()->get();
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
        $view = 'cms.products.' . $action;
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
    public function getProductsByUserWithPaginate($userId , $categoryId = null)
    {
        $query = Product::where('user_id', $userId);

        // If a category ID is provided, filter by that category
        if ($categoryId !== null) {
            $query->where('category_id', $categoryId);
        }

        return $query->paginate(10);

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
