@foreach ($membersArray as $group)
    <div class="card-body bg-dark">
        <p>{{$group['title']}}</p>

        <ul class="list">
            @foreach ($group['users'] as $member)
                <li>
                    <a href="{{ route('user.profile', ['id' => $member->id]) }}" style="color: {{$member->color}}">
                        {{$member->username}}
                    </a>

                    <span class="text-lightgray">
                        @foreach($member->getUserModes() as $mode)
                            <span>{{$loop->first ? '(' : ''}}{{$mode}}{{$loop->last ? ')' : ', ' }}</span>
                        @endforeach
                    </span>
                </li>
            @endforeach
        </ul>
    </div> <br>
@endforeach
