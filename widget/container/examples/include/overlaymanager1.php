			<p>OverlayManager provides an easy way to manage multiple Overlays and keep track of which Overlay is currently in focus. When you register an Overlay with the OverlayManager, it is augmented with <em>focus</em> and <em>blur</em>, as well as two additional events, <em>focusEvent</em> and <em>blurEvent</em>.  By default, clicking on an Overlay that is registered with the OverlayManager will bring it to the top by setting its z-index higher than all the other registered Overlays, and will add the CSS class "focused" to its element.</p>

			<p>In this tutorial, we will build three separate Panels and register them with an OverlayManager. To begin, we will instantiate three Panels that are hidden by default, and render them:</p>

			<textarea name="code" class="JScript" cols="60" rows="1">
				// Build panel1 based on markup
				YAHOO.example.container.panel1 = new YAHOO.widget.Panel("panel1", { xy:[150,100], 
																					visible:false, 
																					width:"300px"
																				  } );
				YAHOO.example.container.panel1.render();

				// Build panel2 based on markup
				YAHOO.example.container.panel2 = new YAHOO.widget.Panel("panel2", { xy:[250,200], 
																					visible:false, 
																					width:"300px"
																				  } );
				YAHOO.example.container.panel2.render();

				// Build panel3 based on markup
				YAHOO.example.container.panel3 = new YAHOO.widget.Panel("panel3", { xy:[350,300], 
																					visible:false, 
																					width:"300px"
																				  } );
				YAHOO.example.container.panel3.render();
			</textarea>

			<p>Next, we will instantiate a new OverlayManager and register the Panels as an array:</p>

			<textarea name="code" class="JScript" cols="60" rows="1">
				YAHOO.example.container.manager = new YAHOO.widget.OverlayManager();
				YAHOO.example.container.manager.register([YAHOO.example.container.panel1,
														  YAHOO.example.container.panel2,
														  YAHOO.example.container.panel3]);
			</textarea>

			<p>Each of the Panels is then automatically augmented with focus and blur methods and events. Each Panel will be automatically focused when clicked, but we can also wire up buttons to focus and blur our Panels. The OverlayManager also has <em>showAll</em>, <em>hideAll</em>, and <em>blurAll</em> methods:</p>

			<textarea name="code" class="HTML" cols="60" rows="1">
				<div>
					panel1: 
					<button onclick="YAHOO.example.container.panel1.show()">Show</button> 
					<button onclick="YAHOO.example.container.panel1.hide()">Hide</button>
					<button onclick="YAHOO.example.container.panel1.focus()">Focus</button>
				</div>
				<div>
					panel2: 
					<button onclick="YAHOO.example.container.panel2.show()">Show</button> 
					<button onclick="YAHOO.example.container.panel2.hide()">Hide</button>
					<button onclick="YAHOO.example.container.panel2.focus()">Focus</button>
				</div>
				<div>
					panel3: 
					<button onclick="YAHOO.example.container.panel3.show()">Show</button> 
					<button onclick="YAHOO.example.container.panel3.hide()">Hide</button>
					<button onclick="YAHOO.example.container.panel3.focus()">Focus</button>
				</div>
				<div>
					All Panels: 
					<button onclick="YAHOO.example.container.manager.showAll()">Show All</button> 
					<button onclick="YAHOO.example.container.manager.hideAll()">Hide All</button>
					<button onclick="YAHOO.example.container.manager.blurAll()">Blur All</button>
				</div>
			</textarea>


			<p>Finally, we will place the basic markup for our Panels, which looks identical to much of the standard module markup we've seen in previous tutorials. Note that we set the "visibility:hidden" style inline on these Panels because we don't want them to flash before they are hidden by default. Setting the style inline ensures that the Panels will never be seen in the browser until they are made visible.</p>

			<textarea name="code" class="HTML" cols="60" rows="1">
				<div id="panel1" style="visibility:hidden">
					<div class="hd">Panel #1 from Markup</div>
					<div class="bd">This is a Panel that was marked up in the document.</div>
					<div class="ft">End of Panel #1</div>
				</div>

				<div id="panel2" style="visibility:hidden">
					<div class="hd">Panel #2 from Markup</div>
					<div class="bd">This is a Panel that was marked up in the document.</div>
					<div class="ft">End of Panel #2</div>
				</div>

				<div id="panel3" style="visibility:hidden">
					<div class="hd">Panel #3 from Markup</div>
					<div class="bd">This is a Panel that was marked up in the document.</div>
					<div class="ft">End of Panel #3</div>
				</div>
			</textarea>