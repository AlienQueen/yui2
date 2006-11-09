			<p>The SimpleDialog component is an extension of Dialog that reproduces the behavior of a simple dialog box (but without using an actual browser popup window); its primary use is to elicit binary decisions from the user (yes/no, okay/cancel, etc.). SimpleDialog makes it easy to implement this kind of interaction. In this tutorial, we will create a SimpleDialog with "Yes"/"No" choices, and display an alert if the user clicks "Yes".</p>

			<p>SimpleDialog defines two new properties: "icon", which defines which of six standard icons will be displayed in the SimpleDialog, and "text", which is used to specify a small amount of text to display in the SimpleDialog. The "buttons" property is inherited from Dialog, and uses the same familiar object literal array syntax, as demonstrated in the constructor:</p>
			
			<textarea name="code" class="JScript" cols="60" rows="1">
				// Instantiate the Dialog
				YAHOO.example.container.simpledialog1 = 
					new YAHOO.widget.SimpleDialog("simpledialog1", 
												 { width: "300px",
												   fixedcenter: true,
												   visible: false,
												   draggable: false,
												   close: true,
												   text: "Do you want to continue?",
												   icon: YAHOO.widget.SimpleDialog.ICON_HELP,
												   constraintoviewport: true,
												   buttons: [ { text:"Yes", handler:handleYes, isDefault:true },
															  { text:"No",  handler:handleNo } ]
												 } );
			</textarea>

			<p>Next, we'll define the handlers for our buttons. Clicking "Yes" will cause an alert to be displayed, whereas the "No" button will simply dismiss the SimpleDialog:</p>

			<textarea name="code" class="JScript" cols="60" rows="1">

				// Define various event handlers for Dialog
				var handleYes = function() {
					alert("You clicked yes!");
					this.hide();
				};

				var handleNo = function() {
					this.hide();
				};

			</textarea>