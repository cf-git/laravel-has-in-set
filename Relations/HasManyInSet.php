<?php
/**
 * Created by Sergei Shubin.
 * Package: CFGit - LaravelRelations:HasInSet
 * Date: 10/26/2018
 * Time: 9:26 AM
 */

namespace CFGit\LaravelHasInSet\Relations;

use \Illuminate\Database\Eloquent\Collection;

class HasManyInSet extends HasOneOrManyInSet
{
    /**
     * Get the results of the relationship.
     *
     * @return mixed
     */
    public function getResults()
    {
        return $this->query->get();
    }

    /**
     * Initialize the relation on a set of models.
     *
     * @param  array   $models
     * @param  string  $relation
     * @return array
     */
    public function initRelation(array $models, $relation)
    {
        foreach ($models as $model) {
            $model->setRelation($relation, $this->related->newCollection());
        }

        return $models;
    }

    /**
     * Match the eagerly loaded results to their parents.
     *
     * @param  array   $models
     * @param  \Illuminate\Database\Eloquent\Collection  $results
     * @param  string  $relation
     * @return array
     */
    public function match(array $models, Collection $results, $relation)
    {
        $dictionary = $this->buildDictionary($results);

        // Once we have the dictionary we can simply spin through the parent models to
        // link them up with their children using the keyed dictionary to make the
        // matching very convenient and easy work. Then we'll just return them.
        foreach ($models as $model) {
            $localKeys = explode(',', $model->getAttribute($this->localKey));
            $collection = [];
            foreach ($dictionary as $key => $value) {
                if (in_array($key, $localKeys)) {
                    $collection[] = reset($value);
                }
            }
            $model->setRelation(
                $relation, $this->related->newCollection($collection)
            );
        }

        return $models;
    }
}
