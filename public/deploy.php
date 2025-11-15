<?php
// This is the webhook secret token you set in GitLab, if any.
$secret = 'glpat-Uvz7yjr87xef3Y67uJ1t';

// Verify the secret token if it's set.
if ($secret !== '' && (!isset($_SERVER['HTTP_X_GITLAB_TOKEN']) || $_SERVER['HTTP_X_GITLAB_TOKEN'] !== $secret)) {
    http_response_code(403);
    exit('Invalid secret token');
}

// Execute the deployment script.
shell_exec('/bin/bash /home/elitmsbx/mubasher-local-backend/public/deploy.sh');

echo "Deployment executed successfully.";
?>
