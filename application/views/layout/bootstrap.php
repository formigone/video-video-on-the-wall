<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?= $page['title']; ?></title>
</head>

<body>
<h1>Welcome!!</h1>

<?php if (!empty($view)) {
   $this->load->view($view, $data);
} ?>
</body>
</html>