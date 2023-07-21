// Load a parsed SGF object into a game state tree

besogo.getDefaultScaleParameters = function(size)
{
  let scaleParameters = [];
	scaleParameters['lowestX'] = size.x;
	scaleParameters['lowestY'] = size.y;
	scaleParameters['highestX'] = size.x;
	scaleParameters['highestY'] = size.y;
	scaleParameters['hFlip'] = false;
	scaleParameters['vFlip'] = false;
	scaleParameters['orientation'] = '';
	scaleParameters['distToX0'] = 0;
	scaleParameters['distToX19'] = 0;
	scaleParameters['distToY0'] = 0;
	scaleParameters['distToY19'] = 0;
  return scaleParameters;
}

besogo.loadSgf = function(sgf, editor)
{
  'use strict';
  let size = { x: 19, y: 19 }, // Default size (may be changed by load)
      root;
	  
	let scaleParameters = [];
	scaleParameters['lowestX'] = 19;
	scaleParameters['lowestY'] = 19;
	scaleParameters['highestX'] = 0;
	scaleParameters['highestY'] = 0;
	scaleParameters['hFlip'] = false;
	scaleParameters['vFlip'] = false;
	scaleParameters['orientation'] = '';
	scaleParameters['distToX0'] = 0;
	scaleParameters['distToX19'] = 0;
	scaleParameters['distToY0'] = 0;
	scaleParameters['distToY19'] = 0;
	
  loadRootProps(sgf); // Load size, variants style and game info
  root = besogo.makeGameRoot(size.x, size.y);

  loadNodeTree(sgf, root); // Load the rest of game tree
  root.figureFirstToMove();
  besogo.updateTreeAsProblem(root);
  editor.loadRoot(root); // Load root into the editor

	scaleParameters['distToX0'] = Math.abs(1-scaleParameters['lowestX']);
	scaleParameters['distToX19'] = 19-scaleParameters['highestX'];
	if(scaleParameters['distToX0']>scaleParameters['distToX19']) scaleParameters['hFlip'] = true;
	scaleParameters['distToY0'] = Math.abs(1-scaleParameters['lowestY']);
	scaleParameters['distToY19'] = 19-scaleParameters['highestY'];
	if(scaleParameters['distToY0']>scaleParameters['distToY19']) scaleParameters['vFlip'] = true;
	
	if(scaleParameters['hFlip'] || scaleParameters['vFlip']){
		scaleParameters['lowestX'] = 19;
		scaleParameters['lowestY'] = 19;
		scaleParameters['highestX'] = 0;
		scaleParameters['highestY'] = 0;
		scaleParameters['distToX0'] = 0;
		scaleParameters['distToX19'] = 0;
		scaleParameters['distToY0'] = 0;
		scaleParameters['distToY19'] = 0;
	
		var i;
		var point;
		for (i = 0; i < sgf.props.length; i++){
			if(sgf.props[i].id=='AB' || sgf.props[i].id=='AW'){
				var j;
				for (j = 0; j < sgf.props[i].values.length; j++){
					point = lettersToCoords(sgf.props[i].values[j].slice(0, 2));
					if(scaleParameters['hFlip']) point.x = 19 - point.x + 1;
					if(scaleParameters['vFlip']) point.y = 19 - point.y + 1;
					checkScaleParameters('x', point.x);
					checkScaleParameters('y', point.y);
					
				}
			}else if(sgf.props[i].id=='B' || sgf.props[i].id=='W'){
			}
		}
		scaleParameters['distToX0'] = Math.abs(1-scaleParameters['lowestX']);
		scaleParameters['distToX19'] = 19-scaleParameters['highestX'];
		scaleParameters['distToY0'] = Math.abs(1-scaleParameters['lowestY']);
		scaleParameters['distToY19'] = 19-scaleParameters['highestY'];
	}
	
	if(scaleParameters['distToX19']<10 && scaleParameters['distToY19']<10){
		scaleParameters['orientation'] = 'full-board';
		besogoFullBoard = true;
	}
	return scaleParameters;
	
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
        break;
      case 'TR': // Add triangle markup
        applyPointList(prop.values, node, markupFunc, 3);
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
  function checkScaleParameters(axis, value){
	  if(axis==='x'){
		if(value<scaleParameters['lowestX']) scaleParameters['lowestX'] = value; 
		if(value>scaleParameters['highestX']) scaleParameters['highestX'] = value;
	  }else if(axis==='y'){
		if(value<scaleParameters['lowestY']) scaleParameters['lowestY'] = value;
		if(value>scaleParameters['highestY']) scaleParameters['highestY'] = value;
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
	  
	  //console.log(point);
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
