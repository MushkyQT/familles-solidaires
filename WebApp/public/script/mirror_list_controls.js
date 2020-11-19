$(".deleteMirror").on("click", function (e) {
    let targetMirrorAlias = $(this).data('mirrorTargetAlias');
    let targetMirrorAddr = $(this).data('mirrorTargetAddr')
    $(".deleteMirrorModal__body").text("Etes vous sur de vouloir supprimer " + targetMirrorAlias);
    $(".deleteMirrorModal__body").data('mirrorTargetAddr', targetMirrorAddr);
});

$(".deleteMirrorModal__confirmDelete").on("click", function () {
    $.ajax({
        type: "POST",
        url: 'http://127.0.0.1:8000/ajax/remove_mirror',
        data: {
            'mirror': $(".deleteMirrorModal__body").data('mirrorTargetAddr'),
            'owner': $(".deleteMirrorModal__body").data('owner'),
        },
        dataType: 'json',
        error: function () {
            location.reload();
        },
        success: function () {
            location.reload();
        },
    });
});