<?php
/**
* @author     Tony Jeffree
* @link     http://www.tonyjeffree.com
*/

class Career {
    
    protected $exp           = array();    // Core experience
    protected $skills        = array();    // Skills mastered
    protected $employment    = array();    // Employment history

    public function __get($foo) {
        if (!property_exists($this, $foo)) {
            return false;
        }
        
        return $this->{$foo};
    }

}

/**
* Overview of a Position
* 
* @param     String         $companyName     Company Name
* @param     DateTime     $startDate         Start Date
* @param     DateTime     $finishDate     Finish Date
*/
class Position {
    
    public $companyName;
    public $startDate;
    public $finishDate;

    public function __construct($companyName, $startDate, $finishDate) {
        $this->companyName   = $companyName;
        $this->startDate     = $startDate;
        $this->finishDate    = $finishDate;
    }

}

class Web_Developer extends Career {

    protected $websites = array();

}

class Position_Web_Developer extends Position {

    const SEPERATE_CONTENT_PRESENTATION    = true;
    const USE_FONT_TAG                     = false;
    
    public $title = 'Web Developer';

    public $responsibilities = array(
        'implementing new features',
        'creating prototypes',
        'deploying new releases and informing colleagues of updates',
        'working with support engineers to resolve any issues',
        'creating internal web applications for system administration'
    );

    public $implemented = array(
        'web application to notify of PHP errors on live servers - WebSockets / Redis pubsub / Javascript / HTML',
        'distributed report generation queue - Redis / PHP Daemons',
        'MVC framework for all new web applications (in use on tachomaster.co.uk, falcontracking.co.uk, predrive.co.uk)',
        'set up Grunt tasks for unit testing, packaging, versioning and deployment to staging server',
        'created Knowledge Base for user-end documentation, taking advantage of docpad for static site generation',
        'autoloading of common classes across web applications to make a DRYer environment',                 // DRY = Don`t Repeat Yourself
        'email ticketing system for support department',
        'Google Analytics across all web applications',
        'Java online smart card reader - reading EU Driver Cards',
        'slippy map using Openlayers and OpenStreetMap & Bing Maps',
        'general notification application for web services - Adobe Air / Flex',
        'SVN version control',
        'bug, feature and enhancement tracking application',
        'Android and iPhone/iPad App utilising my core skills with PhoneGap/Cordova/AngularJS'
    );

}

class Position_Support_Engineer extends Position {
    
    const BE_PATIENT    = true;
    const LEARN_FAST    = true;

    public $title = 'Support Engineer';

    public $responsibilities = array(
        'support existing software',
        'report software issues, bugs and improvements',
        'taking support calls directly from customers'
    );

    public $implemented      = array(
        '2nd line call log system in HTML/Javascript - MS Access back-end (for my sins)',
        'MS Access database UI bug fixes and improvements'
    );

}

/**
* 
* 
*/
class TonyJeffree extends Web_Developer {

    const NAME      = 'Tony Jeffree';
    const EMAIL     = 'mail@tonyjeffree.com';
    const TWITTER   = '<a href="//twitter.com/#tjeffree">@tjeffree</a>';
    const LINKEDIN  = '<a href="//uk.linkedin.com/in/tonyjeffree">tonyjeffree</a>';
    const GITHUB    = '<a href="//github.com/tjeffree">tjeffree</a>';

    public function __construct() {
        
        date_default_timezone_set('Europe/London');

        $this->gatherCoreSkills();
        $this->gatherSkills();
        $this->gatherEmployment();
        $this->listWebsites();

    }

    public function render() {
        
    }

    function date_diff($date1, $date2) { 
        $current = $date1; 
        $datetime2 = date_create($date2); 
        $count = 0; 
        while(date_create($current) < $datetime2) { 
            $current = gmdate("Y-m-d", strtotime("+1 year", strtotime($current))); 
            $count++;
        }
        return $count; 
    } 

    protected function gatherCoreSkills() {
        
        $now = new DateTime('now');
        $fmt = $now->format('Y-m-d');

        $this->exp['Javascript']       = $this->date_diff('2001-01-01', $fmt);
        $this->exp['HTML']             = $this->date_diff('2001-01-01', $fmt);
        $this->exp['PHP']              = $this->date_diff('2003-01-01', $fmt);

    }

    protected function gatherSkills() {
        
        $this->skills[]                = 'CSS (2, 3, ..)';
        $this->skills[]                = 'node.js';
        $this->skills[]                = 'MySQL';
        $this->skills[]                = 'Version control (SVN, Git)';
        $this->skills[]                = 'jQuery, modernizr, Bootstrap';
        $this->skills[]                = 'Linux (command line, scripting)';
        $this->skills[]                = 'Redis';
        $this->skills[]                = 'Java';
        $this->skills[]                = 'C#';
        $this->skills[]                = 'DNS';
        $this->skills[]                = 'AngularJS';
        $this->skills[]                = 'PhoneGap / Cordova';
        $this->skills[]                = 'Android/iOS Deployment';
        $this->skills[]                = 'Photoshop';
        $this->skills[]                = 'Touch typing (100 wpm on a good day)';

    }

    protected function listWebsites() {
        
        $this->websites[]             = array('Tachomaster', 'http://www.tachomaster.co.uk');
        $this->websites[]             = array('Falcon', 'http://www.falcontracking.co.uk');
        $this->websites[]             = array('Road Tech', 'http://www.roadtech.co.uk');
        $this->websites[]             = array('Word Game', 'http://shex.co.uk/wordgame/');
        $this->websites[]             = array('Tachomaster Worker App (Google Play linked, also on iOS)', 'https://play.google.com/store/apps/details?id=com.RoadTech.Tachomaster');

    }

    protected function gatherEmployment() {

        $this->employment[]            = new Position_Web_Developer(
                                        'Road Tech Computer Systems Ltd.', 
                                            new DateTime('2002-08-01'), 
                                            new DateTime('now')
                                    );
        
        $this->employment[]            = new Position_Support_Engineer(
                                        'Team Management Systems Ltd. (Company bought out by Kodak)'    , 
                                            new DateTime('1998-12-01'), 
                                            new DateTime('2002-07-31')
                                    );

    }

}
