Viergewinnt Documentation
=========================

This document tries to give an overview of this project, the document structure and the workings of the code.

What is this project?
---------------------

This project's aim was to implement a multiplayer online game of Captain's Mistress using only php, plain javascript (with jQuery) and a MySQL database. The exact requirements (in German) can be found in `doc/requirements.doc`.


How is it structured?
---------------------

Obviously, the documentation can be found in `doc`. 

Files in `lib` do not need to be accessed from the outside (instead they are included in other php scripts). `lib/template` contains `base.php`, the currently only template in this project.

Files in `public` are available to external access. `public/api` contains php scripts that are polled. `public/scripts` contains .js files, most notably `jquery.js` and `bootstrap.js`. `public/styles` contains .css files. The remaining files in `public` form the core of the application.


So, what do those files do?
---------------------------

Let's try a structured approach here, by directory.

### lib

* `auth.php` checks if someone is logged in at the moment, and if not, redirects to `index.php`.

* `connectDB` contains the database credentials, and opens a connection.

* `exitRemaining` ends all running games the current player is involved in, assuming he lost them.

* `template/base.php` is the template for all the other sites. It accepts a $HEAD and $BODY variable which are inserted into the html.

### public/api

* `pollEnemy` returns the second player in the current player's game as a json.

* `pollGameList` returns all running games as text/html, formatted as `<li>$gamename ($playername)</li>`.

* `pollGame` returns the game board, the status and whose turn it is as json.


### public/scripts

* `game.js` manages polling, draws the game board and does generally nice things.

### public

Self-explanatory files such as * `login.php`, `logout.php`  and `register.php` will be omitted.

* `game.php` displays the game board (and uses `game.js`). 

* `giveup.php` ends the game, setting the current player as loser, and redirects to `index.php`.

* `index.php` links to the login and registration page if the user is not already logged in. Once he is logged in, it displays a list of running games and a link for starting a new game. If a user is logged on and a game he is involved in is still running, he is directly redirected to `game.php`.

* `join.php` receives the game the player wants to join as parameter and redirects to `game.php` as long as the second player position has not already been filled, otherwise it redirects to `index.php`.

* `login.php` is the login page. On success, it redirects to `index.php`.

* `logout.php` logs the user out, ending all his games, and redirects do `index.php`.

* `register.php` is the registration page. All user input is sanitized with `mysql_real_escape_string()`.

* `startgame.php` lets the user choose a game name and a color combination. It redirects to `game.php`.

* `turn.php` receives the column a player has clicked as parameter. It then checks if this move is valid, and, if so, updates the game board, checks if the game has been ended by this moves and returns a json like `api/pollGame`.
