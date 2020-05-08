<!-- Cms Comments -->


<!--notifications-->
@if(Session::has('success_message')) {{-- variabili di sessione per alerts --}}
<div id="alert" class="alert alert-success text-center alert-dismissable fade in">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  {!! Session::get('success_message') !!}
</div>
@endif

@if(Session::has('error_message')) 
<div id="alert" class="alert alert-danger text-center alert-dismissable fade in">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  {!! Session::get('error_message') !!}
</div>
@endif

{{--error validation form --}}
@if (count($errors) > 0)
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

<!--comments list-->
<div id="comments" class="well">
  @if (count($comments) > 0)
  <h4>
    <strong>{{ $total_comments }}</strong> comment{{ $total_comments === 1 ? 'o':'i' }} all'articolo <strong>{{ $comments->first()->post->title }}</strong>
  </h4>
  @endif

  <ul class="media-list">
    @if ($comments)
      <!-- Comments loop -->
      @foreach ($comments as $comment)
      <li id="comment-{{ $comment->id }}" class="media">
        <div class="media-body">
          <div class="media-heading">
            {{$comment->from_user_name}} <small>- {{ date('d/m/Y H:i', strtotime($comment->created_at)) }}</small>
          </div>
          <p class="comment-body"> {{ $comment->body }} </p> {{--VERIFICARE SICUREZZA TAG HTML E VIRGOLETTE --}}
          <!-- reply btn-->
          <p class="reply text-right">
            <button class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#respond-comment-{{ $comment->id }}">Rispondi</button>
          </p>

          @foreach ($comments_child as $comment_child) 
          @if ($comment_child->comment_parent == $comment->id ) {{-- !!! RISOLTOOOO VERIFICARE !!! !!!! --}}
          <!--Nested Comment - annidamento-->
          <div class="media reply-comm">
            <div class="media-body">
              <div class="media-heading">
                {{ $comment_child->from_user_name }} <small>- {{ date('d/m/Y H:i', strtotime($comment_child->created_at)) }}</small>
              </div>
              <p class="comment-body"> {{ $comment_child->body }} </p>
            </div>
          </div>
          <!--Fine Nested Comment - annidamento-->
          @endif
          @endforeach

          <!-- comment-reply form -->
          <div id="respond-comment-{{ $comment->id }}" class="collapse comment-respond">
            <div>Rispondi al commento di <b>{{ $comment->from_user_name }}</b></div>

            <form id="reply-commentform-{{ $comment->id }}" class="" action="{{ url($comment->post->slug . '/comment/send') }}" method="post">
              {{ csrf_field() }}
              <div class="form-group">
                <label>Nome</label> <!--for="c-name"-->
                <input class="form-control" type="text" name="c-name">
                <label>Email</label> <!--for="c-email"-->
                <small>(Il tuo indirizzo email non sarà pubblicato)</small>
                <input class="form-control" type="email" name="c-email">
                <label>Commento</label> <!--for="c-body"-->
                <textarea class="form-control" rows="3" name="c-body"></textarea>

                <input name="c-subscription" type="checkbox" value="1" checked />
                <label>Voglio ricevere aggiornamenti su questa discussione</label> <!--for="c-subscription"-->

                <!--input name="comment_post_ID" value="1" id="comment_post_ID" type="hidden"-->
                <input name="comment_parent" id="comment_parent_{{ $comment->id }}" value="{{ $comment->id }}" type="hidden">

              </div>
              <button type="submit" class="btn btn-primary">Invia</button>
            </form>

            <div class="text-right">
              <button class="btn btn-link" data-toggle="collapse" data-target="#respond-comment-{{ $comment->id }}">Comprimi / Annulla</button>
            </div>
          </div>
        </div>
      </li>
      @endforeach
    @endif
  </ul>

  <hr>
  <!-- Comment Form -->
  <div class="invite">Lascia un commento {{ count($comments) > 0 ? 'anche tu' : '' }}  o fai la tua richiesta:</div>

  <form id="commentform" class="" action="{{ route('comment-send', [$post->slug]) }}" method="post">
    {{ csrf_field() }}
    <div class="form-group">
      <label>Nome</label> <!--for="c-name"-->
      <input class="form-control" type="text" name="c-name">
      <label>Email</label> <!-- for="c-email" -->
      <small>(Il tuo indirizzo email non sarà pubblicato)</small>
      <input class="form-control" type="email" name="c-email">
      <label>Commento</label> <!--for="c-body"-->
      <textarea class="form-control" rows="3" name="c-body"></textarea>
      <input type="checkbox" name="c-subscription" value="1" checked>
      <label>Voglio ricevere aggiornamenti su questa discussione</label> <!--for="c-subscription"-->
      <input name="comment_parent" id="comment_parent" value="0" type="hidden">
    </div>
    <button type="submit" class="btn btn-primary">Invia</button>
  </form>

  <form id="user-subscr" class="form-user-subscr" action="{{ route('comment-subscribe', [$post->slug]) }}" method="post">
    {{ csrf_field() }}
    <!--input class="" type="text" name="name-subscr" placeholder="Nome"-->
    <input class="updates-input" type="email" name="mail-subscr" placeholder="e-mail">
    <button type="submit" class="btn btn-primary btn-sm" >Voglio ricevere aggiornamenti su questa discussione senza lasciare un commento</button>
  </form>
</div><!--#comments-->
