
document.addEventListener('DOMContentLoaded',  function() {
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

        const mataBoxId = window.codad5EasyMetaboxQuickEdit.meta_box_id
        Codad5EasyGetMetaData(mataBoxId, post_id).then(d => {
            const  fields = window.codad5EasyMetaboxQuickEdit.quick_edit_fields ?? [];
            fields.forEach(f => {
                let input = edit_row.querySelector(`input[name="${f}"]`);
                if(d?.[f]){
                    input.value = d?.[f];
                }
            })
        })
    };
});



/**
 * Fetch meta data for a given metabox and post ID.
 *
 * @param {string} metabox_id - The metabox identifier used to construct the AJAX action.
 * @param {number} post_id - The ID of the post to fetch data for.
 * @returns {Promise<object>} A promise that resolves with the meta data or rejects with an error.
 */
function Codad5EasyGetMetaData(metabox_id, post_id) {
    return new Promise(function(resolve, reject) {
        jQuery.ajax({
            url: window.codad5EasyMetaboxQuickEdit.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: `cem_${metabox_id}_fetch_post_by_id`,
                post_id: post_id,
                nonce: window.codad5EasyMetaboxQuickEdit.nonce
            },
            success: function(response) {
                console.log(response);
                if (response.success) {
                    resolve(response.data);
                } else {
                    reject(new Error('Error: ' + response.data));
                }
            },
            error: function(xhr, status, error) {
                reject(new Error('AJAX error: ' + error));
            }
        });
    });
}
