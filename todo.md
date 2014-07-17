TODO
----

Player: {
  divWidth = 1/width;
  divHeight = 1/height;
  
  update: function(elapsed){
    if (movingRight){
      x += speed * elapsed;
      handleCollision(this, Dir.right);
    } else if (movingLeft){
      // ...
    }
    
    if (movingUp){
      // ...
    } else if (movingDown){
      // ...
    }
  }
}
// . = player between tiles
// # = wall
// * = new player position between tiles
// % = player colliding with wall
[.][ ][ ]  [ ][*][ ]
[.][#][ ]  [ ][%][ ]

[.][#][ ]  [ ][%][ ]
[.][ ][ ]  [ ][*][ ]

handleCollision: function(entity, dir){
  if (dir === Dir.right){
    tileX = parseInt(entity.x * entity.divWidth);
    tileX2 = parseInt(entity.x * entity.divWidth + map.width);

    if (map.tiles[tileX].type === Tile.Type.WALL ||
        map.tiles[tileX2].type === Tile.Type.WALL) {
      entity.x = (tileX - 1) * entity.width;
    }
 }
}

