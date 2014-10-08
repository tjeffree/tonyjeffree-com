// This is the only object we're polluting the global scope with
function profileRenderer(){}
(function(){
    "use strict";

    // Private
    var 
        keyword = [
            '@author',
            '@link',
            '@param',
            'abstract',
            'protected',
            'public',
            'private',
            'const ',
            'extends',
            'class ',
            ' = ',
            'new',
            '-&gt;'
        ],

        construct = [
            'function',
            '__construct',
            'array',
            'String',
            'DateTime',
            'Position_Support_Engineer',
            'Position_Web_Developer'
        ],

        consts = [
            'true',
            'false'
        ],

        // Links to build our navigation with
        links = [
            {   search: '@author   Tony Jeffree',
                desc: 'Top'
            },
            {   search: 'class TonyJeffree',
                desc: 'Profile'
            },
            {   search: 'function gatherCoreSkills()',
                desc: 'Core Skills'
            },
            {   search: 'function gatherSkills()',
                desc: 'Skills'
            },
            {   search: 'function listWebsites()',
                desc: 'Live Websites'
            },
            {   search: 'function gatherEmployment()',
                desc: 'Employment History'
            },
            {   search: 'class Position_Web_Developer',
                desc: 'Web Developer Role'
            },
            {   search: 'class Position_Support_Engineer',
                desc: 'Support Engineer Role'
            }
        ],
        
        w           = window,
        d           = document,
        e           = d.documentElement,
        g           = d.getElementsByTagName('body')[0],
        
        winHeight   = w.innerHeight|| e.clientHeight|| g.clientHeight,

        phpblock    = null, // php source container
        
        $highlight  = null, // row highlight
        $nav        = null, // navigation
        $phpscroll  = null, // container for the php output
        
        llen        = null, // count of lines
        php         = null; // will hold the php source

        // Public
        this.init = function() {

            // jQuery up some objects we'll need later
            $highlight  = $('#highlight');
            $nav        = $('nav ul');
            $phpscroll  = $('#phpscroll');
            
            phpblock    = d.getElementById('phpcode');

            // The source php code
            php         = phpblock.innerHTML;
            
            // Catch any change in the window size
            w.addEventListener('resize', function() {
                winHeight = w.innerHeight|| e.clientHeight|| g.clientHeight;
            }, false);

            createNav();
            doSearches();
            render();
            setScroll();
        }

        function createNav() {
            // Find location of anchors and populate the navigation
//            $.each(links, function(i,l){
            for (var x=0, html = "", linkLen = links.length;x<linkLen;x++) {
                
                var l           = links[x],
                    strLocation = php.indexOf(l.search),
                    newStr      = php.substring(0,strLocation),
                    lineNo      = newStr.split('\n').length;

                html += '<li><a href="#" data-lineno="' + (lineNo) + '">'+l.desc+'</a></li>';

            };
            
            $nav.append(html);

            // Attach our click handlers to our navigation
            $nav.on('click', 'a', function(){
                var lineno   = this.getAttribute('data-lineno'),
                    line     = $('#l'+lineno);

               $('html,body').animate({scrollTop: line.offset().top - (winHeight/2)}, 1000);

               return false;
            });
        }

        // Run a bunch of regexes to add some classes to the source code - makes it pretty
        // If nothing else it saves me wrapping a bunch of PHP code up in HTML tags
        function doSearches() {
            php = php.replace(/(\$this\->)/g, '$this<span class="php-keyword">-&gt;</span>');

            php = php.replace(new RegExp('(' + keyword.join('|') + ')', 'g'), '<span class="php-keyword">$1</span>');

            php = php.replace(new RegExp('(const|<span class="php-keyword">const</span>) ([A-Z_]+)', 'g'), '$1 <span class="php-const">$2</span>');

            php = php.replace(new RegExp('(' + construct.join('|') + ')', 'g'), '<span class="php-construct">$1</span>');

            php = php.replace(new RegExp('(' + consts.join('|') + ')', 'g'), '<span class="php-const">$1</span>');

            var phpcomment = '<span class="php-comment">$1</span>\n';
            php = php.replace(new RegExp('(// [a-zA-Z0-9!=<>"\'` ]+)\n','g')    , phpcomment);
            php = php.replace(new RegExp('(/[\*]+)\n','g')                      , phpcomment);
            php = php.replace(new RegExp('([\*]{1} .*)\n','g')                  , phpcomment);
            php = php.replace(new RegExp('([\*]{1}/)\n','g')                    , phpcomment);

            php = php.replace(/('([^'\\]*(\\.[^'\\]*)*)')/g, '<span class="php-string">$1</span>');

            var urlExp = new RegExp('(\\b(https?|ftp|file):\\/\\/[-A-Z0-9+&@#\\/%?=~_|!:,.;]*[-A-Z0-9+&@#\\/%=~_|])', 'ig');
            php = php.replace(urlExp, '<a href="$1">$1</a>');

            var mailExp = /(([a-z0-9*._+]){1,}\@(([a-z0-9]+[-]?){1,}[a-z0-9]+\.){1,}([a-z]{2,4}|museum)(?![\w\s?&.\/;#~%"=-]*>))/g;
            php = php.replace(mailExp, '<a href="mailto:$1">$1</a>');
            
            phpblock.innerHTML = php;
        }

        // Output the newly styled PHP code
        function render() {
            var lines   = php.split('\n'),
                x,
				output	= [];

            llen = lines.length;
            
            for (x=0;x<llen;x++) {
                output.push('<pre class="row" id="l'+x+'">' + (lines[x].length==0 ? '&nbsp;' : lines[x]) + '</pre>');
            }
            
            // remove the php source
            g.removeChild(phpblock);

            $phpscroll.append(output).css({marginTop: winHeight/2, marginBottom: winHeight/2});

            // Don't need to hold this any more
            php = null;
        }

        // Handle the scrolling of the page to move all the highlights
        function setScroll() {

            var rows,
                opac        = [.9,.85,.8,.75,.7,.65,.6,.5,.4,.3],
                opacFor     = [.9,.85,.85,.8,.8,.75,.75,.7,.6,.5,.4,.3],
                opacLen     = opac.length,
                opacForLen  = opacFor.length,
                hlTO        = null,                                         // Hang on to a timeout to clear/reset as we scroll
                current     = null;

            // Collect all rows and set to lowest opacity
            rows = $('.row', $phpscroll)
                        .css({opacity: opac[opacLen-1]});

            function onScroll() {
                
                // Clear any existing scroll timeout
                clearTimeout(hlTO);

                var thisRow, tmp, newScroll, x=0,
                    docHeight = g.scrollHeight || g.offsetHeight;
                
                // Set a new timeout
                hlTO = setTimeout(function() {
                    // Move the row highlight to where we are now
                    $highlight.show().animate({top: current.offset().top});
                }, 200);

                // Get new scroll distance
                newScroll   = g.scrollTop;

                // Calculate the row in the middle of the viewport
                thisRow     = parseInt((newScroll / (docHeight-winHeight)) * llen);

                // Set all rows to lowest opacity
                $(rows).css({opacity: opac[ opacLen-1 ]});

                if (thisRow >= rows.length) {
                    thisRow = rows.length-1;
                }

                // Set the current row - we might need this in the next iteration for the highlight
                current = $(rows[thisRow]);

                // Set the current rows opacity to 1
                current.css({opacity:1});

                // Go through and set surrounding rows opacity to create a nice effect
                for (x=1;x<=opacForLen;x++) {
                    if (x<=10) { $(rows[thisRow-x]).css({opacity: opac[x]}); }
                    $(rows[thisRow+x]).css({opacity: opacFor[x]});
                }

            }

            // Catch the window scroll
            w.addEventListener('scroll', function() {
                onScroll();
            }, false);
            
            // Kick this off on the initial load to get things moving
            onScroll();

        }

}).apply(profileRenderer);
