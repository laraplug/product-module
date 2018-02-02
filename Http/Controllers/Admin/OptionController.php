<?php

namespace Modules\Product\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Product\Entities\Option;
use Modules\Product\Http\Requests\CreateOptionRequest;
use Modules\Product\Http\Requests\UpdateOptionRequest;
use Modules\Product\Repositories\OptionRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class OptionController extends AdminBaseController
{
    /**
     * @var OptionRepository
     */
    private $option;

    public function __construct(OptionRepository $option)
    {
        parent::__construct();

        $this->option = $option;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$options = $this->option->all();

        return view('product::admin.options.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('product::admin.options.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateOptionRequest $request
     * @return Response
     */
    public function store(CreateOptionRequest $request)
    {
        $this->option->create($request->all());

        return redirect()->route('admin.product.option.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('product::options.title.options')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Option $option
     * @return Response
     */
    public function edit(Option $option)
    {
        return view('product::admin.options.edit', compact('option'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Option $option
     * @param  UpdateOptionRequest $request
     * @return Response
     */
    public function update(Option $option, UpdateOptionRequest $request)
    {
        $this->option->update($option, $request->all());

        return redirect()->route('admin.product.option.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('product::options.title.options')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Option $option
     * @return Response
     */
    public function destroy(Option $option)
    {
        $this->option->destroy($option);

        return redirect()->route('admin.product.option.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('product::options.title.options')]));
    }
}
