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
            url: ajax_vars.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: `${metabox_id}_fetch_post_by_id`,
                post_id: post_id,
                nonce: ajax_vars.nonce
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
