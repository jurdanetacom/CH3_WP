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
function total($url){
    return ch3_get_tweets($url) + ch3_get_shares($url) + ch3_get_likes($url) + ch3_get_plusones($url); 
}



function ch3_share_post(){ ?>
    <div class="compartirsingle row">
        <div class="mascompartir large-3 medium-3 small-6 columns">
            <p style="padding:0 .5em;">¡Compartido <strong><?php $urlpost = get_the_permalink(); echo total($urlpost) ?></strong> veces!</p>
        </div>
        <div class="gp large-3 medium-3 small-6 columns">
            <div class="g-plus" data-action="share" data-annotation="vertical-bubble" data-height="60"></div>
        </div>
        <div class="fb large-3 medium-3 small-6 columns">
            <div class="fb-share-button" data-href="<?php echo get_permalink(); ?>" data-width="80" data-type="box_count"></div>
        </div>
        <div class="tw large-3 medium-3 small-6 columns">
            <a href="https://twitter.com/share" class="twitter-share-button" data-count="vertical" data-url="<?php the_permalink(); ?>" data-via="notilogia" data-lang="es">Twittear</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
        </div>
    </div>
<?php }



?>