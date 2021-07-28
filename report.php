<?php

/**
 * Use this file to output reports required for the SQL Query Design test.
 * An example is provided below. You can use the `asTable` method to pass your query result to,
 * to output it as a styled HTML table.
 */

require_once('vendor/autoload.php');
require_once('include/utils.php');

/*
 * Example Query
 * -------------
 * Retrieve all team codes & names
 */
echo '<h1>Example Query</h1>';
$teamSql = "SELECT * FROM team";
$teamResult = query($teamSql);
// dd($teamResult);
echo asTable($teamResult);

/*
 * Report 1
 * --------
 * Produce a query that reports on the best 3pt shooters in the database that are older than 30 years old. Only
 * retrieve data for players who have shot 3-pointers at greater accuracy than 35%.
 *
 * Retrieve
 *  - Player name
 *  - Full team name
 *  - Age
 *  - Player number
 *  - Position
 *  - 3-pointers made %
 *  - Number of 3-pointers made
 *
 * Rank the data by the players with the best % accuracy first.
 */
echo '<h1>Report 1 - Best 3pt Shooters</h1>';
$sql = "SELECT
                roster.name as 'Player Name',
                team.name as 'Full Team Name',
                TIMESTAMPDIFF(YEAR, dob, CURDATE()) as 'Age',
                roster.number as 'Player Number',
                roster.pos as 'Position',
                concat((player_totals.3pt / player_totals.3pt_attempted) * 100,'%') as '3-Pointer Average',
                player_totals.3pt_attempted as 'Number of 3-Pointers made'
            from roster
            inner join team
                on roster.team_code = team.code
            inner join player_totals
                on roster.id = player_totals.player_id
            order by ((player_totals.3pt / player_totals.3pt_attempted) * 100) desc";
$report1 = query($sql);
echo asTable($report1);

/*
 * Report 2
 * --------
 * Produce a query that reports on the best 3pt shooting teams. Retrieve all teams in the database and list:
 *  - Team name
 *  - 3-pointer accuracy (as 2 decimal place percentage - e.g. 33.53%) for the team as a whole,
 *  - Total 3-pointers made by the team
 *  - # of contributing players - players that scored at least 1 x 3-pointer
 *  - of attempting player - players that attempted at least 1 x 3-point shot
 *  - total # of 3-point attempts made by players who failed to make a single 3-point shot.
 *
 * You should be able to retrieve all data in a single query, without subqueries.
 * Put the most accurate 3pt teams first.
 */
echo '<h1>Report 2 - Best 3pt Shooting Teams</h1>';
$sql = "SELECT
            team.name as 'Team Name',
            concat(ROUND( (sum(ptc.3pt) / sum(pta.3pt_attempted)) * 100, 2), '%') as '3-Pointer Average',
            sum(ptc.3pt) as 'Total of 3 Pointer Made',
            count(rc.id) as '3 Pointer Contributors',
            count(ra.id) as '3 Pointer Attempts',
            sum(pta.3pt_attempted) as '3 Pointer Failed Attempts'
        FROM team t
        INNER JOIN roster rc
            ON t.code = contributors.team_code
        INNER JOIN player_totals ptc
            ON rc.id = ptc.player_id and (sum(ptc.3pt) > 0)
        INNER JOIN roster ra
            ON t.code = contributors.team_code
        INNER JOIN player_totals pta
            ON ra.id = pta.player_id and (sum(pta.3pt) = 0)
        GROUP BY t.code";
$report2 = query($sql);
echo asTable($report2);
?>