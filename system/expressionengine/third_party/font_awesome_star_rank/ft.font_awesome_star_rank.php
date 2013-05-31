<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once PATH_THIRD.'font_awesome_star_rank/config.php';

/**
 *  Font Awesome Star Rank Fieldtype for ExpressionEngine
 *  Font Awesome 3.1.0 or higher is required for use with this add-on
 *	Download Font Awesome at: http://fortawesome.github.io/Font-Awesome/icons/
 *
 * @package		ExpressionEngine 2.x
 * @subpackage	Fieldtypes
 * @category	Fieldtypes
 * @editor    	John C. Derrick <john@ecowai.com>
 * @copyright 	Copyright (c) 2013 Ecowai, LLC - http://www.johncderrick.com
 *
 * @license   	http://creativecommons.org/licenses/by-sa/3.0/ Attribution-Share Alike 3.0 Unported
 *
 * @author 		Originally released under CC-AS 3.0 by Max Lazar as 'MX Stars Field' - www.eec.ms
 *
 * @updates 	Includes Font Awesome integration along with other general improvements and bug fixes
 * @version		1.2 - published May 30, 2013
 *
 */

class font_awesome_star_rank_ft extends EE_Fieldtype
{

	var $info = array(
		'name'    => FONT_AWESOME_STAR_RANK_NAME,
		'version' => FONT_AWESOME_STAR_RANK_VER
	);

	var $has_array_data = TRUE;
    var $addon_name = 'font_awesome_star_rank';

    /**
     * Constructor
     *
     * @access	public
     */
    function font_awesome_star_rank()
    {
        parent::EE_Fieldtype();
		
		$this->asset_path   = $this->EE->config->item('theme_folder_url').'third_party/font_awesome_star_rank/';
		$this->asset_path  = defined('URL_THIRD_THEMES') ? URL_THIRD_THEMES . '/font_awesome_star_rank' : $this->EE->config->item('theme_folder_url') . '/third_party/font_awesome_star_rank';
		
		/** ----------------------------------------
		/**  Prepare Cache
		/** ----------------------------------------*/

		if (! isset($this->EE->session->cache['font_awesome_star_rank']))
		{
			$this->EE->session->cache['font_awesome_star_rank'] = array('includes' => array());
		}
		$this->cache =& $this->EE->session->cache['font_awesome_star_rank'];
	
	}  
	
    // --------------------------------------------------------------------
    
    function validate($data)
    {
        $valid = TRUE;
        
    }
    
    // --------------------------------------------------------------------
    
    public function display_field($data)
    {
        if (!isset($this->cache[$this->addon_name]['header'])) {
            $this->EE->cp->add_to_head('<script type="text/javascript" src="' . URL_THIRD_THEMES . 'font_awesome_star_rank/js/jquery-ui-1.8.5.custom.min.js"></script>');
            $this->EE->cp->add_to_head('<script type="text/javascript" src="' . URL_THIRD_THEMES . 'font_awesome_star_rank/js/jquery.ui.stars.min.js"></script>');
			$this->EE->cp->add_to_head('<link rel="stylesheet" type="text/css" href="' . URL_THIRD_THEMES . 'font_awesome_star_rank/font-awesome/css/font-awesome.min.css" />');
			$this->EE->cp->add_to_head('<script type="text/javascript" src="' . URL_THIRD_THEMES . 'font_awesome_star_rank/js/font_awesome_star_rank-liveupdate.js"></script>');
            $this->EE->cp->add_to_head('<link rel="stylesheet" type="text/css" href="' . URL_THIRD_THEMES . 'font_awesome_star_rank/css/ui.stars.css" />');
            $this->cache[$this->addon_name]['header'] = true;
        }
        ;
        
        $prefix      = 'font_awesome_star_rank';
        $split       = (isset($this->settings[$prefix . '_split'])) ? $this->settings[$prefix . '_split'] : '2';
        $stars_count = (isset($this->settings[$prefix . '_field_stars'])) ? $this->settings[$prefix . '_field_stars'] : '5';
		$empty_star_icon = (isset($this->settings[$prefix . '_empty_star_icon'])) ? $this->settings[$prefix . '_empty_star_icon'] : 'star-empty';
        $half_star_icon = (isset($this->settings[$prefix . '_half_star_icon'])) ? $this->settings[$prefix . '_half_star_icon'] : 'star-half-empty';
		$full_star_icon = (isset($this->settings[$prefix . '_full_star_icon'])) ? $this->settings[$prefix . '_full_star_icon'] : 'star';
        
        $name = str_replace(array(
            '[',
            ']'
        ), '_', $this->field_name);
        $r    = "";
        $css  = "";
        
        $r = "<p><div id=\"rs_$name\" style='padding-left:10px;'><select name=\"$this->field_name\" class=\"star_rank\">";
        for ($i = 1; $i <= $stars_count * $split; $i++) {
            $selected = ($i == $data) ? " selected=\"true\"" : "";
            $r .= "<option value=\"$i\"$selected>$i</option>";
        }
        
        $r .= "</select>";
        $this->EE->javascript->output('$("#rs_' . $name . '").stars({inputType: "select",   split: ' . $split . '});');
        
        
        $r .= '</div></p>';
        
        
        return $r;
    }
    
    // --------------------------------------------------------------------
    function replace_scale($data)
    {
        $r = $this->settings['font_awesome_star_rank_field_stars'];
        
        return $r;
    }
	
	// Output data to the front end    
    function replace_tag($data, $params = '', $tagdata = '')
    {
		$star_prefix = 'font_awesome_star_rank';
	
        if (!empty($tagdata)) {
            $prefix = 'font_awesome_star_rank';
            $split  = (isset($this->settings[$prefix . '_split'])) ? $this->settings[$prefix . '_split'] : '2';
            $size   = ((int) $tagdata != 0) ? (int) $tagdata : 2;
            $r      = ($size / $split) * $data;
        } else {
            $r = $data;
        }
        ;
        
		/** 
			Pulls the values for the respective icons from Fieldtype settings
		**/
		
		$empty = "<i class=\"icon-".$this->settings[$star_prefix . '_field_empty_star_icon']."\"></i> ";
		$half_empty = "<i class=\"icon-".$this->settings[$star_prefix . '_field_half_star_icon']."\"></i> ";
		$full = "<i class=\"icon-".$this->settings[$star_prefix . '_field_full_star_icon']."\"></i> ";
			
		if ($r == 1) {
			$star_value = $half_empty.$empty.$empty.$empty.$empty;
		} else if ($r == 2) {
			$star_value = $full.$empty.$empty.$empty.$empty;
		} else if ($r == 3) {
			$star_value = $full.$half_empty.$empty.$empty.$empty;
		} else if ($r == 4) {
			$star_value = $full.$full.$empty.$empty.$empty;
		} else if ($r == 5) {
			$star_value = $full.$full.$half_empty.$empty.$empty;
		} else if ($r == 6) {
			$star_value = $full.$full.$full .$empty.$empty;
		} else if ($r == 7) {
			$star_value = $full.$full.$full.$half_empty.$empty;
		} else if ($r == 8) {
			$star_value = $full.$full.$full.$full.$empty;
		} else if ($r == 9) {
			$star_value = $full.$full.$full.$full.$half_empty;
		} else if ($r == 10) {
			$star_value = $full.$full.$full.$full.$full;
		} else { 
			$star_value = $empty.$empty.$empty.$empty.$empty;
		}
		
		return '<span class="font_awesome_star_rank">' .$star_value.'</span>';
    }
    
    /**
     * Displays the data on the publish page
     * 
     * @access public
     * @param $data The cell data
	 *
     */
    public function display_cell($data)
    {
        if (!isset($this->EE->session->cache[__CLASS__]['font_awesome_star_rank'])) {
            $this->EE->cp->add_to_head('<script type="text/javascript" src="' . URL_THIRD_THEMES . 'font_awesome_star_rank/js/jquery-ui-1.8.5.custom.min.js"></script>');
            $this->EE->cp->add_to_head('<script type="text/javascript">font_awesome_star_rank = {}; </script>');
            $this->EE->cp->add_to_head('<script type="text/javascript" src="' . URL_THIRD_THEMES . 'font_awesome_star_rank/js/jquery.ui.stars.min.js"></script>');
            $this->EE->cp->add_to_head('<link rel="stylesheet" type="text/css" href="' . URL_THIRD_THEMES . 'font_awesome_star_rank/css/ui.stars.css" />');
            $this->EE->cp->add_to_foot('<script type="text/javascript" src="' . URL_THIRD_THEMES . 'font_awesome_star_rank/js/font_awesome_star_rank.js"></script>');
			$this->EE->cp->add_to_head('<link rel="stylesheet" type="text/css" href="' . URL_THIRD_THEMES . 'font_awesome_star_rank/font-awesome/css/font-awesome.min.css" />');
			$this->EE->cp->add_to_head('<script type="text/javascript" src="' . URL_THIRD_THEMES . 'font_awesome_star_rank/js/font_awesome_star_rank-liveupdate.js"></script>');
            $this->EE->session->cache[__CLASS__]['font_awesome_star_rank'] = true;
        }
        ;
        
        $prefix      = 'font_awesome_star_rank';
        $split       = (isset($this->settings[$prefix . '_split'])) ? $this->settings[$prefix . '_split'] : '2';
        $stars_count = (isset($this->settings[$prefix . '_field_stars'])) ? $this->settings[$prefix . '_field_stars'] : '5';
			
		$val = isset($this->row_id) ? 'row_id_'.$this->row_id : '0';

		$name = $this->field_id.'_'.$val.'_'.$this->col_id;

		
        $r    = "";
        $css  = "";
        
        $r = "<p><div class=\"font_awesome_star_rank star_rank\" style='padding-left:10px;'><select class=\"font_awesome_star_rank\" name=\"$this->cell_name\">";
        for ($i = 1; $i <= $stars_count * $split; $i++) {
            $selected = ($i == $data) ? " selected=\"true\"" : "";
            $r .= "<option value=\"$i\"$selected>$i</option>";
        }
        
        $r .= "</select>";
        
        $this->EE->cp->add_to_foot('<script type="text/javascript">$(".font_awesome_star_rank").stars({inputType: "select", split: ' . $split . '});</script>');
               
        $r .= '</div></p>';
        
        return $r;
    }
    
    /**
     * Display Cell Settings
     * 
     * @access public
     * @param $cell_settings array The cell settings
     * @return array Label and form inputs
     */
    public function display_cell_settings($cell_settings)
    {
        $prefix = 'font_awesome_star_rank';
        
        $field_stars = 5;
        $field_split = 2;
        $out         = "";
		$field_empty_star_icon = (empty($cell_settings[$prefix . '_field_empty_star_icon']) OR $cell_settings[$prefix . '_field_empty_star_icon'] == '') ? 'star-empty' : $cell_settings[$prefix . '_field_empty_star_icon'];
		$field_half_star_icon = (empty($cell_settings[$prefix . '_field_half_star_icon']) OR $cell_settings[$prefix . '_field_half_star_icon'] == '') ? 'star-half-empty' : $cell_settings[$prefix . '_field_half_star_icon'];
		$field_full_star_icon = (empty($cell_settings[$prefix . '_field_full_star_icon']) OR $cell_settings[$prefix . '_field_full_star_icon'] == '') ? 'star' : $cell_settings[$prefix . '_field_full_star_icon'];
        
 	/**
     * Matrix Options Values
     * For use with Font Awesome 3.1.1 and above
	 * Locked down for 5 stars with a spit of 2 for the time being
    **/        
        $out .= '<p>The options are fixed values.<br />There are five (5) stars available<br />with a split value of two (2).<br />(i.e.; 1 Star, 1.5 Stars, etc...)</p><table class="matrix-col-settings" border="0" cellpadding="0" cellspacing="0"><tbody><tr class=" matrix-first">';
        $out .= '<th class="matrix-first">Stars Available</th><td class="matrix-last">Fixed (5 Stars)<div style="display:none;">' . $this->select_list($prefix . '_field_stars', $field_stars) . '</div></td></tr>';
        $out .= '<tr class=" matrix-last"><th class="matrix-first">Split Value</th><td class="matrix-last">Fixed (Split of 2)<div style="display:none;">' . $this->select_list($prefix . 'field_split', $field_split) . '</div></td></tr></div>';
		$out .= '<tr class=" matrix-last"><th class="matrix-first">Empty Star Icon</th><td class="matrix-last">' . $this->input_value($prefix . '_field_empty_star_icon', $field_empty_star_icon) . '</td></tr>';
		$out .= '<tr class=" matrix-last"><th class="matrix-first">Half Star Icon</th><td class="matrix-last">' . $this->input_value($prefix . '_field_half_star_icon', $field_half_star_icon) . '</td></tr>';
		$out .= '<tr class=" matrix-last"><th class="matrix-first">Full Star Icon</th><td class="matrix-last">' . $this->input_value($prefix . '_field_full_star_icon', $field_full_star_icon) . '</td></tr>';    
		$out .= '<tr class=" matrix-last"><th class="matrix-first">Include Font-Awesome Plugin Tag</th><td class="matrix-last">{exp:font_awesome_star_rank_css}</td></tr></tbody></table>';
		
        return $out;
    }
    // --------------------------------------------------------------------

	/**
	 * Display Global Settings
	 */
	function display_global_settings()
	{
		$license_key = isset($this->settings['license_key']) ? $this->settings['license_key'] : '';

		// load the language file
		$this->EE->lang->loadfile('font_awesome_star_rank');

		// load the table lib
		$this->EE->load->library('table');

		// use the default template known as
		// $cp_pad_table_template in the views
		$this->EE->table->set_template(array(
			'table_open'    => '<table class="mainTable padTable" border="0" cellspacing="0" cellpadding="0">',
			'row_start'     => '<tr class="even">',
			'row_alt_start' => '<tr class="odd">'
		));

		$this->EE->table->set_heading(array('data' => lang('preference'), 'style' => 'width: 50%'), lang('setting'));

		$this->EE->table->add_row(
			lang('license_key', 'license_key'),
			form_input('license_key', $license_key, 'id="license_key" size="40"')
		);
		$this->EE->table->add_row('Created By', 'John C. Derrick');
		$this->EE->table->add_row('Optional Plugin Tag Use', '{exp:font_awesome_star_rank_css}');


		return $this->EE->table->generate();
	}

	/**
	 * Save Global Settings
	 */
	function save_global_settings()
	{
		return array(
			'license_key' => isset($_POST['license_key']) ? $_POST['license_key'] : ''
		);
	}


	// --------------------------------------------------------------------
    
	 /**
     * Options Values
     * For use with Font Awesome 3.1.1 or higher
     **/
	 
    function display_settings($data)
    {
        if (!isset($this->cache[$this->addon_name]['header-settings'])) {
			$this->EE->cp->add_to_head('<link rel="stylesheet" type="text/css" href="' . URL_THIRD_THEMES . 'font_awesome_star_rank/font-awesome/css/font-awesome.min.css" />');
			$this->EE->cp->add_to_head('<script type="text/javascript" src="' . URL_THIRD_THEMES . 'font_awesome_star_rank/js/font_awesome_star_rank-liveupdate.js"></script>');
            $this->cache[$this->addon_name]['header-settings'] = true;
        }
	
		$prefix = 'font_awesome_star_rank';
        
        $field_stars = (empty($data[$prefix . '_field_stars']) OR $data[$prefix . '_field_stars'] == '') ? 5 : $data[$prefix . '_field_stars'];
        $field_split = (empty($data[$prefix . '_split']) OR $data[$prefix . '_split'] == '') ? 2 : $data[$prefix . '_split'];
		
		$field_empty_star_icon = (empty($data[$prefix . '_field_empty_star_icon']) OR $data[$prefix . '_field_empty_star_icon'] == '') ? 'star-empty' : $data[$prefix . '_field_empty_star_icon'];
		$field_half_star_icon = (empty($data[$prefix . '_field_half_star_icon']) OR $data[$prefix . '_field_half_star_icon'] == '') ? 'star-half-empty' : $data[$prefix . '_field_half_star_icon'];
		$field_full_star_icon = (empty($data[$prefix . '_field_full_star_icon']) OR $data[$prefix . '_field_full_star_icon'] == '') ? 'star' : $data[$prefix . '_field_full_star_icon'];
		
        $this->EE->table->add_row('Stars', $this->select_list($prefix . '_field_stars', $field_stars));
        $this->EE->table->add_row('Split', $this->select_list($prefix . '_split', $field_split));		
		$this->EE->table->add_row('Empty Star Icon', $this->input_value($prefix . '_field_empty_star_icon', $field_empty_star_icon));
		$this->EE->table->add_row('Half Star Icon', $this->input_value($prefix . '_field_half_star_icon', $field_half_star_icon));
		$this->EE->table->add_row('Full Star Icon', $this->input_value($prefix . '_field_full_star_icon', $field_full_star_icon));
		$this->EE->table->add_row('Reference', 'Font Awesome: <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">View all icons &rarr;</a>');
		$this->EE->table->add_row('Include Font-Awesome Plugin Tag', '{exp:font_awesome_star_rank_css}');
	
    }
    /**/
	
	// This function is currently fixed at a set value, so we've hidden the select menus for now.
    function select_list($field_name, $data)
    {
        $r = 'Fixed Value<div style="display:none;"><select name="' . $field_name . '" >';
        for ($i = 1; $i <= 30; $i++) {
            $selected = ($i == $data) ? " selected=\"true\"" : "";
            $r .= "<option value=\"$i\"$selected>$i</option>";
        }
        $r .= "</select></div>";
        return $r;    
	}
	
	// Let's input the Font Awesome icons and display their live values
    function input_value($field_name, $data)
    {
        $r = '<strong>icon-</strong><input class="starinput ' . $field_name . '" name="' . $field_name . '"';
			$r .= " value=\"$data\" ";
        $r .= " /> <span style=\"font-size:18px;padding:0 10px;color:#333;\" id=\"$field_name\"><i class=\"icon-$data\"></i></span> <span style=\"color:#666\">(live preview)";
        return $r;
	}	
	
    // --------------------------------------------------------------------
    function install()
    {
        return array(
            'font_awesome_star_rank_field_stars' => '5'
        );
        return array(
            'font_awesome_star_rank_field_split' => '2'
        );
		return $font_awesome_star_rank_field_empty_star_icon;
		return $font_awesome_star_rank_field_half_star_icon;
		return $font_awesome_star_rank_field_full_star_icon;
    }
    
	/**
	 * Display Variable Settings
	 * @param array $data
	 */
	function display_var_settings($data)
	{
		return $this->_field_settings($data);
	}
	
    function save_settings($settings)
    {
        return array(
            'font_awesome_star_rank_field_stars' => $this->EE->input->post('font_awesome_star_rank_field_stars'),
            'font_awesome_star_rank_split' => $this->EE->input->post('font_awesome_star_rank_split'),
			'font_awesome_star_rank_field_empty_star_icon' => $this->EE->input->post('font_awesome_star_rank_field_empty_star_icon'),
			'font_awesome_star_rank_field_half_star_icon' => $this->EE->input->post('font_awesome_star_rank_field_half_star_icon'),
			'font_awesome_star_rank_field_full_star_icon' => $this->EE->input->post('font_awesome_star_rank_field_full_star_icon')
        );
    
	return $settings;
	
	}
	
    // --------------------------------------------------------------------

	/**
	 * Save LV Settings
	 */
	function save_var_settings($settings)
	{
		return array(
            'font_awesome_star_rank_field_stars' => $this->EE->input->post('font_awesome_star_rank_field_stars'),
            'font_awesome_star_rank_split' => $this->EE->input->post('font_awesome_star_rank_split'),
			'font_awesome_star_rank_field_empty_star_icon' => $this->EE->input->post('font_awesome_star_rank_field_empty_star_icon'),
			'font_awesome_star_rank_field_half_star_icon' => $this->EE->input->post('font_awesome_star_rank_field_half_star_icon'),
			'font_awesome_star_rank_field_full_star_icon' => $this->EE->input->post('font_awesome_star_rank_field_full_star_icon')
        );
	}
	
	/**
	 * Display Var
	 */
	function display_var_field($data)
	{
		return $this->display_field($data);
	} 
}

// END font_awesome_star_rank_ft class

/* End of file ft.font_awesome_star_rank.php */
/* Location: ./expressionengine/third_party/font_awesome_star_rank/ft.font_awesome_star_rank.php */