<?php

namespace Ollieread\Articulate\Repositories;

use Illuminate\Database\DatabaseManager;
use Ollieread\Articulate\Database\Builder;
use Ollieread\Articulate\Entities;
use Ollieread\Articulate\Mapper;

class EntityRepository
{
    /**
     * @var string
     */
    private $_entity;

    /**
     * @var \Illuminate\Database\DatabaseManager
     */
    private $_database;

    /**
     * @var \Ollieread\Articulate\Entities
     */
    private $_manager;

    /**
     * @var \Ollieread\Articulate\Mapper
     */
    private $_mapper;

    public function __construct(DatabaseManager $database, Entities $manager, Mapper $mapper)
    {
        $this->_database = $database;
        $this->_manager  = $manager;
        $this->_mapper   = $mapper;
        $this->_entity   = $mapper->getEntity();
    }

    protected function query(): Builder
    {
        $connection = $this->_mapper->getConnection();
        $table      = $this->_mapper->getTable();
        $builder    = new Builder($this->_database->connection($connection),
            $this->_database->getQueryGrammar(),
            $this->_database->getPostProcessor(),
            $this->_manager,
            $this->_mapper);

        return $builder->from($table);
    }
}