<!DOCTYPE html>
<html>

<head>
    <title>Import Users</title>
</head>

<body>
    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="file">Choose CSV File</label>
            <input type="file" name="file" id="file" required>
        </div>
        <button type="submit">Upload</button>
    </form>
</body>

</html>
