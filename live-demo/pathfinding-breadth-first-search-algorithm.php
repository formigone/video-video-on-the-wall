<!doctype html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Pathfinding Algorithm - Breadth First Search - Demo</title>
   <link href='/favicon.ico' rel='icon' type='image/x-icon'/>
<body>
<style>
   html, body {
      width: 100%;
      height: 100%;
      margin: 0;
      padding: 0;
   }

   canvas {
      margin: 0;
      padding: 0;
      display: block;
   }

   #notice {
      display: block;
      position: absolute;
      bottom: 0;
      height: 45px;
      width: 100%;
      background: #74cfae;
      border-top: 5px solid #4F8371;
      padding: 0;
      margin: 0;
      color: #000;
      font-family: monospace;
   }

   #notice p {
      margin: 10px;
   }
</style>
<script>
/**
 *
 * @constructor
 */
var Cell = function() {
   this.init = false;
   this.walls = 0x1111;
};

Cell.walls = {
   UP: 0x1000,
   DOWN: 0x0100,
   LEFT: 0x0010,
   RIGHT: 0x0001
};

Cell.dummy = new Cell();
Cell.dummy.init = true;

/**
 *
 * @param {number} x
 * @param {number} y
 * @param {number} width
 * @param {number} height
 * @param {string} color
 * @constructor
 */
var Player = function(x, y, width, height, color) {
   this.x = x;
   this.y = y;
   this.width = width;
   this.height = height;
   this.color = color;
};

/**
 *
 * @param {number} width
 * @param {number} height
 * @constructor
 */
var Board = function(width, height) {
   this.width = width;
   this.height = height;
   this.cells = [];

   this.init();
};

Board.prototype.init = function() {
   for (var i = 0, len = this.width * this.height; i < len; i++) {
      this.cells.push(new Cell());
   }
};

/**
 *
 * @param {number} x
 * @param {number} y
 * @return Cell
 */
Board.prototype.getCell = function(x, y) {
   var i = y * this.width + x;

   return this.cells[i];
};

Board.prototype.seed = function() {
   var start = parseInt(Math.random() * this.cells.length, 10);
   var end = -1;
   var min = this.cells.length * 0.25;

   do {
      end = parseInt(Math.random() * this.cells.length, 10);
   } while (Math.abs(start - end) < min);

   return {
      start: this.getPos(start),
      end: this.getPos(end)
   };
};

/**
 *
 * @param {number} x
 * @param {number} y
 * @param {number} wall
 */
Board.prototype.setWall = function(x, y, wall) {
   var i = y * this.width + x;
   this.cells[i].walls = wall;
};

/**
 *
 * @param {number} x
 * @param {number} y
 * @param {number} wall
 */
Board.prototype.clearWall = function(x, y, wall) {
   var i = y * this.width + x;
   this.cells[i].walls ^= wall;
};

Board.prototype.generate = function() {
   var stack = [];
   var self = this;
   var keys = ['up', 'down', 'left', 'right'];

   function shuffle(arr) {
      for (var j, x, i = arr.length; i; j = Math.floor(Math.random() * i), x = arr[--i], arr[i] = arr[j], arr[j] = x);
      return arr;
   };

   var carveTo = function(x, y) {
      var cell = self.getCell(x, y);

      if (cell.init) {
         stack.pop();
         var next = stack.pop();
         self.getCell(next.x, next.y).init = false;

         if (stack.length > 0) {
            carveTo(next.x, next.y);
         }

         return true;
      }

      cell.init = true;
      stack.push({x: x, y: y});

      var neig = self.getNeighbors(x, y);
      keys = shuffle(keys);
      var check = 0;
      var rand = 0;

      while (check++ < keys.length) {
         rand = keys[check - 1];

         switch (rand) {
            case 'up':
               if (!neig.up.init) {
                  self.clearWall(x, y, Cell.walls.UP);
                  self.clearWall(x, y - 1, Cell.walls.DOWN);
                  y--;
                  check = keys.length;
               }
               break;

            case 'down':
               if (!neig.down.init) {
                  self.clearWall(x, y, Cell.walls.DOWN);
                  self.clearWall(x, y + 1, Cell.walls.UP);
                  y++;
                  check = keys.length;
               }
               break;
            case 'left':
               if (!neig.left.init) {
                  self.clearWall(x, y, Cell.walls.LEFT);
                  self.clearWall(x - 1, y, Cell.walls.RIGHT);
                  x--;
                  check = keys.length;
               }
               break;
            case 'right':
               if (!neig.right.init) {
                  self.clearWall(x, y, Cell.walls.RIGHT);
                  self.clearWall(x + 1, y, Cell.walls.LEFT);
                  x++;
                  check = keys.length;
               }
               break;
         }
      }

      carveTo(x, y);
   };

   return carveTo(0, 0);
};

/**
 *
 * @param {number} i
 * @return {Object.<number, number>}
 */
Board.prototype.getPos = function(i) {
   return {
      x: i % this.width,
      y: parseInt(i / this.height, 10)
   };
};

/**
 *
 * @param {number} x
 * @param {number} y
 * @returns {Array.<Cell>}
 */
Board.prototype.getNeighbors = function(x, y) {
   return {
      up: (y > 0 ? this.getCell(x, y - 1) : Cell.dummy),
      down: (y < this.height - 1 ? this.getCell(x, y + 1) : Cell.dummy),
      left: (x > 0 ? this.getCell(x - 1, y) : Cell.dummy),
      right: (x < this.width - 1 ? this.getCell(x + 1, y) : Cell.dummy)
   };
};

/**
 *
 * @param {Player} hero
 * @param {number} dir
 * @param {number} back
 * @return bool
 */
Board.prototype.canMove = function(hero, dx, dy, dir, back) {
   var x = parseInt(hero.x + dx, 10);
   var y = parseInt(hero.y + dy, 10);

   if (hero.x < -Math.abs(dx) || hero.y < -Math.abs(dy)) {
      return false;
   }

   if (hero.x + 1 > this.width + Math.abs(dx) || hero.y + 1 > this.height + Math.abs(dy)) {
      return false;
   }

   var cell = this.getCell(x, y) || Cell.dummy;

   if (cell.walls & dir) {
//        return false;
   }

   return true;
};

/**
 *
 * @param {Map} map
 * @param {Object.<string|number>} options
 * @constructor
 */
var MapRenderer = function(map, options) {
   this.map = map;

   this.tileWidth = options.tileWidth;
   this.tileHeight = options.tileHeight;

   this.width = this.tileWidth * this.map.width;
   this.height = this.tileHeight * this.map.height;

   this.colors = {
      bg: options.bgColor,
      wall: options.wallColor
   };

   this.fps = options.fps || 32;
   this.delay = 1000 / this.fps;
   this.lastTime = 0;

   this.target = options.target;
   this.hero = options.hero;

   this.canvas = document.createElement('canvas');
   this.canvas.width = this.width;
   this.canvas.height = this.height;

   this.ctx = this.canvas.getContext('2d');

   (options.container || document.body).appendChild(this.canvas);
};

MapRenderer.prototype.render = function(time) {
   var now = time - this.lastTime;
   var tiles = this.map.tiles;
   var x = 0;
   var y = 0;

   if (now > this.delay) {
      this.ctx.fillStyle = this.colors.bg;
      this.ctx.fillRect(0, 0, this.width, this.height);
      this.ctx.fillStyle = this.colors.wall;

      for (var i = 0, len = tiles.length; i < len; i++) {
         if (tiles[i].type === Tile.Type.OPEN) {
            x = i % this.map.width;
            y = parseInt(i / this.map.width);

            this.ctx.fillRect(x * this.tileWidth, y * this.tileHeight, this.tileWidth, this.tileHeight);
         }
      }

      this.lastTime = now;
   }
};

var Tile = function() {
   this.type = Tile.Type.CLOSED;
};

Tile.Type = {
   OPEN: 0,
   WALL: 1
};

var Map = function(width, height) {
   this.width = width;
   this.height = height;
   this.tiles = [];

   this.init();
};

Map.prototype.init = function() {
   for (var i = 0, len = this.width * this.height; i < len; i++) {
      this.tiles.push(new Tile());
   }
};

Map.prototype.parseBoard = function(board) {
   /*
    Bw = 2
    Bh = 2
    Mw = 5 => 2n + 1
    Mh = 5 => 2n + 1

    Co = 6 => Mw + 1

    for: i.. in Board
    Cx,i0 = 0
    Cy,i0 = 0

    Cx,i1 = 1
    Cy,i1 = 0

    Cx,i2 = 0
    Cy,i2 = 1

    Cx,i3 = 1
    Cy,i3 = 1

    => x = i % Bw (0, 1, 0, 1)
    => y = i / Bw (0, 0, 1, 1)

    Ci0 = 6  => Co + 2i + Co * y => 6 + 0 + 0 = 6
    Ci1 = 8  => Co + 2i + Co * y => 6 + 2 + 0 = 8
    Ci2 = 16 => Co + 2i + Co * y => 6 + 4 + 6 = 16
    Ci3 = 18 => Co + 2i + Co * y => 6 + 6 + 6 = 18

    (*, 0) (*,    1) (*, 2) (*,    3) (*, 4)
    (*, 5) (_m_0, 6) (*, 7) (_m_1, 8) (*, 9)
    (*,10) (*,   11) (*,12) (*,   13) (*,14)
    (*,15) (_m_2,16) (*,17) (_m_3,18) (*,19)
    (*,20) (*,   21) (*,22) (*,   23) (*,24)

    */
   var offset = this.width + 1;
   var y = 0;
   var x = 0;
   var w = 0;
   var cell = null;

   for (var i = 0, len = board.cells.length; i < len; i++) {
      x = i % board.width;
      y = parseInt(i / board.width);
      w = offset + 2 * i + offset * y;

      cell = board.cells[i];
      this.tiles[w].type = Tile.Type.OPEN;

      if ((cell.walls & Cell.walls.UP) === 0) {
         this.tiles[w - this.width].type = Tile.Type.OPEN;
      }

      if ((cell.walls & Cell.walls.DOWN) === 0) {
         this.tiles[w + this.width].type = Tile.Type.OPEN;
      }

      if ((cell.walls & Cell.walls.LEFT) === 0) {
         this.tiles[w - 1].type = Tile.Type.OPEN;
      }

      if ((cell.walls & Cell.walls.RIGHT) === 0) {
         this.tiles[w + 1].type = Tile.Type.OPEN;
      }
   }
};
</script>

<script>
   /**
    * Copyright (c) 2014 Rodrigo Silveira. All rights reserved.
    * http://www.rodrigo-silveira.com
    */
   var main = function() {
      var WIDTH_CELLS = 20;
      var HEIGHT_CELLS = 20;
      var board = new Board(WIDTH_CELLS, HEIGHT_CELLS);
      board.generate();
      var map = new Map(WIDTH_CELLS * 2 + 1, HEIGHT_CELLS * 2 + 1);

      var points = board.seed();
      var target = new Player(points.start.x, points.start.y, window.innerWidth / board.tileWidth, window.innerHeight / board.tileHeight, '#ff0');
      var hero = new Player(points.end.x, points.end.y, window.innerWidth / board.tileWidth * 0.5, window.innerHeight / board.tileHeight * 0.5, '#c00');

      map.parseBoard(board);

      var renderer = new MapRenderer(map, {
         tileWidth: 16,
         tileHeight: 16,
         bgColor: '#000',
         wallColor: '#0c0',
         fps: 2,

         target: target,
         hero: hero
      });

      var gameLoop = function(time) {
         renderer.render(time);
//            requestAnimationFrame(gameLoop);
      };

      gameLoop(999);
   };
</script>

<script>
   main();
</script>


<script>
   (function(i, s, o, g, r, a, m) {
      i['GoogleAnalyticsObject'] = r;
      i[r] = i[r] || function() {
         (i[r].q = i[r].q || []).push(arguments)
      }, i[r].l = 1 * new Date();
      a = s.createElement(o),
         m = s.getElementsByTagName(o)[0];
      a.async = 1;
      a.src = g;
      m.parentNode.insertBefore(a, m)
   })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

   ga('create', 'UA-36191661-1', 'easylearntutorial.com');
   ga('send', 'pageview');

</script>
<div id="notice">
   <p>
      &copy; <?= date('Y', time()); ?> <a href="/">EasyLearnTutorial</a>. All rights reserved.
   </p>
</div>
</body>
</html>