<h2>Názov služby</h2>
<h3>{{ $serviceName }}</h3>

<h2>Začiatok</h2>
<h3>{{ $startAt }}</h3>

@if ($reasonForCancellation !== NULL)
<h2>Dôvod zrušenia</h2>
<p>{{ $reasonForCancellation }}</p>
@endif