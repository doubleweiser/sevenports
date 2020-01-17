<?php
namespace AutoLoadPosts;

class RelatedPostsWidget extends \WP_Widget
{
	public function init()
	{
		add_action('widgets_init', array($this, 'register_widget'));
	}
	
	public function register_widget()
	{
		register_widget(__CLASS__);
	}
	
	function __construct()
	{
		$widgetId = 'alp-related-posts';
		$widgetName = __('Related Posts', ALP_PLUGIN_DOMAIN);
		$widgetOptions = array(
			'description' => __('Widget displays related posts.', ALP_PLUGIN_DOMAIN),
		);
		parent::__construct($widgetId, $widgetName, $widgetOptions);
	}

	function widget($args, $instance)
	{
		global $post;
		$title = $instance['title'];
		$postsCount = $instance['posts_count'];
		
		if(!is_single())
			return;
		
		$currentCategories = get_the_category();
		
		if(!$currentCategories)
			return;
		
		//get posts from that category
		$relatedPosts = get_posts(array(
			'category' => $currentCategories[0]->cat_ID,
			'posts_per_page' => ($postsCount>0 ? $postsCount-1 : $postsCount),
			'exclude' => $post->ID,
		));
		
		if(!$relatedPosts)
			return;
		
		//render widget
		echo $args['before_widget'];
		?>
		<div class="alp-related-posts-wrapper">
		<?php
		if($title)
		{
			echo $args['before_title'] .
				$title .
				$args['after_title'];			
		}
		?>
			<div class="alp-related-posts">
		
		<?php
		//display current post as first
		echo $this->getPostHTML($post, true);
		?>
		<div class="alp-advert">
			<img src="http://www.mvpthemes.com/zoxnews/wp-content/uploads/2017/07/zox300.png" />
		</div>
		<?php
		//display related posts
		foreach($relatedPosts as $relatedPost)
			echo $this->getPostHTML($relatedPost);
		?>
			</div>
		</div>
		<?php
		echo $args['after_widget'];
	}
	
	function getPostHTML($post, $current = false)
	{
		ob_start();
		?>
		<div class="alp-related-post post-<?php echo $post->ID; ?> <?php echo ($current ? 'current' : ''); ?>" data-id="<?php echo $post->ID; ?>" data-document-title="">
		<?php
		$postThumbnailUrl = get_the_post_thumbnail_url($post->ID, 'thumbnail');
		if($postThumbnailUrl)
		{
		?>
			<a class="featured-image-link" href="<?php echo get_permalink($post->ID); ?>">
				<img class="featured-image" src="<?php echo $postThumbnailUrl ?>"/>
			</a>
			<?php
				}
			?>
			<div class="post-details">
				<p class="post-meta">
					<?php
					$postCategories = get_the_category($post->ID);
					if($postCategories)
					{
						foreach($postCategories as $postCategory)
						{
						?>
							<a class="post-category" href="<?php echo get_category_link($postCategory->term_id); ?>"><?php echo $postCategory->name; ?></a>
						<?php
						}
					}
					?>
				</p>
				<a class="post-title" href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a>
			</div>
			<div class="mvp-alp-soc-wrap">
				<ul class="mvp-alp-soc-list">
					<a href="#" onclick="window.open('http://www.facebook.com/sharer.php?u=<?php the_permalink($post->ID);?>&amp;t=<?php the_title_attribute(array('post'=>$post->ID)); ?>', 'facebookShare', 'width=626,height=436'); return false;" title="<?php esc_html_e( 'Share on Facebook', 'jawn' ); ?>">
						<li class="mvp-alp-soc-fb"><span class="fab fa-facebook"></span></li>
					</a>
					<a href="#" onclick="window.open('http://twitter.com/share?text=<?php the_title_attribute(array('post'=>$post->ID)); ?> &amp;url=<?php the_permalink($post->ID) ?>', 'twitterShare', 'width=626,height=436'); return false;" title="<?php esc_html_e( 'Tweet This Post', 'jawn' ); ?>">
						<li class="mvp-alp-soc-twit"><span class="fab fa-twitter"></span></li>
					</a>
					<a href="#" onclick="window.open('http://pinterest.com/pin/create/button/?url=<?php the_permalink($post->ID);?>&amp;media=<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'mvp-large-thumb' ); echo esc_url($thumb['0']); ?>&amp;description=<?php the_title_attribute(array('post'=>$post->ID)); ?>', 'pinterestShare', 'width=750,height=350'); return false;" title="<?php esc_html_e( 'Pin This Post', 'jawn' ); ?>">
						<li class="mvp-alp-soc-pin"><span class="fab fa-pinterest-p"></span></li>
					</a>
					<a href="mailto:?subject=<?php the_title_attribute(array('post'=>$post->ID)); ?>&amp;BODY=<?php esc_html_e( 'I found this article interesting and thought of sharing it with you. Check it out:', 'jawn' ); ?> <?php the_permalink($post->ID); ?>">
						<li class="mvp-alp-soc-com"><span class="fas fa-envelope"></span></li>
					</a>
				</ul>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}

	function update($new_instance, $old_instance)
	{
		$instance = array();
		$instance['title'] = (isset($new_instance['title']) ? strip_tags($new_instance['title']) : __('Related posts', ALP_PLUGIN_DOMAIN));
		$instance['posts_count'] = (isset($new_instance['posts_count']) ? strip_tags($new_instance['posts_count']) : -1);
		return $instance;
	}

	function form($instance)
	{
		$title = (isset($instance['title']) ? $instance['title'] : __('Related posts', ALP_PLUGIN_DOMAIN));
		$postsCount = (isset($instance['posts_count']) ? $instance['posts_count'] : -1);
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('posts_count'); ?>"><?php _e('Posts count (-1 for All):'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('posts_count'); ?>" name="<?php echo $this->get_field_name('posts_count'); ?>" type="text" value="<?php echo esc_attr($postsCount); ?>" />
		</p>
		<?php 
	}
}