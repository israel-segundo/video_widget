<?php
/**
 * Example Component
 *
 * An example hook component for demonstrating hook system.
 *
 * @category Component
 * @package  Croogo
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */

App::import('Vendor', 'VideoWidget.VideoWidget', array('file' => 'VideoWidget.php'));

class VideoWidgetComponent extends Object {
/**
 * Called after the Controller::beforeFilter() and before the controller action
 *
 * @param object $controller Controller with components to startup
 * @return void
 */
    public function startup(&$controller) {
        
    }
/**
 * Called after the Controller::beforeRender(), after the view class is loaded, and before the
 * Controller::render()
 *
 * @param object $controller Controller with components to beforeRender
 * @return void
 */
    public function beforeRender(&$controller) {

        //if( $controller->action ){
//            return true;
//        }

        $video                = new Video();
        $sources              = $video->getSources();
        $video_setting        = $controller->Setting->find('first',array('conditions'=>array('key'=>'VideoWidget.options')));
        
        if( !empty( $video_setting['Setting']['value'] ) ){

            $settings = $controller->Node->decodeData( $video_setting['Setting']['value'],
                                                          array('trim'=>false,'json'=>true)
                                                        );

            $title    = isset($settings['title'])    ? $settings['title']    : '';
            $video_id = isset($settings['video_id']) ? $settings['video_id'] : '';

            $source   = (isset($settings['source']) && !empty($settings['source']) ) ? $sources[$settings['source']]   : $sources['YouTube'];
            $caption  = isset($settings['caption'])  ? $settings['caption']  : '';
            $autoplay = isset($settings['autoplay']) ? $settings['autoplay'] : 0;
            $height   = $settings['height'];
            $width    = $settings['width'];
            
            $video_object = $video->generate_video_options( $source, $title, $caption,
                                                            $video_id, $autoplay, $height, $width );
            $controller->set(compact('video_object'));

        }
    }
/**
 * Called after Controller::render() and before the output is printed to the browser.
 *
 * @param object $controller Controller with components to shutdown
 * @return void
 */
    public function shutdown(&$controller) {
    }
    
}
?>
