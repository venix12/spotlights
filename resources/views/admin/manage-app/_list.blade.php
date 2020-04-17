<div class="info-panel">
    <div class="info-panel__header">{{ $section }}</div>
    @foreach($questions as $question)
        <div class="d-inline-flex">
            ({{ $question->id }}) {{ $question->question }}

            @if ($section === 'Active questions')
                @if (!$loop->first)
                    <form action="{{ route('admin.app.move-around', 'up') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $question->id }}">
                        <button type="submit" class="button-invisible" title="move up">
                            <i class="fa fa-arrow-up"></i>
                        </button>
                    </form>
                @endif

                @if (!$loop->last)
                    <form action="{{ route('admin.app.move-around', 'down') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $question->id }}">
                        <button class="button-invisible" title="move down">
                            <i class="fa fa-arrow-down"></i>
                        </button>
                    </form>
                @endif
            @endif

            <form action="{{ route('admin.app.edit-question', $question->id) }}">
                <button type="submit" class="button-invisible" title="edit question">
                    <a class="fa fa-pencil"></a>
                </button>
            </form>

            <form action="{{ route('admin.app.delete-revert-question') }}" method="POST">
                @csrf
                <input type="hidden" name="question_id" value="{{ $question->id }}">
                <button type="submit" class="button-invisible" title="{{ $section === 'Active questions' ? 'delete question' : 'revert question' }}">
                    <i class="fa {{ $section === 'Active questions' ? 'fa-trash' : 'fa-refresh' }}"></i>
                </button>
            </form>
        </div>

        <ul>
            @if ($question->parent_id)
                <li>
                    <span class="text-lightgray">
                        parent: {{ $question->parent->question }}
                    </span>
                </li>
            @endif

            @if ($question->type === 'section')
                <li>
                    <span class="text-lightgray">
                        description: {{ $question->description }}
                    </span>
                </li>
            @endif

            <li>
                <span class="text-lightgray">
                    type: {{ $question->type }}
                </span>
            </li>

            <li>
                <span class="text-lightgray">
                    required: {{ $question->required ? 'true' : 'false' }}
                </span>
            </li>

            @if ($question->type === 'textarea')
                <li>
                    <span class="text-lightgray">
                        character limit: {{ $question->char_limit }}
                    </span>
                </li>
            @endif

            <li>
                <span class="text-lightgray">
                    order: {{ $question->order }}
                </span>
            </li>
        </ul>
    @endforeach
</div>
