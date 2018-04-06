<?php

namespace Modules\Product\Traits;

use Modules\Media\Image\Imagy;
use Nwidart\Modules\Facades\Module;

trait FeaturedImageTrait
{

    public static $zone = 'featured_image';

    public function images()
    {
        return $this->filesByZone(static::$zone);
    }

    /**
     * Returns thumnail url
     */
    public function getFeaturedImageAttribute()
    {
        if ($image = $this->images->first()) {
            return $image->path;
        }

        return Module::asset('product:images/placeholder.jpg');
    }

    /**
     * Returns thumnail url
     */
    public function getSmallThumbAttribute()
    {
        if ($image = $this->images->first()) {
            return app(Imagy::class)->getThumbnail($image->path, 'smallThumb');
        }

        return Module::asset('product:images/placeholder_smallThumb.jpg');
    }

    /**
     * Returns thumnail url
     */
    public function getMediumThumbAttribute()
    {
        if ($image = $this->images->first()) {
            return app(Imagy::class)->getThumbnail($image->path, 'mediumThumb');
        }

        return Module::asset('product:images/placeholder_mediumThumb.jpg');
    }

    /**
     * Returns thumnail url
     */
    public function getLargeThumbAttribute()
    {
        if ($image = $this->images->first()) {
            return app(Imagy::class)->getThumbnail($image->path, 'largeThumb');
        }

        return Module::asset('product:images/placeholder_largeThumb.jpg');
    }

}
