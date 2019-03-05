<?php

namespace App\Models;

class Film extends Model {
	protected static $table = "films";

	public function actors()
	{
		$table = Actor::getTable();
		$result = static::$connection->query("SELECT DISTINCT " . $table . ".id, " . $table . ".name, " . $table . ".surname FROM " . $table . " INNER JOIN " . static::$table . " ON " . static::$table .".id = " . $table . ".film_id WHERE " . static::$table . ".id" . " = " . $this->attributes['id']);
		$list = [];
		while($row = $result->fetch()) {
			$activeRecord = new Actor();
			foreach ($row as $key => $value) {
				$activeRecord->$key = $value;
			}
			$list[] = $activeRecord;
		}
		return $list;
	}

	public function delete()
	{
		$res = parent::delete();
		$filmId = $this->id;
		$actors = Actor::where(['film_id' => ['operator' => '=', 'value' => $filmId]])::getAll();
		if ($actors) {
			foreach ($actors as $actor) {
				$actor->delete();
			}
		}
		return $res;
	}

	public static function findByActorsIds(array $ids) {
		$table =  static::$table;
		$strIds = "";
		foreach ($ids as $id) {
			$strIds .= $id . ", ";
		}
		$strIds = substr($strIds, 0, -2);
		$result = static::$connection->query("SELECT * FROM " . $table . " WHERE id IN (" . $strIds . ")");
		$list = [];
		while($row = $result->fetch()) {
			$activeRecord = new Film();
			foreach ($row as $key => $value) {
				$activeRecord->$key = $value;
			}
			$list[] = $activeRecord;
		}
		return $list;
	}
}