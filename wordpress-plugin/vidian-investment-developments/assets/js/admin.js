(function ($) {
    function collectRepeater($repeater) {
        var rows = [];
        $repeater.find('[data-row]').each(function () {
            var row = {};
            $(this).find('[data-field]').each(function () {
                row[$(this).data('field')] = $(this).val();
            });
            rows.push(row);
        });
        $repeater.siblings('.vidian-json').val(JSON.stringify(rows));
    }

    function collectAll() {
        $('.vidian-repeater').each(function () {
            collectRepeater($(this));
        });
    }

    function keypointRow() {
        return '<div class="vidian-row" data-row="keypoints">' +
            '<input type="text" data-field="title" placeholder="Point title" />' +
            '<textarea data-field="text" placeholder="Point description"></textarea>' +
            '<button type="button" class="button-link-delete vidian-remove-row">Remove</button>' +
            '</div>';
    }

    function sectionRow() {
        return '<div class="vidian-row vidian-row--section" data-row="sections">' +
            '<input type="text" data-field="eyebrow" placeholder="Small label e.g. Amenities" />' +
            '<input type="text" data-field="title" placeholder="Section title" />' +
            '<textarea data-field="body" placeholder="Section description"></textarea>' +
            '<textarea data-field="bullets" placeholder="Bullets, one per line"></textarea>' +
            '<button type="button" class="button-link-delete vidian-remove-row">Remove</button>' +
            '</div>';
    }

    $(document).on('input change', '.vidian-repeater [data-field]', collectAll);

    $(document).on('click', '.vidian-add-row', function () {
        var target = $(this).data('target');
        var $repeater = $('[data-repeater="' + target + '"]');
        $repeater.append(target === 'sections' ? sectionRow() : keypointRow());
        collectRepeater($repeater);
    });

    $(document).on('click', '.vidian-remove-row', function () {
        var $repeater = $(this).closest('.vidian-repeater');
        $(this).closest('[data-row]').remove();
        collectRepeater($repeater);
    });

    $(document).on('click', '.vidian-gallery-select', function (event) {
        event.preventDefault();

        var frame = wp.media({
            title: 'Select development gallery',
            button: { text: 'Use selected images' },
            multiple: true,
            library: { type: 'image' }
        });

        frame.on('select', function () {
            var ids = [];
            var html = '';
            frame.state().get('selection').each(function (attachment) {
                attachment = attachment.toJSON();
                ids.push(attachment.id);
                html += '<img src="' + (attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url) + '" alt="" />';
            });

            $('.vidian-gallery-ids').val(ids.join(','));
            $('.vidian-gallery-preview').html(html);
        });

        frame.open();
    });

    $('form#post').on('submit', collectAll);
    collectAll();
})(jQuery);
