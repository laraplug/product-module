<?php

namespace Modules\Product\Repositories;

use Modules\Product\Entities\Attribute;

/**
 * 속성관리자
 * Attribute Manager
 */
interface AttributeManager
{

    /**
     * Returns all the registered entity
     * @return array
     */
    public function all();

    /**
     * Registers an entity namespace.
     * @param Attribute $entity
     * @return void
     */
    public function registerEntity(Attribute $entity);

    /**
     * 네임스페이스로 검색
     * Search by Namespace
     *
     * @param  string $namespace
     * @return mixed
     */
    public function findByNamespace(string $namespace);

    /**
     * 첫번째 엔티티를 리턴
     * Return first entity
     *
     * @return mixed
     */
    public function first();

}
