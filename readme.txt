=== Lameda ===
Contributors: dlo
Donate link:
Tags: images, image, pictures, picture, photo, photos, exif, metadata, attachment, gallery
Requires at least: 2.5
Tested up to: 2.5
Stable tag: 0.1.5

Display attachment's metadata, like picture's EXIF, within your posts.

== Description ==

LAMEDA stands for List Attachment MEtaDAta. This function can be used as a shortcode included in the text or a template tag to display the metadata of an attachment, like EXIFs of a picture. WordPress 2.5 will extract all the EXIF data of the pictures you upload and Lameda will display them easily.

Lameda requires at least WP 2.5 (or up). It is compatible with all versions of WordPress up to the latest release (2.5.1).
 
== Installation ==

1. Download the file. 
1. unzip and drop all the files, (within the lameda directory - including the subdirectories) as is, in your plugins/lameda directory. 
1. Enable the plugin in the WP Admin >> Plugins section. 
1. Insert the shortcode [lameda] and its attributes in the text of a page or modify the template tag in the template files.
 
(Note: if you are upgrading from a previous install, simply overwrite the older files with the new ones following the instructions above.)

Lameda is delivered in English and French but can be easily used with other languages. You just have to create a file lameda-xx_YY.po (xx_YY being the language code of your WordPress settings. Eg: fr_FR for French) from the existing file lameda.pot using PoEdit. Then, just translate the text strings located after the "msgid" tag and put the translated string after the "msgstr" tag.

The resulting PpP-xx_YY.mo file has to stored in the "languages" directory of Lameda.

== Documentation ==

**1) Using shortcode [lameda]**

The shortcode [lameda] can be used to display the metadata of an attachment. It has to be inserted in the text of a page as [lameda attribute1="value1" attribute2="value2"].

Available attributes are:

+ **id:** ID of the attachment whose metadata are going to be displayed. If id is not provided, the plugin will display the current post's metadata. 
+ **info:** Display options for the metadata. Possible values:
 
	all : All available metadata are displayed. (Default value) 

	name-of-metadata : Only the named metadata will be displayed. Available values (not exhaustive):
 
		image_meta : Image informations, EXIFs… 
		width : Image's width 
		height : Image's height 
		file : Image's full path on server 
		sizes : Various sizes of the image
 
The shortcode will be replaced by a table (with class="dlo_lameda") that can be styled with CSS.

Things must be done like this:

1. Write a post.
1. Upload a picture in the post using the button "Add a picture".
1. Find the id of the newly created attachment looking at the number located at the end of the class wp-image-xx (wp-image-10, for instance) given to the picture, in the HTML tab.
1. 4) Modify the text of the post and include the shortcode [lameda] where the metadata have to be displayed. Example:
[lameda id=10 info="image_meta"] will display the EXIFs of the image whose attachment id is 10 in the post.

**2) Using shortcode [lameda_exif]**

The shortcode [lameda-exif] is meant to display metadata of an image attached to a post. EXIF and ITPC informations stored by WordPress when the image is loaded will be displayed in the chosen order. It has to be inserted in the text of a post as [lameda_exif attribute1="value1" attribute2="value2"].

Available attributes are:

+ **id:** ID of the attachment whose metadata are going to be displayed. If id is not provided, the plugin will display the current post's metadata. 
+ **info:** Display options for EXIF data. Possible values:
 
	all : All available metadata are displayed. (Default value)
 
	metadata list : Informations from image_meta metadata whose names are listed are displayed in the specified order. The list must be comma separated. Available values :
 
		aperture : Diaphragm's aperture 
		credit : Text for credit 
		camera : Brand and model of the camera 
		caption: Text 
		created_timestamp : Shooting date 
		copyright : Informations of copyright 
		focal_length: Objective used 
		iso: ISO sensibility 
		shutter_speed: Shutter speed 
		title: Photo's title
 
The shortcode will be replaced by a table (with class="dlo_lameda") that can be styled with CSS.

Things must be done like this:

1. Write a post.
1. Upload a picture in the post using the button "Add a picture".
1. Find the id of the newly created attachment looking at the number located at the end of the class wp-image-xx (wp-image-10, for instance) given to the picture, in the HTML tab.
1. Modify the text of the post and include the shortcode [lameda_exif] where the metadata have to be displayed. Example:
[lameda_exif id=10 info="title,camera,focal_length,iso,aperture,shutter_speed"] will display the title, camera's model, lens used, film, aperture and shutter speed of the image whose attachment id is 10 in the post.

**3) Using template tag lameda()**

The function lameda() can be used to display the metadata of an attachment. It has to be inserted in the template files of the theme as lameda ('info', 'id'). It's easier and better to use this tag in templates dedicated to attachments like attachment.php, image.php, pdf.php, etc…  

Valid parameters are:

+ **id:** ID of the attachment whose metadata are going to be displayed. If id is not provided, the plugin will display the current post's metadata. 
+ **info:** Display options for the metadata. Possible values:
 
	all : All available metadata are displayed. (Default value)
 
	name-of-metadata : Only the named metadata will be displayed. Available values (not exhaustive):
 
		image_meta : Image informations, EXIFs… 
		width : Image's width 
		height : Image's height 
		file : Image's full path on server 
		sizes : Various sizes of the image 

The function will  generate a table (with class = "dlo_lameda")  that can be styled with CSS.

Things must be done like this:

1.Modify the template files using this model:

	<?php get_header(); ?>
	<div id="content" class="widecolumn">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="post" id="post-<?php the_ID(); ?>">
	<h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> » <?php the_title(); ?></h2>
	<div class="entry">
	<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'medium' ); ?></a></p>
	// ----------------------------
	<?php lameda('image_meta') ?>
	// ----------------------------
	<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); // this is the "caption" ?></div>
	<?php the_content('<p class="serif">Read the rest of this entry »</p>'); ?>
	<div class="navigation">
	<div class="alignleft"><?php previous_image_link() ?></div>
	<div class="alignright"><?php next_image_link() ?></div>
	</div><br class="clear" />
	<?php endwhile; else: ?>
	<p>Sorry, no attachments matched your criteria.</p>
	<?php endif; ?>
	</div>
	<?php get_footer(); ?>
1. Write a post.
1. Upload a photo in this post using the button "Add a picture".
1. Insert this picture in the post selecting "Link to page" to add a link that will use the attachment template. 
1. When the post is displayed, click on the picture to open a new page that will display the photo and the EXIF informations.

**4) Using template tag lameda_exif()**

The function lameda_exif() is meant to display metadata of an image attached to a post. EXIF and ITPC informations stored by WordPress when the image is loaded will be displayed in the chosen order. It has to be inserted in the template files of the theme as lameda_exif ('info', 'id'). It's easier and better to use this tag in templates dedicated to attachments like attachment.php, image.php, pdf.php, etc…  

Valid parameters are:

+ **id:** ID of the attachment whose metadata are going to be displayed. If id is not provided, the plugin will display the current post's metadata. 
+ **info:** Display options for EXIF data. Possible values:
 
	all : All available metadata are displayed. (Default value)
 
	metadata list : Informations from image_meta metadata whose names are listed are displayed in the specified order. The list must be comma separated. Available values :
 
		aperture : Diaphragm's aperture 
		credit : Text for credit 
		camera : Brand and model of the camera 
		caption: Text 
		created_timestamp : Shooting date 
		copyright : Informations of copyright 
		focal_length: Objective used 
		iso: ISO sensibility 
		shutter_speed: Shutter speed 
		title: Photo's title 

The function will generate a table (with class="dlo_lameda") that can be styled with CSS.

Things must be done like this:

1.Modify the template files using this model:

	<?php get_header(); ?>
	<div id="content" class="widecolumn">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="post" id="post-<?php the_ID(); ?>">
	<h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> » <?php the_title(); ?></h2>
	<div class="entry">
	<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'medium' ); ?></a></p>
	// ----------------------------
	<?php lameda_exif('title,camera,focal_length,iso,aperture,shutter_speed') ?>
	// ----------------------------
	<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); // this is the "caption" ?></div>
	<?php the_content('<p class="serif">Read the rest of this entry »</p>'); ?>
	<div class="navigation">
	<div class="alignleft"><?php previous_image_link() ?></div>
	<div class="alignright"><?php next_image_link() ?></div>
	</div><br class="clear" />
	<?php endwhile; else: ?>
	<p>Sorry, no attachments matched your criteria.</p>
	<?php endif; ?>
	</div>
	<?php get_footer(); ?>
1. Write a post.
1. Upload a photo in this post using the button "Add a picture".
1. Insert this picture in the post selecting "Link to page" to add a link that will use the attachment template. 
1. When the post is displayed, click on the picture to open a new page that will display the photo and the selected EXIF informations:  title, camera's model, lens used, film, aperture and shutter speed of the image.

== History ==

**v. 0.1.5**

  Replace Shortcode [lameda-exif] by [lameda_exif] as WP 2.5.1 modified the handling of shortcodes

**V.0.1.4**

  Bug corrected - Suppress a warning msg displayed in case of invalid metadata

**V.0.1.3**

  Plugin can be translated using .po file - French translation supplied 

**V. 0.1.2**

  Added function to display a picture's EXIF informations 

**V. 0.1.1**

  metadata table generated with class="dlo_lameda" and th/td html tags for easier styling with CSS

**V. 0.1.0**

  Initial version

