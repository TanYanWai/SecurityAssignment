<?php
// Generate these securely and store in environment variables in production
define('ENCRYPTION_KEY', base64_decode(getenv('ENCRYPTION_KEY')));
define('ENCRYPTION_IV', base64_decode(getenv('ENCRYPTION_IV'))); 