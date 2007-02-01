<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <title>YUI Browser History Manager - Simple Navigation Bar Example</title>
    <link rel="stylesheet" type="text/css" href="../../../../build/reset-fonts-grids/reset-fonts-grids.css"/>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <script src="../../../../build/yahoo/yahoo.js"></script>
    <script src="../../../../build/connection/connection.js"></script>
    <script src="../../../../build/event/event.js"></script>
    <script src="../../../../build/dom/dom.js"></script>
    <script src="../../../../build/history/bhm.js"></script>
  </head>
  <body>
    <script>

// The initial section will be chosen in the following order:
//
// URL fragment identifier (it will be there if the user previously
// bookmarked the application in a specific state)
//
//         or
// "section" URL parameter (it will be there if the user accessed
// the site from a search engine result, or did not have scripting
// enabled when the application was bookmarked in a specific state)
//
//         or
//
// "home" (default)

var bookmarkedSection = YAHOO.util.History.getBookmarkedState( "app" );
var querySection = YAHOO.util.History.getQueryStringParameter( "section" );
var initSection = bookmarkedSection || querySection || "home";

// Register our only module. Module registration MUST take
// place before calling YAHOO.util.History.initialize.
YAHOO.util.History.register( "app", initSection, function( state ) {
    // This is called after calling YAHOO.util.History.navigate, or after the user
    // has trigerred the back/forward button. We cannot discrminate between
    // these two situations.
    loadSection( state );
} );

// This function does an XHR call to load and
// display the specified section in the page.
function loadSection( section ) {
    var url = "./inc/" + section + ".php";

    function successHandler( obj ) {
        // Use the response...
        YAHOO.util.Dom.get( "bd" ).innerHTML = obj.responseText;
    }

    function failureHandler( obj ) {
        // Fallback...
        location.href = "?section=" + section;
    }

    YAHOO.util.Connect.asyncRequest( "GET", url,
        {
            success:successHandler,
            failure:failureHandler
        }
    );
}

function initializeNavigationBar() {
    // Process links
    var anchors = YAHOO.util.Dom.get( "nav" ).getElementsByTagName( "a" );
    for ( var i=0, len=anchors.length ; i<len ; i++ ) {
        var anchor = anchors[i];
        YAHOO.util.Event.addListener( anchor, "click", function( evt ) {
            var href = this.getAttribute( "href" );
            var section = YAHOO.util.History.getQueryStringParameter( "section", href ) || "home";
            // If the Browser History Manager was not successfuly initialized,
            // the following call to YAHOO.util.History.navigate will throw an
            // exception. We need to catch it and update the UI. The only
            // problem is that this new state will not be added to the browser
            // history.
            //
            // Another solution is to make sure this is an A-grade browser.
            // In that case, under normal circumstances, no exception should
            // be thrown here.
            try {
                YAHOO.util.History.navigate( "app", section );
            } catch ( e ) {
                loadSection( section );
            }
            YAHOO.util.Event.preventDefault( evt );
        } );
    }

    // This is the tricky part... The window's onload handler is called when the
    // user comes back to your page using the back button. In this case, the
    // actual section that needs to be loaded corresponds to the last section
    // visited before leaving the page, and not the initial section. This can
    // be retrieved using getCurrentState:
    var currentSection = YAHOO.util.History.getCurrentState( "app" );
    if ( location.hash.substr(1).length > 0 ) {
        // If the section requested in the URL fragment is different from
        // the section loaded in index.php, we have an unpleasant refresh
        // effect because we do an asynchronous XHR call. Instead of doing
        // a synchronous XHR call, we can fix this by erasing the initial
        // content of bd:
        if ( currentSection != querySection )
            YAHOO.util.Dom.get( "bd" ).innerHTML = "";
        loadSection( currentSection );
    }
}

// Subscribe to this event before calling YAHOO.util.History.initialize,
// or it may never get fired! Note that this is guaranteed to be fired
// after the window's onload event.
YAHOO.util.History.onLoadEvent.subscribe( function() {
    initializeNavigationBar();
} );

// The call to YAHOO.util.History.initialize should ALWAYS be from within
// a script block located RIGHT AFTER the opening body tag (this seems to prevent
// an edge case bug on IE - IE seems to sometimes forget the history when
// coming back to a page, and the back - or forward button depending on the
// situation - is disabled...)
try {
    YAHOO.util.History.initialize( "../../../../build/history/assets/blank.html" );
} catch ( e ) {
    // The only exception that gets thrown here is when the browser is not A-grade.
    // Since scripting is enabled, we still try to provide the user with a better
    // experience using AJAX. The only caveat is that the browser history will not work.
    initializeNavigationBar();
}

    </script>
    <div id="doc">
      <div id="hd">
        <img src="../assets/yui.gif" alt="YUI Logo" id="logo"/>
        <div id="nav">
          <ul>
            <li class="first"><a href="?section=home">Home</a></li>
            <li><a href="?section=overview">Overview</a></li>
            <li><a href="?section=products">Products</a></li>
            <li><a href="?section=aboutus">About Us</a></li>
            <li><a href="?section=contactus">Contact Us</a></li>
            <li class="last"><a href="?section=news">News</a></li>
          </ul>
        </div>
      </div>
      <div id="bd">
<?php

$section = "home";
if ( isset( $_GET["section"] ) )
    $section = $_GET["section"];
include( "./inc/" . $section . ".php" );

?>
      </div>
      <div id="ft">YUI Browser History Manager - Simple Navigation Bar Example</div>
    </div>
  </body>
</html>
