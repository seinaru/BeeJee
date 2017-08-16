function Show() {
    document.getElementById('comment-preview-block').style.display = 'block';
    var author = $("#author").val();
    document.getElementById('comment-preview-block').innerHTML =
        '<div class="container" style="padding: 2vh 0 ;">' +
        '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><span>Image</span></div>' +
        '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><span>Login</span></div>' +
        '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><span>Email</span></div>' +
        '<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><span>Post</span></div>' +
        '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><span>Task</span></div>' +
        '<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><span>Progress</span></div>' +
        '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><img src="../../images/images.png" width="50%"></div>' +
        '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><span>'+ author + '</span></div>' +
        '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><span>' + $("#email").val() + '</span></div>' +
        '<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><span>0</span></div>' +
        '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><span>' + $("#message").val() + '</span></div>' +
        '<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><img src="../images/work-in-progress.png" width="100%"></div>' +
        '</div>';



}
