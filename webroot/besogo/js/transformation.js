besogo.makeTransformation = function()
{
  var transformation = [];

  transformation.hFlip = false;
  transformation.vFlip = false;
  transformation.rotate = false;
  transformation.invertColors = false;

  transformation.apply = function(position, size)
  {
    let result = [];
    result.x = position.x;
    result.y = position.y;
    if (this.hFlip)
      result.x = size.x - position.x + 1;
    if (this.vFlip)
      result.y = size.y - position.y + 1;
    if (this.rotate)
    {
      [result.x, result.y] = [size.x - result.y + 1, result.x];
    }
    return result;
  }

  transformation.applyOnColor = function(color)
  {
    if (this.invertColors)
      return -color;
    return color;
  }

  return transformation;
}
