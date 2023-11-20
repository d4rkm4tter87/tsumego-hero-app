besogo.makeScaleParameters = function()
{
  var scaleParameters = [];
  scaleParameters.hFlip = false;
  scaleParameters.vFlip = false;

  scaleParameters.clear = function()
  {
    this.lowestX = 19;
    this.lowestY = 19;
    this.highestX = 0;
    this.highestY = 0;
    this.orientation = '';
    this.distToX0 = 0;
    this.distToX19 = 0;
    this.distToY0 = 0;
    this.distToY19 = 0;
    this.boardCanvasSize = 'regular board';
  }
  scaleParameters.clear();
  
  return scaleParameters;
}
