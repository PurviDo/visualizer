$(document).ready(function () {
    $("#visualizer_summernote").summernote({
        toolbar: [
            // [groupName, [list of button]]
            ["style", ["bold", "italic", "underline", "clear"]],
            ["fontsize", ["fontsize"]],
            ["color", ["color"]],
            ["para", ["ul", "ol", "paragraph"]],
            ["height", ["height"]],
        ],
    });
});
