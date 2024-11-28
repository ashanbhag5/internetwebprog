# Test connection
install.packages("DBI")       # For database connections
install.packages("dplyr")     # Data manipulation
install.packages("dbplyr")    # For converting data frames to SQL
install.packages("RMariaDB") 

library(DBI)
library(RSQLite)
library(dplyr)
library(readr)
library(dbplyr)

library(RMariaDB)

install.packages("nflreadr")
library(nflreadr)

# Connect to the database
conn <- dbConnect(
  MariaDB(),
  dbname = "nfl_data",      # Replace with your database name
  host = "127.0.0.1",       # Default XAMPP host
  user = "root",            # Default XAMPP user
  password = ""             # Default password (leave empty for XAMPP default)
)

# # Check the connection by listing tables

dbListTables(conn)
test_data <- dbGetQuery(conn, "SELECT * FROM player_stats;")

print(test_data)
# pbp_data <- load_pbp(seasons = 2018:2023)
#years <- 2018:2023
#nfl_data <- load_pbp(seasons = years)
#column_names <- colnames(nfl_data)
#write.table(column_names, "nfl_columns.txt", row.names = FALSE, col.names = FALSE, quote = FALSE)



#player_data <- load_player_stats(seasons = (most_recent_season() - 5):most_recent_season())



print(num_rows)
column_names <- colnames(player_stats)
write.table(column_names, "nfl_columns.txt", row.names = FALSE, col.names = FALSE, quote = FALSE)



get_nfl_player_data <- function() {
  # Load the player stats data from nflreadr
  player_stats <- nflreadr::load_player_stats()  # Adjust this to the actual function for player stats
  
  # Check the column names to ensure 'last_updated' is valid or not present
  print(colnames(player_stats))  # Optional: print column names for debugging
  
  # Filter for seasons 2018 to 2024 and select only the relevant columns
  player_data_selected <- player_stats %>%
    filter(season >= 2018 & season <= 2024) %>%
    select(
      player_id,
      player_name,
      player_display_name,
      position,
      season,
      week,
      opponent_team,
      completions,
      attempts,
      passing_yards,
      passing_tds,
      interceptions,
      rushing_yards,
      rushing_tds,
      carries,
      receptions,
      receiving_yards,
      receiving_tds,
      fantasy_points,
      fantasy_points_ppr
    )
  
  # Return the selected data
  return(player_data_selected)
}

# Example usage
player_data <- get_nfl_player_data()

# Print the player data
#print(player_data)

column_info <- dbGetQuery(conn, "DESCRIBE player_stats")

# Extract the column names
column_names <- column_info$Field

# Print the column names
print(column_names)


library(dplyr)

# Filter the desired columns from player_data

filtered_player_data <- player_data %>%
  select(
    player_id, 
    player_name, 
    player_display_name,
    position, 
    season, 
    week, 
    opponent_team, 
    completions, 
    attempts, 
    passing_yards, 
    passing_tds, 
    interceptions, 
    rushing_yards, 
    rushing_tds, 
    carries, 
    receptions, 
    receiving_yards, 
    receiving_tds, 
    fantasy_points, 
    fantasy_points_ppr,
  )

  dbWriteTable(
  conn,
  name = "player_stats",
  value = filtered_player_data,
  append = TRUE, # Append data to the existing table
  row.names = FALSE
)

# View the resulting data frame
head(filtered_player_data)
# Retrieve existing player IDs from the databasedbDisconnect(conn)
