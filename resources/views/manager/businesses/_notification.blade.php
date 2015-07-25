<li class="news-item">
<table cellpadding="4">
<tr>
    <td>
        @if ($notification->body()->first()->name == 'user.booked')
            <span class="label label-success">{!! Icon::calendar() !!}</span>
        @else
            <span class="label label-info">{!! Icon::hand_right() !!}</span>
        @endif
    </td>
    <td>
        @if ($notification->extra)
            {{trans('notifications.'.$notification->body()->first()->name, ['user' => $notification->from()->first()->name] + json_decode($notification->extra, true)) }}
        @else
            {{trans('notifications.'.$notification->body()->first()->name, ['user' => $notification->from()->first()->name]) }}
        @endif
        &nbsp;<small class="text-muted">{{Carbon::parse($notification->created_at)->timezone($business->timezone)->diffForHumans() }}</small>
    </td>
</tr>
</table>
</li>