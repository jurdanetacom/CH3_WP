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
}


//functions to count shares

function ch3_get_shares($url) {    
  $json_string = file_get_contents("http://www.linkedin.com/countserv/count/share?url=$url&format=json");
  $json = json_decode($json_string, true);
  return intval( $json['count'] );
}
function ch3_get_tweets($url) {

    $json_string = file_get_contents('http://urls.api.twitter.com/1/urls/count.json?url=' . $url);
    $json = json_decode($json_string, true);

    return intval( $json['count'] );
}

function ch3_get_likes($url) {

    $json_string = file_get_contents('http://graph.facebook.com/?ids=' . $url);
    $json = json_decode($json_string, true);

    return intval( $json[$url]['shares'] );
}

function ch3_get_plusones($url) {

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://clients6.google.com/rpc");
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $url . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    $curl_results = curl_exec ($curl);
    curl_close ($curl);

    $json = json_decode($curl_results, true);

    return intval( $json[0]['result']['metadata']['globalCounts']['count'] );
}
function ch3_total_shares($url){
    return ch3_get_tweets($url) + ch3_get_shares($url) + ch3_get_likes($url) + ch3_get_plusones($url); 
}









 ?>