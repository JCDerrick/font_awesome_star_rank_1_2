<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 *  Font Awesome Star Rank CSS file Plugin for ExpressionEngine
 *  Font Awesome 3.1.0 is included within this add-on
 *
 * @package		ExpressionEngine 2.x
 * @subpackage	Plugin
 * @category	Plugin
 * @author    	John C. Derrick <john@ecowai.com>
 * @copyright 	Copyright (c) 2013 Ecowai, LLC - http://www.johncderrick.com
 *
 * @license   	http://creativecommons.org/licenses/by-sa/3.0/ Attribution-Share Alike 3.0 Unported
 *
 * @updates 	Includes Font Awesome CSS integration for the Font Awesome Star Rank Fieldtype
 * @version		1.0 - published May 30, 2013
 *
 */ 

$plugin_info = array(
    'pi_name' => 'Font Awesome Star Rank CSS',
    'pi_version' => '1.0',
    'pi_author' => 'John C. Derrick',
    'pi_author_url' => 'http://www.johncderrick.com/',
    'pi_description'=> 'A plugin that easily helps include Font Awesome 3.1.0 CSS file & fonts for use with Font Awesome Star Rank.',
    'pi_usage'        => Font_awesome_star_rank_css::usage()
);

class Font_awesome_star_rank_css
{

    public $return_data = "";

    // --------------------------------------------------------------------
	function font_awesome_star_rank_css()
    {		
		$this->asset_path = $this->EE->config->item('theme_folder_url').'third_party/font_awesome_star_rank/';
		$this->asset_path = defined('URL_THIRD_THEMES') ? URL_THIRD_THEMES . '/font_awesome_star_rank' : $this->EE->config->item('theme_folder_url') . '/third_party/font_awesome_star_rank';
	}
    /**
     * Font_awesome_star_rank_css
     *
     * This function returns a list of members
     *
     * @access  public
     * @return  string
     */
    public function __construct()
    {
		$css_file_path = '<link rel="stylesheet" type="text/css" href="'.URL_THIRD_THEMES.'font_awesome_star_rank/font-awesome/css/font-awesome.min.css" />';

            $this->return_data = $css_file_path;
    }

    // --------------------------------------------------------------------

    /**
     * Usage
     *
     * This function describes how the plugin is used.
     *
     * @access  public
     * @return  string
     */
    public static function usage()
    {
        ob_start();  ?>

The Font Awesome Star Rank CSS Plugin simply outputs the Font Awesome 3.1.0 CSS file and respective font icons.

    {exp:font_awesome_star_rank_css}
    
 *  License for Font Awesome 3.1.0
 *  -------------------------------------------------------
 *  - The Font Awesome font is licensed under the SIL Open Font License v1.1 -
 *    http://scripts.sil.org/OFL
 *
 *  - Font Awesome CSS, LESS, and SASS files are licensed under the MIT License -
 *    http://opensource.org/licenses/mit-license.html
 *
 *  - Attribution is no longer required in Font Awesome 3.0, but much appreciated:
 *    "Font Awesome by Dave Gandy - http://fontawesome.io"    

    <?php
        $buffer = ob_get_contents();
        ob_end_clean();

        return $buffer;
    }
    // END
}
/* End of file pi.font_awesome_star_rank_css.php */
/* Location: ./system/expressionengine/third_party/Font_awesome_star_rank_css/pi.font_awesome_star_rank_css.php */