<?php

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



function ch3_share_post(){ ?>
	<div class="sharing">
		<div class="small-3 columns fb">
			<a target="_blank" href="javascript:window.location=%22http://www.facebook.com/sharer.php?u=%22+encodeURIComponent(document.location)+%22&#38;t=%22+encodeURIComponent(document.title)" title="Compartir en facebook"><span class="icon-facebook"></span><span class="hide-for-small">Compartir</span></a>
		</div>
		<div class="small-3 columns tw">
			<a class="top_social" href="javascript:window.location=%22https://twitter.com/share?url=%22+encodeURIComponent(document.location)+%22&text=%22+encodeURIComponent(document.title)"><span class="icon-twitter"></span><span class="hide-for-small">Tweet</span></a>
		</div>
		<div class="small-3 columns gp">
			<a href="https://plusone.google.com/_/+1/confirm?hl=en&url=<?php if(is_home()){echo home_url();}else{the_permalink();} ?>" target="_blank" title="Compartir este artículo en Google Plus"><span class="icon-googleplus"></span><span class="hide-for-small">Google +1</span></a>
		</div>
		<div class="small-3 columns shared">
			<span><span class="triangulocompartir"></span>  <?php echo ch3_total_shares(get_the_permalink()) ?> </span>
		</div>
	</div>
<?php }

function breadcrumb_links() {
    if (!is_home()) {
        echo '<nav class="breadcrumbs" title="'.get_bloginfo('description').'">';
        echo '<a href="'.get_bloginfo('wpurl').'">';bloginfo('name');
        echo "</a>  ";
        if (is_category() || is_single()) {
            the_category();
            if (is_single()) {
                echo '<a href="'.get_permalink().'" class="current">';
                the_title();
                echo "</a>";
            }
        } elseif (is_page()) {
            echo '<a href="'.get_permalink().'" class="current">';
            echo the_title().'</nav>';
            echo "</a>";
        }
        echo "</nav>";
    }
}

?>