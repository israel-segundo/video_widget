<?php
    echo $html->css('/video_widget/css/main');
    echo $html->script('/video_widget/js/video_widget');

    $title    = isset($settings['title'])    ? $settings['title']: '';
    $video_id = isset($settings['video_id']) ? $settings['video_id']:'';
    $source   = isset($settings['source'])   ? $settings['source']: '';
    $caption  = isset($settings['caption'])  ? $settings['caption']:'undefined';
    $autoplay = isset($settings['autoplay']) ? $settings['autoplay']:0;
    $height   = isset($settings['height']) ? $settings['height'] : 200;
    $width    = isset($settings['width']) ? $settings['width'] : 300;
?> 

<script type="text/javascript">
    VideoWidget.initialize('<?php echo json_encode($sources); ?>');
</script>

<div class="example index">
    <h2><?php echo $title_for_layout; ?></h2>

    <div id="video_widget_settings">
        <?php
            echo $form->create(null, array('url' => array('plugin' => 'video_widget','action' => 'admin_configurate')));

            echo $form->input('VideoWidget.title', 
                    array('id' => 'video_title', 'value'=> $title ) );

            echo $form->input('VideoWidget.source', 
                    array( 'id'      => 'source',
                           'type'    => 'select',
                           'options' => array_combine(array_keys($sources), array_keys($sources)),
                           'value'   => $source
                         )
            );

            echo $form->input('VideoWidget.video_id', 
                    array('id' => 'video_id', 'type'=>'text','label'=>'Video Id', 'value'=> $video_id));

            echo $form->input('VideoWidget.width',    array('id' => 'video_width', 'value'=> $width));
            echo $form->input('VideoWidget.height',   array('id' => 'video_height', 'value'=>$height));
            echo $form->input('VideoWidget.caption',  array('id' => 'video_caption', 'value'=>'ninguna', 'type'=>'hidden'));
            echo $form->input('VideoWidget.autoplay', 
                    array(  'id' => 'video_autoplay',
                            'type'=>'checkbox',
                            'checked'=>($autoplay==1)
                         ));

            echo $form->submit('Save');
            echo $form->end();
        ?>
    </div>

    <div id="video_widget_preview">

        <h3> Preview </h3>
        
        <?php
            if( !empty($video_id))
                echo $this->element( 'video', array( 'video' => $video_object) );
        ?>
        
    </div>
</div>