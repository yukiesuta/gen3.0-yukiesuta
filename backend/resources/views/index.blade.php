<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>quizy1</title>
    <link
        href="https://storage.googleapis.com/google-code-archive-downloads/v2/code.google.com/html5resetcss/html5reset-1.6.css">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
</head>

<body>
    <div class="main">
        @foreach($questions as $question)
            @php
                $valid = $choices->where('group', $question->group)->where('valid', 1)->first()
            @endphp
            <div class="quiz">
                <h1>{{ $question->group }}. この地名はなんて読む？</h1>
                <img src="img/1.png">
                <ul>
                    @foreach ($choices->where('group', $question->group) as $choice)
                        <li 
                            id="answerlist_{{ $question->group }}_{{ $loop->index + 1 }}"
                            name="answerlist_{{ $question->group }}"
                            class="answerlist"
                            onclick="check(
                                {{ $question->group }},
                                {{ $loop->index + 1 }},
                                )"
                        >
                        {{ $valid }}
                            {{ $choice->name }}
                        </li>
                    @endforeach
                    <li id="answerbox_{{ $question->group }}" class="answerbox">
                        <span id="answertext_{{ $question->group }}"></span><br>
                        <span>
                            正解は「
                            {{ $valid->name }}
                            」です！
                        </span>
                    </li>
                </ul>
            </div>
        @endforeach
        <script src="{{ asset('/js/main.js') }}"></script>
    </div>
</body>

</html>