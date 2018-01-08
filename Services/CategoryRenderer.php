<?php

namespace Modules\Product\Services;

class CategoryRenderer
{
    /**
     * @var string
     */
    private $startTag = '<div class="dd">';
    /**
     * @var string
     */
    private $endTag = '</div>';
    /**
     * @var string
     */
    private $category = '';

    /**
     * @param $categoryItems
     * @return string
     */
    public function render($categoryItems)
    {
        $this->category .= $this->startTag;
        $this->generateHtmlFor($categoryItems);
        $this->category .= $this->endTag;

        return $this->category;
    }

    /**
     * Generate the html for the given items
     * @param $items
     */
    private function generateHtmlFor($items)
    {
        $this->category .= '<ol class="dd-list">';
        foreach ($items as $item) {
            $this->category .= "<li class=\"dd-item\" data-id=\"{$item->id}\">";
            $editLink = route('admin.product.category.edit', [$item->id]);
            $this->category .= <<<HTML
<div class="btn-group" role="group" aria-label="Action buttons" style="display: inline">
    <a class="btn btn-sm btn-info" style="float:left;" href="{$editLink}">
        <i class="fa fa-pencil"></i>
    </a>
    <a class="btn btn-sm btn-danger jsDeleteCategoryItem" style="float:left; margin-right: 15px;" data-item-id="{$item->id}">
       <i class="fa fa-times"></i>
    </a>
</div>
HTML;
            $this->category .= "<div class=\"dd-handle\">{$item->name}</div>";

            if ($this->hasChildren($item)) {
                $this->generateHtmlFor($item->items);
            }

            $this->category .= '</li>';
        }
        $this->category .= '</ol>';
    }

    /**
     * @param $item
     * @return bool
     */
    private function hasChildren($item)
    {
        return count($item->items);
    }
}
