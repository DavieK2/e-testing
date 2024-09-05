<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
    <table>

        <thead>
            <th>S/N</th>
            <th>STUDENT NAME</th>
            <th>FORM NUMBER</th>
            <th>PROGRAM OF STUDY</th>
            @foreach ($assessment_subjects as $subject)
                <th>{{ $subject['subject_name'] }}</th>
            @endforeach
        </thead>

        <tbody>
            
        </tbody>
    </table>

</body>
</html>