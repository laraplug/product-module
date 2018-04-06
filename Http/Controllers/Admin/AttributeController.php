<?php

namespace Modules\Product\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Product\Entities\Attribute;
use Modules\Product\Http\Requests\CreateAttributeRequest;
use Modules\Product\Http\Requests\UpdateAttributeRequest;
use Modules\Product\Repositories\AttributeRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class AttributeController extends AdminBaseController
{
    /**
     * @var AttributeRepository
     */
    private $attribute;

    public function __construct(AttributeRepository $attribute)
    {
        parent::__construct();

        $this->attribute = $attribute;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$attributes = $this->attribute->all();

        return view('product::admin.attributes.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('product::admin.attributes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateAttributeRequest $request
     * @return Response
     */
    public function store(CreateAttributeRequest $request)
    {
        $this->attribute->create($request->all());

        return redirect()->route('admin.product.attribute.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('product::attributes.title.attributes')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Attribute $attribute
     * @return Response
     */
    public function edit(Attribute $attribute)
    {
        return view('product::admin.attributes.edit', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Attribute $attribute
     * @param  UpdateAttributeRequest $request
     * @return Response
     */
    public function update(Attribute $attribute, UpdateAttributeRequest $request)
    {
        $this->attribute->update($attribute, $request->all());

        return redirect()->route('admin.product.attribute.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('product::attributes.title.attributes')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Attribute $attribute
     * @return Response
     */
    public function destroy(Attribute $attribute)
    {
        $this->attribute->destroy($attribute);

        return redirect()->route('admin.product.attribute.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('product::attributes.title.attributes')]));
    }
}
