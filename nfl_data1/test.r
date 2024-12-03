
library(nflreadr)
library(dplyr)
library(DBI)
library(RMariaDB)

# Step 1: Load player stats for the desired seasons
seasons <- 2020:2024
player_stats <- do.call(rbind, lapply(seasons, load_player_stats))

# Step 2: Filter for relevant columns
filtered_stats <- player_stats %>%
  select(
    player_id, player_name, player_display_name, headshot_url, 
    position, position_group, attempts, completions,
    season, week, recent_team, opponent_team,
    passing_yards, passing_tds, interceptions,
    rushing_yards, rushing_tds, carries,
    receiving_yards, receiving_tds, receptions, targets,
    fantasy_points, fantasy_points_ppr
  ) %>%
  filter(!is.na(player_id))  # Exclude rows with missing player_id

# Step 3: Connect to MySQL Database
con <- dbConnect(
  MariaDB(),
  user = "root",           
  password = "",           
  dbname = "nfl_data", 
  host = "localhost"       
)

dbWriteTable(
  con,
  name = "player_stats",
  value = filtered_stats,
  append = TRUE, 
  row.names = FALSE
)

# Step 6: Disconnect from the database
dbDisconnect(con)