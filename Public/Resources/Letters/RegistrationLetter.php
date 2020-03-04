<?php
use Kernel\Request\RequestInterface as Request;
/**
 * @var $request Request
 */
$registrationHash = $request->getParam('registrationHash');
$host = $_SERVER['SERVER_NAME'];
?>

<!doctype html>
<html lang="en">
<body>
<?php echo "<p>Hello! Thank you for registration. Here is your link <a href=\"${host}/registration/${registrationHash}\">test.framework/registration/do/${registrationHash}</a> <br>Follow it to finish registration</p>"; ?>
</body>
</html>
