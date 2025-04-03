#!/bin/bash

# Script to prepare Vite assets for uploading to production server
echo "Preparing Vite assets for production..."

# Create a build archive
echo "Creating build archive..."
cd public
rm -f build.zip
zip -r build.zip build/
cd ..

echo "Build archive created at public/build.zip"
echo "Please upload this file to your production server at /home/eastbizzcom/public_html/ofys/public/"
echo "Then run the fix-vite-errors.sh script on your server."

# Show the size of the archive
echo "Archive size:"
ls -lh public/build.zip
