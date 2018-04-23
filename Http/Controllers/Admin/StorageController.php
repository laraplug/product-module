<?php

namespace Modules\Product\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Product\Entities\Storage;
use Modules\Product\Http\Requests\CreateStorageRequest;
use Modules\Product\Http\Requests\UpdateStorageRequest;
use Modules\Product\Repositories\StorageRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class StorageController extends AdminBaseController
{
    /**
     * @var StorageRepository
     */
    private $storage;

    public function __construct(StorageRepository $storage)
    {
        parent::__construct();

        $this->storage = $storage;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $storages = $this->storage->all();

        return view('product::admin.storages.index', compact('storages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('product::admin.storages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateStorageRequest $request
     * @return Response
     */
    public function store(CreateStorageRequest $request)
    {
        $this->storage->create($request->all());

        return redirect()->route('admin.product.storage.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('product::storages.title.storages')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Storage $storage
     * @return Response
     */
    public function edit(Storage $storage)
    {
        return view('product::admin.storages.edit', compact('storage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Storage $storage
     * @param  UpdateStorageRequest $request
     * @return Response
     */
    public function update(Storage $storage, UpdateStorageRequest $request)
    {
        $this->storage->update($storage, $request->all());

        return redirect()->route('admin.product.storage.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('product::storages.title.storages')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Storage $storage
     * @return Response
     */
    public function destroy(Storage $storage)
    {
        $this->storage->destroy($storage);

        return redirect()->route('admin.product.storage.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('product::storages.title.storages')]));
    }
}
