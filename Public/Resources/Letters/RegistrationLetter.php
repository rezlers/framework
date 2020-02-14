<?php
use Kernel\Request\RequestInterface as Request;
/**
 * @var $request Request
 */
$registrationLink = $request->getParam('RegistrationLink')
?>

<!doctype html>
<html lang="en">
<body>
<?php echo "<p>Hello! Thank you for registration. Here is your link <a href=\"/registration/${registrationLink}\">${registrationLink}</a> <br>Follow it to finish registration</p>"; ?>
</body>
</html>
