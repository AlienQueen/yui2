			<p>The Tooltip control is an extension of Overlay that is analogous to popup tooltips within common operating systems. The standard tooltip interaction pattern involves a small overlay that is displayed when the mouse hovers over a context element for a specified amount of time. Tooltip is designed to be simple to implement with easily-accessed configuration options and visual styling handled entirely via CSS.</p>

			<p>Tooltip is very basic, and can be instantiated using inline script. No call to <em>render</em> is required, as the Tooltip will automatically render itself after the window has finished loading. Tooltip introduces several specific configuration properties:</p>

			<ul class="properties">
				<li><strong>context</strong> - Defines the context element that will trigger the Tooltip to be displayed. This property can be set using either an element id or an element reference.</li>
				<li><strong>text</strong> - The Tooltip's text. If the text property is omitted, the Tooltip will try to set its own text using the context element's "title" attribute.</li>
				<li><strong>showdelay</strong> - The number of milliseconds to wait before showing the Tooltip on mouse over. Defaults to 200.</li>
				<li><strong>hidedelay</strong> - The number of milliseconds to wait before hiding the Tooltip on mouse out. Defaults to 250.</li>
				<li><strong>autodismissdelay</strong> - The number of milliseconds to wait before automatically dismissing the Tooltip. Defaults to 5000.</li>
			</ul>

			<p>In this tutorial, we will create two Tooltips. The first will be associated with an element with an id of "ctx", and will have its text set explicitly. The second Tooltip will be associated with a link with an id of "link", but it will retrieve its text from the link's "title" attribute:</p>

			<textarea name="code" class="JScript" cols="60" rows="1">
				YAHOO.example.container.tt1 = new YAHOO.widget.Tooltip("tt1", { context:"ctx", text:"My text was set using the 'text' configuration property" });
				YAHOO.example.container.tt2 = new YAHOO.widget.Tooltip("tt2", { context:"link" });
			</textarea>

			<p>The corresponding markup for the context elements for this tutorial look like this:</p>

			<textarea name="code" class="HTML" cols="60" rows="1">
					<div id="ctx">Hover over me to see a Tooltip!</div>
					<a id="link" href="http://www.yahoo.com" title="Do You Yahoo?">Hover over me to see a Tooltip!</a>
			</textarea>