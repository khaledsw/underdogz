/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


jQuery(document).ready(function () {

//Su kien khi opacity thay doi
    jQuery('.alternate .skill-field-value').live('input', function () {
        var ranVal = jQuery(this).val();
        jQuery(this).parent().find('.field-value').html(ranVal);
    }).trigger('input');

    jQuery('.iwc-metabox-fields .add-row').click(function () {
        var type = '';
        if (jQuery(this).hasClass('experience')) {
            type = 'experience';
        }
        if (jQuery(this).hasClass('skills')) {
            type = 'skills';
        }
        if (jQuery(this).hasClass('info')) {
            type = 'info';
        }
        if (jQuery(this).hasClass('courses-related')) {
            type = 'courses-related';
        }
        if (jQuery(this).hasClass('social')) {
            type = 'social';
        }
        var html = addMetaBoxRow(type);
        jQuery(html).insertBefore(jQuery(this).parents('tr'));
    });

    //add teacher reference
    //Xu ly khi nut bam create parallax dc click
    jQuery('.button.teacher-reference').click(function () {
        jQuery('#list-teachers.hidden').appendTo('body').fadeIn(500, function () {
            jQuery(this).removeClass('hidden');
        });
    });

    //Take this Course
    jQuery('.class-detail .class-info .course').on('click', function (e) {
        jQuery.fn.custombox({
            url: '#take-this-courses',
            effect: 'fadein',
            width: '700'
        });
        e.preventDefault();
    });


    var timeoutAjax;
    jQuery('input.auto-load-post').live('input', function () {
        var itemtarget = jQuery(this);
        var value = jQuery(this).val();
        if (value.length < 3) {
            return;
        }
        var exclude_id = '';
        jQuery('input.related_couses_id').each(function () {
            exclude_id += jQuery(this).val() + ',';
        });
        clearTimeout(timeoutAjax);
        timeoutAjax = setTimeout(function () {
            jQuery.ajax({
                url: iwcCfg.ajaxUrl,
                data: {action: 'iwcLoadCoursesPosts', excids: exclude_id, keyword: value},
                type: "post",
                beforeSend: function (xhr) {
                    itemtarget.parent().find('.iw-courses-list').html('').show();
                    itemtarget.parent().find('.iw-ajax-loading').show();
                },
                success: function (responseJSON) {
                    var a = jQuery.parseJSON(responseJSON);
                    if (a.success) {
                        itemtarget.parent().find('.iw-courses-list').html(a.data);
                    }
                    itemtarget.parent().find('.iw-ajax-loading').hide();
                }
            });
        }, 300);
    });

    jQuery('.iwc-metabox-fields .remove-button').live('click', function () {
        jQuery(this).parents('tr').remove();
    });

    jQuery('.iwc-metabox-fields .iw-courses-list li').live('click', function () {
        var liselect = jQuery(this);
        if (liselect.data('title')) {
            jQuery('.iwc-metabox-fields .auto-load-post').val(jQuery(liselect).data('title'));
        }
        liselect.parents('.iw-courses-list').hide();
    });
    jQuery('.iwc-metabox-fields .auto-load-post').unbind().off();
    jQuery('.iwc-metabox-fields .auto-load-post').keypress(function (e) {
        if (keyUpEvent(e.keyCode)) {
            e.preventDefault();
            e.stopPropagation();
            return false;
        }
    });
    var frame;
    //Get image from wp library
    jQuery('.button-add-image .add-new-image').click(function () {
        // Set options
        var options = {
            state: 'insert',
            frame: 'post',
            multiple: true,
            library: {
                type: 'image'
            }
        };

        frame = wp.media(options).open();

        // Tweak views
        frame.menu.get('view').unset('gallery');
        frame.menu.get('view').unset('featured-image');

        frame.toolbar.get('view').set({
            insert: {
                style: 'primary',
                text: 'Insert',
                click: function () {
                    var models = frame.state().get('selection');
                    models.each(function (e) {
                        var url = e.attributes.url;
                        var item_control = '<div class="iw-image-item">';
                        item_control += '<div class="action-overlay">';
                        item_control += '<span class="remove-image">x</span>';
                        item_control += '</div>';
                        item_control += '<img src="' + url + '" width="150"/>';
                        item_control += '<input type="hidden" value="' + url + '" name="iw_information[image_gallery][]"/>';
                        jQuery('.iwc-metabox-fields .list-image-gallery').append(item_control);
                    });
                    frame.close();
                }
            } // end insert
        });
    });


    //Remove image from list gallery
    jQuery('.list-image-gallery .action-overlay .remove-image').live('click', function () {
        jQuery(this).parents('.iw-image-item').hide(200).remove();
    });
});


function addMetaBoxRow(type) {
    var html = '';
    if (type === 'skills') {
        html += '<tr class="alternate">';
        html += '<td>';
        html += '<input placeholder="Training Skills Title" type="text" size="20" name="iw_information[training_skills][key_title][]"/>';
        html += '</td>';
        html += '<td>';
        html += '<label class="field-value" style="font-weight: bold;">50</label><br/>';
        html += '<input class="skill-field-value" placeholder="Training Skills Value" type="range" min="0" max="100" step="1" size="20" value="50" name="iw_information[training_skills][key_value][]"/>';
        html += '</td>';
        html += '<td>';
        html += '<span class="button remove-button">Remove</span>';
        html += '</td>';
        html += '</tr>';
    }
    if (type === 'experience') {
        html += '<tr class="alternate">';
        html += '<td>';
        html += '<input placeholder="Training Experience Title" type="text" size="20" name="iw_information[training_experience][key_title][]"/>';
        html += '</td>';
        html += '<td>';
        html += '<textarea placeholder="Training Experience Value" name="iw_information[training_experience][key_value][]"></textarea>';
        html += '</td>';
        html += '<td>';
        html += '<span class="button remove-button">Remove</span>';
        html += '</td>';
        html += '</tr>';
    }
    if (type === 'info') {
        html += '<tr class="alternate">';
        html += '<td>';
        html += '<input placeholder="Info Title" type="text" size="20" name="iw_information[basic_information][key_title][]"/>';
        html += '</td>';
        html += '<td>';
        html += '<input placeholder="Info Value" type="text" size="20" name="iw_information[basic_information][key_value][]"/>';
        html += '</td>';
        html += '<td>';
        html += '<span class="button remove-button">Remove</span>';
        html += '</td>';
        html += '</tr>';
    }
    if (type === 'social') {
        html += '<tr class="alternate">';
        html += '<td>';
        html += '<select id="iw_information_social_link_key_title" name="iw_information[social_link][key_title][]">'+jQuery('.social-link-types select:last').html()+'</select>';
        html += '</td>';
        html += '<td>';
        html += '<input type="url" value="" name="iw_information[social_link][key_value][]" placeholder="Social Link Value">';
        html += '</td>';
        html += '<td>';
        html += '<span class="button remove-button">Remove</span>';
        html += '</td>';
        html += '</tr>';
    }
    if (type === 'courses-related') {
        var id = jQuery('.iw-courses-list li.selected').data('id');
        var title = jQuery('.iw-courses-list li.selected').data('title');
        html += '<tr class="alternate">';
        html += '<td>';
        html += '<label class="related_couses_id">' + id + '</label>';
        html += '<input class="related_couses_id" type="hidden" value="' + id + '" size="20" name="iw_information[related_couses][key_value][]"/>';
        html += '</td>';
        html += '<td>';
        html += '<label class="related_couses_title">' + title + '</label>';
        html += '<input type="hidden" value="' + title + '" size="20" name="iw_information[related_couses][key_title][]"/>';
        html += '</td>';
        html += '<td>';
        html += '<span class="button remove-button">Remove</span>';
        html += '</td>';
        html += '</tr>';
        jQuery('.iwc-metabox-fields .auto-load-post').val('');
    }
    return html;
}

function rate(mediaId, rating) {
    jQuery.ajax({
        url: iwcCfg.ajaxUrl,
        data: {action: 'iwcAthleteAjaxVote', id: mediaId, rating: rating},
        type: "post",
        success: function (responseJSON) {
            var a = jQuery.parseJSON(responseJSON);
            if (a.success) {
                jQuery('.btp-rating-container-' + mediaId).each(function () {
                    jQuery(this).find('.btp-rating-current').css({
                        width: a.rating_width + "px"
                    });
                    jQuery('.btp-rating-container-' + mediaId + ' .btp-rating-notice').text(a.rating_text);
                });
            }
            else {
                alert(a.message);
            }
        }, error: function () {
            alert('Unknow Error!!!');
        }
    });
}

function rateAthlete(mediaId, rating) {
    jQuery.ajax({
        url: iwcCfg.ajaxUrl,
        data: {action: 'iwcAthleteAjaxVote', id: mediaId, rating: rating},
        type: "post",
        success: function (responseJSON) {
            var a = jQuery.parseJSON(responseJSON);
            if (a.success) {
                jQuery('.btp-rating-container-' + mediaId).each(function () {
                    jQuery(this).find('.btp-rating-current').css({
                        width: a.rating_width + "%"
                    });
                    jQuery('.btp-rating-container-' + mediaId + ' .btp-rating-notice').text(a.rating_text);
                });
            }
            else {
                alert(a.message);
            }
        }, error: function () {
            alert('Unknow Error!!!');
        }
    });
}

function keyUpEvent(key) {
    var listLi = jQuery('.iw-courses-list ul');
    if (key === 40) {
        //down key
        var thisli = jQuery('li.selected', listLi);
        if (thisli.next().length > 0) {
            thisli.removeClass('selected');
            thisli.next().addClass('selected');
        }
    } else if (key === 38) {
        //up key
        var thisli = jQuery('li.selected', listLi);
        if (thisli.prev().length > 0) {
            thisli.removeClass('selected');
            thisli.prev().addClass('selected');
        }
    } else if (key === 27) {
        //esc key
        listLi.parent().hide();
    } else if (key === 13) {
        //enter key
        var liselect = listLi.find('li.selected');
        if (liselect.data('title')) {
            jQuery('.iwc-metabox-fields .auto-load-post').val(jQuery(liselect).data('title'));
        }
        listLi.parent().hide();
        return true;
    }
    return false;
}

function sendTakeCourse() {
    var title = jQuery('#take-this-courses input[name="post_title"]').val();
    var yname = jQuery('#take-this-courses input[name="yname"]').val();
    var yemail = jQuery('#take-this-courses input[name="yemail"]').val();
    var ymobile = jQuery('#take-this-courses input[name="ymobile"]').val();
    var ymessage = jQuery('#take-this-courses textarea[name="ymessage"]').val();
    var temail = jQuery('#take-this-courses input[name="teacher_email"]').val();
    var msg = '';
    jQuery('.take-message .list-message').html('');
    if (yname === '') {
        msg += '<li>Please input your name</li>';
    }
    if (yemail === '') {
        msg += '<li>Please input your email</li>';
    }else{
        var emailReg = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!emailReg.test(yemail)){
            msg += '<li>Please input valid email</li>';
        }
    }
    if (ymessage === '') {
        msg += '<li>Please input your message</li>';
    }

    if (msg) {
        jQuery('.take-message').addClass('take-error');
        jQuery('.take-message .list-message').html(msg);
        return false;
    }

    jQuery.ajax({
        url: iwcCfg.ajaxUrl,
        data: {action: 'iwcSendMailTakeCourse', title: title, name: yname, email: yemail, temail: temail, mobile: ymobile, message: ymessage},
        type: "post",
        beforeSend: function (xhr) {
            jQuery('#take-this-courses .ajax-overlay').show();
        },
        success: function (responseJSON) {
            var a = jQuery.parseJSON(responseJSON);
            if (a.success) {
                jQuery('.take-message').addClass('take-success').removeClass('take-error');
            }
            else {
                jQuery('.take-message').addClass('take-error').removeClass('take-success');
            }
            jQuery('.take-message .list-message').html('<li>' + a.message + '</li>');
            jQuery('#take-this-courses .ajax-overlay').hide();
        }, error: function () {
            alert('Unknow Error!!!');
            jQuery('#take-this-courses .ajax-overlay').hide();
        }
    });
    return false;
}
