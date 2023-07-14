(function() {
  'use strict';
  var besogo = window.besogo = window.besogo || {}; // Establish our namespace
  besogo.VERSION = '0.0.2-alpha';
  besogo.editor = null;
  let scaleParameters = [];
  let corner;
  besogo.create = function(container, options)
  {
    var editor, // Core editor object
        boardDisplay,
        resizer, // Auto-resizing function
        boardDiv, // Board display container
        panelsDiv, // Parent container of panel divs
		
        insideText = container.textContent || container.innerText || '',
        i, panelName; // Scratch iteration variables

	if(options.tsumegoPlayTool){
		var makers = // Map to panel creators
			{
			  control: besogo.makeControlPanel,
			  comment: besogo.makeCommentPanel,
			  tool: besogo.makeToolPanel,
			  tsumegoPlayTool: besogo.makeToolPanel,
			  tree: besogo.makeTreePanel,
			  file: besogo.makeFilePanel
			}
	}else{
		var makers = // Map to panel creators
			{
			  control: besogo.makeControlPanel,
			  comment: besogo.makeCommentPanel,
			  tool: besogo.makeToolPanel,
			  tree: besogo.makeTreePanel,
			  file: besogo.makeFilePanel
			}
	}

	let sgfLoaded = {
	  aInternal: 10,
	  aListener: function(val) {},
	  set scaleParameters(val) {
		this.aInternal = val;
		this.aListener(val);
	  },
	  get scaleParameters() {
		return this.aInternal;
	  },
	  registerListener: function(listener) {
		this.aListener = listener;
	  }
	}
	
    container.className += ' besogo-container'; // Marks this div as initialized
    // Process options and set defaults
    options = options || {}; // Makes option checking simpler
    options.size = besogo.parseSize(options.size || 19);
    options.coord = options.coord || 'none';
    options.tool = options.tsumegoPlayTool || 'auto';
    if(options.tsumegoPlayTool) options.tsumegoPlayTool = options.tsumegoPlayTool || 'auto';
    if (options.panels === '')
      options.panels = [];
  
	corner = options.corner;
    //options.panels = options.panels || 'control+names+comment+tool+tree+file';
    if (typeof options.panels === 'string')
      options.panels = options.panels.split('+');
  
	if(options.tsumegoPlayTool){
		options.panels2 = options.panels2 || 'tsumegoPlayTool';
		if (typeof options.panels2 === 'string')
		  options.panels2 = options.panels2.split('+');
	}
  
    if (typeof options.bottomPanels === 'string')
      options.bottomPanels = options.bottomPanels.split('+');
  
    options.path = options.path || '';
    if (options.shadows === undefined)
      options.shadows = 'auto';
    else if (options.shadows === 'off')
      options.shadows = false;
  
    // Make the core editor object
    besogo.editor = besogo.makeEditor(options.size.x, options.size.y);
    container.besogoEditor = besogo.editor;
    besogo.editor.setTool(options.tool);
	if(options.tsumegoPlayTool) besogo.editor.setTool(options.tsumegoPlayTool);
    besogo.editor.setCoordStyle(options.coord);
    if (options.realstones) // Using realistic stones
    {
      besogo.editor.REAL_STONES = true;
      besogo.editor.SHADOWS = options.shadows;
    }
	
	if (options.themeParameters) // Using realistic stones
    {
       besogo.editor.BLACK_STONES = options.themeParameters[0];
       besogo.editor.WHITE_STONES = options.themeParameters[1];
    }
    else // SVG stones
      besogo.editor.SHADOWS = (options.shadows && options.shadows !== 'auto');

    if (options.sgf) // Load SGF file from URL or SGF string
    {
      let validURL = false;
      try
      {
        new URL(options.sgf);
        validURL = true;
      } catch (e) {}
      try
      {
        if (validURL)
          fetchParseLoad(options.sgf, besogo.editor, options.path, sgfLoaded);
        else
        {
          parseAndLoad(options.sgf, besogo.editor);
          navigatePath(besogo.editor, options.path);
        }
      }
      catch(e)
      {
          console.error(e);
          // Silently fail on network error
      }
    }
    else if (insideText.match(/\s*\(\s*;/)) // Text content looks like an SGF file
    {
      parseAndLoad(insideText, besogo.editor);
      navigatePath(besogo.editor, options.path); // Navigate editor along path
    }

    if (typeof options.variants === 'number' || typeof options.variants === 'string')
      besogo.editor.setVariantStyle(+options.variants); // Converts to number

    while (container.firstChild) // Remove all children of container
      container.removeChild(container.firstChild);

	//Fixes the asynchronous load of board and content
	sgfLoaded.registerListener(function(val) {
		boardDiv = makeDiv('besogo-board'); // Create div for board display
		boardDisplay = besogo.makeBoardDisplay(boardDiv, besogo.editor, sgfLoaded.scaleParameters, corner); // Create board display

		if (!options.nokeys) // Add keypress handler unless nokeys option is truthy
		  addKeypressHandler(container, besogo.editor, boardDisplay);

		if (!options.nowheel)
		// Add mousewheel handler unless nowheel option is truthy
		  addWheelHandler(boardDiv, besogo.editor);

		if (options.panels.length > 0) // Only create if there are panels to add
		{
		  panelsDiv = makeDiv('besogo-panels');
		  for (i = 0; i < options.panels.length; i++)
		  {
			panelName = options.panels[i];
			if (makers[panelName]) // Only add if creator function exists
			  makers[panelName](makeDiv('besogo-' + panelName, panelsDiv), besogo.editor);
		  }
		  if (!panelsDiv.firstChild) // If no panels were added
		  {
			container.removeChild(panelsDiv); // Remove the panels div
			panelsDiv = false; // Flags panels div as removed
		  }
		}
		if(options.tsumegoPlayTool){
			if (options.panels2.length > 0) // Only create if there are panels to add
			{
			  panelsDiv = makeDiv('besogo-bottom-panels');
			  for (i = 0; i < options.panels2.length; i++)
			  {
				panelName = options.panels2[i];
				if (makers[panelName]) // Only add if creator function exists
				  makers[panelName](makeDiv('besogo-' + panelName, panelsDiv), editor);
			  }
			  if (!panelsDiv.firstChild) // If no panels were added
			  {
				container.removeChild(panelsDiv); // Remove the panels div
				panelsDiv = false; // Flags panels div as removed
			  }
			}
		}

		options.resize = options.resize || 'auto';
		if (options.resize === 'auto') // Add auto-resizing unless resize option is truthy
		{
		  resizer = function()
		  {
			var windowHeight = window.innerHeight, // Viewport height
				// Calculated width of parent element
				parentWidth = parseFloat(getComputedStyle(container.parentElement).width),
				maxWidth = +(options.maxwidth || -1),
				orientation = options.orient || 'auto',

				portraitRatio = +(options.portratio || 200) / 100,
				landscapeRatio = +(options.landratio || 200) / 100,
				minPanelsWidth = +(options.minpanelswidth || 350),
				minPanelsHeight = +(options.minpanelsheight || 400),
				minLandscapeWidth = +(options.transwidth || 600),

				// Initial width parent
				width = (maxWidth > 0 && maxWidth < parentWidth) ? maxWidth : parentWidth,
				height; // Initial height is undefined

			// Determine orientation if 'auto' or 'view'
			if (orientation !== 'portrait' && orientation !== 'landscape')
			  if (width < minLandscapeWidth || (orientation === 'view' && width < windowHeight))
				orientation = 'portrait';
			  else
				orientation = 'landscape';

			  if (orientation === 'portrait') // Portrait mode
			  {
				if (!isNaN(portraitRatio))
				{
				  height = portraitRatio * width;
				  if (panelsDiv)
					height = (height - width < minPanelsHeight) ? width + minPanelsHeight : height;
				} // Otherwise, leave height undefined
			  }
			  else if (orientation === 'landscape') // Landscape mode
			  {
				if (!panelsDiv) // No panels div
				  height = width; // Square overall
				else if (isNaN(landscapeRatio))
				  height = windowHeight;
				else // Otherwise use ratio
				  height = width / landscapeRatio;

				if (panelsDiv) // Reduce height to ensure minimum width of panels div
				  height = (width < height + minPanelsWidth) ? (width - minPanelsWidth) : height;
			  }
			 
			  
			setDimensions(width, height);
			container.style.width = width + 'px';
		  };
		  window.addEventListener("resize", resizer);
		  resizer(); // Initial div sizing
		}
		else if (options.resize === 'fixed')
		  setDimensions(container.clientWidth, container.clientHeight);
		else if (options.resize === 'fill')
		{
		  resizer = function()
		  {
			var // height = window.innerHeight, // Viewport height
				height = parseFloat(getComputedStyle(container.parentElement).height),
				// Calculated width of parent element
				width = parseFloat(getComputedStyle(container.parentElement).width),

				minPanelsWidth = +(options.minpanelswidth || 350),
				minPanelsHeight = +(options.minpanelsheight || 300),

				// Calculated dimensions for the panels div
				panelsWidth = 0, // Will be set if needed
				panelsHeight = 0;

			if (width >= height) // Landscape mode
			{
			  container.style['flex-direction'] = 'row';
			  if (panelsDiv)
				  panelsWidth = (width - height >= minPanelsWidth) ? (width - height) : minPanelsWidth;
			  panelsDiv.style.height = height + 'px';
			  panelsDiv.style.width = panelsWidth + 'px';
			  boardDiv.style.height = height + 'px';
			  boardDiv.style.width = (width - panelsWidth) + 'px';
			}
			else // Portrait mode
			{
			  container.style['flex-direction'] = 'column';
			  if (panelsDiv)
				panelsHeight = (height - width >= minPanelsHeight) ? (height - width) : minPanelsHeight;
			  panelsDiv.style.height = panelsHeight + 'px';
			  panelsDiv.style.width = width + 'px';
			  boardDiv.style.height = (height - panelsHeight) + 'px';
			  boardDiv.style.width = width + 'px';
			}
		  };
		  window.addEventListener("resize", resizer);
		  resizer(); // Initial div sizing
		}
	  
	  
	});

  // Sets dimensions with optional height param
  function setDimensions(width, height) {
	    //height=390;
	    //width=410;
		//console.log('height '+height);
		//console.log('width '+width);
		//container.style['flex-direction'] = 'row';
		//boardDiv.style.height = height + 'px';
       // boardDiv.style.width = width + 'px';
		
		/*
        if (height && width > height) { // Landscape mode
            container.style['flex-direction'] = 'row';
            boardDiv.style.height = height + 'px';
            boardDiv.style.width = height + 'px';
            if (panelsDiv) {
                panelsDiv.style.height = height + 'px';
                panelsDiv.style.width = (width - height) + 'px';
            }
        } else { // Portrait mode (implied if height is missing)
            container.style['flex-direction'] = 'column';
            boardDiv.style.height = width + 'px';
            boardDiv.style.width = width + 'px';
            if (panelsDiv) {
                if (height) { // Only set height if param present
                    panelsDiv.style.height = (height - width) + 'px';
                }
                panelsDiv.style.width = width + 'px';
            }
        }
		*/
    }

    // Creates and adds divs to specified parent or container
    function makeDiv(className, parent) {
        var div = document.createElement("div");
        if (className) {
            div.className = className;
        }
        parent = parent || container;
        parent.appendChild(div);
        return div;
    }
}; 

// Parses size parameter from SGF format
besogo.parseSize = function(input)
{
    var matches,
        sizeX,
        sizeY;

    input = (input + '').replace(/\s/g, ''); // Convert to string and remove whitespace

    matches = input.match(/^(\d+):(\d+)$/); // Check for #:# pattern
    if (matches) // Composed value pattern found
    {
      sizeX = +matches[1]; // Convert to numbers
      sizeY = +matches[2];
    }
    else if (input.match(/^\d+$/)) // Check for # pattern
    {
      sizeX = +input; // Convert to numbers
      sizeY = +input; // Implied square
    }
    else // Invalid input format
      sizeX = sizeY = 19; // Default size value
    if (sizeX > 52 || sizeX < 1 || sizeY > 52 || sizeY < 1)
      sizeX = sizeY = 19; // Out of range, set to default

    return { x: sizeX, y: sizeY };
};

// Automatically converts document elements into besogo instances
besogo.autoInit = function()
{
  var allDivs = document.getElementsByTagName('div'), // Live collection of divs
      targetDivs = [], // List of divs to auto-initialize
      options, // Structure to hold options
      attrs; // Scratch iteration variables

  for (let i = 0; i < allDivs.length; i++) // Iterate over all divs
    if ((hasClass(allDivs[i], 'besogo-editor') || // Has an auto-init class
         hasClass(allDivs[i], 'besogo-viewer') ||
         hasClass(allDivs[i], 'besogo-diagram')) &&
        !hasClass(allDivs[i], 'besogo-container')) // Not already initialized
      targetDivs.push(allDivs[i]);

  for (let i = 0; i < targetDivs.length; i++) // Iterate over target divs
  {
    options = {}; // Clear the options struct
    if (hasClass(targetDivs[i], 'besogo-editor'))
    {
      options.panels = ['control', 'comment', 'tool', 'tree', 'file'];
      options.tool = 'auto';
      if(options.tsumegoPlayTool) options.tsumegoPlayTool = 'auto';
    }
    else if (hasClass(targetDivs[i], 'besogo-viewer'))
    {
      options.panels = ['control', 'comment'];
      options.tool = 'navOnly';
      if(options.tsumegoPlayTool) options.tsumegoPlayTool = 'navOnly';
    } else if (hasClass(targetDivs[i], 'besogo-diagram'))
    {
      options.panels = [];
      options.tool = 'navOnly';
      if(options.tsumegoPlayTool) options.tsumegoPlayTool = 'navOnly';
    }

    attrs = targetDivs[i].attributes;
    for (let j = 0; j < attrs.length; j++) // Load attributes as options
      options[attrs[j].name] = attrs[j].value;
    besogo.create(targetDivs[i], options);
  }

  function hasClass(element, str) { return (element.className.split(' ').indexOf(str) !== -1); }
};

// Sets up keypress handling
function addKeypressHandler(container, editor, boardDisplay)
{
  if (!container.getAttribute('tabindex'))
    container.setAttribute('tabindex', '0'); // Set tabindex to allow div focusing

  container.addEventListener('keydown', function(evt)
  {
    evt = evt || window.event;
    switch (evt.keyCode)
    {
      case 33: editor.prevNode(10); break; // page up
      case 34: editor.nextNode(10); break; // page down
      case 35: editor.nextNode(-1); break; // end
      case 36: editor.prevNode(-1); break; // home
      case 37: // left
        if (evt.shiftKey)
          editor.prevBranchPoint();
        else
          editor.prevNode(1);
        break;
      case 38: editor.nextSibling(-1); break; // up
      case 39: editor.nextNode(1); break; // right
      case 40: editor.nextSibling(1); break; // down
      case 46: editor.cutCurrent(); break; // delete
      case 16:
        if (!editor.isShift())
        {
          editor.setShift(true); // shift
          boardDisplay.redrawHover(editor.getCurrent());
        }
        break;
    }
    if (evt.keyCode >= 33 && evt.keyCode <= 40)
      evt.preventDefault(); // Suppress page nav controls
  });

  container.addEventListener('keyup', function(evt)
  {
    evt = evt || window.event;
    switch (evt.keyCode)
    {
      case 16:
        editor.setShift(false);
        boardDisplay.redrawHover(editor.getCurrent());
        break; // shift
    }
  });
}

// Sets up mousewheel handling
function addWheelHandler(boardDiv, editor)
{
  boardDiv.addEventListener('wheel', function(evt)
  {
    evt = evt || window.event;
    if (evt.deltaY > 0)
    {
      editor.nextNode(1);
      evt.preventDefault();
    }
    else if (evt.deltaY < 0)
    {
      editor.prevNode(1);
      evt.preventDefault();
    }
  });
}

// Parses SGF string and loads into editor
function parseAndLoad(text, editor)
{
  var sgf;
  try
  {
    sgf = besogo.parseSgf(text);
  }
  catch (error)
  {
    return; // Silently fail on parse error
  }
  
  scaleParameters = besogo.loadSgf(sgf, editor);
  //if the setting is not full-board
  if(scaleParameters['orientation']!=='full-board'){
	  //set default corner top-left
	  if(scaleParameters['hFlip']){
		  let transformation = besogo.makeTransformation();
		  transformation.hFlip = true;
		  besogo.editor.applyTransformation(transformation);
	  }
	  if(scaleParameters['vFlip']){
		  let transformation = besogo.makeTransformation();
		  transformation.vFlip = true;
		  besogo.editor.applyTransformation(transformation);
	  }
	  scaleParameters['orientation'] = 'top-left';
	  console.log(corner);
	  //if another corner than top-left is set
	  if(corner=='top-right'){
		  let transformation = besogo.makeTransformation();
		  transformation.hFlip = true;
		  besogo.editor.applyTransformation(transformation);
		  scaleParameters['orientation'] = 'top-right';
	  }else if(corner=='bottom-left'){
		  let transformation = besogo.makeTransformation();
		  transformation.vFlip = true;
		  besogo.editor.applyTransformation(transformation);
		  scaleParameters['orientation'] = 'bottom-left';
	  }else if(corner=='bottom-right'){
		  let transformation = besogo.makeTransformation();
		  transformation.hFlip = true;
		  besogo.editor.applyTransformation(transformation);
		  transformation = besogo.makeTransformation();
		  transformation.vFlip = true;
		  besogo.editor.applyTransformation(transformation);
		  scaleParameters['orientation'] = 'bottom-right';
	  }
  }
  return scaleParameters;
}

// Fetches text file at url from same domain
function fetchParseLoad(url, editor, path, sgfLoaded)
{
  var http = new XMLHttpRequest();
	
  http.onreadystatechange = function()
  {
    if (http.readyState === 4 && http.status === 200) // Successful fetch
    {
      sgfLoaded.scaleParameters = parseAndLoad(http.responseText, editor);
      navigatePath(editor, path);
    }
  };
  http.overrideMimeType('text/plain'); // Prevents XML parsing and warnings
  http.open("GET", url, true); // Asynchronous load
  http.send();
}

function navigatePath(editor, path)
{
  var subPaths;
  path = path.split(/[Nn]+/); // Split into parts that start in next mode
  for (let i = 0; i < path.length; i++)
  {
    subPaths = path[i].split(/[Bb]+/); // Split on switches into branch mode
    executeMoves(subPaths[0], false); // Next mode moves
    for (let j = 1; j < subPaths.length; j++) // Intentionally starting at 1
      executeMoves(subPaths[j], true); // Branch mode moves
  }

  function executeMoves(part, branch)
  {
    part = part.split(/\D+/); // Split on non-digits
    for (let i = 0; i < part.length; i++)
      if (part[i]) // Skip empty strings
        if (branch)
        { // Branch mode
          if (editor.getCurrent().children.length)
          {
            editor.nextNode(1);
            editor.nextSibling(part[i] - 1);
          }
        }else{
          editor.nextNode(+part[i]); // Converts to number
		}
  }
}


})(); // END closure
