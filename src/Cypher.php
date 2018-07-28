<?php

namespace Ahsan\Cypher;

use Illuminate\Database\Eloquent\Collection;

class Cypher
{
	use Concerns\Connection,
		Concerns\Create,
		Concerns\Relation;

	/**
	 * The Neo4j Current Node Label
	 */
	protected $table;

	/**
	 * The Neo4j Current Node Label
	 */
	protected $model;

	/**
	 * The Neo4j query string
	 */
	protected $statement;

	/**
	 * The Neo4j query parameters
	 */
	protected $bindings;

	/**
	 * The Graphaware ResultSet
	 */
	protected $result;

	/**
	 * The Graphaware ResultSet
	 */
	protected $attributes = [];

	/**
	 * neo4j query
	 */
	public function query($statement, $bindings = [])
	{
		$this->statement = $statement;
		$this->bindings = $bindings;

		$this->setModel();

		return $this;
	}

	/**
	 * neo4j query
	 */
	public function runQuery()
	{
		return $this->client->run($this->statement, $this->bindings);
	}

	/**
	 * neo4j query
	 */
	public function setModel()
	{
        if (! isset($this->model)) {
        	$model = 'App\\' . class_basename($this);
			$this->model = new $model();
        }
	}

	/**
	 * neo4j query
	 */
	public function table($model)
	{
		$model = 'App\\' . $model;
		$this->model = new $model();

		return $this;
	}

	public function first()
	{
		$result = $this->runQuery();

		$attributes = $result->getRecord()->values()[0]->values();
		$attributes['id'] = $result->getRecord()->values()[0]->identity();

		return $this->model->newFromBuilder($attributes);
	}

	public function get()
	{
		$models = [];

		$result = $this->runQuery();

		if (!$result->getRecords())
			return Collection::make($models);

		foreach ($result->getRecords() as $record) {
			$attributes = $record->values()[0]->values();
			$attributes['id'] = $record->values()[0]->identity();

			$models[] = $this->model->newFromBuilder($attributes);
		}

		return Collection::make($models);
	}
}
