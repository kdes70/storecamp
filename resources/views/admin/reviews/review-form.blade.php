{{ Form::open(['route' => ['admin::reviews::reply', $review->id], 'method' => 'PUT', "role" => "form", "class" => "confirmMessage" ]) }}
<h2>Reply review</h2>
<!-- Message Form Input -->
<div class="form-group">
    {{ Form::textarea('reply_message', null, [
    'class' => 'form-control autogrow confirmMessageBody', "rows" => "3","placeholder"=>"Reply form here.."]) }}
</div>
<div class="form-group text-right">
    <button class="btn btn-primary confirmMessageBtn" data-href="{{route('admin::reviews::reply', $review->id)}}">Reply</button>
</div>
{{ Form::close() }}