<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Http\Requests\Url\StoreRequest;
use App\Repositories\UrlsRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\URL;

class UrlsRepository implements UrlsRepositoryInterface
{
    public function __construct(private Url $model)
    {
       //
    }

    public function getUrlsWithCategory(int $category_id, int $countPerPage): Paginator
    {
        return $this->model
            ->where('category_id', $category_id)
            ->with(['category'])
            ->paginate($countPerPage);
    }

    public function saveUrl(StoreRequest $request): bool
    {
        $this->model->category_id = $request->input('category_id');
        $this->model->path = $request->input('url_path');

        try{
            $this->model->save();
        } catch (\Exception $ex){
            return false;
        }

        return true;
    }

    public function updateUrl(StoreRequest $request, int $id): bool
    {
        // TODO: Implement updateUrl() method.
    }

    public function deleteUrl(int $id): bool
    {
        if (! $this->model->find($id)->delete()) {
            return false;
        }

        return true;
    }
}
