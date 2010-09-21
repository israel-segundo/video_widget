/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var VideoWidget = {
    sources    : null,
    initialize : function( json_sources ){
        VideoWidget.sources = JSON.parse(json_sources);
    }
};

$(document).ready(function(){
    $('#video_title');
    $('#video_source');

});