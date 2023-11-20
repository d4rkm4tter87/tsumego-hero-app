besogo.makeScaleParameters = function(size)
{
  var scaleParameters = [];
  scaleParameters.hFlip = false;
  scaleParameters.vFlip = false;

  scaleParameters.clear = function(size)
  {
    this.lowestX = size.x;
    this.lowestY = size.y;
    this.highestX = size.x;
    this.highestY = size.y;
    this.orientation = '';
    this.distToX0 = 0;
    this.distToX19 = 0;
    this.distToY0 = 0;
    this.distToY19 = 0;
    this.boardCanvasSize = 'regular board';
  }

  scaleParameters.setupLimitsFromTree = function(node, transformation, size)
  {
    for (let i = 0; i < node.setupStones.length; ++i)
      if (node.setupStones[i])
        this.addPosition(transformation.apply(node.toXY(i), size));
    if (node.move)
      this.addPosition(transformation.apply(move, size));
    for (let i = 0; i < node.children.length; ++i)
      this.setupLimitsFromTree(node.children[i], transformation, size);
  }

  scaleParameters.addPosition = function(position)
  {
    if (position.x < this.lowestX)
      this.lowestX = position.x;
    if (position.x > this.highestX)
      this.highestX = position.x;
    if (position.y < this.lowestY)
      this.lowestY = position.y;
    if (position.y > this.highestY)
      this.highestY = position.y
  }

  scaleParameters.clear(size);

  return scaleParameters;
}
