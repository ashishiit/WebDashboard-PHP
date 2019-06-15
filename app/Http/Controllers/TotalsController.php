<?php declare(strict_types=1);

namespace App\Http\Controllers;
use DB;
class TotalsController extends Controller
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
     *
        $players = DB::table('player')->get();
        echo "total players = ", count($players);     
     */
    
    function calculateTimestamp($time)
    {        
        $hours = floor($time / 3600);
        $minutes = floor(($time / 60) % 60);
        $seconds = $time % 60;

        return "$hours:$minutes:$seconds";
    }
    
    $gameSession = DB::table('gameplay_session');
    $totalPlayers = DB::table('player')->count();
    $totalGames = DB::table('game')->count();
    $totalSchools = DB::table('school')->count();

    // Calculate total number of hours spent per game and aggregate
    // From game session beginTime to endTime
    $games = $gameSession->get();
    $time_seconds = 0;
    foreach ($games as $game) 
    {
        $startTime = $game->begin_timestamp;
        $endTime = $game->end_timestamp;
        $diff = $endTime - $startTime;
        $time_seconds += $diff;
    }

    $timestamp = calculateTimestamp($time_seconds);
    $totals = [
        'missions_total' => (int)$gameSession->sum('missions_complete'),
        'schools_total' => $totalSchools,
        'games_total' => $totalGames,
        'players_total' => $totalPlayers,
        'hours_total' => round($time_seconds/(60*60)),
        'time_stamp' => $timestamp
    ];
      return json_encode($totals);
      /*
     * Using PDO:
     *    $pdo = new \PDO('sqlite:..\\database\\perf_task.db');
     *    $stmt = $pdo->query('select * from game');
     *    $games = $stmt->fetchAll(\PDO::FETCH_ASSOC);
     */
     
  }
}