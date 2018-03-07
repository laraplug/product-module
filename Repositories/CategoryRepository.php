<?php

namespace Modules\Product\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface CategoryRepository extends BaseRepository
{

    /**
     * Get all root elements
     *
     * @return object
     */
    public function getAllRoots();

    /**
     * Get elements by slug array
     *
     * @param  array $slugs
     * @return object
     */
    public function getBySlugs(array $slugs);

}
