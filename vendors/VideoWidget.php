<?php

class Video{
    
    public function getSources(){

       $sources = array(
          'YouTube'     => array(
              'url'   => "http://www.youtube.com/v/::id::&autoplay=::autoplay::&loop=0&rel=0"
          ),

          'Vimeo'       => array(
              'url'   => "http://vimeo.com/moogaloop.swf?clip_id=::id::&amp;server=vimeo.com&amp;loop=0&amp;fullscreen=1&amp;autoplay=::autoplay::"
          ),

          'MySpace'     => array(
              'url'   => "http://mediaservices.myspace.com/services/media/embed.aspx/m=::id::,t=1,mt=video,ap=::autoplay::"
          ),

          'Veoh'        => array(
              'url'   => "http://www.veoh.com/static/swf/webplayer/WebPlayer.swf?version=AFrontend.5.4.2.20.1002&permalinkId=::id::&player=videodetailsembedded&id=anonymous&videoAutoPlay=::autoplay::"
          ),

          'Blip'        => array(
              'url'   => "http://blip.tv/play/::id::"
          ),

           'Viddler' => array(
               'url'        => "http://www.viddler.com/player/::id::",
               'flashvar1'  => "<param name=\"flashvars\" value=\"autoplay=t\" />",
               'flashvar2'  => 'flashvars="autoplay=t" '
           ),
           'DailyMotion' => array(
               'url' => "http://www.dailymotion.com/swf/::id::&autoStart=::autoplay::&related=0"
           ),
//           'Revver' => array(
//               'url' => "http://flash.revver.com/player/1.0/player.swf?mediaId=::id::&autoStart=::autoplay::"
//           ),
//           'Google' => array(
//               'url'        => "http://video.google.com/googleplayer.swf?docid=::id::&hl=en&fs=true"
//               //'flashvar2'  => 'FlashVars="autoPlay=true&playerMode=embedded"'
//           )
        );

        return $sources;
    }

    public function generate_video_options( $source, $title='', $caption='', $video_id='', $autoplay=0, $height, $width ){

        $options = array();
        $source_url = isset($source['url'])?$source['url']:'';
        $url = $this->build_video_url($source_url, $video_id, $autoplay);
        
        $options['title']     = $title;
        $options['caption']   = $caption;
        $options['url']       = $url;
        $options['height']    = $height;
        $options['width']     = $width;
        $options['flashvar']  = ( isset($source['flashvar1']))?$source['flashvar1']:'';
        $options['flashvar2'] = ( isset($source['flashvar2']))?$source['flashvar2']:'';
        
        return $options;
        
    }

    public function build_video_url( $unparsed_url, $video_id, $autoplay ){

        $url = $unparsed_url;
        $url = str_replace( '::id::', $video_id, $url);
        $url = str_replace( '::autoplay::', $autoplay, $url);

        return $url;
    }
}

?>
