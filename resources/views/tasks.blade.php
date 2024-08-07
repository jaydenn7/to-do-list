<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MLP To-Do</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
          integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #F1F1F1;
        }

        table {
            table-layout: fixed;
        }

        .action-wrapper {
            display: inline-block
        }

        #footer {
            margin-top: 1em
        }

        #table-wrapper {
            background-color: #FFFFFF;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        #logo {
            margin: 1em
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <img id="logo" src="{{ asset("images/logo.png") }}" alt="MLP Logo">
    </div>
    <div class="row">
        <div class="col-md-4">
            <form method="post" action="{{ route("tasks.store") }}">
                {{ csrf_field() }}

                <div class="form-group">
                    <input name="description" class="form-control" placeholder="Insert task name">
                </div>

                @if ($errors->has("description"))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    <button type="submit" class="form-control btn btn-primary">Add</button>
                </div>
            </form>
        </div>
        <div class="col-md-8" id="table-wrapper">
            <table class="table">
                <thead>
                <tr>
                    <th width="10%">#</th>
                    <th width="75%">Task</th>
                    <th width="15%"><!-- Actions --></th>
                </tr>
                </thead>
                <tbody>
                @php /** @var \App\Models\Task $task */ @endphp
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>

                        <td @if($task->completed_at) style="text-decoration: line-through" @endif>
                            {{ $task->description }}
                        </td>

                        <td class="text-right">
                            @if(!$task->completed_at)
                                <div class="action-wrapper">
                                    <form method="post" action="{{ route("tasks.complete", ["task" => $task]) }}">
                                        {{ method_field("PATCH") }}
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-success">
                                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                        </button>
                                    </form>
                                </div>

                                <div class="action-wrapper">
                                    <form method="post" action="{{ route("tasks.destroy", ["task" => $task]) }}">
                                        {{ method_field("DELETE") }}
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-danger">
                                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row text-center" id="footer">
        <p>Copyright © {{ \Carbon\Carbon::now()->year }} All Rights Reserved.</p>
    </div>
</div>
</body>
</html>
