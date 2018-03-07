<?php

namespace Ollieread\Articulate\Database;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Query\Grammars\Grammar;
use Illuminate\Database\Query\Processors\Processor;
use Illuminate\Support\Collection;
use Ollieread\Articulate\EntityManager;

class Builder extends QueryBuilder
{
    /**
     * @var \Ollieread\Articulate\EntityManager
     */
    protected $_manager;

    /**
     * @var string
     */
    protected $_entity;

    /**
     * @var array
     */
    protected $with = [];

    public function __construct(
        ConnectionInterface $connection,
        Grammar $grammar = null,
        Processor $processor = null,
        EntityManager $manager)
    {
        parent::__construct($connection, $grammar, $processor);

        $this->_manager = $manager;
    }

    public function for($entity)
    {
        $this->_entity = $entity;

        return $this->from($this->_manager->getMapping($entity)->getTable());
    }

    protected function results(array $columns = ['*']): array
    {
        $original = $this->columns;

        if (is_null($original)) {
            $this->columns = $columns;
        }

        $results       = $this->processor->processSelect($this, $this->runSelect());
        $this->columns = $original;

        return $results;
    }

    public function get($columns = ['*']): Collection
    {
        $results = $this->results($columns);

        return $this->hydrateAll($results);
    }

    public function first($columns = ['*'])
    {
        $results = $this->results($columns);

        return $this->hydrate(array_shift($results));
    }

    public function newEntityInstance()
    {
        $entity = $this->_entity;

        return new $entity;
    }

    private function hydrate($attributes = [])
    {
        return $this->_manager->hydrate($this->_entity, $attributes);
    }

    private function hydrateAll(array $results)
    {
        $collection = new Collection;

        foreach ($results as $row) {
            $collection->push($this->hydrate($row));
        }

        return $collection;
    }
}