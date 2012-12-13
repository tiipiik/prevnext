<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Simple Previous / Next navigation between single blog posts.
 * 
 * @author  	Daniel Bough
 * @website		http://www.danielbough.com
 */
class Widget_Prevnext extends Widgets
{
	/**
	 * The widget title
	 *
	 * @var array
	 */
	public $title = 'PrevNext';

	/**
	 * The translations for the widget description
	 *
	 * @var array
	 */
	public $description = array(
		'en' => 'Simple single post navigation.'
	);
	
	/**
	 * The author of the widget
	 *
	 * @var string
	 */
	public $author = 'Daniel Bough';

	/**
	 * The author's website.
	 * 
	 * @var string 
	 */
	public $website = 'http://www.danielbough.com';

	/**
	 * The version of the widget
	 *
	 * @var string
	 */
	public $version = '1.1';

	/**
	 * The fields for customizing the options of the widget.
	 *
	 * @var array 
	 */
	public $fields = array(

	);
	
	public function format_url($slug, $unixtime) {
		$year = date('Y', $unixtime);
		$month = date('m', $unixtime);
		$url = site_url("blog/$year/$month/$slug");
		return $url;
	}
	
	/**
	 * The main function of the widget.
	 *
	 * @param array $options The options for displaying a PrevNext widget.
	 * @return array 
	 */
	public function run($options)
	{
		if (empty($options['html']))
		{
			$slug = end($this->uri->segments);
		
			//Get ID of current post
			$idquery = $this->db->query("SELECT id FROM default_blog WHERE slug = '$slug' and status = 'live'");
			$idrow = $idquery->row();
			$id = isset($idrow->id) ? $idrow->id : 0;
			
			//Get previous url
			$prevurlquery = $this->db->query("SELECT slug, created_on FROM default_blog WHERE id < '$id' and status = 'live' ORDER BY id desc LIMIT 1");
			$purow = $prevurlquery->row();
			$prev_url = isset($purow->slug) ? $this->format_url($purow->slug, $purow->created_on) : '';
			
			//Get previous title
			$prevtitlequery = $this->db->query("SELECT title FROM default_blog WHERE id < '$id' and status = 'live' ORDER BY id desc LIMIT 1");
			$ptrow = $prevtitlequery->row();
			$prev_title = isset($ptrow->title) ? $ptrow->title : '';
			
			//Get next url
			$nexturlquery = $this->db->query("SELECT slug, created_on FROM default_blog WHERE id > '$id' and status = 'live' ORDER BY id asc LIMIT 1");
			$nurow = $nexturlquery->row();
			$next_url = isset($nurow->slug) ? $this->format_url($nurow->slug, $nurow->created_on) : '';
	
			//Get next title
			$nexttitlequery = $this->db->query("SELECT title FROM default_blog WHERE id > '$id' and status = 'live' ORDER BY id asc LIMIT 1");
			$ntrow = $nexttitlequery->row();
			$next_title = isset($ntrow->title) ? $ntrow->title : '';
			
			return array(
			'id' => $id,
			'prev_url' => $prev_url,
			'prev_title' => $prev_title,
			'next_url' => $next_url,
			'next_title' => $next_title
			);
		}
		
		

		// Display vars
		return array(
			'output' => $this->parser->parse_string($options['html'], NULL, TRUE),
		);
	}

}
