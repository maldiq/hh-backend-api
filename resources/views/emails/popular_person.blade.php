<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Popular Person Notification</title>
</head>
<body>
    <h2>Popular Person Alert</h2>

    <p>
        The following person has received more than <strong>50 likes</strong>:
    </p>

    <ul>
        <li><strong>Name:</strong> {{ $person->name }}</li>
        <li><strong>Age:</strong> {{ $person->age }}</li>
        <li><strong>Location:</strong> {{ $person->location }}</li>
        <li><strong>Total Likes:</strong> {{ $person->likes_count ?? 'N/A' }}</li>
    </ul>

    <p>Please review this user’s activity from the admin panel.</p>

</body>
</html>
