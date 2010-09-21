<?php
/**
 * Example Controller
 *
 * PHP version 5
 *
 * @category Controller
 * @package  Croogo
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
App::import('Vendor', 'VideoWidget.VideoWidget', array('file' => 'VideoWidget.php'));

class VideoWidgetController extends VideoWidgetAppController {
/**
 * Controller name
 *
 * @var string
 * @access public
 */
    public $name = 'VideoWidget';
/**
 * Models used by the Controller
 *
 * @var array
 * @access public
 */
    public $uses = array('Setting');

    public $helpers = array('VideoWidget.VideoWidget');

    public function index() {
        $this->set('title_for_layout', __('VideoWidget', true));
    }

    public function admin_index() {

        $this->set('title_for_layout', __('VideoWidget', true));

        $settings = $this->getVideoWidgetSettings();

        $video        = new Video();
        $sources      = $video->getSources();
        
        
        $title    = isset($settings['title'])    ? $settings['title']    : '';
        $video_id = isset($settings['video_id']) ? $settings['video_id'] : '';

        $source   = (isset($settings['source']) && !empty($settings['source']) ) ? $sources[$settings['source']]   : $sources['YouTube'];
        $caption  = isset($settings['caption'])  ? $settings['caption']  : '';
        $autoplay = isset($settings['autoplay']) ? $settings['autoplay'] : 0;
        $height   = isset($settings['height']) ? $settings['height'] : 200;
        $width    = isset($settings['width']) ? $settings['width'] : 300;

        $video_object = $video->generate_video_options( $source, $title, $caption,
                                                        $video_id, $autoplay, $height, $width );


        $this->set(compact('sources', 'settings', 'video_object'));
    }

    public function admin_configurate(){

        if( !empty( $this->data )){

            $video_widget_options = array();

            /* TODO
             * Este campo de fields se dejo para poder validar los campos
             */
            $fields = array(
                'title'    => '',
                'source'   => '',
                'video_id' => '',
                'width'    => '',
                'height'   => '',
                'caption'  => '',
                'autoplay' => ''
            );

            foreach( $fields as $field => $condition ){
                
                if( isset( $this->data['VideoWidget'][$field] )
                    && @$this->data['VideoWidget'][$field] != '' )
                {
                    $video_widget_options[$field] = $this->data['VideoWidget'][$field];    
                }else{
                    $this->Session->setFlash("El campo $field no puede ser vacio");
                    $this->redirect( array('plugin' => 'video_widget', 'action' => 'index') );
                    return;
                }
            }

            $this->saveVideoSettings($video_widget_options);

            $this->Session->setFlash('The settings were updated');
            $this->redirect( array('plugin' => 'video_widget', 'action' => 'index') );
        }
    }


    public function getVideoWidgetSettings(){

        $video_setting = $this->Setting->find('first',array('conditions'=>array('key'=>'VideoWidget.options')));

        if( !empty( $video_setting['Setting']['value'] ) ){

            $settings = $this->Node->decodeData( $video_setting['Setting']['value'],
                                                          array('trim'=>false,'json'=>true)
                                                        );
        }else{
            //  aqui que pasa?
            $settings = array();
        }
        return $settings;

    }

    public function saveVideoSettings( $new_settings ){

        $settings     = $this->Setting->find('first',array('conditions'=>array('key'=>'VideoWidget.options')));

        $settings['Setting']['value'] = $this->Node->encodeData( $new_settings,
                                                                    array('trim'=>false,'json'=>true)
                                                                  );
        $this->Setting->save($settings);
    }
    
}
?>
