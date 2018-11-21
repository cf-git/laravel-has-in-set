<?php
/**
 * Created by Sergei Shubin.
 * Package: Pest_z - wordpress theme
 * Date: 10/26/2018
 * Time: 9:13 AM
 */

namespace CFGit\LaravelHasInSet\Relations;


use Illuminate\Database\Eloquent\Relations\HasOneOrMany;

abstract class HasOneOrManyInSet extends HasOneOrMany
{
    /**
     * Set the base constraints on the relation query.
     *
     * @return void
     */
    public function addConstraints()
    {
        if (static::$constraints) {
            $this->query->whereRaw("FIND_IN_SET({$this->foreignKey}, '{$this->getParentKey()}')");

            $this->query->whereNotNull($this->foreignKey);
        }
    }
    /**
     * Set the constraints for an eager load of the relation.
     *
     * @param  array  $models
     * @return void
     */
    public function addEagerConstraints(array $models)
    {
        $this->query->whereRaw("FIND_IN_SET({$this->foreignKey}, '{$this->getKeys($models, $this->localKey)[0]}')");
    }
}
