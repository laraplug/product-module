<?php

namespace Modules\Product\Blade;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Product\Contracts\ProductInterface;

use Modules\Product\Repositories\ProductManager;

final class AttributesDirective
{

    /**
     * @var ProductInterface
     */
    private $entity;
    /**
     * @var ProductManager
     */
    private $productManager;

    public function __construct(ProductManager $productManager)
    {
        $this->productManager = $productManager;
    }

    public function show($arguments)
    {
        $this->extractArguments($arguments);

        return $this->renderForm($this->entity);
    }

    /**
     * Extract the possible arguments as class properties
     * @param array $arguments
     */
    private function extractArguments(array $arguments)
    {
        $this->entity = array_get($arguments, 0);
    }

    private function renderForm(ProductInterface $product)
    {
        $form = '';
        $translatableForm = '';

        $normalAttributes = $product->attributes->where('is_translatable', false);
        $translatableAttributes = $product->attributes->where('is_translatable', true);

        foreach ($normalAttributes as $attribute) {
            $form .= $attribute->getFormField($entity);
        }

        foreach ($translatableAttributes as $attribute) {
            foreach(LaravelLocalization::getSupportedLanguagesKeys() as $i => $locale) {
                $active = locale() == $locale ? 'active' : '';
                $translatableForm .= "<div class='tab-pane $active' id='tab_attributes_$i'>";
                $translatableForm .= $attribute->getTranslatableFormField($entity, $locale);
                $translatableForm .= '</div>';
            }
        }

        return view('attribute::admin.blade.form', compact('entity', 'form', 'translatableForm'));
    }
}
