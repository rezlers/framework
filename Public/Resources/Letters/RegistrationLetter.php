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
<?php echo "<p>Hello! Thank you for registration. Here is your link <a href=\"ec2-3-17-14-139.us-east-2.compute.amazonaws.com/registration/do/${registrationHash}\">test.framework/registration/do/${registrationHash}</a> <br>Follow it to finish registration</p>"; ?>
</body>
</html>
