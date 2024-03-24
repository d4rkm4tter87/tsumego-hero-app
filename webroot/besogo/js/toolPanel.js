besogo.makeToolPanel = function(container, editor)
{
  'use strict';
  var element, // Scratch for building SVG images
      svg, // Scratch for building SVG images
      labelText, // Text area for next label input
      selectors = {}; // Holds selection rects

  var reviewButton = null;
  var tlIcon = null;
  var trIcon = null;
  var blIcon = null;
  var brIcon = null;
  
  if (container.className == 'besogo-tsumegoPlayTool')
    makeReviewToolButtons(container, editor);
  else if (!besogo.isEmbedded)
    makeEditorToolButtons(container, editor);
  else
    makeEditorToolButtons2(container, editor);
  besogo.editor.addListener(toolStateUpdate); // Set up listener for tool state updates
  
  toolStateUpdate({ label: besogo.editor.getLabel(), tool: besogo.editor.getTool(), tsumegoPlayTool: besogo.editor.getTool() }); // Initialize

  function makeReviewToolButtons(container, editor)
  {
    makeImageButton('/img/colorOrientation.png', 'change the color of your stones', 'colorOrientation', function()
    {
      let transformation = besogo.makeTransformation();
      transformation.invertColors = true;
	  let descriptionText = $('#descriptionText').text();
	  if(descriptionText.includes('Black'))
		descriptionText = descriptionText.replaceAll('Black', 'White');
	  else if(descriptionText.includes('White'))
		descriptionText = descriptionText.replaceAll('White', 'Black');
	  $('#descriptionText').text(descriptionText);
      besogo.editor.applyTransformation(transformation);
    });
    if (besogo.scaleParameters['orientation']!=='full-board')
    {
      if (besogo.scaleParameters['boardCanvasSize']==='horizontal half board')
        tlIcon = 'boardOrientationT';
      else if (besogo.scaleParameters['boardCanvasSize']==='vertical half board')
        tlIcon = 'boardOrientationL';
      else
        tlIcon = 'boardOrientationTL';
      makeImageButton('/img/'+tlIcon+'.png', 'top-left', 'boardOrientationTL', function()
      {
        if (besogo.boardParameters['corner']==='top-left')
        {
          //already there
        }
        else if (besogo.boardParameters['corner']==='top-right')
        {
          let transformation = besogo.makeTransformation();
          transformation.hFlip = true;
          besogo.editor.applyTransformation(transformation);
          updateCoordArea('x', false);
        }
        else if (besogo.boardParameters['corner']==='bottom-left')
        {
          let transformation = besogo.makeTransformation();
          transformation.vFlip = true;
          besogo.editor.applyTransformation(transformation);
          updateCoordArea(false, 'y');
        }
        else if (besogo.boardParameters['corner']==='bottom-right')
        {
          let transformation = besogo.makeTransformation();
          transformation.hFlip = true;
          besogo.editor.applyTransformation(transformation);
          transformation = besogo.makeTransformation();
          transformation.vFlip = true;
          besogo.editor.applyTransformation(transformation);
          updateCoordArea('x', 'y');
        }
        if (besogo.scaleParameters['orientation']!=='full-board')
          besogo.boardCanvasSvg.setAttribute('viewBox', '0 0 ' + besogo.boardParameters['boardWidth'] + ' ' + besogo.boardParameters['boardHeight']);
        $("#boardOrientationTL").css("opacity","1");
        $("#boardOrientationTR").css("opacity",".62");
        $("#boardOrientationBL").css("opacity",".62");
        $("#boardOrientationBR").css("opacity",".62");
        besogo.boardParameters['corner']='top-left';
        besogo.editor.adjustCommentCoords();
      });
      
      if (besogo.scaleParameters['boardCanvasSize']!=='horizontal half board')
      {
        if (besogo.scaleParameters['boardCanvasSize']==='vertical half board')
          trIcon = 'boardOrientationR';
        else
          trIcon = 'boardOrientationTR';
        makeImageButton('/img/'+trIcon+'.png', 'top-right', 'boardOrientationTR', function()
        {
          if (besogo.boardParameters['corner']==='top-left')
          {
            let transformation = besogo.makeTransformation();
            transformation.hFlip = true;
            besogo.editor.applyTransformation(transformation);
            updateCoordArea('x', false);
          }
          else if (besogo.boardParameters['corner']==='top-right')
          {
            //already there
          }
          else if (besogo.boardParameters['corner']==='bottom-left')
          {
            let transformation = besogo.makeTransformation();
            transformation.hFlip = true;
            besogo.editor.applyTransformation(transformation);
            transformation = besogo.makeTransformation();
            transformation.vFlip = true;
            besogo.editor.applyTransformation(transformation);
            updateCoordArea('x', 'y');
          }
          else if (besogo.boardParameters['corner']==='bottom-right')
          {
            let transformation = besogo.makeTransformation();
            transformation.vFlip = true;
            besogo.editor.applyTransformation(transformation);
            updateCoordArea(false, 'y');
          }
          if (besogo.scaleParameters['orientation']!=='full-board')
            besogo.boardCanvasSvg.setAttribute('viewBox', besogo.boardParameters['boardWidth2'] + ' ' + 0 + ' ' + besogo.boardParameters['boardWidth3'] + ' ' + besogo.boardParameters['boardHeight3']);
          $("#boardOrientationTL").css("opacity",".62");
          $("#boardOrientationTR").css("opacity","1");
          $("#boardOrientationBL").css("opacity",".62");
          $("#boardOrientationBR").css("opacity",".62");
          besogo.boardParameters['corner']='top-right';
          besogo.editor.adjustCommentCoords();
        });
      }
      if (besogo.scaleParameters['boardCanvasSize']!=='vertical half board')
      {
        if (besogo.scaleParameters['boardCanvasSize']==='horizontal half board')
        blIcon = 'boardOrientationB';
        else
        blIcon = 'boardOrientationBL';
        makeImageButton('/img/'+blIcon+'.png', 'bottom-left', 'boardOrientationBL', function()
        {
          if (besogo.boardParameters['corner'] === 'top-left')
          {
            let transformation = besogo.makeTransformation();
            transformation.vFlip = true;
            besogo.editor.applyTransformation(transformation);
            updateCoordArea(false, 'y');
          }
          else if (besogo.boardParameters['corner'] === 'top-right')
          {
            let transformation = besogo.makeTransformation();
            transformation.hFlip = true;
            besogo.editor.applyTransformation(transformation);
            transformation = besogo.makeTransformation();
            transformation.vFlip = true;
            besogo.editor.applyTransformation(transformation);
            updateCoordArea('x', 'y');
          }
          else if (besogo.boardParameters['corner']==='bottom-left')
          {
            //already there
          }
          else if (besogo.boardParameters['corner']==='bottom-right')
          {
            let transformation = besogo.makeTransformation();
            transformation.hFlip = true;
            besogo.editor.applyTransformation(transformation);
            updateCoordArea('x', false);
          }
          if (besogo.scaleParameters['orientation']!=='full-board')
            besogo.boardCanvasSvg.setAttribute('viewBox', 0 + ' ' + besogo.boardParameters['boardHeight2'] + ' ' + besogo.boardParameters['boardWidth3'] + ' ' + besogo.boardParameters['boardHeight3']);
          $("#boardOrientationTL").css("opacity",".62");
          $("#boardOrientationTR").css("opacity",".62");
          $("#boardOrientationBL").css("opacity","1");
          $("#boardOrientationBR").css("opacity",".62");
          besogo.boardParameters['corner']='bottom-left';
          besogo.editor.adjustCommentCoords();
        });
      }
      if (besogo.scaleParameters['boardCanvasSize']!=='vertical half board' && besogo.scaleParameters['boardCanvasSize']!=='horizontal half board')
      {
        makeImageButton('/img/boardOrientationBR.png', 'bottom-right', 'boardOrientationBR', function()
        {
          if (besogo.boardParameters['corner'] === 'top-left')
          {
            let transformation = besogo.makeTransformation();
            transformation.hFlip = true;
            besogo.editor.applyTransformation(transformation);
            transformation = besogo.makeTransformation();
            transformation.vFlip = true;
            besogo.editor.applyTransformation(transformation);
            updateCoordArea('x', 'y');
          }
          else if (besogo.boardParameters['corner']==='top-right')
          {
            let transformation = besogo.makeTransformation();
            transformation.vFlip = true;
            besogo.editor.applyTransformation(transformation);
            updateCoordArea(false, 'y');
          }
          else if (besogo.boardParameters['corner']==='bottom-left')
          {
            let transformation = besogo.makeTransformation();
            transformation.hFlip = true;
            besogo.editor.applyTransformation(transformation);
            updateCoordArea('x', false);
          }
          else if (besogo.boardParameters['corner']==='bottom-right')
          {
            //already there
          }
          if (besogo.scaleParameters['orientation']!=='full-board')
            besogo.boardCanvasSvg.setAttribute('viewBox', besogo.boardParameters['boardWidth2'] + ' ' + besogo.boardParameters['boardHeight2'] + ' ' + besogo.boardParameters['boardWidth3'] + ' ' + besogo.boardParameters['boardHeight3']);
          $("#boardOrientationTL").css("opacity",".62");
          $("#boardOrientationTR").css("opacity",".62");
          $("#boardOrientationBL").css("opacity",".62");
          $("#boardOrientationBR").css("opacity","1");
          besogo.boardParameters['corner']='bottom-right';
          besogo.editor.adjustCommentCoords();
        });
      }
    }
    
    if (!besogoNoLogin)
    {
      let favImage = '';
      if (!favorite) favImage = '/img/favButton.png';
      else favImage = '/img/favButtonActive.png';
      makeImageButton(favImage, 'mark as favorite', 'favButton', function()
      {
        if (favImage=='/img/favButton.png')
        {
          favImage = '/img/favButtonActive.png';
          document.cookie = 'favorite=' + tsumegoFileLink;
        }
        else
        {
          favImage = '/img/favButton.png';
          document.cookie = 'favorite=-' + tsumegoFileLink;
        }
        $("#favButton").attr('src',favImage);
      });
    }
    if (!besogo.multipleChoice && besogo.multipleChoiceCustom===false)
    {
	  if(passEnabled==1){
		  makeButtonText('Pass', 'Pass move', function(){
			var tool = editor.getTool();
			if (tool !== 'navOnly' && tool !== 'auto' && tool !== 'playB' && tool !== 'playW') {
				editor.setTool('auto'); // Ensures that a move tool is selected
			}
			editor.click(0, 0, false); // Clicking off the board signals a pass
		  }, 'besogo-pass-button');
	  }
      if (mode==1)
      {
        let prevButtonId;
        prevButtonId = 'besogo-back-button';
        if (prevButtonLink!=0)
          prevButtonLink = '/tsumegos/play/'+prevButtonLink;
        else
          prevButtonLink = '/sets/view/'+nextButtonLinkSet;

        makeHyperlinkText('Back', 'previous problem', prevButtonLink, prevButtonId);
      
        makeButtonText('Reset', 'reset the problem', function()
        {
          resetParameters(besogo.editor.getCurrent().parent===null);
          besogo.editor.resetToStart();
          toggleBoardLock(false);
          besogo.editor.setReviewMode(false);
          document.getElementById("status").innerHTML = "";
          document.getElementById("theComment").style.cssText = "display:none;";
          $("#customAlerts").fadeOut(500);
          $(".besogo-panels").css("display","none");
          if (besogo.scaleParameters['boardCanvasSize'] === 'full board')
          {
            $(".besogo-board").css("width", "60%");
            $(".besogo-board").css("margin", "0 252px");
          }
          else if (besogo.scaleParameters['boardCanvasSize'] === 'horizontal half board')
          {
            $(".besogo-board").css("width", "78%");
            $(".besogo-board").css("margin", "0 138px");
            $(".besogo-board").css("height",trueBoardHeight);
          }
          else if (besogo.scaleParameters['boardCanvasSize'] === 'vertical half board')
          {
            $(".besogo-board").css("width", "30%");
            $(".besogo-board").css("margin", "0 443px");
          }
          else
          {
            $(".besogo-board").css("width", "50%");
            $(".besogo-board").css("margin", "0 315px");
          }
      
          $(".besogo-board").css("box-shadow","0 8px 14px 0 rgba(0, 0, 0, 0.3), 0 6px 20px 0 rgba(0, 0, 0, 0.2)");
          besogo.editor.notifyListeners({ treeChange: true, navChange: true, stoneChange: true });
        }, 'besogo-reset-button');
      
        let nextButtonId;
        let nextButtonLink2 = 0;
        nextButtonId = 'besogo-next-button';
        if (nextButtonLink!=0)
          nextButtonLink2 = '/tsumegos/play/'+nextButtonLink;
        else
          nextButtonLink2 = '/tsumegos/play/'+nextButtonLinkLv+'?refresh=3';
        
        makeHyperlinkText('Next', 'next problem', nextButtonLink2, nextButtonId);
      }
      else if (mode == 2)
      {
        makeHyperlinkText('History', 'history of rating mode', "/tsumego_rating_attempts/user/"+besogoUserId, 'history-button');
        makeButtonText('Next', 'next problem', function()
        {
          if (besogoMode2Solved)
            window.location.href = "/tsumegos/play/"+nextButtonLink;
        }, 'besogo-next-button-inactive');
      }
      else if (mode == 3)
      {
        makeButtonText('Next',
		   'next problem',
		   function() { window.location.href = "/tsumegos/play/"+besogoMode3Next; },
		   'besogo-next-button');
      }
	  
      let reviewButtonId;
      if (editor.getReviewEnabled())
        reviewButtonId = 'besogo-review-button';
      else
        reviewButtonId = 'besogo-review-button-inactive';

      let trueBoardWidth = null;
      let trueBoardHeight = null;
      let reviewBoardWidth = null;
      let reviewBoardHeight = null;
      let trueRatio = null;

      makeButtonText('Review', 'review mode', function()
      {
        if (trueBoardHeight===null)
        {
          trueBoardWidth = $(".besogo-board").width();
          trueBoardHeight = $(".besogo-board").height();
        }
        if (editor.getReviewEnabled())
        {
          if (!editor.getReviewMode())
          {
            $(".besogo-panels").css("display","flex");
            if (besogo.scaleParameters['boardCanvasSize'] !== 'vertical half board') //only case where width < 50%
              $(".besogo-board").css("width", "50%");
            $(".besogo-board").css("margin","0");
            $(".besogo-board").css("box-shadow","0 8px 14px 0 rgba(0, 0, 0, 0.3), 0 6px 20px 0 rgba(0, 0, 0, 0.2)");
            
            if (reviewBoardHeight===null)
            {
              reviewBoardWidth = $(".besogo-board").width();
              reviewBoardHeight = $(".besogo-board").height();
              trueRatio = trueBoardWidth/trueBoardHeight;
              reviewBoardHeight = reviewBoardWidth/trueRatio;
            }
            $(".besogo-board").css("height",reviewBoardHeight);
            toggleBoardLock(false);
            deleteNextMoveGroup = true;
            editor.setReviewMode(true);
            besogo.editor.notifyListeners({ treeChange: true, navChange: true, stoneChange: true });//fixes tree showing after solve
          }
          else
          {
            $(".besogo-panels").css("display","none");
            if (besogo.scaleParameters['boardCanvasSize'] === 'full board')
            {
              $(".besogo-board").css("width", "60%");
              $(".besogo-board").css("margin", "0 252px");
            }
            else if (besogo.scaleParameters['boardCanvasSize'] === 'horizontal half board')
            {
              $(".besogo-board").css("width", "78%");
              $(".besogo-board").css("margin", "0 138px");
            }
            else if (besogo.scaleParameters['boardCanvasSize'] === 'vertical half board')
            {
              $(".besogo-board").css("width", "30%");
              $(".besogo-board").css("margin", "0 443px");
            }
            else
            {
              $(".besogo-board").css("width", "50%");
              $(".besogo-board").css("margin", "0 315px");
            }
            $(".besogo-board").css("height",trueBoardHeight);
            deleteNextMoveGroup = false;
            editor.setReviewMode(false);
          }
          besogo.editor.setControlButtonLock(false);
          besogo.editor.resetToStart();
          document.getElementById("status").innerHTML = "";
          besogo.editor.notifyListeners({ treeChange: true, navChange: true, stoneChange: true });
        }
      }, reviewButtonId);
    }
    else if (besogo.multipleChoiceCustom==="multiple_choice")
    {
	  toggleBoardLock(true, true);
      let prevButtonId;
      prevButtonId = 'besogo-back-button';
      if (prevButtonLink!=0)
        prevButtonLink = '/tsumegos/play/'+prevButtonLink;
      else
        prevButtonLink = '/sets/view/'+nextButtonLinkSet;

      makeHyperlinkText('Back', 'previous problem', prevButtonLink, prevButtonId);
    
      makeButtonText(besogo.multipleChoiceCustomSetup[0], '', function()
      {
        displayMultipleChoiceCustomResult(1);
      }, 'besogo-multipleChoice1');
    
      makeButtonText(besogo.multipleChoiceCustomSetup[1], '', function()
      {
        displayMultipleChoiceCustomResult(2);
      }, 'besogo-multipleChoice2');
	  if(besogo.multipleChoiceCustomSetup[2]!=""){
        makeButtonText(besogo.multipleChoiceCustomSetup[2], '', function()
        {
          displayMultipleChoiceCustomResult(3);
        }, 'besogo-multipleChoice3');
      }
	  if(besogo.multipleChoiceCustomSetup[3]!=""){
        makeButtonText(besogo.multipleChoiceCustomSetup[3], '', function()
        {
          displayMultipleChoiceCustomResult(4);
        }, 'besogo-multipleChoice4');
	  }
      let nextButtonId;
      let nextButtonLink2 = 0;
      nextButtonId = 'besogo-next-button';
      if (nextButtonLink!=0)
        nextButtonLink2 = '/tsumegos/play/'+nextButtonLink;
      else
        nextButtonLink2 = '/tsumegos/play/'+nextButtonLinkLv+'?refresh=3';
      makeHyperlinkText('Next', 'next problem', nextButtonLink2, nextButtonId);
	}
	else if (besogo.multipleChoiceCustom==="score_estimating")
    {
	  toggleBoardLock(true, true);
      let prevButtonId;
      prevButtonId = 'besogo-back-button';
      if (prevButtonLink!=0)
        prevButtonLink = '/tsumegos/play/'+prevButtonLink;
      else
        prevButtonLink = '/sets/view/'+nextButtonLinkSet;

      makeHyperlinkText('Back', 'previous problem', prevButtonLink, prevButtonId);
    
      makeButtonText('Black wins', '', function()
      {
        displayScoreEstimatingResult('b');
      }, 'besogo-se-black');
    
      makeButtonText('White wins', '', function()
      {
        displayScoreEstimatingResult('w');
      }, 'besogo-se-white');
	  makeButtonText('-', '', function()
      {
        displayScoreEstimatingResult('-');
      }, 'besogo-se-less');
	  makeButtonText('+', '', function()
      {
        displayScoreEstimatingResult('+');
      }, 'besogo-se-more');
      let nextButtonId;
      let nextButtonLink2 = 0;
      nextButtonId = 'besogo-next-button';
      if (nextButtonLink!=0)
        nextButtonLink2 = '/tsumegos/play/'+nextButtonLink;
      else
        nextButtonLink2 = '/tsumegos/play/'+nextButtonLinkLv+'?refresh=3';
      makeHyperlinkText('Next', 'next problem', nextButtonLink2, nextButtonId);
	}
	else
	{
      toggleBoardLock(true, true);
      let prevButtonId;
      prevButtonId = 'besogo-back-button';
      if (prevButtonLink!=0)
        prevButtonLink = '/tsumegos/play/'+prevButtonLink;
      else
        prevButtonLink = '/sets/view/'+nextButtonLinkSet;

      makeHyperlinkText('Back', 'previous problem', prevButtonLink, prevButtonId);
		
      makeButtonText('Black is dead', '', function()
      {
        displayMultipleChoiceResult(1);
      }, 'besogo-multipleChoice1');
    
      makeButtonText('White is dead', '', function()
      {
        displayMultipleChoiceResult(2);
      }, 'besogo-multipleChoice2');
    
      makeButtonText('Unsettled', '', function()
      {
        displayMultipleChoiceResult(3);
      }, 'besogo-multipleChoice3');
    
      makeButtonText('Seki', '', function()
      {
        displayMultipleChoiceResult(4);
      }, 'besogo-multipleChoice4');
	  
	  
      let nextButtonId;
      let nextButtonLink2 = 0;
      nextButtonId = 'besogo-next-button';
      if (nextButtonLink!=0)
        nextButtonLink2 = '/tsumegos/play/'+nextButtonLink;
      else
        nextButtonLink2 = '/tsumegos/play/'+nextButtonLinkLv+'?refresh=3';
      makeHyperlinkText('Next', 'next problem', nextButtonLink2, nextButtonId);
    }
    makeAuthorText('author-notice');
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
	makeButtonText('Pass', 'Pass move', function(){
	  var tool = editor.getTool();
	  if (tool !== 'navOnly' && tool !== 'auto' && tool !== 'playB' && tool !== 'playW') {
		  editor.setTool('auto'); // Ensures that a move tool is selected
	  }
	  editor.click(0, 0, false); // Clicking off the board signals a pass
	});
    makeButtonText('Cut', 'Remove branch', function() { editor.cutCurrent(); });
    makeButtonText('Raise', 'Raise variation', function() { editor.promote(); });
    makeButtonText('Lower', 'Lower variation', function() { editor.demote(); });
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

  function makeEditorToolButtons2(container, editor)
  {
	//removed buttons - the other editor should be used
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
  function makeButtonText(text, tip, callback, id=null)
  {
    var button = document.createElement('input');
    button.type = 'button';
    button.value = text;
    button.title = tip;
    if (id!==null) 
    button.id = id;
    button.onclick = callback;
    container.appendChild(button);
    return button;
  }
  
  // Creates hyperlink button
  function makeHyperlinkText(text, tip, link, id)
  {
    var button = document.createElement('a');
    if (link !== 0)
    button.href = link;
    button.title = tip;
    button.id = id;
    button.text = text;
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
  }

  // Draws a yin yang
  function makeYinYang(x, y)
  {
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

  // updates the area of valid coordinates
  function updateCoordArea(x=false, y=false)
  {
    let convertedCoords = besogo.coord['western'](besogo.scaleParameters['boardCoordSize'], besogo.scaleParameters['boardCoordSize']);
    if (x != false)
    {
      besogo.coordArea['lowestX'] = besogo.scaleParameters['boardCoordSize'] - besogo.coordArea['lowestX'] - 1;
      besogo.coordArea['highestX'] = besogo.scaleParameters['boardCoordSize'] - besogo.coordArea['highestX'] - 1;
      besogo.coordArea['lowestXconverted'] = convertedCoords.x[besogo.coordArea['lowestX'] + 1];
      besogo.coordArea['highestXconverted'] = convertedCoords.x[besogo.coordArea['highestX'] + 1];
    }
    if (y != false)
    {
      besogo.coordArea['lowestY'] = besogo.scaleParameters['boardCoordSize'] - besogo.coordArea['lowestY'] - 1;
      besogo.coordArea['highestY'] = besogo.scaleParameters['boardCoordSize'] - besogo.coordArea['highestY'] - 1;
      besogo.coordArea['lowestYconverted'] = convertedCoords.y[besogo.coordArea['lowestY'] + 1];
      besogo.coordArea['highestYconverted'] = convertedCoords.y[besogo.coordArea['highestY'] + 1];
    }
  }
};
