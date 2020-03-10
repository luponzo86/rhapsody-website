#!/bin/bash

# import variables
jobdir=$(realpath $1)
pyscript=$(realpath $2)
jobid=$(basename $jobdir | sed 's/job_//')

# set environmental variables
source .profile
export HOME="$(dirname $jobdir)"

cd $jobdir

# check if user provided email address
if [ -e input-email.txt ]; then
  # email=$(cat input-email.txt)
  email="lponzoni@pitt.edu, $(cat input-email.txt)"
  # prevent other emails to be sent
  echo | cat input-email.txt - >> sent_emails.txt
  rm input-email.txt
else
  # email=""
  email="lponzoni@pitt.edu"
fi

# run rhapsody
$PYTHON $pyscript > rhapsody-log.txt 2>&1
if [ $? -eq 0 ]; then
  status="completed successfully!"
  page="results"
else
  status="aborted"
  page="status"
fi

# send notification when done
if [ ! -z "$email" ]; then
  sendmail -t <<EOF
To: ${email}
Subject: Rhapsody: job ${jobid} ${status}
MIME-Version: 1.0
Content-type: text/html; charset=UTF-8
From: Rhapsody Webserver <dcb@pitt.edu>

<html>
<head>
<title>Rhapsody</title>
</head>
<body>
<p>Click <a href="http://rhapsody.csb.pitt.edu/${page}.php?id=${jobid}">here</a>
to access the results page.</p>
</body>
</html>
EOF
fi

exit 0
