<?php
$dbconn = pg_connect("host=localhost dbname=habit_app");

class Habit {
  public $id;
  public $title;
  public $description;
  public $daysOfWeek;
  public $timing;
  public $completed;
  public $comments;

  public function __construct($id, $title, $description, $daysOfWeek,$timing,$completed,$comments){
    $this->id = $id;
    $this->title = $title;
    $this->description = $description;
    $this->daysOfWeek = $daysOfWeek;
    $this->timing = $timing;
    $this->completed = $completed;
    $this->comments = $comments;

  }
}

class Habits {
  static function all(){
    $habits = array();

    $results = pg_query("SELECT * FROM habits");

    $row_object = pg_fetch_object($results);
    while($row_object){
      $new_habit = new Habit(
        intval($row_object->id),
        $row_object->title,
        $row_object->description,
        $row_object->daysofweek,
        $row_object->timing ,
        boolval($row_object->completed) ,
        $row_object->comments
      );
      $habits[] = $new_habit;
      $row_object = pg_fetch_object($results);
    }
    return $habits;
  }

  static function create($habit){
    $query = "INSERT INTO habits (title, description, daysOfWeek,timing,completed,comments) VALUES ($1, $2, $3,$4,$5,$6)";
    $query_params = array(
    $habit->title,
    $habit->description ,
    $habit->daysOfWeek,
    $habit->timing,
    $habit->completed ,
    $habit->comments
  );
    pg_query_params($query, $query_params);
    return self::all();
  }

  static function update($updated_habit){
    echo "inside update";
      $query = "UPDATE habits SET title = $1, description = $2, daysOfWeek = $3, timing=$4, completed=$5, comments=$6 WHERE id = $7";
      $query_params = array(
        $updated_habit->title,
        $updated_habit->description ,
        $updated_habit->daysOfWeek,
        $updated_habit->timing,
        $updated_habit->completed ,
        $updated_habit->comments,
        $updated_habit->id
      );
      $result = pg_query_params($query, $query_params);
      return self::all();
    }

    static function delete($id){
      $query = "DELETE FROM habits WHERE id = $1";
      $query_params = array($id);
      $result = pg_query_params($query, $query_params);

      return self::all();
    }
}

 ?>
