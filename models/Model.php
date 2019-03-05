<?php

namespace App\Models;

use App\Components\DB;

abstract class Model {
	protected static $connection = null;
	protected static $table = null;
	protected static $relations = [];
	protected $attributes = [];
	protected static $params = [];
	protected static $orParams = [];
	protected static $orders = [];

	public static function setConnection() {
		static::$connection = DB::getConnection();
	}

	public function __get($property)
	{
		return (isset($this->attributes[$property])) ? $this->attributes[$property] : null;
	}

	public function __set($key, $value)
	{
		$this->attributes[$key] = $value;
	}

	public static function find($id)
	{
		static::setConnection();
		$result = static::$connection->query("SELECT * FROM " . static::$table . " WHERE id = " . $id);
		$row = $result->fetch();
		if (!$row)
			return null;
		$activeRecord = new static;
		foreach ($row as $key => $value) {
				$activeRecord->$key = $value;
		}
		$activeRecord->loadRelations();
		return $activeRecord;

	}

	public static function getAll()
	{
		static::setConnection();
		$where = static::createWhereCondition();
		$order = static::createOrder();
		// echo $order . '<br>';
		// echo "SELECT * FROM " . static::$table . $where . $order;
		// echo '<br>';
		$result = static::$connection->query("SELECT * FROM " . static::$table . $where . $order);
		$collection = array();
		while($row = $result->fetch()) {
			$activeRecord = new static;
			foreach ($row as $key => $value) {
				$activeRecord->$key = $value;
			}
			$activeRecord->loadRelations();
			$collection[] = $activeRecord;
		}
		static::$params = [];
		static::$orParams = [];
		static::$orders = [];
		return $collection;
	}

	public static function with(string $relation)
	{
		static::$relations[] = $relation; 
		return static::class;
	}

	public static function getTable()
	{
		return static::$table;
	}

	protected function loadRelations()
	{
		if (!empty(static::$relations)) {
				foreach (static::$relations as $rel) {
					if (!isset($this->$rel)) {
						$this->$rel = $this->$rel();
					}
				}
			}
	}

	public function save()
	{
		static::setConnection();
		$fields = "(";
		$values = "(";
		if (empty($this->attributes))
			throw new \Exception("Error: Model - " . static::class . " does not any attribute");
		foreach ($this->attributes as $field => $value) {
			$fields .= $field  . ",";
			$values .= ":" . $field . ",";
		}
		$fields = substr($fields, 0, -1);
		$values = substr($values, 0, -1);
		$fields .= ")";
		$values .= ")";
		$sql = "INSERT INTO " . static::$table . $fields . " VALUES " . $values;
		$stmt  = static::$connection->prepare($sql);
		$result = $stmt->execute($this->attributes);
		if ($result) {
			$this->id = static::$connection->lastInsertId();
			return true;
		} else {
			return false;
		}
	}

	public function delete()
	{
		static::setConnection();
		$sql = "DELETE FROM " . static::$table . " WHERE id = :id";
		$stmt = static::$connection->prepare($sql);
		return $stmt->execute(['id' => $this->id]); 
	}

	public static function where(array $params)
	{
		static::$params = $params;
		return static::class;
	}

	public static function orWhere(array $params)
	{
		static::$orParams = $params;
		return static::class;
	}

	public static function orderBy(array $params) {
		static::$orders = $params;
		return static::class;
	}

	protected static function createWhereCondition()
	{
		$params = static::$params;
		$where = "";
		if (!empty($params)) {
			$where = " WHERE ";
			foreach ($params as $param => $value) {
				$separator = ($value['operator'] != "IN") ? "\"" : "";
				$where .= "`" . $param . "` " . $value['operator'] . " " .  $separator . $value['value'] . $separator . ' AND ';
			}
			$where = substr($where, 0, -5);
		}
		$orParams = static::$orParams;
		$or = "";
		if (!empty($orParams)) {
			$or = " OR ";
			foreach ($orParams as $param => $value) {
				$separator = ($value['operator'] != "IN") ? "\"" : "";
				$or .= "`" . $param . "` " . $value['operator'] . " " .  $separator . $value['value'] . $separator . ' AND ';
			}
			$or = substr($or, 0, -5);
		}
		$res = $where . $or;
		return $res;
	}

	protected static function createOrder()
	{
		$orders = static::$orders;
		$order = "";
		if (!empty($orders)) {
			foreach ($orders as $key => $value) {
				$order = " ORDER BY " . $key . " " . $value;
			}
		}
		return $order;
	}
}