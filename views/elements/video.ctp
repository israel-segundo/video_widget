<?php

    if( !isset($this->Layout->View->viewVars['video_object'])){
        echo '<br/><strong>Video Widget Plugin</strong><br/>';
        echo 'You must configure one video<br/><br/>';
    }else{

        $video = $this->Layout->View->viewVars['video_object'];

        $title    = $video['title'];
        $caption  = $video['caption'];
        $width    = $video['width'];
        $height   = $video['height'];
        $url      = $video['url'];
        $flashvar = $video['flashvar'];
        $flashvar2 = $video['flashvar2'];
?>
    <div id="video">
        <!--<div id="video_title">
            <?php //echo $title;?>
        </div>-->
        <div id="video_container">

            <object width="<?php echo $width?>" height="<?php echo $height;?>">

                <?php echo $flashvar;?>

                <param name="allowfullscreen" value="true" />
                <param name="allowscriptaccess" value="always" />
                <param name="movie" value="<?php echo $url;?>" />
                <param name="wmode" value="transparent">
                <embed src="<?php echo $url;?>"
                       type="application/x-shockwave-flash"
                       wmode="transparent"
                       allowfullscreen="true"
                       allowscriptaccess="always"

                       <?php echo $flashvar2;?>

                       width="<?php echo $width;?>" height="<?php echo $height;?>" />
            </object>
        </div>
    </div>
<?php }?>