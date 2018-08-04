<?php
/**
 * FooGallery JPEG Junkyard gallery template
 * This is the template that is run when a FooGallery shortcode is rendered to the frontend
 */

global $current_foogallery;
global $current_foogallery_arguments;

/**
 * Add rel=lightbox and otherss
 */

// if (!function_exists('modify_html_attrs')) {
//     function modify_html_attrs($attr, $args, $obj)
//     {
//         return array_merge($attr, array('rel'=>'lightbox'));
//     }
// }

// add_filter('foogallery_attachment_html_link_attributes', 'modify_html_attrs',10,3);


/**
 * Build list of vol. ??? links for left side
 */
if (!function_exists('get_gallery_menu')) {
    function get_gallery_menu($galleries, $cgid)
    {
        $html = "";
        foreach ($galleries as $g) {
            $id = $g->ID;
            $vol = substr($g->name, 2, 99);
            $active_class = ($id == $cgid) ? 'active' : '';
            $link = "<a href='?vol=$id'>Vol. $vol</a>";
            $wrapper = "<div class='jj-menu-item $active_class' data-id='$id' data-cgid='$cgid'>$link</div>";
            $html .= $wrapper;
        }

        return $html;
    }
}

/**
 * Build html elements for thumbnail section
 */
if (!function_exists('get_gallery_items')) {
    function get_gallery_items($gallery, $args)
    {
        $html = "";
        foreach ($gallery->attachments() as $attachment) {
            $html .= '<div class="jj-gallery-item">';
            $html .= '<a href="' . $attachment->url . '" title=" ' . $attachment->caption . ' " class="lightbox" rel="lightbox"></a>';
            $html .= $attachment->html($args);
            $html .= '</div>';
        }

        return $html;
    }
}

/**
 * Get and sort all galleries named jj???
 */
$galleries = foogallery_get_all_galleries();
$galleries = array_filter($galleries, function ($g) {
    return substr($g->name, 0, 2) == "jj";
});

usort($galleries, function ($a, $b) {
    return strcmp($a->name, $b->name);
});

/**
 * Defalut to the first gallery in the list
 */
$current_foogallery = $galleries[0];

/**
 * If gallery ID in query string, use that one
 */
if (isset($_GET["vol"])) {
    $current_foogallery = FooGallery::get_by_id($_GET["vol"]);
}

/**
 * Get arguments to pass to FooGallery when building thumbnails
 */

$args = array(
    'width'=>300,
    'height'=>533,
    'crop'=>1
);

/**
 * Build our HTML elements
 */
$volumes = get_gallery_menu($galleries, $current_foogallery->ID);
$thumbnails = get_gallery_items($current_foogallery, $args);
$attachments = $current_foogallery->attachments();
$initial_image = $attachments[0]->url;

/**
 * Some HTML tag stuff for rendering
 */
$gallery_attr_id = 'foogallery-gallery-' . $current_foogallery->ID;
$gallery_attr_class = 'foogallery';

?>

<div class="jj-container">
	<div class="jj-albums">
		<div>
			<?=$volumes?>
		</div>
	</div>
	<div class="jj-preview">
		<div class="jj-image-container" style="background: url('<?=$initial_image?>') center center / cover;">
		</div>
	</div>
	<div class="jj-gallery">
		<div id="<?=gallery_attr_id?>" class="<?=$gallery_attr_class?>">
			<?=$thumbnails?>
		</div>
	</div>
</div>