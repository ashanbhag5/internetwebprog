CREATE DATABASE nfl_data;
USE nfl_data;

--Creates table for player stats
CREATE TABLE IF NOT EXISTS player_stats (
  player_id VARCHAR(255),
  player_name VARCHAR(255),
  player_display_name VARCHAR(255),
  headshot_url TEXT,
  position VARCHAR(50),
  position_group VARCHAR(50),
  attempts INT,
  completions INT,
  season INT,
  week INT,
  recent_team VARCHAR(10),
  opponent_team VARCHAR(10),
  passing_yards INT,
  passing_tds INT,
  interceptions INT,
  rushing_yards INT,
  rushing_tds INT,
  carries INT,
  receiving_yards INT,
  receiving_tds INT,
  receptions INT,
  targets INT,
  fantasy_points DOUBLE,
  fantasy_points_ppr DOUBLE
);

--Rounds player stats
UPDATE player_stats
SET 
  passing_yards = ROUND(passing_yards, 2),
  passing_tds = ROUND(passing_tds, 2),
  interceptions = ROUND(interceptions, 2),
  rushing_yards = ROUND(rushing_yards, 2),
  rushing_tds = ROUND(rushing_tds, 2),
  carries = ROUND(carries, 2),
  receiving_yards = ROUND(receiving_yards, 2),
  receiving_tds = ROUND(receiving_tds, 2),
  receptions = ROUND(receptions, 2),
  targets = ROUND(targets, 2),
  fantasy_points = ROUND(fantasy_points, 2),
  fantasy_points_ppr = ROUND(fantasy_points_ppr, 2);



--Creates matchups table
CREATE TABLE matchups (
    week INT,
    date DATE,
    team_1 VARCHAR(100),
    team_2 VARCHAR(100)
);



--Populates table
INSERT INTO matchups (week, date, team_1, team_2) 
VALUES 
(13, '2024-11-30', 'Chicago', 'Detroit'),
(13, '2024-11-30', 'N.Y. Giants', 'Dallas'),
(13, '2024-11-30', 'Miami', 'Green Bay'),
(13, '2024-11-30', 'Las Vegas', 'Kansas City'),
(13, '2024-11-30', 'Pittsburgh', 'Cincinnati'),
(13, '2024-11-30', 'Houston', 'Jacksonville'),
(13, '2024-11-30', 'Arizona', 'Minnesota'),
(13, '2024-11-30', 'Indianapolis', 'New England'),
(13, '2024-11-30', 'Seattle', 'N.Y. Jets'),
(13, '2024-11-30', 'Tennessee', 'Washington'),
(13, '2024-11-30', 'Tampa Bay', 'Carolina'),
(13, '2024-11-30', 'L.A. Rams', 'New Orleans'),
(13, '2024-11-30', 'Philadelphia', 'Baltimore'),
(14, '2024-12-07', 'Green Bay', 'Detroit'),
(14, '2024-12-07', 'N.Y. Jets', 'Miami'),
(14, '2024-12-07', 'Atlanta', 'Minnesota'),
(14, '2024-12-07', 'New Orleans', 'N.Y. Giants'),
(14, '2024-12-07', 'Carolina', 'Philadelphia'),
(14, '2024-12-07', 'Cleveland', 'Pittsburgh'),
(14, '2024-12-07', 'Las Vegas', 'Tampa Bay'),
(14, '2024-12-07', 'Jacksonville', 'Tennessee'),
(14, '2024-12-07', 'Seattle', 'Arizona'),
(14, '2024-12-07', 'Buffalo', 'L.A. Rams'),
(14, '2024-12-07', 'Chicago', 'San Francisco'),
(14, '2024-12-07', 'L.A. Chargers', 'Kansas City'),
(15, '2024-12-14', 'L.A. Rams', 'San Francisco'),
(15, '2024-12-14', 'Dallas', 'Carolina'),
(15, '2024-12-14', 'Kansas City', 'Cleveland'),
(15, '2024-12-14', 'Miami', 'Houston'),
(15, '2024-12-14', 'N.Y. Jets', 'Jacksonville'),
(15, '2024-12-14', 'Washington', 'New Orleans'),
(15, '2024-12-14', 'Baltimore', 'N.Y. Giants'),
(15, '2024-12-14', 'Cincinnati', 'Tennessee'),
(15, '2024-12-14', 'New England', 'Arizona'),
(15, '2024-12-14', 'Indianapolis', 'Denver'),
(15, '2024-12-14', 'Buffalo', 'Detroit'),
(15, '2024-12-14', 'Tampa Bay', 'L.A. Chargers'),
(15, '2024-12-14', 'Pittsburgh', 'Philadelphia'),
(15, '2024-12-14', 'Green Bay', 'Seattle'),
(16, '2024-12-21', 'Cleveland', 'Cincinnati'),
(16, '2024-12-21', 'Houston', 'Kansas City'),
(16, '2024-12-21', 'Pittsburgh', 'Baltimore'),
(16, '2024-12-21', 'N.Y. Giants', 'Atlanta'),
(16, '2024-12-21', 'New England', 'Buffalo'),
(16, '2024-12-21', 'Arizona', 'Carolina'),
(16, '2024-12-21', 'Detroit', 'Chicago'),
(16, '2024-12-21', 'Tennessee', 'Indianapolis'),
(16, '2024-12-21', 'L.A. Rams', 'N.Y. Jets'),
(16, '2024-12-21', 'Philadelphia', 'Washington'),
(16, '2024-12-21', 'Denver', 'L.A. Chargers'),
(16, '2024-12-21', 'Minnesota', 'Seattle'),
(16, '2024-12-21', 'Jacksonville', 'Las Vegas'),
(16, '2024-12-21', 'San Francisco', 'Miami'),
(16, '2024-12-21', 'Tampa Bay', 'Dallas'),
(16, '2024-12-21', 'New Orleans', 'Green Bay');

--Creates saved players table
CREATE TABLE saved_players (
    player_id VARCHAR(255) PRIMARY KEY,       -- Unique identifier for each entry
    player_name VARCHAR(100) NOT NULL,       -- Name of the player
    position ENUM('QB', 'RB', 'WR', 'TE', 'K', 'DEF') NOT NULL, -- Player position
    team VARCHAR(50) NOT NULL               -- Team the player belongs to
);
