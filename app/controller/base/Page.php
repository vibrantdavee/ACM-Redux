<?php
/*!
 * Page
 * \brief Manages the page information such as includes css and JavaScript.* 
 * \author David Nuon <david@davidnuon.com> 
 */

namespace Controller;

class Page {
    protected $title         = "";
    protected $page_template = "";
    protected $urlString     = "";
    protected $found         = true;

    protected $css  = array();
    protected $js   = array();

	protected $breadCrumb = array();
	
    protected $tags = array();
    
	function __construct() {
		$homeURL = rx_siteURL();
		$this->addCrumb(array('Home', $homeURL));
	}
	
	
    // Setters

    /*!
     * Sets the found status of the page
     *      \param $bool boolean
     *      \public 
     */

     public function setFound($bool) {
        $this->found = $bool;    
     }   
       
    /*!
     * Sets the title for the page
     *      \param $title string
     *      \public 
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /*!
     * Sets the view template for the page
     *      \param $view string
     * 
     */
    public function setView($view) {
        $this->page_template = $view;
    }

    /*!
     * Pushes the CSS files for the page
     *      \param mixed
     *      \public 
     */
    
    public function pushCSS() {
        $css = array();

        foreach (func_get_args() as $arg) {
            if (gettype($arg) === 'array') {
              $css = array_merge($css, $arg);
            }
            else if (gettype($arg)== 'string') {
              array_push($css, $arg);
            }
        }


        $this->css = array_merge($this->css, $css);
    }

    /*!
     * Pushes the JS files for the page
     *      \param mixed
     *      \public 
     */
    
    public function pushJS() {
        $js = array();

        foreach (func_get_args() as $arg) {
            if (gettype($arg) === 'array') {
              $js = array_merge($js, $arg);
            }
            else if (gettype($arg)== 'string') {
              array_push($js, $arg);
            }
        }
        $this->js = array_merge($this->js, $js);
    }

    /*!
     * Sets the url string that will be used to determine the path.
     *      \param $url string
     */

    public function setPath($url) {
          $this->urlString = $url;
    }
	
	/*! 
	 * Sets the breadcrumb as an array
	 * 		\param $breadCrumb array
	 */
	
	public function addCrumb($breadCrumb) {
		if(gettype($breadCrumb) === 'array' &&
				   count($breadCrumb) === 2) {
			$this->breadCrumb[] = $breadCrumb;
		}
	}

    /*!
     *  Returns a boolean of whether the page is found
     *      \return boolean
     * 
     */
    
    public function found() {
        return $this->found;
    }

    /*!
     *  Returns an array representing the path of the url
     *      \return array
     * 
     */
    public function getPath() {
        return explode('/', $this->urlString);
    }

    /*!
     *  Returns a string that is the slug of the url.
     *  Returns an empty string if there is no slug.
     *      \return string
     *
     */

     public function getSlug() {
         $pathArray = $this->getPath();
         if(count($pathArray) > 0) {
             return $pathArray[0];
         } else {
             return '';
         }
     }

     /*!
     * Returns a string of HTML for the CSS
     *      \return string
     */
    public function getCSS() {
        $out = "";
        $cssArray = $this->css;

        foreach ($cssArray as $CSSFile) {
        	// rx_cssURL returns its input if it is already a url (starting with SITEROOT)
        	
            // If rx_cssURL returns a different string, we assume
            // its a file in the /css/ directory
        	if(rx_cssURL($CSSFile) != $CSSFile) { 
	            $out .= '<link rel="stylesheet" type="text/css" ' .
	                    ' href="' . rx_cssURL($CSSFile) . '" />';
			} else {
	            $out .= '<link rel="stylesheet" type="text/css" ' .
	                    ' href="' . $CSSFile . '" />';				
			}
        }

        return $out;
    }

    /*!
     * Returns a string representing the breadcrumb
     *      \return string
     */

     public function getBreadCrumb() {
     	$out    = '';
		$length = count($this->breadCrumb);
		
		for($count = 0; $count <= $length - 1; $count++) {			
			if ($count === $length - 1) {
				$out .= '<strong>' . $this->breadCrumb[$count][0] . '</strong>';	
			} else {
				$out .= '<a href="' . $this->breadCrumb[$count][1] . '">';
				$out .= $this->breadCrumb[$count][0] . '</a> / ';
			}
		}
		
		return $out;
     }
     
    /*!
     * Returns a string of HTML for the JavaScript
     *      \return string
     */
    public function getJS() {
        $out = '';
        foreach ($this->js as $JSFile) {
            // rx_cssURL returns its input if it is already a url (starting with SITEROOT)
            
            // If rx_jsURL returns a different string, we assume
            // its a file in the /js/ directory
            if(rx_jsURL($JSFile) != $JSFile) { 
                $out .= '<script ' .
                        ' src="' . rx_jsURL($JSFile) . '"></script>';
            } else {
                $out .= '<script ' .
                        ' src="' . $JSFile . '"></script>';
            }
        }

        return $out;
    }

    /*!
     * Returns a string of HTML for the meta-description
     *      \return string
     */
    public function getTags() {

    }

    /*!
     * Returns thte title
     *      \return string
     */
    public function getTitle() {
        return $this->title;
    }

    /*!
     * Returns the HTML for the page
     *      \return string
     */
    public function renderPage() {
        renderView($this->page_template);
    }
    
}