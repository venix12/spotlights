@foreach ($membersArray as $group)
    <p><b>{{$group['title']}}</b></p>

    <ul class="list">
        @foreach ($group['users'] as $member)
            <li>
                <a href="{{ route('user.profile', ['id' => $member->id]) }}" style="color: {{$group['colour']}}">
                    {{$member->username}}
                </a>

                <span class="text-muted">
                    @foreach($member->getUserModes() as $mode)
                        {{$mode}}
                        {{$loop->last ? '' : ', '}}
                    @endforeach
                </span>
            </li>
        @endforeach
    </ul>
@endforeach
