<?php

namespace Modules\Product\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Product\Entities\AttributeOption;
use Modules\Product\Http\Requests\CreateAttributeOptionRequest;
use Modules\Product\Http\Requests\UpdateAttributeOptionRequest;
use Modules\Product\Repositories\AttributeOptionRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class AttributeOptionController extends AdminBaseController
{
    /**
     * @var AttributeOptionRepository
     */
    private $attributeoption;

    public function __construct(AttributeOptionRepository $attributeoption)
    {
        parent::__construct();

        $this->attributeoption = $attributeoption;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$attributeoptions = $this->attributeoption->all();

        return view('product::admin.attributeoptions.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('product::admin.attributeoptions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateAttributeOptionRequest $request
     * @return Response
     */
    public function store(CreateAttributeOptionRequest $request)
    {
        $this->attributeoption->create($request->all());

        return redirect()->route('admin.product.attributeoption.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('product::attributeoptions.title.attributeoptions')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  AttributeOption $attributeoption
     * @return Response
     */
    public function edit(AttributeOption $attributeoption)
    {
        return view('product::admin.attributeoptions.edit', compact('attributeoption'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AttributeOption $attributeoption
     * @param  UpdateAttributeOptionRequest $request
     * @return Response
     */
    public function update(AttributeOption $attributeoption, UpdateAttributeOptionRequest $request)
    {
        $this->attributeoption->update($attributeoption, $request->all());

        return redirect()->route('admin.product.attributeoption.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('product::attributeoptions.title.attributeoptions')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AttributeOption $attributeoption
     * @return Response
     */
    public function destroy(AttributeOption $attributeoption)
    {
        $this->attributeoption->destroy($attributeoption);

        return redirect()->route('admin.product.attributeoption.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('product::attributeoptions.title.attributeoptions')]));
    }
}
