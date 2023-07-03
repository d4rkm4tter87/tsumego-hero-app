besogo.makeFilePanel = function(container, editor) {
    'use strict';
    var fileChooser, // Reference to the file chooser element
        element, // Scratch variable for creating elements
        WARNING = "Everything not saved will be lost";

	var isEmbedded = typeof mode === "number";  //check if embedded in the website

	if(!isEmbedded){
		makeNewBoardButton(9); // New 9x9 board button
		makeNewBoardButton(13); // New 13x13 board button
		makeNewBoardButton(19); // New 19x19 board button
		makeNewBoardButton('?'); // New custom board button
	}

    // Hidden file chooser element
    fileChooser = makeFileChooser();
    container.appendChild(fileChooser);

	if(!isEmbedded){
		// Load file button
		element = document.createElement('input');
		element.type = 'button';
		element.value = 'Open';
		element.title = 'Import SGF';
		element.onclick = function()  // Bind click to the hidden file chooser
		{
		  if (editor.wasEdited() && !confirm("Changes were made, throw it away?"))
			return;
		  fileChooser.click();
		};
		container.appendChild(element);
	}
    // Save file button
    element = document.createElement('input');
    element.type = 'button';
    element.value = 'Save';
    element.title = 'Export SGF';
	if(!isEmbedded){
		element.onclick = function()
		{
		  var fileName = prompt('Save file as', 'export');
		  if (fileName) // Canceled or empty string does nothing
		  {
			saveFile(fileName + ".sgf", besogo.composeSgf(editor));
			editor.resetEdited();
		  }
		};
	}else{
		element.onclick = function()
		{
		  var fileName = confirm('Save '+clearFile+'?');
		  if (fileName) // Canceled or empty string does nothing
		  {
			saveFile(file, besogo.composeSgf(editor), true);
			editor.resetEdited();
		  }
		};
	}
    container.appendChild(element);
	
	if(!isEmbedded){
		// Save file button
		element = document.createElement('input');
		element.type = 'button';
		element.value = 'Save expanded';
		element.title = 'Export SGF export with all virtual variations expanded';
		element.onclick = function()
		{
		  let checkResult = editor.getRoot().checkTsumegoHeroCompatibility()
		  if (checkResult)
		  {
			editor.setCurrent(checkResult.node);
			window.alert(checkResult.message);
			return;
		  }

		  var fileName = prompt('Save file as', 'export');
		  if (fileName) // Canceled or empty string does nothing
		  {
			saveFile(fileName + ".sgf", besogo.composeSgf(editor, true));
			editor.resetEdited();
		  }
		};
		container.appendChild(element);
	}

    // Makes a new board button
    function makeNewBoardButton(size)
    {
      var button = document.createElement('input');
      button.type = 'button';
      button.value = size + "x" + size;
      if (size === '?')
      { // Make button for custom sized board
        button.title = "New custom size board";
        button.onclick = function()
        {
          var input = prompt("Enter custom size for new board" + "\n" + (editor.wasEdited() ? WARNING : ''), "19:19");
          if (input)  // Canceled or empty string does nothing
          {
            var size = besogo.parseSize(input);
            editor.loadRoot(besogo.makeGameRoot(size.x, size.y));
            editor.setGameInfo({});
          }
        };
      }
      else
      { // Make button for fixed size board
        button.title = "New " + size + "x" + size + " board";
        button.onclick = function()
        {
          if (!editor.wasEdited() || confirm(button.title + "?\n" + WARNING))
          {
            editor.loadRoot(besogo.makeGameRoot(size, size));
            editor.setGameInfo({});
          }
        };
      }
      container.appendChild(button);
    }

    // Creates the file selector
    function makeFileChooser()
    {
      var chooser = document.createElement('input');
      chooser.type = 'file';
      chooser.style.display = 'none'; // Keep hidden
      chooser.onchange = readFile; // Read, parse and load on file select
      return chooser;
    }

    // Reads, parses and loads an SGF file
    function readFile(evt)
    {
      var file = evt.target.files[0], // Selected file
          reader = new FileReader();

      var newChooser = makeFileChooser(); // Create new file input to reset selection

      container.replaceChild(newChooser, fileChooser); // Replace with the reset selector
      fileChooser = newChooser;

      reader.onload = function(e) // Parse and load game tree
      {
        var sgf;
        try
        {
          sgf = besogo.parseSgf(e.target.result);
        }
        catch (error)
        {
          alert('SGF parse error at ' + error.at + ':\n' + error.message);
          return;
        }
        besogo.loadSgf(sgf, editor);
      };
      reader.readAsText(file); // Initiate file read
    }

    // Composes SGF file and initializes download
    function saveFile(fileName, text, redirect=false)
    {
      var link = document.createElement('a'),
          blob = new Blob([text], { encoding:"UTF-8", type:"text/plain;charset=UTF-8" });

      link.download = fileName; // Set download file name
      link.href = URL.createObjectURL(blob);
      link.style.display = 'none'; // Make link hidden
	  if(!redirect){
		  container.appendChild(link); // Add link to ensure that clicking works
		  link.click(); // Click on link to initiate download
		  container.removeChild(link); // Immediately remove the link
	  }else{
		  text = text.replaceAll(";", "@");
		  text = text.replaceAll("\n", "€");
		  document.cookie = "requestProblem="+text;
		  //console.log(text);
		  window.location.href = "/tsumegos/play/"+tsumegoFileLink+"?requestProblem=true";
	  }
    }
};
