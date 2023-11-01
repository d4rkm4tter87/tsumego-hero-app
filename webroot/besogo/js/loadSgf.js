// Load a parsed SGF object into a game state tree

besogo.getDefaultScaleParameters = function(size)
{
  besogo.scaleParameters['lowestX'] = size.x;
  besogo.scaleParameters['lowestY'] = size.y;
  besogo.scaleParameters['highestX'] = size.x;
  besogo.scaleParameters['highestY'] = size.y;
  besogo.scaleParameters['hFlip'] = false;
  besogo.scaleParameters['vFlip'] = false;
  besogo.scaleParameters['orientation'] = '';
  besogo.scaleParameters['distToX0'] = 0;
  besogo.scaleParameters['distToX19'] = 0;
  besogo.scaleParameters['distToY0'] = 0;
  besogo.scaleParameters['distToY19'] = 0;
  besogo.scaleParameters['boardCanvasSize'] = 'regular board';
  return besogo.scaleParameters;
}

besogo.loadSgf = function(sgf, editor)
{
  'use strict';
  let size = { x: 19, y: 19 }, // Default size (may be changed by load)
      root;
	let bCounter = 0;
    let wCounter = 0;
  if(besogo.multipleChoice){
    let bCounter = 0;
    let wCounter = 0;
  }
  besogo.scaleParameters['lowestX'] = 19;
  besogo.scaleParameters['lowestY'] = 19;
  besogo.scaleParameters['highestX'] = 0;
  besogo.scaleParameters['highestY'] = 0;
  besogo.scaleParameters['hFlip'] = false;
  besogo.scaleParameters['vFlip'] = false;
  besogo.scaleParameters['orientation'] = '';
  besogo.scaleParameters['distToX0'] = 0;
  besogo.scaleParameters['distToX19'] = 0;
  besogo.scaleParameters['distToY0'] = 0;
  besogo.scaleParameters['distToY19'] = 0;
  besogo.scaleParameters['boardCanvasSize'] = 'regular board';

  loadRootProps(sgf); // Load size, variants style and game info
  root = besogo.makeGameRoot(size.x, size.y);

  loadNodeTree(sgf, root); // Load the rest of game tree
  root.figureFirstToMove();
  besogo.updateTreeAsProblem(root);
  editor.loadRoot(root); // Load root into the editor

  besogo.scaleParameters['distToX0'] = Math.abs(1-besogo.scaleParameters['lowestX']);
  besogo.scaleParameters['distToX19'] = size.x-besogo.scaleParameters['highestX'];
  if(besogo.scaleParameters['distToX0']>besogo.scaleParameters['distToX19']) besogo.scaleParameters['hFlip'] = true;
  besogo.scaleParameters['distToY0'] = Math.abs(1-besogo.scaleParameters['lowestY']);
  besogo.scaleParameters['distToY19'] = size.x-besogo.scaleParameters['highestY'];
  if(besogo.scaleParameters['distToY0']>besogo.scaleParameters['distToY19']) besogo.scaleParameters['vFlip'] = true;

  if(besogo.scaleParameters['hFlip'] || besogo.scaleParameters['vFlip']){
    besogo.scaleParameters['lowestX'] = size.x;
    besogo.scaleParameters['lowestY'] = size.x;
    besogo.scaleParameters['highestX'] = 0;
    besogo.scaleParameters['highestY'] = 0;
    besogo.scaleParameters['distToX0'] = 0;
    besogo.scaleParameters['distToX19'] = 0;
    besogo.scaleParameters['distToY0'] = 0;
    besogo.scaleParameters['distToY19'] = 0;

    var i;
    var point;
    for (i = 0; i < sgf.props.length; i++){
      if(sgf.props[i].id=='AB' || sgf.props[i].id=='AW'){
        var j;
        for (j = 0; j < sgf.props[i].values.length; j++){
          point = lettersToCoords(sgf.props[i].values[j].slice(0, 2));
          if(besogo.scaleParameters['hFlip']) point.x = size.x - point.x + 1;
          if(besogo.scaleParameters['vFlip']) point.y = size.x - point.y + 1;
          checkScaleParameters('x', point.x);
          checkScaleParameters('y', point.y);

        }
      }else if(sgf.props[i].id=='B' || sgf.props[i].id=='W'){
      }
    }
    besogo.scaleParameters['distToX0'] = Math.abs(1-besogo.scaleParameters['lowestX']);
    besogo.scaleParameters['distToX19'] = size.x-besogo.scaleParameters['highestX'];
    besogo.scaleParameters['distToY0'] = Math.abs(1-besogo.scaleParameters['lowestY']);
    besogo.scaleParameters['distToY19'] = size.x-besogo.scaleParameters['highestY'];
  }

  if(besogo.scaleParameters['distToX19']<10 && besogo.scaleParameters['distToY19']<10){
    besogo.scaleParameters['orientation'] = 'full-board';
    besogo.boardParameters['fullBoard'] = true;
  }
  
	let boardCoordSize = size.x-1;
	besogo.coordArea['lowestX'] = 0;
	besogo.coordArea['lowestY'] = 0;
	besogo.coordArea['highestX'] = boardCoordSize-besogo.scaleParameters['distToX19']+3;
	besogo.coordArea['highestY'] = boardCoordSize-besogo.scaleParameters['distToY19']+3;
	if(besogo.coordArea['highestX']>11)
		besogo.coordArea['highestX'] = boardCoordSize;
	if(besogo.coordArea['highestY']>11)
		besogo.coordArea['highestY'] = boardCoordSize;
	
	if(size.x!==19)
	{
		besogo.coordArea['highestX'] = boardCoordSize;
		besogo.coordArea['highestY'] = boardCoordSize;
	}
	
	besogo.scaleParameters['boardCoordSize'] = size.x;
	
  return besogo.scaleParameters;

  // Loads the game tree
  function loadNodeTree(sgfNode, gameNode)
  {
    var i, nextGameNode;
	
    // Load properties from the SGF node into the game state node
    for (i = 0; i < sgfNode.props.length; i++){
      loadProp(gameNode, sgfNode.props[i]);
  }
    // Recursively load the rest of the tree
    for (i = 0; i < sgfNode.children.length; i++)
    {
      nextGameNode = gameNode.makeChild();
      gameNode.addChild(nextGameNode);
      loadNodeTree(sgfNode.children[i], nextGameNode);
    }
  }

  // Loads property into node
  function loadProp(node, prop)
  {
    var setupFunc = 'placeSetup',
        markupFunc = 'addMarkup',
        move;
    switch(prop.id)
    {
      case 'B': // Play a black move
        move = lettersToCoords(prop.values[0]);
        checkScaleParameters('x', move.x);
        checkScaleParameters('y', move.y);
        node.playMove(move.x, move.y, -1, true);
        break;
      case 'W': // Play a white move
        move = lettersToCoords(prop.values[0]);
        checkScaleParameters('x', move.x);
        checkScaleParameters('y', move.y);
        node.playMove(move.x, move.y, 1, true);
        break;
      case 'AB': // Setup black stones
        applyPointList(prop.values, node, setupFunc, -1);
        break;
      case 'AW': // Setup white stones
        applyPointList(prop.values, node, setupFunc, 1);
        break;
      case 'AE': // Setup empty stones
        applyPointList(prop.values, node, setupFunc, 0);
        break;
      case 'CR': // Add circle markup
        applyPointList(prop.values, node, markupFunc, 1);
        break;
      case 'SQ': // Add square markup
        applyPointList(prop.values, node, markupFunc, 2);
		if(besogo.multipleChoice)
			applyPointList2(prop.values, node, setupFunc, 1, besogo.multipleChoiceSetup);
        break;
      case 'TR': // Add triangle markup
        applyPointList(prop.values, node, markupFunc, 3);
		if(besogo.multipleChoice)
			applyPointList2(prop.values, node, setupFunc, -1, besogo.multipleChoiceSetup);
        break;
      case 'M': // Intentional fallthrough treats 'M' as 'MA'
      case 'MA': // Add 'X' cross markup
        applyPointList(prop.values, node, markupFunc, 4);
        break;
      case 'SL': // Add 'selected' (small filled square) markup
        applyPointList(prop.values, node, markupFunc, 5);
        break;
      case 'L': // Intentional fallthrough treats 'L' as 'LB'
      case 'LB': // Add label markup
        applyPointList(prop.values, node, markupFunc, 'label');
        break;
      case 'C': // Comment placed on node
        if (node.comment)
          node.comment += '\n' + prop.values.join().trim();
        else
          node.comment = prop.values.join().trim();
        break;
      case 'S':
        node.statusSource = besogo.loadStatusFromString(prop.values.join().trim());
        break;
      case 'G':
        node.goal = besogo.loadGoalFromString(prop.values.join().trim());
        break;
    }
  }

  //checks the highest and lowest placed stones to decide what parts of the board are shown
  function checkScaleParameters(axis, value)
  {
    if (axis === 'x')
    {
      if (value < besogo.scaleParameters['lowestX'])
        besogo.scaleParameters['lowestX'] = value;
      if (value>besogo.scaleParameters['highestX'])
        besogo.scaleParameters['highestX'] = value;
    }
    else if (axis==='y')
    {
      if (value < besogo.scaleParameters['lowestY'])
        besogo.scaleParameters['lowestY'] = value;
      if (value > besogo.scaleParameters['highestY'])
        besogo.scaleParameters['highestY'] = value;
    }
  }

  // Extracts point list and calls func on each
  // Set param to 'label' to signal handling of label markup property
  function applyPointList(values, node, func, param)
  {
    var i, x, y, // Scratch iteration variables
        point, // Current point in iteration
        otherPoint, // Bottom-right point of compressed point lists
        label; // Label extracted from value
	
    for (i = 0; i < values.length; i++)
    {
    point = lettersToCoords(values[i].slice(0, 2));
    checkScaleParameters('x', point.x);
    checkScaleParameters('y', point.y);
      if (param === 'label') // Label markup property
      {
        label = values[i].slice(3).replace(/\n/g, ' ');
        node[func](point.x, point.y, label); // Apply with extracted label
      }
      else // Not a label markup property
        if (values[i].charAt(2) === ':') // Expand compressed point list
        {
          otherPoint = lettersToCoords(values[i].slice(3));
          if (otherPoint.x === point.x && otherPoint.y === point.y)
            // Redundant compressed pointlist
            node[func](point.x, point.y, param);
          else if (otherPoint.x < point.x || otherPoint.y < point.y)
          {
            // Only apply to corners if not arranged properly
            node[func](point.x, point.y, param);
            node[func](otherPoint.x, otherPoint.y, param);
          }
          else // Iterate over the compressed points
            for (x = point.x; x <= otherPoint.x; x++)
                for (y = point.y; y <= otherPoint.y; y++)
                    node[func](x, y, param);
        }
        else // Apply on single point
          node[func](point.x, point.y, param);
    }
  }
  
  //multiple choice random stone placement (triangle to black, square to white)
  function applyPointList2(values, node, func, param, multipleChoice=null)
  {
    var i, x, y, // Scratch iteration variables
        point, // Current point in iteration
        otherPoint, // Bottom-right point of compressed point lists
        label,
		counter; 
		
	let bOrW = 0;
	if(param==-1)
		bOrW = 0;
	else if(param==1)
		bOrW = 1;
    for (i = 0; i < values.length; i++)
    {
		if(param==-1)
			counter = bCounter;
		else if(param==1)
			counter = wCounter;
		if(multipleChoice[bOrW][counter]==1){
		point = lettersToCoords(values[i].slice(0, 2));
		checkScaleParameters('x', point.x);
		checkScaleParameters('y', point.y);
		  if (param === 'label') // Label markup property
		  {
			label = values[i].slice(3).replace(/\n/g, ' ');
			node[func](point.x, point.y, label); // Apply with extracted label
		  }
		  else // Not a label markup property
			if (values[i].charAt(2) === ':') // Expand compressed point list
			{
			  otherPoint = lettersToCoords(values[i].slice(3));
			  if (otherPoint.x === point.x && otherPoint.y === point.y)
				// Redundant compressed pointlist
				node[func](point.x, point.y, param);
			  else if (otherPoint.x < point.x || otherPoint.y < point.y)
			  {
				// Only apply to corners if not arranged properly
				node[func](point.x, point.y, param);
				node[func](otherPoint.x, otherPoint.y, param);
			  }
			  else // Iterate over the compressed points
				for (x = point.x; x <= otherPoint.x; x++)
					for (y = point.y; y <= otherPoint.y; y++)
						node[func](x, y, param);
			}
			else // Apply on single point
			  node[func](point.x, point.y, param);
			
		}
		if(multipleChoice!==null){
			if(param==-1)
				bCounter++;
			else if(param==1)	
				wCounter++;
		}
	}
  }

  // Loads root properties (size, variant style and game info)
  function loadRootProps(node)
  {
    var gameInfoIds = ['PB', 'BR', 'BT', 'PW', 'WR', 'WT', // Player info
            'HA', 'KM', 'RU', 'TM', 'OT', // Game parameters
            'DT', 'EV', 'GN', 'PC', 'RO', // Event info
            'GC', 'ON', 'RE', // General comments
            'AN', 'CP', 'SO', 'US' ], // IP credits
        gameInfo = {}, // Structure for game info properties
        i, id, value; // Scratch iteration variables

    for (i = 0; i < node.props.length; i++)
    {
      id = node.props[i].id; // Property ID
      value = node.props[i].values.join().trim(); // Join the values array
      if (id === 'SZ') // Size property
        size = besogo.parseSize(value);
      else if (id === 'ST')
        editor.setVariantStyle( +value ); // Converts value to number
      else if (gameInfoIds.indexOf(id) !== -1) // Game info property
      {
        if (id !== 'GC') // Treat all but GC as simpletext
          value = value.replace(/\n/g, ' '); // Convert line breaks to spaces
        if (value) // Skip load of empty game info strings
          gameInfo[id] = value;
      }
    }
    editor.setGameInfo(gameInfo);
  }

  // Converts letters to numerical coordinates
  function lettersToCoords(letters)
  {
    if (letters.match(/^[A-Za-z]{2}$/)) // Verify input is two letters
      return { x: charToNum(letters.charAt(0)), y: charToNum(letters.charAt(1)) };
    else // Anything but two letters
      return { x: 0, y: 0 }; // Return (0, 0) coordinates
  }

  function charToNum(c) // Helper for lettersToCoords
  {
    if (c.match(/[A-Z]/)) // Letters A-Z to 27-52
      return c.charCodeAt(0) - 'A'.charCodeAt(0) + 27;
    else  // Letters a-z to 1-26
      return c.charCodeAt(0) - 'a'.charCodeAt(0) + 1;
  }
};
