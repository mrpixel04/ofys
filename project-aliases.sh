#!/bin/bash

# Project-specific aliases
alias pa-c="php artisan optimize:clear"
alias pa-s="php artisan serve"
alias c="clear"
alias nrd="npm run dev"
alias stopit="pkill -f 'php artisan serve' && pkill -f 'npm run dev' && echo 'Development servers stopped successfully.'"
alias startit="php artisan serve > /dev/null 2>&1 & echo 'PHP artisan server started in background.' && npm run dev"

# Display the available aliases when the file is sourced
echo "Project aliases loaded successfully. Available commands:"
echo "  pa-c    - php artisan optimize:clear"
echo "  pa-s    - php artisan serve"
echo "  c       - clear"
echo "  nrd     - npm run dev"
echo "  stopit  - kill both PHP artisan serve and npm run dev processes"
echo "  startit - start both PHP artisan serve and npm run dev processes"
