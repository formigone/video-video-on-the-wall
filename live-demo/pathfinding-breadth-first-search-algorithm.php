<!doctype html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Pathfinding Algorithm - Breadth First Search - Demo</title>
   <link href='/favicon.ico' rel='icon' type='image/x-icon'/>
<body>
<div style="display:none"><img src='img/zelda-spritesheet.png'></div>
<style>
   html, body {
      width: 100%;
      height: 100%;
      margin: 0;
      padding: 0;
      background: #aaa;
   }

   canvas {
      margin: 20px auto;
      padding: 0;
      display: block;
      box-shadow: 0 10px 70px #333;

      image-rendering: optimizeSpeed;
      image-rendering: -moz-crisp-edges;
      image-rendering: -webkit-optimize-contrast;
      image-rendering: -o-crisp-edges;
      image-rendering: optimize-contrast;
      -ms-interpolation-mode: nearest-neighbor;
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
 * @param {Material} material
 * @constructor
 */
var Player = function(x, y, width, height, material, _update) {
   this.x = x;
   this.y = y;
   this.width = width;
   this.height = height;
   this.material = material;

   this.view = 0;
   this.lastTime = 0;
   this.animSpeed = 1000 / 6;

   this.dir = Controller.Keys.RIGHT;
   this.update = _update || this.update;
};

Player.prototype.update = function(time){
   var now = time - this.lastTime;

   if (now > this.animSpeed) {
      this.view = (this.view + 1) % this.material.length;
      this.lastTime = time
   }
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
var MapRenderer = function(map, hero, target, options) {
   this.map = map;
   this.hero = hero;
   this.target = target;

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
   var material = null;

   if (now > this.delay) {
      this.ctx.clearRect(0, 0, this.width, this.height);

      for (var i = 0, len = tiles.length; i < len; i++) {
         x = i % this.map.width;
         y = parseInt(i / this.map.width);

         material = tiles[i].material;
         this.ctx.drawImage(material.img,
            material.sx, material.sy, material.width, material.height,
            x * this.tileWidth, y * this.tileHeight, this.tileWidth, this.tileHeight);
      }

      this.ctx.drawImage(this.target.material[this.target.view].img,
         this.target.material[this.target.view].sx, this.target.material[this.target.view].sy,
         this.target.material[this.target.view].width, this.target.material[this.target.view].height,
         this.target.x * this.target.width, this.target.y * this.target.height, this.target.width, this.target.height);

      this.ctx.drawImage(this.hero.material[this.hero.view].img,
         this.hero.material[this.hero.view].sx, this.hero.material[this.hero.view].sy,
         this.hero.material[this.hero.view].width, this.hero.material[this.hero.view].height,
         this.hero.x * this.hero.width, this.hero.y * this.hero.height, this.hero.width, this.hero.height);

      this.lastTime = now;
   }
};

var Material = function(img, sx, sy, w, h) {
   this.img = img;
   this.sx = sx;
   this.sy = sy;
   this.width = w;
   this.height = h;
};

var Tile = function(material, type) {
   this.material = material;
   this.type = type || Tile.Type.WALL;
};

Tile.Type = {
   OPEN: 0,
   WALL: 1
};

var Map = function(width, height, _init) {
   this.width = width;
   this.height = height;
   this.tiles = [];

   _init.call(this);
};

Map.prototype.parseBoard = function(board, mats) {
   /*
    Co = 6 => Mw + 1
    Ci => Co + 2i + Co * y
    x => i % Bw (0, 1, 0, 1)
    y => i / Bw (0, 0, 1, 1)
    */
   var offset = this.width + 1;
   var y = 0;
   var x = 0;
   var w = 0;
   var cell = null;

   if (mats instanceof Array === false) {
      mats = [mats];
   }

   var mat = mats[0];

   for (var i = 0, len = board.cells.length; i < len; i++) {
      x = i % board.width;
      y = parseInt(i / board.width);
      w = offset + 2 * i + offset * y;

      cell = board.cells[i];
      this.tiles[w].type = Tile.Type.OPEN;
      this.tiles[w].material = mat;

      if ((cell.walls & Cell.walls.UP) === 0) {
         this.tiles[w - this.width].type = Tile.Type.OPEN;
         this.tiles[w - this.width].material = mat;
      }

      if ((cell.walls & Cell.walls.DOWN) === 0) {
         this.tiles[w + this.width].type = Tile.Type.OPEN;
         this.tiles[w + this.width].material = mat;
      }

      if ((cell.walls & Cell.walls.LEFT) === 0) {
         this.tiles[w - 1].type = Tile.Type.OPEN;
         this.tiles[w - 1].material = mat;
      }

      if ((cell.walls & Cell.walls.RIGHT) === 0) {
         this.tiles[w + 1].type = Tile.Type.OPEN;
         this.tiles[w + 1].material = mat;
      }
   }
};

var Controller = function() {
   this.keys = {};
   this.pressed = 0;
};

Controller.Keys = {
   LEFT: 37,
   UP: 38,
   RIGHT: 39,
   DOWN: 40
};

Controller.Codes = {
   37: 'LEFT',
   38: 'UP',
   39: 'RIGHT',
   40: 'DOWN'
};
</script>

<script>
/**
 * Copyright (c) 2014 Rodrigo Silveira. All rights reserved.
 * http://www.rodrigo-silveira.com
 */
var main = function() {
   var WIDTH_CELLS = 15;
   var HEIGHT_CELLS = 10;
   var board = new Board(WIDTH_CELLS, HEIGHT_CELLS);
   board.generate();
   var map = new Map(WIDTH_CELLS * 2 + 1, HEIGHT_CELLS * 2 + 1, materialGrassCb);

   map.parseBoard(board, getMaterialGrassFloors());

   var ctrl = new Controller();

   document.body.addEventListener('keydown', function(e) {
      if (Controller.Codes[e.keyCode]) {
         e.preventDefault();

         if(!ctrl.keys[e.keyCode]){
            ctrl.pressed++;
            ctrl.keys[e.keyCode] = true;
            hero.dir = e.keyCode;
         }
      }
   });

   document.body.addEventListener('keyup', function(e) {
      if (Controller.Codes[e.keyCode]) {
         e.preventDefault();

         ctrl.keys[e.keyCode] = false;
         ctrl.pressed--;
      }
   });

   var updateHero = function(time) {
      if (ctrl.pressed === 0) {
         if (this.dir === Controller.Keys.RIGHT) {
            this.view = 0;
         } else if (this.dir === Controller.Keys.LEFT) {
            this.view = 3;
         } else if (this.dir === Controller.Keys.UP) {
            this.view = 6;
         } else if (this.dir === Controller.Keys.DOWN) {
            this.view = 9;
         }
      } else {
         var now = time - this.lastTime;
         if (now > this.animSpeed) {
            if (this.dir === Controller.Keys.RIGHT) {
               this.view = (this.view + 1) % 3;
            } else if (this.dir === Controller.Keys.LEFT) {
               this.view = ((this.view + 1) % 3) + 3;
            } else if (this.dir === Controller.Keys.UP) {
               this.view = ((this.view + 1) % 3) + 6;
            } else if (this.dir === Controller.Keys.DOWN) {
               this.view = ((this.view + 1) % 3) + 9;
            }
            this.lastTime = time
         }
      }
   };

   var hero = new Player(1, 1, 32, 32, getLinkMaterial(), updateHero);
   var target = new Player(map.width - 2, map.height - 2, 32, 32, getTargetMaterial());
   var renderer = new MapRenderer(map, hero, target, {
      tileWidth: 32,
      tileHeight: 32,
      bgColor: '#fff',
      wallColor: '#000',
      fps: 2
   });

   var gameLoop = function(time) {
      target.update(time);
      hero.update(time);
      renderer.render(time);
      requestAnimationFrame(gameLoop);
   };

   gameLoop(0);
};

var getLinkMaterial = function() {
   var img = new Image();
   img.src = 'img/link-spritesheet.png';

   return [
      new Material(img, 0, 0, 50, 50),
      new Material(img, 50, 0, 50, 50),
      new Material(img, 100, 0, 50, 50),

      new Material(img, 0, 50, 50, 50),
      new Material(img, 50, 50, 50, 50),
      new Material(img, 100, 50, 50, 50),

      new Material(img, 0, 100, 50, 50),
      new Material(img, 50, 100, 50, 50),
      new Material(img, 100, 100, 50, 50),

      new Material(img, 0, 150, 50, 50),
      new Material(img, 50, 150, 50, 50),
      new Material(img, 100, 150, 50, 50),
   ];
};

var getTargetMaterial = function() {
   var img = new Image();
   img.src = 'img/zelda-spritesheet.png';

   return [
      new Material(img, 211, 84, 30, 30),
      new Material(img, 242, 84, 30, 30),
      new Material(img, 275, 84, 30, 30),
   ];
};


var materialWoodCb = function() {
   var imgWall = new Image();
   imgWall.src = 'img/zelda-gba-tileset.png';

   var mat = new Material(imgWall, 16 * 33 + 34 + 3, 16 * 8 + 9 - 2, 16, 16);
   var matTL = new Material(imgWall, 16 * 0 + 1, 16 * 0 + 1, 16, 16);
   var matTR = new Material(imgWall, 16 * 5 + 6, 16 * 0 + 1, 16, 16);
   var matBL = new Material(imgWall, 16 * 0 + 1, 16 * 4 + 5, 16, 16);
   var matBR = new Material(imgWall, 16 * 5 + 6, 16 * 4 + 5, 16, 16);
   var matT = new Material(imgWall, 16 * 1 + 2, 16 * 0 + 1, 16, 16);
   var matB = new Material(imgWall, 16 * 1 + 2, 16 * 4 + 5, 16, 16);
   var matL = new Material(imgWall, 16 * 0 + 1, 16 * 3 + 4, 16, 16);
   var matR = new Material(imgWall, 16 * 5 + 6, 16 * 3 + 4, 16, 16);
   var tile = null;
   var x = 0;
   var y = 0;

   for (var i = 0, len = this.width * this.height; i < len; i++) {
      x = i % this.width;
      y = parseInt(i / this.width);

      if (x === 0) {
         tile = new Tile(matL);
      } else if (x === this.width - 1) {
         tile = new Tile(matR);
      } else if (y === 0) {
         tile = new Tile(matT);
      } else if (y === this.height - 1) {
         tile = new Tile(matB);
      } else {
         tile = new Tile(mat);
      }

      this.tiles.push(tile);
   }

   this.tiles[0] = new Tile(matTL);
   this.tiles[this.width - 1] = new Tile(matTR);
   this.tiles[this.width * this.height - this.width] = new Tile(matBL);
   this.tiles[this.width * this.height - 1] = new Tile(matBR);
};

var getMaterialWoodFloors = function() {
   var img = new Image();
   img.src = 'img/zelda-gba-tileset.png';

   return [
      new Material(img, 16 * 1 + 2, 16 * 1 + 2, 16, 16)
   ];
};


var materialStoneCb = function() {
   var img = new Image();
   img.src = 'img/zelda-gba-tileset.png';

   var mat = new Material(img, 16 * 10 + 11 - 8, 16 * 7 + 8, 16, 16);
   var matTL = new Material(img, 16 * 9 + 10 - 8, 16 * 6 + 7, 16, 16);
   var matTR = new Material(img, 16 * 11 + 12 - 8, 16 * 6 + 7, 16, 16);
   var matBL = new Material(img, 16 * 9 + 10 - 8, 16 * 8 + 9, 16, 16);
   var matBR = new Material(img, 16 * 11 + 12 - 8, 16 * 8 + 9, 16, 16);
   var matT = new Material(img, 16 * 10 + 11 - 8, 16 * 6 + 7, 16, 16);
   var matB = new Material(img, 16 * 10 + 11 - 8, 16 * 8 + 9, 16, 16);

   var matL = new Material(img, 16 * 9 + 10 - 8, 16 * 7 + 8, 16, 16)
   var matR = new Material(img, 16 * 11 + 12 - 8, 16 * 7 + 8, 16, 16)

   var tile = null;
   var x = 0;
   var y = 0;

   for (var i = 0, len = this.width * this.height; i < len; i++) {
      x = i % this.width;
      y = parseInt(i / this.width);

      if (x === 0) {
         tile = new Tile(matL);
      } else if (x === this.width - 1) {
         tile = new Tile(matR);
      } else if (y === 0) {
         tile = new Tile(matT);
      } else if (y === this.height - 1) {
         tile = new Tile(matB);
      } else {
         tile = new Tile(mat);
      }

      this.tiles.push(tile);
   }

   this.tiles[0] = new Tile(matTL);
   this.tiles[this.width - 1] = new Tile(matTR);
   this.tiles[this.width * this.height - this.width] = new Tile(matBL);
   this.tiles[this.width * this.height - 1] = new Tile(matBR);
};

var getMaterialStoneFloors = function() {
   var img = new Image();
   img.src = 'img/zelda-gba-tileset.png';

   return [
      new Material(img, 16 * 25 + 26 + 3, 16 * 8 + 9 - 2, 16, 16)
   ];
};


var materialGrassCb = function() {
   var img = new Image();
   img.src = 'img/zelda-gba-tileset.png';

   var mat = new Material(img, 16 * 33 + 34 + 3, 16 * 8 + 9 - 2, 16, 16);

   var matTL = new Material(img, 16 * 39 + 40 + 3, 16 * 12 + 13 - 2, 16, 16);
   var matT = new Material(img, 16 * 40 + 41 + 3, 16 * 12 + 13 - 2, 16, 16);
   var matTR = new Material(img, 16 * 41 + 42 + 3, 16 * 12 + 13 - 2, 16, 16);
   var matL = new Material(img, 16 * 39 + 40 + 3, 16 * 13 + 14 - 2, 16, 16);

   var matBL = new Material(img, 16 * 39 + 40 + 3, 16 * 14 + 15 - 2, 16, 16);
   var matB = new Material(img, 16 * 40 + 41 + 3, 16 * 14 + 15 - 2, 16, 16);
   var matBR = new Material(img, 16 * 41 + 42 + 3, 16 * 14 + 15 - 2, 16, 16);
   var matR = new Material(img, 16 * 41 + 42 + 3, 16 * 13 + 14 - 2, 16, 16);

   var tile = null;
   var x = 0;
   var y = 0;

   for (var i = 0, len = this.width * this.height; i < len; i++) {
      x = i % this.width;
      y = parseInt(i / this.width);

      if (x === 0) {
         tile = new Tile(matL);
      } else if (x === this.width - 1) {
         tile = new Tile(matR);
      } else if (y === 0) {
         tile = new Tile(matT);
      } else if (y === this.height - 1) {
         tile = new Tile(matB);
      } else {
         tile = new Tile(mat);
      }

      this.tiles.push(tile);
   }

   this.tiles[0] = new Tile(matTL);
   this.tiles[this.width - 1] = new Tile(matTR);
   this.tiles[this.width * this.height - this.width] = new Tile(matBL);
   this.tiles[this.width * this.height - 1] = new Tile(matBR);
};

var getMaterialGrassFloors = function() {
   var img = new Image();
   img.src = 'img/zelda-gba-tileset.png';

   return [
      new Material(img, 16 * 21 + 22 + 3, 16 * 14 + 15 - 2, 16, 16)
   ];
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