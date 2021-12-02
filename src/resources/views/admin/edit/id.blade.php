<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>quizy</title>
    <link
        href="https://storage.googleapis.com/google-code-archive-downloads/v2/code.google.com/html5resetcss/html5reset-1.6.css">
</head>

<body>
    <div>
        <img src="/img/{{ $question->image }}" alt="">
        <form action="/{{ request()->path() }}" method="POST">
            @csrf
            <table>
                <th>
                    <td>選択肢</td>
                    <td>正解</td>
                </th>
                @foreach($question->choices as $choice)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>
                            <input
                                type="text"
                                name="name{{ $loop->index }}"
                                value="{{ $choice->name }}"
                            >
                        </td>
                        <td>
                            <input
                                type="radio"
                                name="valid"
                                value="{{ $loop->index }}"
                                @if($choice->valid) checked @endif
                            >
                        </td>
                    </tr>
                @endforeach
            </table>
            <input type="submit" value="更新">
        </form>
    </div>
</body>

</html>