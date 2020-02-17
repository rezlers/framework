<?php
use Kernel\Request\RequestInterface as Request;
/**
 * @var $request Request
 */
$registrationHash = $request->getParam('registrationHash')
?>

<!doctype html>
<html lang="en">
<body>
<?php echo "<p>Hello! Thank you for registration. Here is your link <a href=\"test.framework/registration/${registrationHash}\">test.framework/registration/${registrationHash}</a> <br>Follow it to finish registration</p>"; ?>
</body>
</html>
