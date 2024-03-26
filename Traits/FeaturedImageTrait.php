<?php

namespace Modules\Product\Traits;

use Modules\Media\Image\Imagy;
use Nwidart\Modules\Facades\Module;

trait FeaturedImageTrait
{

    /**
     * @inheritDoc
     */
    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        if(!$this->appends) $this->appends = [];
        if(!$this->hidden) $this->hidden = [];

        $this->appends[] = 'image_path';
        $this->appends[] = 'small_thumb';
        $this->appends[] = 'medium_thumb';
        $this->appends[] = 'large_thumb';

        $this->hidden[] = 'images';
        $this->hidden[] = 'gallery';
    }
    public function gallery(){
        return $this->filesByZone('gallary');
    }
    public static function zone()
    {
        return isset(static::$zone) ? static::$zone : 'featured_image';
    }

    public function images()
    {
        return $this->filesByZone(static::zone());
    }

    /**
     * Returns thumnail url
     */
    public function getImagePathAttribute()
    {
        if ($image = $this->images->first()) {
            return $image->path_string;
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
