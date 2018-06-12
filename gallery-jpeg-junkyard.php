<?php
/**
 * FooGallery JPEG Junkyard gallery template
 * This is the template that is run when a FooGallery shortcode is rendered to the frontend
 */

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

function get_gallery_items($gallery, $args)
{
    $html = "";
    foreach ($gallery->attachments() as $attachment) {
        $html .= '<div class="jj-gallery-item">' . $attachment->html($args) . '</div>';
    }

    return $html;
}

function filter_galleries($gallery)
{
    return substr($gallery->name, 0, 2) == "jj";
}

function gallery_cmp($a, $b)
{
    return strcmp($a->name, $b->name);
}

global $current_foogallery; // current loaded gallery
global $current_foogallery_arguments; // current shortcude args
$gallery = $current_foogallery;

// get list of galleries for menu
$galleries = foogallery_get_all_galleries();
$galleries = array_filter($galleries, 'filter_galleries');
usort($galleries, 'gallery_cmp');
$gallery = $galleries[0];

// does query string have a gallery ID?
$gid = isset($_GET["vol"]) ? $_GET["vol"] : null;

if (isset($gid)) {
    // override current gallery selection
    $gallery = FooGallery::get_by_id($gid);
}

// get our thumbnail sizing args
$args = foogallery_gallery_template_setting('thumbnail_size', 'thumbnail');

// override w/h
$args['height'] = 533;
$args['width'] = 300;

//add the link setting to the args
$args['link'] = foogallery_gallery_template_setting('thumbnail_link', 'image');

//get which lightbox we want to use
// $lightbox = foogallery_gallery_template_setting('lightbox', 'unknown');

// html attribtues for later
$html_id = 'foogallery-gallery-' . $gallery->ID;
$html_class = 'foogallery ';

$menu = get_gallery_menu($galleries, $gallery->ID);
$gallery_items = get_gallery_items($gallery, $args);
$image_start = $gallery->attachments()[0]->url;

?>

<div class="jj-container">
	<div class="jj-albums">
		<div>
			<?=$menu?>
		</div>
	</div>
	<div class="jj-preview">
		<div class="jj-image-container" style="background: url('<?=$image_start?>') center center / cover;">
		</div>
	</div>
	<div class="jj-gallery">
		<div id="<?=$html_id?>" class="<?=$html_class?>">
			<?=$gallery_items?>
		</div>
	</div>
</div>