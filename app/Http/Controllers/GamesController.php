<?php declare(strict_types=1);

namespace App\Http\Controllers;
use DB;
class GamesController extends Controller
{
  public function send()
  {
    /*
     * You can find a diagram and other information about the database in the file database/diagram.pdf.
     *
     * You may use Lumen's built-in query builder (https://lumen.laravel.com/docs/5.8/database)
     * or PHP's PDO library (https://www.php.net/manual/en/book.pdo.php) to query the database.
     *
     * You can see an example of each below.
     *
     * Using Lumen:
     */
    $games = DB::table('game')->get();
    
    $gameDetails = [];

    foreach ($games as $game) {
      $hours = 0;
      $players = [];

      $gameSessions = DB::table('gameplay_session')->where('game_id', $game->id);
      $missionsCompleted = (int)$gameSessions->sum('missions_complete');

      foreach ($gameSessions->get() as $session) {
        // Add unique player ids
        if (!in_array($session->player_id, $players))
          $players[] = $session->player_id;


        $startTime = $session->begin_timestamp;
        $endTime = $session->end_timestamp;

        $diff = $endTime - $startTime;
        $hours += $diff / (60 * 60);
      }

      $gameDetails[] = [
        'game_id' => (int)$game->id,
        'name' => $game->name,
        'topic' => $game->topic,
        'total_players' => count($players),
        'hours_played' => round($hours),        
        'mission_completed' => $missionsCompleted
      ];
    }
    return json_encode($gameDetails);
     /*
     * Using PDO:
     *    $pdo = new \PDO('sqlite:..\\database\\perf_task.db');
     *    $stmt = $pdo->query('select * from game');
     *    $games = $stmt->fetchAll(\PDO::FETCH_ASSOC);
     */
  }
}