document.addEventListener('DOMContentLoaded', function() {
    var wp_inline_edit = inlineEditPost.edit;
    inlineEditPost.edit = function(id) {
        // Call the original WordPress edit function
        wp_inline_edit.apply(this, arguments);

        // Get the post ID
        var post_id = (typeof id === 'object') ? parseInt(this.getId(id)) : 0;
        if (!post_id) return;

        console.log(`Quick edit post ID: ${post_id}`);

        // Get the post row and Quick Edit form
        var post_row = document.getElementById('post-' + post_id);
        var edit_row = document.getElementById('edit-' + post_id);

        if (!post_row || !edit_row) return;

        // Select the box office values from the post row
        var box_office_value = post_row.querySelector('.column-box_office')?.textContent.trim().replace('₦', '').replace(/,/g, '');
        var week_box_office_value = post_row.querySelector('.column-week_box_office')?.textContent.trim().replace('₦', '').replace(/,/g, '');

        console.log("Box Office:", box_office_value);
        console.log("Week Box Office:", week_box_office_value);

        // Populate the Quick Edit form fields
        var box_office_input = edit_row.querySelector('input[name="_cean_movie_box_office"]');
        var week_box_office_input = edit_row.querySelector('input[name="_cean_movie_week_box_office"]');

        if (box_office_input) box_office_input.value = box_office_value || '';
        if (week_box_office_input) week_box_office_input.value = week_box_office_value || '';
    };
});
