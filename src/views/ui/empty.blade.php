<style>
.sctn-empty{padding: 1em;color:#888}
.sctn-empty-big {padding: 2em 1em;text-align: center;}
.sctn-empty-icon{font-size: 2em;color: #AEAEAE;}
</style>



@if( ! empty($style) && $style=='small')
<div class="sctn-empty">
<p>{{ $text or 'Список пуст' }}</p>
</div>
@else
<div class="sctn-empty sctn-empty-big">
<div class="sctn-empty-icon"><i class="fa fa-cloud"></i></div>
<p>{{ $text or 'Список пуст' }}</p>
</div>
@endif