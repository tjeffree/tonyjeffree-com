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
        'created deployment web app for internal use to interface with current rsync set up to move code to the staging server',
        'autoloading of common classes across web applications to make a DRYer environment',                 // DRY = Don`t Repeat Yourself
        'MVC framework for all new web applications (in use on tachomaster.co.uk, falcontracking.co.uk, predrive.co.uk)',
        'Java J2ME mobile phone application for recording working time',
        'email ticketing system for support department',
        'Google Analytics across all web applications',
        'Java online smart card reader - reading EU Driver Cards',
        'slippy map using Openlayers and OpenStreetMap & Bing Maps',
        'general notification application for web services - Adobe Air / Flex',
        'desktop application to notify of PHP errors on live servers - Adobe Air / Javascript, HTML',
	'SVN version control',
	'bug, feature and enhancement tracking application'
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

        $this->exp['PHP']              = $this->date_diff('2003-01-01', $fmt);    // 9 years
        $this->exp['Javascript']       = $this->date_diff('2001-01-01', $fmt);    // 12 years
        $this->exp['HTML']             = $this->date_diff('2001-01-01', $fmt);    // 12 years

    }

    protected function gatherSkills() {
        
        $this->skills[]                = 'jQuery';
        $this->skills[]                = 'MySQL';
        $this->skills[]                = 'CSS';                                    // CSS3 included!
        $this->skills[]                = 'Linux (command line, scripting)';
        $this->skills[]                = 'nodejs';
        $this->skills[]                = 'Redis';
        $this->skills[]                = 'Java';
        $this->skills[]                = 'C# (some!)';
        $this->skills[]                = 'DNS';

    }

    protected function listWebsites() {
        
        $this->websites[]             = 'http://www.tachomaster.co.uk';
        $this->websites[]             = 'http://www.falcontracking.co.uk';
        $this->websites[]             = 'http://shex.co.uk/wordgame/';

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
