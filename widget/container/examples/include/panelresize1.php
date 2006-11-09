			<p>In this tutorial, we will build a subclass for Panel called ResizePanel that will allow the Panel to be resized using a draggable handle in the bottom right hand corner of the footer.</p>

			<p>The first step to subclassing the Panel is writing the constructor for the new subclass (ResizePanel, in this case), and setting the new class up to extend the Panel class using <em>YAHOO.extend</em>:</p>

			<textarea name="code" class="JScript" cols="60" rows="1">

				// BEGIN PHOTOBOX SUBCLASS //
				YAHOO.widget.PhotoBox = function(el, userConfig) {
					if (arguments.length > 0) {
						YAHOO.widget.PhotoBox.superclass.constructor.call(this, el, userConfig);
					}
				}
				
				// Inherit from YAHOO.widget.Panel
				YAHOO.extend(YAHOO.widget.PhotoBox, YAHOO.widget.Panel);

			</textarea>
			
			<p>Next, we will define a few constants for use by the ResizePanel class: "CSS_PANEL_RESIZE", which defines the CSS class to apply to the Panel, and "CSS_RESIZE_HANDLE", the CSS class to apply to the resize handler.</p>

			<textarea name="code" class="JScript" cols="60" rows="1">

				YAHOO.widget.ResizePanel.CSS_PANEL_RESIZE = "resizepanel";

				YAHOO.widget.ResizePanel.CSS_RESIZE_HANDLE = "resizehandle";

			</textarea>

			<p>Next, the initialization method for the ResizePanel is defined. The first step the initialization must perform is to call the superclass's <em>init</em> method so that the superclasses can initialize first. Then, we fire the <em>beforeInitEvent</em> and add the CSS class to the Panel, and create the element that will serve as the resize handle in the footer. Next, we make sure that the footer is set to blank text if no footer is specified by render time, since a footer is required in order for the ResizePanel to function properly. The last step of our initialization is to subscribe a function to the <em>renderEvent</em> that will configure the resize handle's drag and drop instance. The resize is achieved by calculating the difference in position between the handle's start point and end point.</p>

			<textarea name="code" class="JScript" cols="60" rows="1">
				YAHOO.widget.ResizePanel.prototype.init = function(el, userConfig) {
					YAHOO.widget.ResizePanel.superclass.init.call(this, el);
					this.beforeInitEvent.fire(YAHOO.widget.ResizePanel);

					YAHOO.util.Dom.addClass(this.innerElement, YAHOO.widget.ResizePanel.CSS_PANEL_RESIZE);

					this.resizeHandle = document.createElement("DIV");
					this.resizeHandle.id = this.id + "_r";
					this.resizeHandle.className = YAHOO.widget.ResizePanel.CSS_RESIZE_HANDLE;
						
					this.beforeRenderEvent.subscribe(function() {
							if (! this.footer) {
								this.setFooter("");
							}
						}, 
						this, true
					);

					this.renderEvent.subscribe(function() {
						var me = this;
						
						me.innerElement.appendChild(me.resizeHandle);

						this.ddResize = new YAHOO.util.DragDrop(this.resizeHandle.id, this.id);
						this.ddResize.setHandleElId(this.resizeHandle.id);

						var headerHeight = me.header.offsetHeight;

						this.ddResize.onMouseDown = function(e) {

							this.startWidth = me.innerElement.offsetWidth;
							this.startHeight = me.innerElement.offsetHeight;
							
							me.cfg.setProperty("width", this.startWidth + "px");
							me.cfg.setProperty("height", this.startHeight + "px");

							this.startPos = [YAHOO.util.Event.getPageX(e),
											 YAHOO.util.Event.getPageY(e)];

							me.innerElement.style.overflow = "hidden";
							me.body.style.overflow = "auto";
						}
						
						this.ddResize.onDrag = function(e) {
							var newPos = [YAHOO.util.Event.getPageX(e),
										  YAHOO.util.Event.getPageY(e)];
							
							var offsetX = newPos[0] - this.startPos[0];
							var offsetY = newPos[1] - this.startPos[1];
					
							var newWidth = Math.max(this.startWidth + offsetX, 10);
							var newHeight = Math.max(this.startHeight + offsetY, 10);

							me.cfg.setProperty("width", newWidth + "px");
							me.cfg.setProperty("height", newHeight + "px");

							var bodyHeight = (newHeight - 5 - me.footer.offsetHeight - me.header.offsetHeight - 3);
							if (bodyHeight < 0) {
								bodyHeight = 0;
							}

							me.body.style.height =  bodyHeight + "px";

							var innerHeight = me.innerElement.offsetHeight;
							var innerWidth = me.innerElement.offsetWidth;

							if (innerHeight < headerHeight) {
								me.innerElement.style.height = headerHeight + "px";
							}

							if (innerWidth < 20) {
								me.innerElement.style.width = "20px";
							}
						}

					}, this, true);

					if (userConfig) {
						this.cfg.applyConfig(userConfig, true);
					}

					this.initEvent.fire(YAHOO.widget.ResizePanel);
				};
			</textarea>