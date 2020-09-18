humhub.module('blog', function(module, require, $) {

    var client = require('client');
    var util = require('util');
    var stream = require('stream');
    var Widget = require('ui.widget').Widget;
    var additions = require('ui.additions');
    var loader = require('ui.loader');

    /**
     * Number of initial stream enteis loaded when stream is initialized.
     * @type Number
     */
    var STREAM_INIT_COUNT = 10;

    /**
     * Number of stream entries loaded with each request (except initial request)
     * @type Number
     */
    var STREAM_LOAD_COUNT = 10;

    /**
     * ActivityStream instance;
     * @type LatestBlogsStream
     */
    var instance;



    var LatestBlogsStreamEntry = stream.StreamEntry.extend(function (id) {
        stream.StreamEntry.call(this, id);
    });

    LatestBlogsStreamEntry.prototype.loadEntry = function(evt) {
        load(evt);
    };

    LatestBlogsStreamEntry.prototype.delete = function () {/* Not implemented */};
    LatestBlogsStreamEntry.prototype.edit = function () {/* Not implemented */};

    /**
     * ActivityStream implementation.
     *
     * @param {type} container id or jQuery object of the stream container
     * @returns {undefined}
     */
    var LatestBlogsStream = stream.Stream.extend(function (container, options) {
        stream.Stream.call(this, container, {
            initLoadCount: STREAM_INIT_COUNT,
            loadCount: STREAM_LOAD_COUNT,
            streamEntryClass: LatestBlogsStreamEntry,
        });
    });

    LatestBlogsStream.prototype.initScroll = function () {
        if(!this.$content.is(':visible')) {
            return;
        }

        // listen for scrolling event yes or no
        var scrolling = true;
        var that = this;
        this.$content.scroll(function (evt) {
            if(that.lastEntryLoaded()) {
                return;
            }
            // save height of the overflow container
            var _containerHeight = that.$content.height();
            // save scroll height
            var _scrollHeight = that.$content.prop("scrollHeight");
            // save current scrollbar position
            var _currentScrollPosition = that.$content.scrollTop();

            // load more activites if current scroll position is near scroll height
            if (_currentScrollPosition >= (_scrollHeight - _containerHeight - 30)) {
                // checking if ajax loading is necessary or the last entries are already loaded
                if (scrolling) {
                    scrolling = false;
                    // load more activities
                    that.loadEntries({loader: true}).then(function() {
                        that.$content.getNiceScroll().resize();
                    }).finally(function () {
                        scrolling = true;
                    });
                }
            }
        });


        // set niceScroll to activity list
        that.$content.niceScroll({
            cursorwidth: "7",
            cursorborder: "",
            cursorcolor: "#555",
            cursoropacitymax: "0.2",
            nativeparentscrolling: false,
            railpadding: {top: 0, right: 3, left: 0, bottom: 0}
        });
    };

    LatestBlogsStream.templates = {
        streamMessage: '<div class="streamMessage"><div class="panel-body">{message}</div></div>'
    };

    var BlogContent = Widget.extend();

    var unload = function() {
        // Cleanup nicescroll rails from dom
        if(instance && instance.$) {
            instance.$content.getNiceScroll().remove();
            instance.$content.css('overflow', 'hidden');
        }
        instance = undefined;
    };

    var load = function(evt)
    {
        loader.set($('.blog-content'), {css: {padding: '100px'}});
        client.get(evt).then(function(response) {
            history.replaceState(null, null, response.url);
            $('#blog-root').replaceWith(response.output);
            additions.applyTo($('#blog-root'));
        }).catch(function(e) {
            module.log.error(e, true);
            loader.reset($('.blog-content'));
        });
    }

    module.export({
        LatestBlogsStream: LatestBlogsStream,
        LatestBlogsStreamEntry: LatestBlogsStreamEntry,
        BlogContent: BlogContent,
        load: load,
        unload: unload
    });
});