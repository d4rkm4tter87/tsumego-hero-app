besogo.makeToolPanel = function(container, editor)
{
  'use strict';
  var element, // Scratch for building SVG images
      svg, // Scratch for building SVG images
      labelText, // Text area for next label input
      selectors = {}; // Holds selection rects
	  var reviewMode = false;
	  var isEmbedded = typeof mode === "number"; //check if embedded in the website

  var reviewMode = false;
  var reviewButton = null;
  if (container.className == 'besogo-tsumegoPlayTool')
    makeReviewToolButtons(container, editor);
  else
    makeEditorToolButtons(container, editor);

  besogo.editor.addListener(toolStateUpdate); // Set up listener for tool state updates
  
  toolStateUpdate({ label: besogo.editor.getLabel(), tool: besogo.editor.getTool(), tsumegoPlayTool: besogo.editor.getTool() }); // Initialize

  function makeReviewToolButtons(container, editor)
  {
	  makeImageButton('/img/colorOrientation.png', 'Invert colors of all stones and moves.', 'colorOrientation', function()
	  {
		let transformation = besogo.makeTransformation();
		transformation.invertColors = true;
		besogo.editor.applyTransformation(transformation);
	  });
	  if(!besogoFullBoard){
		  makeImageButton('/img/boardOrientationTL.png', 'top-left', 'boardOrientationTL', function()
		  {
			if(besogoCorner==='top-left'){
				//already there
			}else if(besogoCorner==='top-right'){
				let transformation = besogo.makeTransformation();
				transformation.hFlip = true;
				besogo.editor.applyTransformation(transformation);
			}else if(besogoCorner==='bottom-left'){
				let transformation = besogo.makeTransformation();
				transformation.vFlip = true;
				besogo.editor.applyTransformation(transformation);
			}else if(besogoCorner==='bottom-right'){
				let transformation = besogo.makeTransformation();
				transformation.hFlip = true;
				besogo.editor.applyTransformation(transformation);
				transformation = besogo.makeTransformation();
				transformation.vFlip = true;
				besogo.editor.applyTransformation(transformation);
			}
			globalSvg.setAttribute('viewBox', '0 0 ' + besogoBoardWidth + ' ' + besogoBoardHeight);
			besogoCorner='top-left';
		  });
		  
		  makeImageButton('/img/boardOrientationTR.png', 'top-right', 'boardOrientationTR', function()
		  {
			if(besogoCorner==='top-left'){
				let transformation = besogo.makeTransformation();
				transformation.hFlip = true;
				besogo.editor.applyTransformation(transformation);
			}else if(besogoCorner==='top-right'){
				//already there
			}else if(besogoCorner==='bottom-left'){
				let transformation = besogo.makeTransformation();
				transformation.hFlip = true;
				besogo.editor.applyTransformation(transformation);
				transformation = besogo.makeTransformation();
				transformation.vFlip = true;
				besogo.editor.applyTransformation(transformation);
			}else if(besogoCorner==='bottom-right'){
				let transformation = besogo.makeTransformation();
				transformation.vFlip = true;
				besogo.editor.applyTransformation(transformation);
			}
			globalSvg.setAttribute('viewBox', besogoBoardWidth2 + ' ' + 0 + ' ' + besogoBoardWidth3 + ' ' + besogoBoardHeight3);
			besogoCorner='top-right';
		  });
		  
		  makeImageButton('/img/boardOrientationBL.png', 'bottom-left', 'boardOrientationBL', function()
		  {
			if(besogoCorner==='top-left'){
				let transformation = besogo.makeTransformation();
				transformation.vFlip = true;
				besogo.editor.applyTransformation(transformation);
			}else if(besogoCorner==='top-right'){
				let transformation = besogo.makeTransformation();
				transformation.hFlip = true;
				besogo.editor.applyTransformation(transformation);
				transformation = besogo.makeTransformation();
				transformation.vFlip = true;
				besogo.editor.applyTransformation(transformation);
			}else if(besogoCorner==='bottom-left'){
				//already there
			}else if(besogoCorner==='bottom-right'){
				let transformation = besogo.makeTransformation();
				transformation.hFlip = true;
				besogo.editor.applyTransformation(transformation);
			}
			globalSvg.setAttribute('viewBox', 0 + ' ' + besogoBoardHeight2 + ' ' + besogoBoardWidth3 + ' ' + besogoBoardHeight3);
			besogoCorner='bottom-left';
		  });
		  
		  makeImageButton('/img/boardOrientationBR.png', 'bottom-right', 'boardOrientationBR', function()
		  {
			if(besogoCorner==='top-left'){
				let transformation = besogo.makeTransformation();
				transformation.hFlip = true;
				besogo.editor.applyTransformation(transformation);
				transformation = besogo.makeTransformation();
				transformation.vFlip = true;
				besogo.editor.applyTransformation(transformation);
			}else if(besogoCorner==='top-right'){
				let transformation = besogo.makeTransformation();
				transformation.vFlip = true;
				besogo.editor.applyTransformation(transformation);
			}else if(besogoCorner==='bottom-left'){
				let transformation = besogo.makeTransformation();
				transformation.hFlip = true;
				besogo.editor.applyTransformation(transformation);
			}else if(besogoCorner==='bottom-right'){
				//already there
			}
			globalSvg.setAttribute('viewBox', besogoBoardWidth2 + ' ' + besogoBoardHeight2 + ' ' + besogoBoardWidth3 + ' ' + besogoBoardHeight3);
			besogoCorner='bottom-right';
		  });
	  }
	  
	  
	  /*
	  makeButtonText('H Flip', 'Flip horizontally', function()
	  {
		let transformation = besogo.makeTransformation();
		transformation.hFlip = true;
		besogo.editor.applyTransformation(transformation);
		//globalSvg.setAttribute('viewBox', '200 0 ' + 1700 + ' ' + 700);
	  });
	  makeButtonText('V Flip', 'Flip vertically', function()
	  {
		let transformation = besogo.makeTransformation();
		transformation.vFlip = true;
		besogo.editor.applyTransformation(transformation);
	  });
	  
	  makeButtonText('Rotate', 'Rotate the board clockwise', function()
	  {
		let transformation = besogo.makeTransformation();
		transformation.rotate = true;
		editor.applyTransformation(transformation);
	  });
	  */
	  
	  makeButtonText('Back', 'Previous problem', function()
	  {
		if(prevButtonLink!=0) window.location.href = "/tsumegos/play/"+prevButtonLink;
	  });
	  
	  makeButtonText('Reset', 'Resets the problem', function()
	  {
		besogo.editor.prevNode(-1);
		toggleBoardLock(false);
		reviewEnabled2 = false;
		reviewMode = false;
		document.getElementById("status").innerHTML = "";
		document.getElementById("theComment").style.cssText = "display:none;";
		$(".besogo-panels").css("display","none");
		$(".besogo-board").css("margin","0 315px");
		besogo.editor.notifyListeners({ treeChange: true, navChange: true, stoneChange: true });
		
	  });
	  makeButtonText('Next', 'Next problem', function()
	  {
		if(nextButtonLink!=0) window.location.href = "/tsumegos/play/"+nextButtonLink;
	  });
	  makeButtonText('Review', 'Review mode', function()
	  {
		if(reviewEnabled){
			if(!reviewMode){
				$(".besogo-panels").css("display","flex");
				$(".besogo-board").css("margin","0");
				toggleBoardLock(false);
				deleteNextMoveGroup = true;
			}else{
				$(".besogo-panels").css("display","none");
				$(".besogo-board").css("margin","0 315px");
				deleteNextMoveGroup = false;
			}
			reviewMode = !reviewMode;
			reviewEnabled2 = !reviewEnabled2;
			besogo.editor.notifyListeners({ treeChange: true, navChange: true, stoneChange: true });
		}
	  });
	  
	  makeAuthorText('author-notice');
	//not defined?
    //reviewButton.disabled = true; 
  }

  function makeEditorToolButtons(container, editor)
  {
    svg = makeButtonSVG('auto', 'Auto-play/navigate\n' +
        'crtl+click to force ko, suicide, overwrite\n' +
        'shift+click to jump to move'); // Auto-play/nav tool button
    svg.appendChild(makeYinYang(0, 0));

    svg = makeButtonSVG('addB', 'Set black\nshift+click addWhite\nctrl+click to play'); // Add black button
    element = besogo.svgEl('g');
    element.appendChild(besogo.svgStone(-15, -15, -1, 15)); // Black stone
    element.appendChild(besogo.svgStone(15, -15, 1, 15)); // White stone
    element.appendChild(besogo.svgStone(-15, 15, 1, 15)); // White stone
    element.appendChild(besogo.svgStone(15, 15, -1, 15)); // Black stone
    svg.appendChild(element);

    svg = makeButtonSVG('circle', 'Circle'); // Circle markup button
    svg.appendChild(besogo.svgCircle(0, 0, 'black'));

    svg = makeButtonSVG('square', 'Square'); // Square markup button
    svg.appendChild(besogo.svgSquare(0, 0, 'black'));

    svg = makeButtonSVG('triangle', 'Triangle'); // Triangle markup button
    svg.appendChild(besogo.svgTriangle(0, 0, 'black'));

    svg = makeButtonSVG('cross', 'Cross'); // Cross markup button
    svg.appendChild(besogo.svgCross(0, 0, 'black'));

    svg = makeButtonSVG('block', 'Block'); // Block markup button
    svg.appendChild(besogo.svgBlock(0, 0, 'black'));

    svg = makeButtonSVG('clrMark', 'Clear mark'); // Clear markup button
    element = besogo.svgEl('g');
    element.appendChild(besogo.svgTriangle(0, 0, besogo.GREY));
    element.appendChild(besogo.svgCross(0, 0, besogo.RED));
    svg.appendChild(element);

    svg = makeButtonSVG('label', 'Label'); // Label markup button
    svg.appendChild(besogo.svgLabel(0, 0, 'black', 'A1'));

    labelText = document.createElement("input"); // Label entry text field
    labelText.type = "text";
    labelText.title = 'Next label';
    labelText.onblur = function() { editor.setLabel(labelText.value); };
    labelText.addEventListener('keydown', function(evt)
    {
      evt = evt || window.event;
      evt.stopPropagation(); // Stop keydown propagation when in focus
    });
    container.appendChild(labelText);

    makeButtonText('Pass', 'Pass move', function()
    {
      var tool = editor.getTool();
      if (tool !== 'navOnly' && tool !== 'auto')
        editor.setTool('auto'); // Ensures that a move tool is selected
      editor.click(0, 0, false); // Clicking off the board signals a pass
    });

    makeButtonText('Raise', 'Raise variation', function() { editor.promote(); });
    makeButtonText('Lower', 'Lower variation', function() { editor.demote(); });
    makeButtonText('Cut', 'Remove branch', function() { editor.cutCurrent(); });
    makeButtonText('H Flip', 'Flip horizontally', function()
    {
      let transformation = besogo.makeTransformation();
      transformation.hFlip = true;
      editor.applyTransformation(transformation);
    });
    makeButtonText('V Flip', 'Flip vertically', function()
    {
      let transformation = besogo.makeTransformation();
      transformation.vFlip = true;
      editor.applyTransformation(transformation);
    });

    makeButtonText('Rotate', 'Rotate the board clockwise', function()
    {
      let transformation = besogo.makeTransformation();
      transformation.rotate = true;
      editor.applyTransformation(transformation);
    });

    makeButtonText('Invert', 'Invert colors of all stones and moves.', function()
    {
      let transformation = besogo.makeTransformation();
      transformation.invertColors = true;
      editor.applyTransformation(transformation);
    });

    makeButtonText('Invert firstMove', 'Invert the color of the first move', function()
    {
      let transformation = besogo.makeTransformation();
      transformation.invertColors = true;
      editor.getRoot().firstMove = transformation.applyOnColor(editor.getRoot().firstMove);
      editor.notifyListeners({ treeChange: true, navChange: true, stoneChange: true });
      editor.edited = true;
    });
  }

  // Creates a button holding an SVG image
  function makeButtonSVG(tool, tooltip)
  {
    var button = document.createElement('button'),
        svg = besogo.svgEl('svg', { // Icon container
            width: '100%',
            height: '100%',
            viewBox: '-55 -55 110 110' }), // Centered on (0, 0)
        selected = besogo.svgEl("rect", { // Selection rectangle
            x: -50, // Center on (0, 0)
            y: -50,
            width: 100,
            height: 100,
            fill: 'none',
            'stroke-width': 8,
            stroke: besogo.GOLD,
            rx: 20, // Rounded rectangle
            ry: 20, // Thanks, Steve
            visibility: 'hidden'
        });

    container.appendChild(button);
    button.appendChild(svg);
    button.onclick = function()
    {
      if (tool === 'auto' && editor.getTool() === 'auto')
        editor.setTool('navOnly');
      else
        editor.setTool(tool);
    };
    button.title = tooltip;
    selectors[tool] = selected;
    svg.appendChild(selected);
    return svg; // Returns reference to the icon container
  }

  // Creates text button
  function makeButtonText(text, tip, callback)
  {
    var button = document.createElement('input');
    button.type = 'button';
    button.value = text;
    button.title = tip;
    button.onclick = callback;
    container.appendChild(button);
    return button;
  }
  
   // Creates image button
  function makeImageButton(src, tip, id, callback)
  {
    var img = document.createElement('img');
    img.src = src;
	img.title = tip;
	img.id = id;
    img.onclick = callback;
    container.appendChild(img);
    return img;
  }
	  
  function makeAuthorText(id, name)
  {
	var div = document.createElement('div');
	div.id = id;
	container.appendChild(div);
	$("#author-notice").text('File by '+author);
	return div;
  }

  // Callback for updating tool state and label
  function toolStateUpdate(msg)
  {
    if (msg.label && labelText)
      labelText.value = msg.label;
    if (msg.tool)
      for (let tool in selectors) // Update which tool is selected
        if (selectors.hasOwnProperty(tool))
          if (msg.tool === tool)
            selectors[tool].setAttribute('visibility', 'visible');
          else
            selectors[tool].setAttribute('visibility', 'hidden');
    if (msg.hasOwnProperty('reviewEnabled'))
    {
      reviewEnabled = msg.reviewEnabled;
      //reviewButton.disabled = !reviewEnabled;
    }
  }

  // Draws a yin yang
  function makeYinYang(x, y) {
      var element = besogo.svgEl('g');

      // Draw black half circle on right side
      element.appendChild( besogo.svgEl("path", {
          d: "m" + x + "," + (y - 44) + " a44 44 0 0 1 0,88z",
          stroke: "none",
          fill: "black"
      }));

      // Draw white part of ying yang on left side
      element.appendChild( besogo.svgEl("path", {
          d: "m" + x + "," + (y + 44) + "a44 44 0 0 1 0,-88a22 22 0 0 1 0,44z",
          stroke: "none",
          fill: "white"
      }));

      // Draw round part of black half of ying yang
      element.appendChild( besogo.svgEl("circle", {
          cx: x,
          cy: y + 22,
          r: 22,
          stroke: "none",
          fill: "black"
      }));

      return element;
  }
};
