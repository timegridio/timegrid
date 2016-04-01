<!-- Notifications Menu -->
<li class="dropdown notifications-menu">
  <!-- Menu toggle button -->
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-calendar-check-o"></i>
    <span class="label {{ $appointments->count() > 0 ? 'label-warning' : 'label-default' }}">{{ $appointments->count() }}</span>
  </a>
  <ul class="dropdown-menu">
    @foreach($appointments as $appointment)
    <li>
      <!-- Inner Menu: contains the notifications -->
      <ul class="menu">
        <li><!-- start notification -->
          <a href="{{ route('user.agenda') . '#' . $appointment->code() }}">
            <i class="fa fa-calendar-check-o text-aqua"></i> {{ $appointment->service->name }} : {{ $appointment->business->name }}
          </a>
        </li>
        <!-- end notification -->
      </ul>
    </li>
    @endforeach
    <li class="footer"><a href="{{ route('user.agenda') . '#' . $appointment->code() }}"></a></li>
  </ul>
</li>
