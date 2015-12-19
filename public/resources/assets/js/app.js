/**
 * Created by Defrosted Tuna on 11/22/2015.
 */
$(document).ready(function() {
    new buttonplate('.button-primary');
});
$(".form-wrap").hide();

$(".button-photo").click(function() {
    if($(".button-photo").hasClass("button-photo-on")) {
        $(".form-wrap").slideToggle(function() {
            $(".upload-wrap").removeClass("upload-wrap-on");
        });
        $(".button-photo").removeClass("button-photo-on");
    } else {
        $(".button-photo").addClass("button-photo-on");
        $(".upload-wrap").addClass("upload-wrap-on");
        $(".form-wrap").delay(500).slideToggle();
    }
});

$('#input-file').on('change', function (event, files, label) {
    var file_name = this.value.replace(/\\/g, '/').replace(/.*\//, '')
    if($("#input-file").val() != '') {
        $('.button-file-select').addClass("button-file-select-on");
    } else {
        $(".button-file-select").removeClass("button-file-select-on");
    }
    $(".selected-file").remove();
    $("<h3 class='selected-file'>" + file_name + "</h3>").appendTo(".input-field").hide().fadeIn();
});

//Prepend only the submitted image to the photo gallery and fade in on submit
$('#upload-form').submit(function(e){
    e.preventDefault();
    $.ajax({
        url : "photo/store",
        type: "POST",
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function(data){
            //cleanup
            $(".flash-error").remove();
            $(".selected-file").remove();
            $("<div class='flash-success'><p>Uploaded!</p></div>").prependTo(".main-wrap").fadeIn(3000).delay(5000).slideUp(function() {
                $(".form-wrap").slideUp();
                //set toggle classes back to defaults
                $(".button-photo").removeClass("button-photo-on");
                setTimeout(function() {
                    $(".upload-wrap").removeClass("upload-wrap-on");
                }, 500);
            });
            $("input[type=file]").val('');
            $(".button-file-select").removeClass("button-file-select-on");
            //prepend image to front of list
            $("<div class='flex-image'><a href='photo/" + data.slug + "'>" + "<img src='" + window.location + data.thumb_path + "'>" + "</a></div>").prependTo('.photo-gallery').hide().fadeIn(2000);


        },

        error: function(jqXHR, textStatus, errorThrown){
            //cleanup
            $(".flash-error").remove();
            $(".selected-file").remove();
            $(".button-file-select").removeClass("button-file-select-on");
            //prepend div to top of page
            $("<div class='flash-error'></div>").prependTo(".main-wrap").hide();
            $.each($.parseJSON(jqXHR.responseText),function(index, array){
                $.each(array, function(i, error){
                    //add each error to the div
                    $("<p>" + error + "</p>").appendTo(".flash-error");
                });
            });
            //show flash-errors
            $(".flash-error").fadeIn(1000);
        }
    });
});