var $ = jQuery.noConflict();
var bro_excerpt_length;
(function ($) {
    bro_excerpt_length = {
        run: function () {
            if($("#excerpt").length) {
                var count = bro_excerpt_length_js_variable.count;
                this.counter('#excerpt', '#postexcerpt .inside p', count);
            }
        },
        count_compute: function (one, two) {
            return one - two;
        },
        counter: function (selector, warning, count) {
            var this_class = this;
            $(selector).on('keyup textchange mouseenter bro_excerpt_length_start', function () {
                var $this = $(this);
                var error = this_class.count_compute(Number($this.val().length), count);
                if ($this.val().length > count) {
                    $this.val($this.val().substr(0, count));
                }
                this_class.insert_counter(warning, error);
            });
        },
        insert_counter: function (selector, count) {
            var warning_counter_id = '#postexcerpt_counter';
            var text;
            var html_class = 'green';

            if (count <= 0) {
                html_class = 'green';
                text = bro_excerpt_length_js_localize.string_more + Math.abs(count);

            } else {
                html_class = 'red';
                text = bro_excerpt_length_js_localize.string_less + count;
            }

            if (!$(warning_counter_id).length) {
                $(selector).before("<p id='postexcerpt_counter' class='" + html_class + "'> " + text + " </p>");
            } else {
                $(warning_counter_id).text(text).attr('class', html_class);
            }
        }
    };
    $(document).ready(function () {
        bro_excerpt_length.run();
    });
})(jQuery);
