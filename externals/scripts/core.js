/**
 * Created by JetBrains PhpStorm.
 * User: Mirlan
 * Date: 09.11.15
 * Time: 16:46
 * To change this template use File | Settings | File Templates.
 */
var Photobattle = {

    votePhoto : function (elem) {
        var content = $$('.layout_core_content')[0];
        var loader = $$('.battle-loader')[0];
        var won = elem.getAttribute('won');
        var loss = elem.getAttribute('loss');
        var wonplayer = elem.getAttribute('wonplayer');

        var self = this;

        var req = new Request({
            method : "post",
            data: 'won=' + won + '&loss=' + loss + '&wonplayer=' + wonplayer + '&format=html',
            url : en4.core.baseUrl + 'photobattle/index/index',

            onRequest: function() {
                loader.show();
            },
            onFailure:function(){
                alert('Failure!');
            },
            onComplete: function(responseHTML) {
                content.innerHTML = responseHTML;
                self.updateWidgetWLB();
                self.updateWidgetTL();
            }
        }).send();

    },

    updateWidgetWLB : function() {
        var contentWLB = $$('.layout_photobattle_winner_last_battle')[0];
        var reqWidgetWLB = new Request.HTML({
            method : "post",
            data: 'widget=winner-last-battle&format=html',
            url : en4.core.baseUrl + 'photobattle/renderwidget',
            onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
                var widgetWLB = responseElements.getElement('.winner-last-battle-widget-content')[0];
                contentWLB.empty();
                widgetWLB.inject(contentWLB);
            }
        }).send();
    },

    updateWidgetTL : function() {
        var contentTL = $$('.layout_photobattle_top_leader')[0];
        var reqWidgetTL = new Request.HTML({
            method : "post",
            data: 'widget=top-leader&format=html',
            url : en4.core.baseUrl + 'photobattle/renderwidget',
            onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
                var widgetTL = responseElements.getElement('.top-leader-widget-content')[0];
                contentTL.empty();
                widgetTL.inject(contentTL);
            }
        }).send();
    }
};
