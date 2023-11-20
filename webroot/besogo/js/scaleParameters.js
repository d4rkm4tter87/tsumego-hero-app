besogo.makeScaleParameters = function(size)
{
  var scaleParameters = [];
  scaleParameters.hFlip = false;
  scaleParameters.vFlip = false;

  scaleParameters.clear = function(size)
  {
    this.lowest = structuredClone(size);
    this.highest = {x: 0, y: 0};
    this.orientation = '';
    this.distToX0 = 0;
    this.distToX19 = 0;
    this.distToY0 = 0;
    this.distToY19 = 0;
    this.boardCanvasSize = 'regular board';
  }

  scaleParameters.setupLimitsFromTree = function(node, transformation, size)
  {
    this.setupLimitsFromTreeInternal(node, transformation, size);

    this.distToX0 = Math.abs(1 - this.lowest.x);
    this.distToX19 = size.x - this.highest.x;
    this.distToY0 = Math.abs(1 - this.lowest.y);
    this.distToY19 = size.x - this.highest.y;
  }

  scaleParameters.setupLimitsFromTreeInternal = function(node, transformation, size)
  {
    for (let i = 0; i < node.setupStones.length; ++i)
      if (node.setupStones[i])
        this.addPosition(transformation.apply(node.toXY(i), size));
    if (node.move)
      this.addPosition(transformation.apply(move, size));
    for (let i = 0; i < node.children.length; ++i)
      this.setupLimitsFromTreeInternal(node.children[i], transformation, size);
  }

  scaleParameters.addPosition = function(position)
  {
    if (position.x < this.lowest.x)
      this.lowest.x = position.x;
    if (position.x > this.highest.x)
      this.highest.x = position.x;
    if (position.y < this.lowest.y)
      this.lowest.y = position.y;
    if (position.y > this.highest.y)
      this.highest.y = position.y
  }

  scaleParameters.isOnTheRight = function()
  {
    return this.distToX0 > this.distToX19;
  }

  scaleParameters.isOnBottom = function()
  {
    return this.distToY0 > this.distToY19;
  }

  scaleParameters.clear(size);

  return scaleParameters;
}
