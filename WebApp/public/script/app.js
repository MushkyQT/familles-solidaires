$(".closeMe").on("click", function () {
    $(this).parent().fadeOut();
});

$(".addMirrorSubmit").on("click", function() {
    $(".addMirrorForm").submit();
})