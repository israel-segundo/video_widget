<?php

class VideoWidgetActivation {

    public function beforeActivation(&$controller) {
        
        return true;
    }

    public function onActivation(&$controller) {
        // ACL: set ACOs with permissions
        $controller->Croogo->addAco('VideoWidget');
        $controller->Croogo->addAco('VideoWidget/admin_index');
        $controller->Croogo->addAco('VideoWidget/index', array('registered', 'public'));
        $controller->Croogo->addAco('VideoWidget/admin_configurate', array('registered', 'public'));

        $this->createBlock($controller);
        $this->resetSettings($controller);
    }

    public function beforeDeactivation(&$controller) {
        return true;
    }

    public function onDeactivation(&$controller) {
        // ACL: remove ACOs with permissions
        $controller->Croogo->removeAco('VideoWidget'); 
        $this->removeBlock($controller);
        $this->resetSettings($controller);
    }

    public function resetSettings(&$controller){

        $video_widget_options = array(
            'title'    => 'Test Video - Something',
            'source'   => 'YouTube',
            'video_id' => 'xzkhOmKVW08',
            'width'    => '300',
            'height'   => '200',
            'caption'  => '',
            'autoplay' => '0'
        );

        $setting = $controller->Setting->find('first',
                                              array('conditions'=>array('Setting.key'=>'VideoWidget.options')));

        $setting['Setting']['key']   = 'VideoWidget.options';
        $setting['Setting']['value'] = $controller->Node->encodeData($video_widget_options,
                                                                        array('trim'=>false,'json'=>true));
        $controller->Setting->save($setting);
    }

    public function createBlock(&$controller){

        $controller->loadModel('Block');
        $controller->Block->create();
        $controller->Block->set(array(
            'visibility_roles' => $controller->Node->encodeData(array("1","2","3","4","5","6")),
            'visibility_paths' => '',
            'region_id'        => 4,
            'title'            => 'Video',
            'alias'            => 'video_widget',
            'body'             => '[element:video plugin="video_widget"]',
            'show_title'       => 1,
            'status'           => 1
        ));
        $controller->Block->save();
    }

    public function removeBlock(&$controller){
        
        $controller->loadModel('Block');
        $block = $controller->Block->find('first', array('conditions'=>array('Block.alias'=>'video_widget')));

        if( $block ){
            $controller->Block->delete($block['Block']['id']);
        }
        
    }
}
?>
