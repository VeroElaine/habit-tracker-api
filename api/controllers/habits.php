
<?php
include_once __DIR__ . '/../models/habits.php';
header('Content-Type: application/json');

if ($_REQUEST['action'] === 'INDEX') {
    echo json_encode(Habits::all());
}
elseif ($_REQUEST['action'] === 'POST') {
  $request_body = file_get_contents('php://input');
  $body_object = json_decode($request_body);
  $new_habit = new Habit(
                  null,
                  $body_object->habit,
                  $body_object->description,
                  $body_object->daysOfWeek,
                  $body_object->timing,
                  boolval($body_object->completed),
                  $body_object->comments
                );
  $all_habits = Habits::create($new_habit);
  echo json_encode($all_habits);
}
else if ($_REQUEST['action'] === 'UPDATE'){
  $request_body = file_get_contents('php://input');
  $body_object = json_decode($request_body);
  $updated_habit = new Habit($_REQUEST['id'],
                              $body_object->habit,
                              $body_object->description,
                              $body_object->daysOfWeek,
                              $body_object->timing,
                              $body_object->completed,
                              $body_object->comments
                            );
  $all_habits = Habits::update($updated_habit);
  echo json_encode($all_habits);
  }

  else if ($_REQUEST['action'] === 'DELETE') {
    $all_habits = Habits::delete($_REQUEST['id']);
    echo json_encode($all_habits);
  }
 ?>
