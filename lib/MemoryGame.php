

<?php

class MemoryGame
{
    private $board;
    private $board_size;
    private $flipped_cards;
    private $previous_card;
    private $num_moves;
    private $game_won;
    private $current_player;

    public function __construct($num_pairs)
    {
        // Set up the game board
        $this->board_size = ceil(sqrt($num_pairs * 2));
        $this->board = [];
        for ($i = 0; $i < $this->board_size; $i++) {
            for ($j = 0; $j < $this->board_size; $j++) {
                $this->board[$i][$j] = null;
            }
        }

        // Place the cards on the board randomly
        $values = range(1, $num_pairs);
        $pairs = array_merge($values, $values);
        shuffle($pairs);
        for ($i = 0; $i < $this->board_size; $i++) {
            for ($j = 0; $j < $this->board_size; $j++) {
                $card = array_pop($pairs);
                $this->board[$i][$j] = new Card($card, "images/$card.jpg");
            }
        }

        // Initialize other game variables
        $this->flipped_cards = [];
        $this->previous_card = null;
        $this->num_moves = 0;
        $this->game_won = false;
    }

    public function play()
    {
        // Play the game
        while (true) {
            // Check if all cards have been flipped
            if ($this->game_won) {
                print "You won the game in $this->num_moves moves!\n";
                break;
            }

            // Print the game board
            print '<div class="board">';
            for ($i = 0; $i < $this->board_size; $i++) {
                for ($j = 0; $j < $this->board_size; $j++) {
                    $card = $this->board[$i][$j];
                    if ($card->flipped) {
                        print '<div class="card"><img src="' . $card->image . '"></div>';
                    } else {
                        print '<div class="card"></div>';
                    }
                }
                print '<br>';
            }
            print '</div>';

            // Get the position of the next card to flip
            print '<form method="post">';
            print '<input type="hidden" name="num_pairs" value="' . $_POST['num_pairs'] . '">';
            print '<label for="row">Row:</label>';
            print '<input type="number" name="row" min="0" max="' . ($this->board_size - 1) . '">';
            print '<label for="col">Column:</label>';
            print '<input type="number" name="col" min="0" max="' . ($this->board_size - 1) . '">';
            print '<input type="submit" value="Flip card">';
            print '</form>';

            // Flip the card
            if (isset($_POST['row']) && isset($_POST['col'])) {
                $row = intval($_POST['row']);
                $col = intval($_POST['col']);
                $current_card = $this->board[$row][$col];
                if (!$current_card->flipped) {
                    $current_card->flipped = true;
                    $this->flipped_cards[] = $current_card;

                    // Check if the card matches the previous one
                    if ($this->previous_card === null || $current_card->value !== $this->previous_card->value) {
                        print "Aucune correspondance.<br>";
                    } else {
                        print "Bravo !<br>";
                        $this->current_player->score++;
                    }

                    // Update the previous card and increment the number of moves
                    $this->previous_card = $current_card;
                    $this->num_moves++;
                }

                // Check if the game has been won
                $game_won = true;
                foreach ($this->board as $row) {
                    foreach ($row as $card) {
                        if (!$card->flipped) {
                            $game_won = false;
                            break;
                        }
                    }
                }
                $this->game_won = $game_won;
            }
        }
    }

    public function saveScore()
    {
        // Save the score to the leaderboard
        $leaderboard = fopen('leaderboard.txt', 'a');
        fwrite($leaderboard, "$this->current_player->name,$this->current_player->score\n");
        fclose($leaderboard);
    }
}