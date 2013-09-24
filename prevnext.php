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
	
	public function format_url($slug, $datetime) {
		$date = explode('-',$datetime);
		$year = $date[0];
		$month = $date[1];
		
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
			$idquery = $this->db->query("select id,created from default_blog where slug='".$slug."' and status='live'");
			$idrow = $idquery->row();
			$id = isset($idrow->id) ? $idrow->id : 0;
			$currentPost = isset($idrow->created) ? $idrow->created : 0;
						
			//Get previous url and title
			$prevurlquery = $this->db->query("select created,title,slug from default_blog where created < '$currentPost' and status='live' order by created desc limit 1");
			$purow = $prevurlquery->row();
			$prev_url = isset($purow->slug) ? $this->format_url($purow->slug, $purow->created) : '';
			$prev_title = isset($purow->title) ? $purow->title : '';
			
			//Get next url and title
			$nexturlquery = $this->db->query("select created,title,slug from default_blog where created > '$currentPost' and status='live' order by created asc limit 1");
			$ntrow = $nexturlquery->row();
			$next_url = isset($ntrow->slug) ? $this->format_url($ntrow->slug, $ntrow->created) : '';
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