/**
 * Created by JetBrains PhpStorm.
 * User: Mirlan
 * Date: 09.11.15
 * Time: 16:46
 * To change this template use File | Settings | File Templates.
 */
var Photobattle = {

    votePhoto:function (elem) {
        var content = $$('.layout_core_content')[0];
        var loader = $$('.battle-loader')[0];
        var won = elem.getAttribute('won');
        var loss = elem.getAttribute('loss');
        var wonplayer = elem.getAttribute('wonplayer');

        var self = this;

        var req = new Request({
            method:"post",
            data:'won=' + won + '&loss=' + loss + '&wonplayer=' + wonplayer + '&format=html',
            url:en4.core.baseUrl + 'photobattle/index/index',

            onRequest:function () {
                loader.show();
            },
            onFailure:function () {
                alert('Failure!');
            },
            onComplete:function (responseHTML) {
                content.innerHTML = responseHTML;
                self.updateWidgetWLB();
                self.updateWidgetTL();
                self.updateWidgetNB();
                self.updateWidgetLB();
            }
        }).send();

    },

    updateWidgetWLB:function () {
        var contentWLB = $$('.layout_photobattle_winner_last_battle')[0];
        if (contentWLB != null) {
            var reqWidgetWLB = new Request.HTML({
                method:"post",
                data:'widget=winner-last-battle&format=html',
                url:en4.core.baseUrl + 'photobattle/renderwidget',
                onSuccess:function (responseTree, responseElements, responseHTML, responseJavaScript) {
                    var widgetWLB = responseElements.getElement('.winner-last-battle-widget-content')[0];
                    contentWLB.empty();
                    widgetWLB.inject(contentWLB);
                }
            }).send();
        }
    },

    updateWidgetTL:function () {
        var contentTL = $$('.layout_photobattle_top_leader')[0];
        if (contentTL != null) {
        var reqWidgetTL = new Request.HTML({
            method:"post",
            data:'widget=top-leader&format=html',
            url:en4.core.baseUrl + 'photobattle/renderwidget',
            onSuccess:function (responseTree, responseElements, responseHTML, responseJavaScript) {
                var widgetTL = responseElements.getElement('.top-leader-widget-content')[0];
                contentTL.empty();
                widgetTL.inject(contentTL);
            }
        }).send();
        }
    },

// Update Widget Next Battle
    updateWidgetNB:function () {
        var contentNB = $$('.layout_photobattle_next_battle')[0];
        if (contentNB != null) {
        var reqWidgetNB = new Request.HTML({
            method:"post",
            data:'widget=next-battle&format=html',
            url:en4.core.baseUrl + 'photobattle/renderwidget',
            onSuccess:function (responseTree, responseElements, responseHTML, responseJavaScript) {
                var widgetNB = responseElements.getElement('.next-battle-widget-content')[0];
                contentNB.empty();
                widgetNB.inject(contentNB);
            }
        }).send();
        }
    },

// Update Widget Last Battle
    updateWidgetLB:function () {
        var contentLB = $$('.layout_photobattle_last_battle')[0];
        if (contentLB != null) {
        var reqWidgetLB = new Request.HTML({
            method:"post",
            data:'widget=last-battle&format=html',
            url:en4.core.baseUrl + 'photobattle/renderwidget',
            onSuccess:function (responseTree, responseElements, responseHTML, responseJavaScript) {
                var widgetLB = responseElements.getElement('.last-battle-widget-content')[0];
                contentLB.empty();
                widgetLB.inject(contentLB);
            }
        }).send();
        }
    }
};
