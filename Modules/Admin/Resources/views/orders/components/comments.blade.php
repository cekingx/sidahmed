<div class="ui tiny modal" id="comments_modal">
  	<i class="close icon"></i>
    <div class="header">
        Order Comments
  	</div>

    <div class="content">
        <div id="comments"></div>

        <br/>
        <div class="ui divider"></div>
        <br/>

        <div class="ui form">
            <div class="field">
                <textarea id="comments_textarea" rows="2"></textarea>
            </div>
        </div>
        <a class="ui primary fluid button mt-5" href="javascript:void(0)" onclick="comments_addComment($('#comments_textarea').val())">
            Add comment
        </a>
    </div>
</div>

@push('javascript')
<script type="text/javascript">
    function comments_showModal(order_id) {

        if(!setCurrentOrder(order_id)) return null;

        comments_resetCommentsInModal();
        $.ajax({
            url:"{{route('admin::orders.comments', ['order' => 'XX'])}}".replace('XX', order_id),
            type:"GET",
            data:{order_id: order_id},

            success: function(data) {
                data.forEach(function(meta) {
                    comments_addCommentToModal(meta.content, meta.user.email, meta.time);
                })

                $("#comments_modal").modal('show');
            }
        })
    }

    function comments_addComment(content) {

        $.ajax({
            url:"{{route('admin::orders.comment.create', ['order' => 'XX'])}}".replace('XX', getCurrentOrder().id),
            type:"POST",
            data:{content: content}
        })

        comments_addCommentToModal(content, "{{Auth::user()->email}}", 'now');
        $("#comments_textarea").val('');
    }


    function comments_addCommentToModal(content, user, time) {
        $("#comments").append(`
            <div class="ui segment">
                ${content}<br/><br/>
                <i>${user} | ${time}</i>
            </div>
        `);
    }

    function comments_resetCommentsInModal() {
        $("#comments").html('');
    }
</script>
@endpush