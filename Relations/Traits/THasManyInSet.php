<?php
/**
 * Created by Sergei Shubin.
 * Package: CFGit - LaravelRelations:HasInSet
 * Date: 10/26/2018
 * Time: 9:11 AM
 */

namespace CFGit\LaravelHasInSet\Relations\Traits;

use CFGit\LaravelHasInSet\Relations\HasManyInSet;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait hasManyInSet
 * @package App\Models\Traits
 */
trait THasManyInSet
{

    /**
     * Create a new model instance for a related model.
     *
     * @param  string  $class
     * @return mixed
     */
    abstract protected function newRelatedInstance($class);

    /**
     * Get the default foreign key name for the model.
     *
     * @return string
     */
    abstract public function getForeignKey();

    /**
     * Get the primary key for the model.
     *
     * @return string
     */
    abstract public function getKeyName();

    /**
     * Get a new query builder for the model's table.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    abstract public function newQuery();

    /**
     * Define a one-to-many relationship.
     *
     * @param  string  $related
     * @param  string  $foreignKey
     * @param  string  $localKey
     * @return HasManyInSet
     */
    public function hasManyInSet($related, $foreignKey = null, $localKey = null)
    {
        $instance = $this->newRelatedInstance($related);

        $foreignKey = $foreignKey ?: $this->getForeignKey();

        $localKey = $localKey ?: $this->getKeyName();

        return $this->newHasManyInSet(
            $instance->newQuery(), $this, $instance->getTable().'.'.$foreignKey, $localKey
        );
    }
    /**
     * Instantiate a new HasMany relationship.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Database\Eloquent\Model  $parent
     * @param  string  $foreignKey
     * @param  string  $localKey
     * @return HasManyInSet
     */
    protected function newHasManyInSet(Builder $query, Model $parent, $foreignKey, $localKey)
    {
        return new HasManyInSet($query, $parent, $foreignKey, $localKey);
    }
}
