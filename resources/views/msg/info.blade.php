@if(Session::has('message-info'))
<div class="alert alert-info" role="alert" id="msg-info">
   <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Info:</span>
  {{Session::get('message-info')}}
</div>
@endif