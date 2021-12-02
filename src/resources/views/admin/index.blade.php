<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>quizy</title>
    <link
        href="https://storage.googleapis.com/google-code-archive-downloads/v2/code.google.com/html5resetcss/html5reset-1.6.css">
</head>

<body>
    <ul>
        @foreach($big_questions as $big_question)
            <li>{{ $big_question->name }}</li>
            <div>
                @foreach($questions->where('big_question_id', $big_question->id) as $question)
                <a href="/admin/edit/{{ $question->id }}" style="text-decoration: none;">
                    <img src="/img/{{ $question->image }}" width="200">
                </a>
                @endforeach
                <a href="/admin/add/{{ $big_question->id }}">新規追加</a>
            </div>
        @endforeach
    </ul>
</body>

</html>