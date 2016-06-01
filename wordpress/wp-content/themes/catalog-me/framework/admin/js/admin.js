jQuery(document).ready(function () {
    jQuery(".widget-content .select-page-wrapper select").on("change", function(){
        if (jQuery(this).val() == "custom") {
            jQuery(this).parent(".select-page-wrapper").next(".custom_url").show();
        }
        else {
            jQuery(this).parent(".select-page-wrapper").next(".custom_url").hide();
        }
    });
    jQuery(".widget-content .select-page-wrapper select").trigger("change");
    jQuery(document).on("click", ".button[name=\"add_quick_image\"]", function () {
        var clicked = jQuery(this);
        var number = clicked.attr("number");
        wp.media.editor.send.attachment = function (props, attachment) {
            jQuery("input[name=\"" + number + "\"]").val(attachment.url);
            clicked.closest("div.element-uploader").append("<img class=\"media-image\" src=\"" + attachment.url + "\" />");
            clicked.remove();
        }
        wp.media.editor.open(number);
        return false;
    });

    jQuery(".add_theme_media").click(function () {
        var clicked = jQuery(this);
        var upload_type = clicked.parent("div").children("#upload_type").val();
        wp.media.editor.send.attachment = function (props, attachment) {
            if (upload_type == "url") {
                clicked.parent("div").children("#uploaded_image").val(attachment.url);
            }
            else {
                clicked.parent("div").children("#uploaded_image").val(attachment.id);
            }
            clicked.prev("div").children("img").attr("src", attachment.url);
            clicked.prev("div").children(".theme-reset-image-button").show();
            clicked.prev("div.implecode-admin-media-image.empty").removeClass('empty');
            clicked.hide();
        }
        wp.media.editor.open(jQuery(this));
        return false;
    });

    jQuery(".theme-reset-image-button").click(function () {
        var clicked = jQuery(this);
        clicked.parent("div").prev("#uploaded_image").val("");
        src = jQuery("#default").val();
        clicked.next(".media-image").attr("src", src);
        clicked.parent("div").next(".add_theme_media").show();
        clicked.parent(".implecode-admin-media-image").addClass('empty');
        clicked.hide();
    });
});