@foreach ($membersArray as $group)
    <div class="info-panel">
        <div class="info-panel__header">{{$group['title']}}</div>

        <ul class="list">
            @foreach ($group['users'] as $member)
                <li>
                    <a href="{{ route('user.profile', $member->id) }}" style="color: {{$member->color}}">{{
                        $member->username
                    }}</a>

                    <span class="text-lightgray">
                        @foreach($member->getUserModes() as $mode)
                            <span>{{$loop->first ? '(' : ''}}{{$mode}}{{$loop->last ? ')' : ', ' }}</span>
                        @endforeach
                    </span>
                </li>
            @endforeach
        </ul>
    </div>
@endforeach
