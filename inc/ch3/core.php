<?php 


/** http://wordpress.stackexchange.com/questions/107358/make-wordpress-image-captions-responsive
 * Filter to replace the [caption] shortcode text with HTML5 compliant code
 *
 * @return text HTML content describing embedded figure
 **/

add_filter('img_caption_shortcode', 'ch3_img_caption_filter',10,3);
function ch3_img_caption_filter($val, $attr, $content = null)
{
    extract(shortcode_atts(array(
        'id'    => '',
        'align' => '',
        'width' => '',
        'caption' => ''
    ), $attr));

    if ( 1 > (int) $width || empty($caption) )
        return $val;

    $capid = '';
    if ( $id ) {
        $id = esc_attr($id);
        $capid = 'id="figcaption_'. $id . '" ';
        $id = 'id="' . $id . '" aria-labelledby="figcaption_' . $id . '" ';
    }

    return '<figure ' . $id . 'class="wp-caption ' . esc_attr($align) . '" style="width:'.$width.'px">'
    . do_shortcode( $content ) . '<figcaption ' . $capid 
    . 'class="wp-caption-text">' . $caption . '</figcaption></figure>';
} ?>